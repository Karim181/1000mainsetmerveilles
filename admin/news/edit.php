<?php
/**
 * Édition actualité - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

$user = auth_user();

// Récupérer l'actualité
$id = (int)($_GET['id'] ?? 0);
$article = dbFetchOne('SELECT * FROM news WHERE id = ?', [$id]);

if (!$article) {
    header('Location: ' . admin_url('news') . '?error=Actualité introuvable');
    exit;
}

// Vérifier les droits (admin ou auteur)
if (!auth_is_admin() && $article['author_id'] != $user['id']) {
    header('Location: ' . admin_url('news') . '?error=Accès non autorisé');
    exit;
}

$errors = [];
$data = $article;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $data = array_merge($article, [
        'title' => trim($_POST['title'] ?? ''),
        'content' => trim($_POST['content'] ?? ''),
        'excerpt' => trim($_POST['excerpt'] ?? ''),
        'status' => $_POST['status'] ?? 'draft',
    ]);

    // Validation
    if (empty($data['title'])) {
        $errors[] = 'Le titre est obligatoire.';
    }

    if (empty($data['content'])) {
        $errors[] = 'Le contenu est obligatoire.';
    }

    // Mise à jour du slug si le titre a changé
    $slug = $article['slug'];
    if ($data['title'] !== $article['title']) {
        $slug = slugify($data['title']);
        $existingSlug = dbFetchOne('SELECT id FROM news WHERE slug = ? AND id != ?', [$slug, $id]);
        if ($existingSlug) {
            $slug .= '-' . time();
        }
    }

    // Génération de l'extrait si vide
    $excerpt = $data['excerpt'];
    if (empty($excerpt) && !empty($data['content'])) {
        $excerpt = substr(strip_tags($data['content']), 0, 200);
    }

    // Upload image
    $imageName = $article['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = uploadImage($_FILES['image'], 'news');
        if ($uploadResult['success']) {
            // Supprimer l'ancienne image
            if ($article['image']) {
                deleteImage($article['image'], 'news');
            }
            $imageName = $uploadResult['filename'];
        } else {
            $errors[] = $uploadResult['error'];
        }
    }

    // Suppression image si demandé
    if (isset($_POST['delete_image']) && $article['image']) {
        deleteImage($article['image'], 'news');
        $imageName = null;
    }

    // Mise à jour de published_at si statut change vers "published"
    $publishedAt = $article['published_at'];
    if ($data['status'] === 'published' && $article['status'] !== 'published') {
        $publishedAt = date('Y-m-d H:i:s');
    }

    // Mise à jour si pas d'erreurs
    if (empty($errors)) {
        $sql = 'UPDATE news SET
                title = ?, slug = ?, content = ?, excerpt = ?,
                image = ?, status = ?, published_at = ?, updated_at = NOW()
                WHERE id = ?';

        dbExecute($sql, [
            $data['title'],
            $slug,
            $data['content'],
            $excerpt,
            $imageName,
            $data['status'],
            $publishedAt,
            $id,
        ]);

        // Redirection selon le bouton cliqué
        if (isset($_POST['save_and_preview'])) {
            header('Location: ' . admin_url('news/preview?id=' . $id));
        } else {
            header('Location: ' . admin_url('news') . '?success=Actualité mise à jour');
        }
        exit;
    }
}

$pageTitle = 'Modifier : ' . $article['title'];
include ROOT_PATH . '/admin/includes/header.php';
?>

<div class="admin-card">
    <div class="card-header">
        <h2>Modifier l'actualité</h2>
        <a href="<?= admin_url('news/preview?id=' . $article['id']) ?>" class="btn btn-secondary">👁️ Prévisualiser</a>
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

        <div class="form-group">
            <label for="title">Titre *</label>
            <input type="text" id="title" name="title" value="<?= e($data['title']) ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="excerpt">Résumé (extrait pour la liste)</label>
            <textarea id="excerpt" name="excerpt" class="form-control" rows="2"><?= e($data['excerpt']) ?></textarea>
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
                <?php if ($data['image']): ?>
                    <div class="current-image">
                        <img src="<?= upload_url('news/' . $data['image']) ?>" alt="" class="preview-image">
                        <label class="checkbox-label">
                            <input type="checkbox" name="delete_image" value="1">
                            Supprimer cette image
                        </label>
                    </div>
                <?php endif; ?>
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
