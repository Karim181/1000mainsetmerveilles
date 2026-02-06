<?php
/**
 * Création actualité - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

$user = auth_user();

$errors = [];
$data = [
    'title' => '',
    'content' => '',
    'excerpt' => '',
    'status' => 'draft',
];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $data = [
        'title' => trim($_POST['title'] ?? ''),
        'content' => trim($_POST['content'] ?? ''),
        'excerpt' => trim($_POST['excerpt'] ?? ''),
        'status' => $_POST['status'] ?? 'draft',
    ];

    // Validation
    if (empty($data['title'])) {
        $errors[] = 'Le titre est obligatoire.';
    }

    if (empty($data['content'])) {
        $errors[] = 'Le contenu est obligatoire.';
    }

    // Génération du slug
    $slug = slugify($data['title']);
    $existingSlug = dbFetchOne('SELECT id FROM news WHERE slug = ?', [$slug]);
    if ($existingSlug) {
        $slug .= '-' . time();
    }

    // Génération de l'extrait si vide
    $excerpt = $data['excerpt'];
    if (empty($excerpt) && !empty($data['content'])) {
        $excerpt = substr(strip_tags($data['content']), 0, 200);
    }

    // Upload image
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = uploadImage($_FILES['image'], 'news');
        if ($uploadResult['success']) {
            $imageName = $uploadResult['filename'];
        } else {
            $errors[] = $uploadResult['error'];
        }
    }

    // Date de publication
    $publishedAt = null;
    if ($data['status'] === 'published') {
        $publishedAt = date('Y-m-d H:i:s');
    }

    // Insertion si pas d'erreurs
    if (empty($errors)) {
        $sql = 'INSERT INTO news (title, slug, content, excerpt, image, status, author_id, published_at, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())';

        dbExecute($sql, [
            $data['title'],
            $slug,
            $data['content'],
            $excerpt,
            $imageName,
            $data['status'],
            $user['id'],
            $publishedAt,
        ]);

        $newsId = dbLastId();

        // Redirection selon le bouton cliqué
        if (isset($_POST['save_and_preview'])) {
            header('Location: ' . admin_url('news/preview?id=' . $newsId));
        } else {
            header('Location: ' . admin_url('news') . '?success=Actualité créée avec succès');
        }
        exit;
    }
}

$pageTitle = 'Nouvelle actualité';
include ROOT_PATH . '/admin/includes/header.php';
?>

<div class="admin-card">
    <h2>Créer une actualité</h2>

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

        <div class="form-group">
            <label for="title">Titre *</label>
            <input type="text" id="title" name="title" value="<?= e($data['title']) ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="excerpt">Résumé (extrait pour la liste)</label>
            <textarea id="excerpt" name="excerpt" class="form-control" rows="2" placeholder="Laissez vide pour génération automatique"><?= e($data['excerpt']) ?></textarea>
            <small class="form-help">200 caractères max. Si vide, sera généré depuis le contenu.</small>
        </div>

        <div class="form-group">
            <label for="content">Contenu *</label>
            <textarea id="content" name="content" class="form-control" rows="12" required><?= e($data['content']) ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="status">Statut</label>
                <select id="status" name="status" class="form-control">
                    <option value="draft" <?= $data['status'] === 'draft' ? 'selected' : '' ?>>Brouillon</option>
                    <option value="published" <?= $data['status'] === 'published' ? 'selected' : '' ?>>Publié</option>
                </select>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/jpeg,image/png,image/webp">
                <small class="form-help">Formats acceptés : JPG, PNG, WebP. Max 2 Mo.</small>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" name="save" class="btn btn-primary">💾 Enregistrer</button>
            <button type="submit" name="save_and_preview" class="btn btn-secondary">👁️ Enregistrer et prévisualiser</button>
            <a href="<?= admin_url('news') ?>" class="btn btn-link">Annuler</a>
        </div>
    </form>
</div>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
