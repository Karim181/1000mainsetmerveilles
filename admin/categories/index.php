<?php
/**
 * Gestion des catégories - Admin
 * 1000 Mains et Merveilles
 */

auth_require_admin(); // Réservé aux admins

$success = '';
$error = '';

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $action = $_POST['action'] ?? '';

    // Ajouter une catégorie
    if ($action === 'add') {
        $name = trim($_POST['name'] ?? '');
        $icon = trim($_POST['icon'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);

        if (empty($name)) {
            $error = 'Le nom est obligatoire.';
        } else {
            $slug = slugify($name);
            $existing = dbFetchOne('SELECT id FROM categories WHERE slug = ?', [$slug]);
            if ($existing) {
                $error = 'Une catégorie avec ce nom existe déjà.';
            } else {
                dbExecute(
                    'INSERT INTO categories (name, slug, icon, sort_order) VALUES (?, ?, ?, ?)',
                    [$name, $slug, $icon, $sortOrder]
                );
                $success = 'Catégorie ajoutée.';
            }
        }
    }

    // Modifier une catégorie
    if ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $icon = trim($_POST['icon'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);

        if (empty($name)) {
            $error = 'Le nom est obligatoire.';
        } else {
            $slug = slugify($name);
            $existing = dbFetchOne('SELECT id FROM categories WHERE slug = ? AND id != ?', [$slug, $id]);
            if ($existing) {
                $error = 'Une catégorie avec ce nom existe déjà.';
            } else {
                dbExecute(
                    'UPDATE categories SET name = ?, slug = ?, icon = ?, sort_order = ? WHERE id = ?',
                    [$name, $slug, $icon, $sortOrder, $id]
                );
                $success = 'Catégorie modifiée.';
            }
        }
    }

    // Supprimer une catégorie
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);

        // Vérifier si des produits utilisent cette catégorie
        $productsCount = dbFetchOne('SELECT COUNT(*) as count FROM products WHERE category_id = ?', [$id])['count'];

        if ($productsCount > 0) {
            $error = "Impossible de supprimer : $productsCount produit(s) utilisent cette catégorie.";
        } else {
            dbExecute('DELETE FROM categories WHERE id = ?', [$id]);
            $success = 'Catégorie supprimée.';
        }
    }
}

// Récupérer les catégories avec le nombre de produits
$categories = dbFetchAll(
    'SELECT c.*, COUNT(p.id) as products_count
     FROM categories c
     LEFT JOIN products p ON c.id = p.category_id
     GROUP BY c.id
     ORDER BY c.sort_order, c.name'
);

$pageTitle = 'Catégories';
include ROOT_PATH . '/admin/includes/header.php';
?>

<?php if ($success): ?>
    <div class="alert alert-success"><?= e($success) ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error"><?= e($error) ?></div>
<?php endif; ?>

<!-- Formulaire d'ajout -->
<div class="admin-card">
    <h2>Ajouter une catégorie</h2>
    <form method="POST" class="inline-form">
        <?= csrf_field() ?>
        <input type="hidden" name="action" value="add">

        <div class="inline-form-row">
            <div class="form-group">
                <label for="add_icon">Emoji</label>
                <input type="text" id="add_icon" name="icon" class="form-control" placeholder="🪑" maxlength="10" style="width: 80px; text-align: center; font-size: 1.5rem;">
            </div>

            <div class="form-group" style="flex: 1;">
                <label for="add_name">Nom *</label>
                <input type="text" id="add_name" name="name" class="form-control" required placeholder="Ex: Meubles">
            </div>

            <div class="form-group">
                <label for="add_sort">Ordre</label>
                <input type="number" id="add_sort" name="sort_order" class="form-control" value="0" min="0" style="width: 80px;">
            </div>

            <div class="form-group" style="align-self: flex-end;">
                <button type="submit" class="btn btn-primary">➕ Ajouter</button>
            </div>
        </div>
    </form>
</div>

<!-- Liste des catégories -->
<div class="admin-card">
    <h2>Catégories existantes (<?= count($categories) ?>)</h2>

    <?php if (empty($categories)): ?>
        <p class="empty-state">Aucune catégorie.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Ordre</th>
                    <th style="width: 60px;">Emoji</th>
                    <th>Nom</th>
                    <th>Slug</th>
                    <th>Produits</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                <tr>
                    <form method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" value="<?= $cat['id'] ?>">

                        <td>
                            <input type="number" name="sort_order" value="<?= $cat['sort_order'] ?>" class="form-control form-control-sm" min="0" style="width: 60px;">
                        </td>
                        <td>
                            <input type="text" name="icon" value="<?= e($cat['icon']) ?>" class="form-control form-control-sm" maxlength="10" style="width: 50px; text-align: center; font-size: 1.2rem;">
                        </td>
                        <td>
                            <input type="text" name="name" value="<?= e($cat['name']) ?>" class="form-control form-control-sm" required>
                        </td>
                        <td>
                            <code><?= e($cat['slug']) ?></code>
                        </td>
                        <td>
                            <?php if ($cat['products_count'] > 0): ?>
                                <a href="<?= admin_url('products?category=' . $cat['id']) ?>"><?= $cat['products_count'] ?> produit(s)</a>
                            <?php else: ?>
                                <span class="text-muted">0</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="actions-group">
                                <button type="submit" class="btn btn-sm btn-secondary" title="Enregistrer">💾</button>
                    </form>
                                <form method="POST" style="display: inline;" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer" <?= $cat['products_count'] > 0 ? 'disabled' : '' ?>>🗑️</button>
                                </form>
                            </div>
                        </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<style>
.inline-form-row {
    display: flex;
    gap: 15px;
    align-items: flex-start;
    flex-wrap: wrap;
}

.form-control-sm {
    padding: 8px 10px;
    font-size: 0.9rem;
}

.text-muted {
    color: var(--admin-text-light);
}

code {
    background: var(--admin-bg);
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.85rem;
}
</style>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
