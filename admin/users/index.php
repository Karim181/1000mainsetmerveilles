<?php
/**
 * Liste des utilisateurs - Admin
 * 1000 Mains et Merveilles
 */

auth_require_admin(); // Réservé aux admins uniquement

$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';

// Récupérer tous les utilisateurs
$users = dbFetchAll(
    'SELECT u.*,
            (SELECT COUNT(*) FROM products WHERE author_id = u.id) as products_count,
            (SELECT COUNT(*) FROM news WHERE author_id = u.id) as news_count,
            (SELECT COUNT(*) FROM events WHERE author_id = u.id) as events_count
     FROM users u
     ORDER BY u.role DESC, u.name ASC'
);

$pageTitle = 'Utilisateurs';
include ROOT_PATH . '/admin/includes/header.php';
?>

<?php if ($success): ?>
    <div class="alert alert-success"><?= e($success) ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error"><?= e($error) ?></div>
<?php endif; ?>

<div class="admin-toolbar">
    <a href="<?= admin_url('users/create') ?>" class="btn btn-primary">➕ Nouvel utilisateur</a>
</div>

<div class="admin-card">
    <h2>👥 Gestion des utilisateurs</h2>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Contenu créé</th>
                <th>Dernière connexion</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td>
                    <strong><?= e($user['name']) ?></strong>
                </td>
                <td><?= e($user['email']) ?></td>
                <td>
                    <span class="badge badge-<?= $user['role'] === 'admin' ? 'purple' : 'blue' ?>">
                        <?= $user['role'] === 'admin' ? 'Admin' : 'Éditeur' ?>
                    </span>
                </td>
                <td class="content-stats">
                    <span title="Produits">🛍️ <?= $user['products_count'] ?></span>
                    <span title="Actualités">📰 <?= $user['news_count'] ?></span>
                    <span title="Événements">📅 <?= $user['events_count'] ?></span>
                </td>
                <td>
                    <?php if ($user['last_login']): ?>
                        <?= date('d/m/Y H:i', strtotime($user['last_login'])) ?>
                    <?php else: ?>
                        <span class="text-muted">Jamais</span>
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <a href="<?= admin_url('users/edit?id=' . $user['id']) ?>" class="btn btn-sm btn-secondary" title="Modifier">✏️</a>
                    <?php if ($user['id'] != auth_user()['id']): ?>
                        <a href="<?= admin_url('users/delete?id=' . $user['id']) ?>" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Supprimer cet utilisateur ?')">🗑️</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
.content-stats {
    display: flex;
    gap: 12px;
}
.content-stats span {
    font-size: 13px;
    color: var(--admin-text-light);
}
</style>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
