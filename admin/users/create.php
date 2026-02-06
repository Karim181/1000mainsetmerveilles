<?php
/**
 * Création utilisateur - Admin
 * 1000 Mains et Merveilles
 */

auth_require_admin(); // Réservé aux admins uniquement

$errors = [];
$data = [
    'name' => '',
    'email' => '',
    'password' => '',
    'password_confirm' => '',
    'role' => 'editor',
];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'password_confirm' => $_POST['password_confirm'] ?? '',
        'role' => $_POST['role'] ?? 'editor',
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
        // Vérifier si l'email existe déjà
        $existing = dbFetchOne('SELECT id FROM users WHERE email = ?', [$data['email']]);
        if ($existing) {
            $errors[] = 'Cet email est déjà utilisé.';
        }
    }

    if (empty($data['password'])) {
        $errors[] = 'Le mot de passe est obligatoire.';
    } elseif (strlen($data['password']) < 8) {
        $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
    }

    if ($data['password'] !== $data['password_confirm']) {
        $errors[] = 'Les mots de passe ne correspondent pas.';
    }

    if (!in_array($data['role'], ['admin', 'editor'])) {
        $errors[] = 'Rôle invalide.';
    }

    // Insertion si pas d'erreurs
    if (empty($errors)) {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $sql = 'INSERT INTO users (name, email, password, role, created_at)
                VALUES (?, ?, ?, ?, NOW())';

        dbExecute($sql, [
            $data['name'],
            $data['email'],
            $hashedPassword,
            $data['role'],
        ]);

        header('Location: ' . admin_url('users') . '?success=Utilisateur créé avec succès');
        exit;
    }
}

$pageTitle = 'Nouvel utilisateur';
include ROOT_PATH . '/admin/includes/header.php';
?>

<div class="admin-card">
    <h2>Créer un utilisateur</h2>

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

        <div class="form-row">
            <div class="form-group">
                <label for="password">Mot de passe *</label>
                <input type="password" id="password" name="password" class="form-control" required minlength="8">
                <small class="form-help">Minimum 8 caractères</small>
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe *</label>
                <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label for="role">Rôle *</label>
            <select id="role" name="role" class="form-control">
                <option value="editor" <?= $data['role'] === 'editor' ? 'selected' : '' ?>>Éditeur</option>
                <option value="admin" <?= $data['role'] === 'admin' ? 'selected' : '' ?>>Administrateur</option>
            </select>
            <small class="form-help">
                <strong>Éditeur :</strong> Peut gérer les produits, actualités et événements<br>
                <strong>Admin :</strong> Accès complet (utilisateurs, catégories, maintenance)
            </small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Créer l'utilisateur</button>
            <a href="<?= admin_url('users') ?>" class="btn btn-link">Annuler</a>
        </div>
    </form>
</div>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
