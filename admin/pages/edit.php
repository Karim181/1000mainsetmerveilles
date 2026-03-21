<?php
/**
 * Edition contenu d'une page - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

$pageSlug = $_GET['slug'] ?? '';
$pageNames = [
    'home' => 'Accueil',
    'qui-sommes-nous' => 'Qui sommes-nous',
    'la-ressourcerie' => 'La Ressourcerie',
    'dons' => 'Faire un don',
    'venir-chiner' => 'Venir chiner',
    'nous-rejoindre' => 'Nous rejoindre',
];

if (!isset($pageNames[$pageSlug])) {
    header('Location: ' . admin_url('pages'));
    exit;
}

$success = '';
$errors = [];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $user = auth_user();
    $textFields = $_POST['content'] ?? [];
    $imageFields = $_FILES['image'] ?? [];
    $deleteImages = $_POST['delete_image'] ?? [];

    foreach ($textFields as $sectionKey => $value) {
        dbExecute(
            'UPDATE page_contents SET content_text = ?, updated_by = ?, updated_at = NOW() WHERE page_slug = ? AND section_key = ?',
            [trim($value), $user['id'], $pageSlug, $sectionKey]
        );
    }

    // Upload d'images
    if (!empty($imageFields['name'])) {
        foreach ($imageFields['name'] as $sectionKey => $filename) {
            if (!empty($filename) && $imageFields['error'][$sectionKey] === UPLOAD_ERR_OK) {
                $file = [
                    'name' => $imageFields['name'][$sectionKey],
                    'type' => $imageFields['type'][$sectionKey],
                    'tmp_name' => $imageFields['tmp_name'][$sectionKey],
                    'error' => $imageFields['error'][$sectionKey],
                    'size' => $imageFields['size'][$sectionKey],
                ];

                // Supprimer l'ancienne image
                $old = dbFetchOne(
                    'SELECT content_image FROM page_contents WHERE page_slug = ? AND section_key = ?',
                    [$pageSlug, $sectionKey]
                );
                if ($old && $old['content_image']) {
                    deleteImage($old['content_image'], 'pages');
                }

                $result = uploadImage($file, 'pages');
                if ($result['success']) {
                    dbExecute(
                        'UPDATE page_contents SET content_image = ?, updated_by = ?, updated_at = NOW() WHERE page_slug = ? AND section_key = ?',
                        [$result['filename'], $user['id'], $pageSlug, $sectionKey]
                    );
                } else {
                    $errors[] = 'Erreur upload ' . $sectionKey . ' : ' . $result['error'];
                }
            }
        }
    }

    // Suppression d'images
    foreach ($deleteImages as $sectionKey => $val) {
        $old = dbFetchOne(
            'SELECT content_image FROM page_contents WHERE page_slug = ? AND section_key = ?',
            [$pageSlug, $sectionKey]
        );
        if ($old && $old['content_image']) {
            deleteImage($old['content_image'], 'pages');
            dbExecute(
                'UPDATE page_contents SET content_image = NULL, updated_by = ?, updated_at = NOW() WHERE page_slug = ? AND section_key = ?',
                [$user['id'], $pageSlug, $sectionKey]
            );
        }
    }

    if (empty($errors)) {
        $success = 'Contenus mis a jour avec succes !';
    }
}

// Charger les contenus
$contents = dbFetchAll(
    'SELECT * FROM page_contents WHERE page_slug = ? ORDER BY id',
    [$pageSlug]
);

$pageTitle = 'Modifier : ' . $pageNames[$pageSlug];
include ROOT_PATH . '/admin/includes/header.php';
?>

<div class="admin-card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h2><?= e($pageNames[$pageSlug]) ?></h2>
        <a href="<?= url($pageSlug === 'home' ? '' : $pageSlug) ?>" target="_blank" class="btn btn-link">Voir la page</a>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= e($success) ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= e($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (empty($contents)): ?>
        <p style="color: #8b7e74; padding: 40px; text-align: center;">Aucun bloc editable pour cette page.<br>Les contenus seront ajoutes automatiquement.</p>
    <?php else: ?>
        <form method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <?php foreach ($contents as $content): ?>
            <div class="page-block">
                <label class="page-block-label"><?= e($content['label']) ?></label>

                <?php if ($content['content_type'] === 'text'): ?>
                    <input type="text" name="content[<?= e($content['section_key']) ?>]"
                           value="<?= e($content['content_text'] ?? '') ?>"
                           class="form-control">
                    <small class="form-help">Vous pouvez utiliser &lt;span class="highlight-turquoise"&gt;texte&lt;/span&gt; pour colorer un mot.</small>

                <?php elseif ($content['content_type'] === 'textarea'): ?>
                    <textarea name="content[<?= e($content['section_key']) ?>]"
                              class="form-control" rows="4"><?= e($content['content_text'] ?? '') ?></textarea>

                <?php elseif ($content['content_type'] === 'image'): ?>
                    <?php if ($content['content_image']): ?>
                        <div class="page-block-image">
                            <img src="<?= upload_url('pages/' . $content['content_image']) ?>" alt="" style="max-width: 200px; border-radius: 10px;">
                            <label style="margin-left: 15px; color: #e74c3c; cursor: pointer;">
                                <input type="checkbox" name="delete_image[<?= e($content['section_key']) ?>]" value="1"> Supprimer
                            </label>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image[<?= e($content['section_key']) ?>]"
                           class="form-control" accept="image/jpeg,image/png,image/webp">
                    <small class="form-help">JPG, PNG ou WebP. Max 5 Mo.</small>
                <?php endif; ?>

                <?php if ($content['updated_at']): ?>
                    <small class="form-help" style="margin-top: 5px;">Derniere modification : <?= date('d/m/Y a H:i', strtotime($content['updated_at'])) ?></small>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="<?= admin_url('pages') ?>" class="btn btn-link">Retour</a>
            </div>
        </form>
    <?php endif; ?>
</div>

<style>
.page-block {
    padding: 20px 0;
    border-bottom: 1px solid #f0ebe5;
}

.page-block:last-of-type {
    border-bottom: none;
}

.page-block-label {
    display: block;
    font-weight: 700;
    color: var(--admin-text);
    margin-bottom: 8px;
    font-size: 15px;
}

.page-block-image {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}
</style>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
