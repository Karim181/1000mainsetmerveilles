<?php
/**
 * Prévisualisation actualité - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

// Récupérer l'actualité
$id = (int)($_GET['id'] ?? 0);
$article = dbFetchOne(
    'SELECT n.*, u.name as author_name
     FROM news n
     LEFT JOIN users u ON n.author_id = u.id
     WHERE n.id = ?',
    [$id]
);

if (!$article) {
    header('Location: ' . admin_url('news') . '?error=Actualité introuvable');
    exit;
}

$pageTitle = 'Prévisualisation : ' . $article['title'];
include ROOT_PATH . '/admin/includes/header.php';
?>

<?php $user = auth_user(); ?>
<div class="preview-actions">
    <a href="<?= admin_url('news/edit?id=' . $article['id']) ?>" class="btn btn-primary">✏️ Modifier</a>
    <a href="<?= admin_url('news') ?>" class="btn btn-secondary">← Retour à la liste</a>
    <?php if (auth_is_admin() || $article['author_id'] == $user['id']): ?>
        <a href="<?= admin_url('news/delete?id=' . $article['id']) ?>" class="btn btn-danger" onclick="return confirm('Supprimer cette actualité ?')">🗑️ Supprimer</a>
    <?php endif; ?>

    <?php if ($article['status'] === 'published'): ?>
        <span class="badge badge-success" style="margin-left: auto; font-size: 1rem; padding: 10px 20px;">✅ Cette actualité est publiée</span>
    <?php else: ?>
        <span class="badge badge-warning" style="margin-left: auto; font-size: 1rem; padding: 10px 20px;">📝 Brouillon - non visible publiquement</span>
    <?php endif; ?>
</div>

<div class="preview-container">
    <div class="preview-label">Aperçu du rendu public</div>

    <div class="preview-content">
        <!-- Simulation du rendu public -->
        <article class="news-preview">
            <?php if ($article['image']): ?>
                <div class="news-preview-image">
                    <img src="<?= upload_url('news/' . $article['image']) ?>" alt="<?= e($article['title']) ?>">
                </div>
            <?php endif; ?>

            <div class="news-preview-content">
                <div class="news-preview-meta">
                    <span class="news-preview-date">
                        📅 <?= $article['published_at'] ? date('d F Y', strtotime($article['published_at'])) : 'Non publié' ?>
                    </span>
                    <span class="news-preview-author">
                        ✍️ <?= e($article['author_name']) ?>
                    </span>
                </div>

                <h1 class="news-preview-title"><?= e($article['title']) ?></h1>

                <?php if ($article['excerpt']): ?>
                    <p class="news-preview-excerpt"><?= e($article['excerpt']) ?></p>
                <?php endif; ?>

                <div class="news-preview-body">
                    <?= nl2br(e($article['content'])) ?>
                </div>
            </div>
        </article>
    </div>
</div>

<style>
.preview-actions {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    align-items: center;
}

.preview-container {
    background: #f8fafc;
    border: 2px dashed var(--admin-border);
    border-radius: 12px;
    overflow: hidden;
}

.preview-label {
    background: var(--admin-primary);
    color: white;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 0.9rem;
}

.preview-content {
    padding: 30px;
    background: white;
}

/* Simulation du style public */
.news-preview {
    max-width: 800px;
    margin: 0 auto;
    font-family: 'DM Sans', sans-serif;
}

.news-preview-image {
    margin-bottom: 30px;
}

.news-preview-image img {
    width: 100%;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.news-preview-meta {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
    color: #64748b;
    font-size: 0.95rem;
}

.news-preview-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 20px;
    line-height: 1.2;
}

.news-preview-excerpt {
    font-size: 1.25rem;
    color: #64748b;
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid #e2e8f0;
    line-height: 1.6;
}

.news-preview-body {
    color: #475569;
    line-height: 1.8;
    font-size: 1.1rem;
}

.news-preview-body p {
    margin-bottom: 1.5em;
}

@media (max-width: 768px) {
    .news-preview-title {
        font-size: 1.75rem;
    }

    .preview-actions {
        flex-wrap: wrap;
    }
}
</style>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
