<?php
/**
 * Suppression utilisateur - Admin
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

// Empêcher la suppression de soi-même
if ($id === $currentUser['id']) {
    header('Location: ' . admin_url('users') . '?error=Vous ne pouvez pas supprimer votre propre compte');
    exit;
}

// Compter le contenu créé par cet utilisateur
$stats = [
    'products' => dbFetchOne('SELECT COUNT(*) as c FROM products WHERE author_id = ?', [$id])['c'],
    'news' => dbFetchOne('SELECT COUNT(*) as c FROM news WHERE author_id = ?', [$id])['c'],
    'events' => dbFetchOne('SELECT COUNT(*) as c FROM events WHERE author_id = ?', [$id])['c'],
];
$totalContent = $stats['products'] + $stats['news'] + $stats['events'];

$error = '';

// Traitement de la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        // Vérifier s'il y a du contenu à réassigner
        if ($totalContent > 0) {
            $reassignTo = (int)($_POST['reassign_to'] ?? 0);

            if ($reassignTo > 0) {
                // Vérifier que l'utilisateur de réassignation existe
                $targetUser = dbFetchOne('SELECT id FROM users WHERE id = ?', [$reassignTo]);
                if (!$targetUser) {
                    $error = 'L\'utilisateur de réassignation n\'existe pas.';
                } else {
                    // Réassigner le contenu
                    dbExecute('UPDATE products SET author_id = ? WHERE author_id = ?', [$reassignTo, $id]);
                    dbExecute('UPDATE news SET author_id = ? WHERE author_id = ?', [$reassignTo, $id]);
                    dbExecute('UPDATE events SET author_id = ? WHERE author_id = ?', [$reassignTo, $id]);
                }
            } else {
                $error = 'Vous devez sélectionner un utilisateur pour réassigner le contenu.';
            }
        }

        if (empty($error)) {
            // Supprimer les sessions de l'utilisateur
            dbExecute('DELETE FROM sessions WHERE user_id = ?', [$id]);

            // Supprimer l'utilisateur
            dbExecute('DELETE FROM users WHERE id = ?', [$id]);

            header('Location: ' . admin_url('users') . '?success=Utilisateur supprimé');
            exit;
        }
    }
}

// Récupérer les autres utilisateurs pour la réassignation
$otherUsers = dbFetchAll('SELECT id, name, role FROM users WHERE id != ? ORDER BY name', [$id]);

$pageTitle = 'Supprimer : ' . $user['name'];
include ROOT_PATH . '/admin/includes/header.php';
?>

<div class="admin-card delete-confirm-card">
    <h2>⚠️ Supprimer un utilisateur</h2>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>

    <div class="delete-user-info">
        <p>Vous êtes sur le point de supprimer l'utilisateur :</p>
        <div class="user-to-delete">
            <strong><?= e($user['name']) ?></strong>
            <span class="badge badge-<?= $user['role'] === 'admin' ? 'purple' : 'blue' ?>">
                <?= $user['role'] === 'admin' ? 'Admin' : 'Éditeur' ?>
            </span>
            <br>
            <small><?= e($user['email']) ?></small>
        </div>
    </div>

    <?php if ($totalContent > 0): ?>
        <div class="content-warning">
            <h3>⚠️ Cet utilisateur a créé du contenu</h3>
            <ul class="content-stats-list">
                <?php if ($stats['products'] > 0): ?>
                    <li>🛍️ <?= $stats['products'] ?> produit(s)</li>
                <?php endif; ?>
                <?php if ($stats['news'] > 0): ?>
                    <li>📰 <?= $stats['news'] ?> actualité(s)</li>
                <?php endif; ?>
                <?php if ($stats['events'] > 0): ?>
                    <li>📅 <?= $stats['events'] ?> événement(s)</li>
                <?php endif; ?>
            </ul>
            <p>Ce contenu doit être réassigné à un autre utilisateur avant la suppression.</p>
        </div>
    <?php endif; ?>

    <form method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="delete">

        <?php if ($totalContent > 0): ?>
            <div class="form-group">
                <label for="reassign_to">Réassigner le contenu à *</label>
                <select id="reassign_to" name="reassign_to" class="form-control" required>
                    <option value="">-- Sélectionner un utilisateur --</option>
                    <?php foreach ($otherUsers as $otherUser): ?>
                        <option value="<?= $otherUser['id'] ?>">
                            <?= e($otherUser['name']) ?>
                            (<?= $otherUser['role'] === 'admin' ? 'Admin' : 'Éditeur' ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <div class="form-actions">
            <button type="submit" class="btn btn-danger">🗑️ Supprimer définitivement</button>
            <a href="<?= admin_url('users') ?>" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<style>
.delete-confirm-card {
    max-width: 600px;
}
.delete-user-info {
    margin-bottom: 25px;
}
.user-to-delete {
    background: var(--admin-bg);
    padding: 15px 20px;
    border-radius: 8px;
    margin-top: 10px;
}
.content-warning {
    background: #fff3cd;
    border: 1px solid #ffc107;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 25px;
}
.content-warning h3 {
    margin: 0 0 10px 0;
    color: #856404;
    font-size: 16px;
}
.content-stats-list {
    margin: 15px 0;
    padding-left: 20px;
}
.content-stats-list li {
    margin: 5px 0;
}
</style>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
