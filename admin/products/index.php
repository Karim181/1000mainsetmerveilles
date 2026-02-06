<?php
/**
 * Liste des produits - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

$user = auth_user();

// Filtres
$status = $_GET['status'] ?? '';
$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';

// Construction de la requête
$sql = 'SELECT p.*, c.name as category_name, c.icon as category_icon, u.name as author_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN users u ON p.author_id = u.id
        WHERE 1=1';
$params = [];

if ($status) {
    $sql .= ' AND p.status = ?';
    $params[] = $status;
}

if ($category) {
    $sql .= ' AND p.category_id = ?';
    $params[] = $category;
}

if ($search) {
    $sql .= ' AND (p.name LIKE ? OR p.description LIKE ?)';
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$sql .= ' ORDER BY p.created_at DESC';

$products = dbFetchAll($sql, $params);
$categories = dbFetchAll('SELECT * FROM categories ORDER BY sort_order');

// Messages flash
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';

$pageTitle = 'Produits';
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
        <h2>Liste des produits (<?= count($products) ?>)</h2>
        <a href="<?= admin_url('products/create') ?>" class="btn btn-primary">➕ Nouveau produit</a>
    </div>

    <!-- Filtres -->
    <form class="filters-form" method="GET">
        <div class="filters-row">
            <input type="text" name="search" placeholder="Rechercher..." value="<?= e($search) ?>" class="form-control">

            <select name="status" class="form-control">
                <option value="">Tous les statuts</option>
                <option value="available" <?= $status === 'available' ? 'selected' : '' ?>>Disponible</option>
                <option value="sold" <?= $status === 'sold' ? 'selected' : '' ?>>Vendu</option>
                <option value="reserved" <?= $status === 'reserved' ? 'selected' : '' ?>>Réservé</option>
            </select>

            <select name="category" class="form-control">
                <option value="">Toutes catégories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $category == $cat['id'] ? 'selected' : '' ?>>
                        <?= $cat['icon'] ?> <?= e($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn btn-secondary">Filtrer</button>
            <?php if ($search || $status || $category): ?>
                <a href="<?= admin_url('products') ?>" class="btn btn-link">Réinitialiser</a>
            <?php endif; ?>
        </div>
    </form>

    <?php if (empty($products)): ?>
        <p class="empty-state">Aucun produit trouvé.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Statut</th>
                    <th>Auteur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td>
                        <?php if ($product['image']): ?>
                            <img src="<?= upload_url('products/' . $product['image']) ?>" alt="" class="table-thumb">
                        <?php else: ?>
                            <div class="table-thumb-placeholder">📷</div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <strong><?= e($product['name']) ?></strong>
                        <?php if ($product['is_featured']): ?>
                            <span class="badge badge-warning">⭐ Pépite</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $product['category_icon'] ?> <?= e($product['category_name']) ?></td>
                    <td><strong><?= number_format($product['price'], 2, ',', ' ') ?> €</strong></td>
                    <td>
                        <?php
                        $statusLabels = [
                            'available' => ['label' => 'Disponible', 'class' => 'success'],
                            'sold' => ['label' => 'Vendu', 'class' => 'danger'],
                            'reserved' => ['label' => 'Réservé', 'class' => 'warning'],
                        ];
                        $s = $statusLabels[$product['status']] ?? ['label' => $product['status'], 'class' => 'info'];
                        ?>
                        <span class="badge badge-<?= $s['class'] ?>"><?= $s['label'] ?></span>
                    </td>
                    <td><?= e($product['author_name']) ?></td>
                    <td>
                        <div class="actions-group">
                            <a href="<?= admin_url('products/preview?id=' . $product['id']) ?>" class="btn btn-sm btn-secondary" title="Prévisualiser">👁️</a>
                            <a href="<?= admin_url('products/edit?id=' . $product['id']) ?>" class="btn btn-sm btn-secondary" title="Modifier">✏️</a>
                            <?php if (auth_is_admin() || $product['author_id'] == $user['id']): ?>
                                <a href="<?= admin_url('products/delete?id=' . $product['id']) ?>" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Supprimer ce produit ?')">🗑️</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
