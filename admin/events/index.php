<?php
/**
 * Liste des événements - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

$user = auth_user();

$categories = [
    'atelier' => 'Atelier créatif',
    'evenement' => 'Événement',
    'special' => 'Événement spécial',
];

// Filtres
$status = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';
$period = $_GET['period'] ?? '';
$category = $_GET['category'] ?? '';

// Construction de la requête
$sql = 'SELECT e.*, u.name as author_name
        FROM events e
        LEFT JOIN users u ON e.author_id = u.id
        WHERE 1=1';
$params = [];

if ($status) {
    $sql .= ' AND e.status = ?';
    $params[] = $status;
}

if ($search) {
    $sql .= ' AND (e.title LIKE ? OR e.description LIKE ? OR e.location LIKE ?)';
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($category) {
    $sql .= ' AND e.category = ?';
    $params[] = $category;
}

if ($period === 'upcoming') {
    $sql .= ' AND e.start_date >= NOW()';
} elseif ($period === 'past') {
    $sql .= ' AND e.start_date < NOW()';
}

$sql .= ' ORDER BY e.start_date DESC';

$events = dbFetchAll($sql, $params);

// Messages flash
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';

$pageTitle = 'Événements';
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
        <h2>Liste des événements (<?= count($events) ?>)</h2>
        <a href="<?= admin_url('events/create') ?>" class="btn btn-primary">➕ Nouvel événement</a>
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

            <select name="category" class="form-control">
                <option value="">Toutes les catégories</option>
                <?php foreach ($categories as $val => $label): ?>
                    <option value="<?= $val ?>" <?= $category === $val ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>

            <select name="period" class="form-control">
                <option value="">Toutes les dates</option>
                <option value="upcoming" <?= $period === 'upcoming' ? 'selected' : '' ?>>À venir</option>
                <option value="past" <?= $period === 'past' ? 'selected' : '' ?>>Passés</option>
            </select>

            <button type="submit" class="btn btn-secondary">Filtrer</button>
            <?php if ($search || $status || $period || $category): ?>
                <a href="<?= admin_url('events') ?>" class="btn btn-link">Réinitialiser</a>
            <?php endif; ?>
        </div>
    </form>

    <?php if (empty($events)): ?>
        <p class="empty-state">Aucun événement trouvé.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Lieu</th>
                    <th>Catégorie</th>
                    <th>Statut</th>
                    <th>Auteur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                <?php
                    $isPast = strtotime($event['start_date']) < time();
                ?>
                <tr class="<?= $isPast ? 'event-past' : '' ?>">
                    <td>
                        <?php if ($event['image']): ?>
                            <img src="<?= upload_url('events/' . $event['image']) ?>" alt="" class="table-thumb">
                        <?php else: ?>
                            <div class="table-thumb-placeholder">📅</div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <strong><?= e($event['title']) ?></strong>
                        <?php if ($isPast): ?>
                            <span class="badge badge-info">Passé</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <strong><?= date('d/m/Y', strtotime($event['start_date'])) ?></strong>
                        <br><small><?= date('H:i', strtotime($event['start_date'])) ?></small>
                        <?php if ($event['end_date']): ?>
                            <br><small class="text-muted">→ <?= date('d/m H:i', strtotime($event['end_date'])) ?></small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($event['location']): ?>
                            📍 <?= e($event['location']) ?>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge badge-cat-<?= $event['category'] ?? 'evenement' ?>"><?= e($categories[$event['category'] ?? 'evenement']) ?></span>
                    </td>
                    <td>
                        <?php if ($event['status'] === 'published'): ?>
                            <span class="badge badge-success">Publié</span>
                        <?php else: ?>
                            <span class="badge badge-warning">Brouillon</span>
                        <?php endif; ?>
                    </td>
                    <td><?= e($event['author_name']) ?></td>
                    <td>
                        <div class="actions-group">
                            <a href="<?= admin_url('events/preview?id=' . $event['id']) ?>" class="btn btn-sm btn-secondary" title="Prévisualiser">👁️</a>
                            <a href="<?= admin_url('events/edit?id=' . $event['id']) ?>" class="btn btn-sm btn-secondary" title="Modifier">✏️</a>
                            <?php if (auth_is_admin() || $event['author_id'] == $user['id']): ?>
                                <a href="<?= admin_url('events/delete?id=' . $event['id']) ?>" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Supprimer cet événement ?')">🗑️</a>
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

.event-past {
    opacity: 0.6;
}

.badge-cat-atelier {
    background: #e0f7f8;
    color: #20b4b7;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.badge-cat-evenement {
    background: #e8f0ff;
    color: #2b519f;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.badge-cat-special {
    background: #fff3e0;
    color: #f17f0a;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}
</style>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
