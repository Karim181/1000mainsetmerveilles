<?php
/**
 * Création produit - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

$user = auth_user();
$categories = dbFetchAll('SELECT * FROM categories ORDER BY sort_order');

$errors = [];
$data = [
    'name' => '',
    'description' => '',
    'price' => '',
    'category_id' => '',
    'status' => 'available',
    'is_featured' => 0,
];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'price' => $_POST['price'] ?? '',
        'category_id' => $_POST['category_id'] ?? '',
        'status' => $_POST['status'] ?? 'available',
        'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
    ];

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

    // Génération du slug
    $slug = slugify($data['name']);
    $existingSlug = dbFetchOne('SELECT id FROM products WHERE slug = ?', [$slug]);
    if ($existingSlug) {
        $slug .= '-' . time();
    }

    // Upload image
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = uploadImage($_FILES['image'], 'products');
        if ($uploadResult['success']) {
            $imageName = $uploadResult['filename'];
        } else {
            $errors[] = $uploadResult['error'];
        }
    }

    // Insertion si pas d'erreurs
    if (empty($errors)) {
        $sql = 'INSERT INTO products (name, slug, description, price, category_id, image, status, is_featured, author_id, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())';

        dbExecute($sql, [
            $data['name'],
            $slug,
            $data['description'],
            $data['price'],
            $data['category_id'],
            $imageName,
            $data['status'],
            $data['is_featured'],
            $user['id'],
        ]);

        $productId = dbLastId();

        // Redirection selon le bouton cliqué
        if (isset($_POST['save_and_preview'])) {
            header('Location: ' . admin_url('products/preview?id=' . $productId));
        } else {
            header('Location: ' . admin_url('products') . '?success=Produit créé avec succès');
        }
        exit;
    }
}

$pageTitle = 'Nouveau produit';
include ROOT_PATH . '/admin/includes/header.php';
?>

<div class="admin-card">
    <h2>Créer un produit</h2>

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
