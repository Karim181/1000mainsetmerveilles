<?php
/**
 * Édition produit - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

$user = auth_user();

// Récupérer le produit
$id = (int)($_GET['id'] ?? 0);
$product = dbFetchOne('SELECT * FROM products WHERE id = ?', [$id]);

if (!$product) {
    header('Location: ' . admin_url('products') . '?error=Produit introuvable');
    exit;
}

// Vérifier les droits (admin ou auteur)
if (!auth_is_admin() && $product['author_id'] != $user['id']) {
    header('Location: ' . admin_url('products') . '?error=Accès non autorisé');
    exit;
}

$categories = dbFetchAll('SELECT * FROM categories ORDER BY sort_order');

$errors = [];
$data = $product;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $data = array_merge($product, [
        'name' => trim($_POST['name'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'price' => $_POST['price'] ?? '',
        'category_id' => $_POST['category_id'] ?? '',
        'status' => $_POST['status'] ?? 'available',
        'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
    ]);

    // Validation
    if (empty($data['name'])) {
        $errors[] = 'Le nom est obligatoire.';
    }

    if (empty($data['price']) || !is_numeric($data['price']) || $data['price'] < 0) {
        $errors[] = 'Le prix doit être un nombre positif.';
    }

    if (empty($data['category_id'])) {
        $errors[] = 'La catégorie est obligatoire.';
    }

    // Mise à jour du slug si le nom a changé
    $slug = $product['slug'];
    if ($data['name'] !== $product['name']) {
        $slug = slugify($data['name']);
        $existingSlug = dbFetchOne('SELECT id FROM products WHERE slug = ? AND id != ?', [$slug, $id]);
        if ($existingSlug) {
            $slug .= '-' . time();
        }
    }

    // Upload image
    $imageName = $product['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = uploadImage($_FILES['image'], 'products');
        if ($uploadResult['success']) {
            // Supprimer l'ancienne image
            if ($product['image']) {
                deleteImage($product['image'], 'products');
            }
            $imageName = $uploadResult['filename'];
        } else {
            $errors[] = $uploadResult['error'];
        }
    }

    // Suppression image si demandé
    if (isset($_POST['delete_image']) && $product['image']) {
        deleteImage($product['image'], 'products');
        $imageName = null;
    }

    // Mise à jour du sold_at si statut change vers "sold"
    $soldAt = $product['sold_at'];
    if ($data['status'] === 'sold' && $product['status'] !== 'sold') {
        $soldAt = date('Y-m-d H:i:s');
    } elseif ($data['status'] !== 'sold') {
        $soldAt = null;
    }

    // Mise à jour si pas d'erreurs
    if (empty($errors)) {
        $sql = 'UPDATE products SET
                name = ?, slug = ?, description = ?, price = ?, category_id = ?,
                image = ?, status = ?, is_featured = ?, sold_at = ?, updated_at = NOW()
                WHERE id = ?';

        dbExecute($sql, [
            $data['name'],
            $slug,
            $data['description'],
            $data['price'],
            $data['category_id'],
            $imageName,
            $data['status'],
            $data['is_featured'],
            $soldAt,
            $id,
        ]);

        // Redirection selon le bouton cliqué
        if (isset($_POST['save_and_preview'])) {
            header('Location: ' . admin_url('products/preview?id=' . $id));
        } else {
            header('Location: ' . admin_url('products') . '?success=Produit mis à jour');
        }
        exit;
    }
}

$pageTitle = 'Modifier : ' . $product['name'];
include ROOT_PATH . '/admin/includes/header.php';
?>

<div class="admin-card">
    <div class="card-header">
        <h2>Modifier le produit</h2>
        <a href="<?= admin_url('products/preview?id=' . $product['id']) ?>" class="btn btn-secondary">👁️ Prévisualiser</a>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= e($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-row">
            <div class="form-group">
                <label for="name">Nom du produit *</label>
                <input type="text" id="name" name="name" value="<?= e($data['name']) ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="price">Prix (€) *</label>
                <input type="number" id="price" name="price" value="<?= e($data['price']) ?>" class="form-control" step="0.01" min="0" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category_id">Catégorie *</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">Choisir une catégorie</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $data['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                            <?= $cat['icon'] ?> <?= e($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Statut</label>
                <select id="status" name="status" class="form-control">
                    <option value="available" <?= $data['status'] === 'available' ? 'selected' : '' ?>>Disponible</option>
                    <option value="reserved" <?= $data['status'] === 'reserved' ? 'selected' : '' ?>>Réservé</option>
                    <option value="sold" <?= $data['status'] === 'sold' ? 'selected' : '' ?>>Vendu</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="5"><?= e($data['description']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <?php if ($data['image']): ?>
                <div class="current-image">
                    <img src="<?= upload_url('products/' . $data['image']) ?>" alt="" class="preview-image">
                    <label class="checkbox-label">
                        <input type="checkbox" name="delete_image" value="1">
                        Supprimer cette image
                    </label>
                </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" class="form-control" accept="image/jpeg,image/png,image/webp">
            <small class="form-help">Formats acceptés : JPG, PNG, WebP. Max 2 Mo.</small>
        </div>

        <div class="form-group">
            <label class="checkbox-label">
                <input type="checkbox" name="is_featured" value="1" <?= $data['is_featured'] ? 'checked' : '' ?>>
                ⭐ Mettre en avant (Pépite de la semaine)
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" name="save" class="btn btn-primary">💾 Enregistrer</button>
            <button type="submit" name="save_and_preview" class="btn btn-secondary">👁️ Enregistrer et prévisualiser</button>
            <a href="<?= admin_url('products') ?>" class="btn btn-link">Annuler</a>
        </div>
    </form>
</div>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
