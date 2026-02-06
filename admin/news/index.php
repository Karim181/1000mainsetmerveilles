<?php
/**
 * Liste des actualités - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

$user = auth_user();

// Filtres
$status = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';

// Construction de la requête
$sql = 'SELECT n.*, u.name as author_name
        FROM news n
        LEFT JOIN users u ON n.author_id = u.id
        WHERE 1=1';
$params = [];

if ($status) {
    $sql .= ' AND n.status = ?';
    $params[] = $status;
}

if ($search) {
    $sql .= ' AND (n.title LIKE ? OR n.content LIKE ?)';
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$sql .= ' ORDER BY n.created_at DESC';

$news = dbFetchAll($sql, $params);

// Messages flash
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';

$pageTitle = 'Actualités';
include ROOT_PATH . '/admin/includes/header.php';
?>

<?php if ($success): ?>
    <div class="alert alert-success"><?= e($success) ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error"><?= e($error) ?></div>
<?php endif; ?>

<div class="admin-card">
    <div class="card-header">
        <h2>Liste des actualités (<?= count($news) ?>)</h2>
        <a href="<?= admin_url('news/create') ?>" class="btn btn-primary">➕ Nouvelle actualité</a>
    </div>

    <!-- Filtres -->
    <form class="filters-form" method="GET">
        <div class="filters-row">
            <input type="text" name="search" placeholder="Rechercher..." value="<?= e($search) ?>" class="form-control">

            <select name="status" class="form-control">
                <option value="">Tous les statuts</option>
                <option value="published" <?= $status === 'published' ? 'selected' : '' ?>>Publié</option>
                <option value="draft" <?= $status === 'draft' ? 'selected' : '' ?>>Brouillon</option>
            </select>

            <button type="submit" class="btn btn-secondary">Filtrer</button>
            <?php if ($search || $status): ?>
                <a href="<?= admin_url('news') ?>" class="btn btn-link">Réinitialiser</a>
            <?php endif; ?>
        </div>
    </form>

    <?php if (empty($news)): ?>
        <p class="empty-state">Aucune actualité trouvée.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Statut</th>
                    <th>Auteur</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($news as $article): ?>
                <tr>
                    <td>
                        <?php if ($article['image']): ?>
                            <img src="<?= upload_url('news/' . $article['image']) ?>" alt="" class="table-thumb">
                        <?php else: ?>
                            <div class="table-thumb-placeholder">📰</div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <strong><?= e($article['title']) ?></strong>
                        <?php if ($article['excerpt']): ?>
                            <br><small class="text-muted"><?= e(substr($article['excerpt'], 0, 60)) ?>...</small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($article['status'] === 'published'): ?>
                            <span class="badge badge-success">Publié</span>
                        <?php else: ?>
                            <span class="badge badge-warning">Brouillon</span>
                        <?php endif; ?>
                    </td>
                    <td><?= e($article['author_name']) ?></td>
                    <td>
                        <?php if ($article['published_at']): ?>
                            <?= date('d/m/Y', strtotime($article['published_at'])) ?>
                        <?php else: ?>
                            <span class="text-muted">Non publié</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="actions-group">
                            <a href="<?= admin_url('news/preview?id=' . $article['id']) ?>" class="btn btn-sm btn-secondary" title="Prévisualiser">👁️</a>
                            <a href="<?= admin_url('news/edit?id=' . $article['id']) ?>" class="btn btn-sm btn-secondary" title="Modifier">✏️</a>
                            <?php if (auth_is_admin() || $article['author_id'] == $user['id']): ?>
                                <a href="<?= admin_url('news/delete?id=' . $article['id']) ?>" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Supprimer cette actualité ?')">🗑️</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<style>
.text-muted {
    color: var(--admin-text-light);
}
</style>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
