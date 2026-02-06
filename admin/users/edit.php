<?php
/**
 * Édition utilisateur - Admin
 * 1000 Mains et Merveilles
 */

auth_require_admin(); // Réservé aux admins uniquement

$currentUser = auth_user();

// Récupérer l'utilisateur
$id = (int)($_GET['id'] ?? 0);
$user = dbFetchOne('SELECT * FROM users WHERE id = ?', [$id]);

if (!$user) {
    header('Location: ' . admin_url('users') . '?error=Utilisateur introuvable');
    exit;
}

$errors = [];
$data = [
    'name' => $user['name'],
    'email' => $user['email'],
    'role' => $user['role'],
    'password' => '',
    'password_confirm' => '',
];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'role' => $_POST['role'] ?? $user['role'],
        'password' => $_POST['password'] ?? '',
        'password_confirm' => $_POST['password_confirm'] ?? '',
    ];

    // Validation
    if (empty($data['name'])) {
        $errors[] = 'Le nom est obligatoire.';
    }

    if (empty($data['email'])) {
        $errors[] = 'L\'email est obligatoire.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'L\'email n\'est pas valide.';
    } else {
        // Vérifier si l'email existe déjà pour un autre utilisateur
        $existing = dbFetchOne('SELECT id FROM users WHERE email = ? AND id != ?', [$data['email'], $id]);
        if ($existing) {
            $errors[] = 'Cet email est déjà utilisé par un autre utilisateur.';
        }
    }

    // Validation du mot de passe (uniquement si rempli)
    if (!empty($data['password'])) {
        if (strlen($data['password']) < 8) {
            $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
        }
        if ($data['password'] !== $data['password_confirm']) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }
    }

    // Empêcher un admin de se rétrograder lui-même
    if ($id === $currentUser['id'] && $data['role'] !== 'admin') {
        $errors[] = 'Vous ne pouvez pas vous rétrograder vous-même.';
        $data['role'] = 'admin';
    }

    if (!in_array($data['role'], ['admin', 'editor'])) {
        $errors[] = 'Rôle invalide.';
    }

    // Mise à jour si pas d'erreurs
    if (empty($errors)) {
        if (!empty($data['password'])) {
            // Mise à jour avec nouveau mot de passe
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $sql = 'UPDATE users SET name = ?, email = ?, password = ?, role = ? WHERE id = ?';
            dbExecute($sql, [$data['name'], $data['email'], $hashedPassword, $data['role'], $id]);
        } else {
            // Mise à jour sans changer le mot de passe
            $sql = 'UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?';
            dbExecute($sql, [$data['name'], $data['email'], $data['role'], $id]);
        }

        header('Location: ' . admin_url('users') . '?success=Utilisateur mis à jour');
        exit;
    }
}

$pageTitle = 'Modifier : ' . $user['name'];
include ROOT_PATH . '/admin/includes/header.php';
?>

<div class="admin-card">
    <h2>Modifier l'utilisateur</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= e($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST">
        <?= csrf_field() ?>

        <div class="form-row">
            <div class="form-group">
                <label for="name">Nom complet *</label>
                <input type="text" id="name" name="name" value="<?= e($data['name']) ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="<?= e($data['email']) ?>" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label for="role">Rôle *</label>
            <select id="role" name="role" class="form-control" <?= $id === $currentUser['id'] ? 'disabled' : '' ?>>
                <option value="editor" <?= $data['role'] === 'editor' ? 'selected' : '' ?>>Éditeur</option>
                <option value="admin" <?= $data['role'] === 'admin' ? 'selected' : '' ?>>Administrateur</option>
            </select>
            <?php if ($id === $currentUser['id']): ?>
                <input type="hidden" name="role" value="admin">
                <small class="form-help">Vous ne pouvez pas modifier votre propre rôle.</small>
            <?php else: ?>
                <small class="form-help">
                    <strong>Éditeur :</strong> Peut gérer les produits, actualités et événements<br>
                    <strong>Admin :</strong> Accès complet (utilisateurs, catégories, maintenance)
                </small>
            <?php endif; ?>
        </div>

        <hr>
        <h3>Changer le mot de passe</h3>
        <p class="form-help">Laissez vide pour conserver le mot de passe actuel.</p>

        <div class="form-row">
            <div class="form-group">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" id="password" name="password" class="form-control" minlength="8">
                <small class="form-help">Minimum 8 caractères</small>
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe</label>
                <input type="password" id="password_confirm" name="password_confirm" class="form-control">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
            <a href="<?= admin_url('users') ?>" class="btn btn-link">Annuler</a>
        </div>
    </form>
</div>

<div class="admin-card user-info-card">
    <h3>Informations</h3>
    <ul class="user-info-list">
        <li><strong>Créé le :</strong> <?= date('d/m/Y à H:i', strtotime($user['created_at'])) ?></li>
        <li><strong>Dernière connexion :</strong> <?= $user['last_login'] ? date('d/m/Y à H:i', strtotime($user['last_login'])) : 'Jamais' ?></li>
    </ul>
</div>

<style>
.user-info-card {
    max-width: 400px;
}
.user-info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.user-info-list li {
    padding: 8px 0;
    border-bottom: 1px solid var(--admin-border);
}
.user-info-list li:last-child {
    border-bottom: none;
}
</style>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
