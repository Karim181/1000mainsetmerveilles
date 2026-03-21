<?php
/**
 * Page Actualité - Détail d'une actualité
 * 1000 Mains et Merveilles
 */

// Mois en français
$moisFr = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

// Récupérer le slug
$slug = $_GET['slug'] ?? '';

if (!$slug) {
    http_response_code(404);
    require ROOT_PATH . '/views/404.php';
    exit;
}

// Récupérer l'actualité
$news = dbFetchOne(
    'SELECT n.*, u.name as author_name
     FROM news n
     LEFT JOIN users u ON n.author_id = u.id
     WHERE n.slug = ? AND n.status = "published"',
    [$slug]
);

if (!$news) {
    http_response_code(404);
    require ROOT_PATH . '/views/404.php';
    exit;
}

// Date formatée
$dateNews = strtotime($news['published_at'] ?? $news['created_at']);
$jour = date('d', $dateNews);
$mois = $moisFr[(int)date('n', $dateNews)];
$annee = date('Y', $dateNews);

// Actualités récentes (pour sidebar)
$autresActualites = dbFetchAll(
    'SELECT id, title, slug, image, published_at, created_at
     FROM news
     WHERE status = "published" AND id != ?
     ORDER BY published_at DESC, created_at DESC
     LIMIT 3',
    [$news['id']]
);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($news['title']) ?> | 1000 Mains et Merveilles</title>
    <meta name="description" content="<?= e($news['excerpt'] ?? substr(strip_tags($news['content']), 0, 160)) ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= e($news['title']) ?>">
    <meta property="og:description" content="<?= e($news['excerpt'] ?? substr(strip_tags($news['content']), 0, 160)) ?>">
    <?php if ($news['image']): ?>
    <meta property="og:image" content="<?= upload_url('news/' . $news['image']) ?>">
    <?php endif; ?>

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/favicon-32x32.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('images/apple-icon-180x180.png') ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/actualites.css') ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <?php include ROOT_PATH . '/components/navbar.php'; ?>

    <!-- ========== HERO ARTICLE ========== -->
    <section class="article-hero">
        <div class="container">
            <div class="article-hero-content">
                <a href="<?= url('actualites') ?>" class="article-back">← Retour aux actualités</a>
                <span class="article-date"><?= $jour ?> <?= $mois ?> <?= $annee ?></span>
                <h1><?= e($news['title']) ?></h1>
                <?php if ($news['excerpt']): ?>
                    <p class="article-excerpt"><?= e($news['excerpt']) ?></p>
                <?php endif; ?>
                <div class="article-meta">
                    <span class="article-author">Par <?= e($news['author_name'] ?? 'L\'équipe') ?></span>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== CONTENU ARTICLE ========== -->
    <section class="article-section">
        <div class="container">
            <div class="article-layout">
                <!-- Contenu principal -->
                <article class="article-main">
                    <?php if ($news['image']): ?>
                    <div class="article-featured-image">
                        <img src="<?= upload_url('news/' . $news['image']) ?>" alt="<?= e($news['title']) ?>">
                    </div>
                    <?php endif; ?>

                    <div class="article-body">
                        <?= nl2br(e($news['content'])) ?>
                    </div>

                    <div class="article-share">
                        <span>Partager :</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(url('actualite?slug=' . $news['slug'])) ?>" target="_blank" class="share-btn share-facebook">Facebook</a>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(url('actualite?slug=' . $news['slug'])) ?>&text=<?= urlencode($news['title']) ?>" target="_blank" class="share-btn share-twitter">X</a>
                    </div>
                </article>

                <!-- Sidebar -->
                <aside class="article-sidebar">
                    <?php if (!empty($autresActualites)): ?>
                    <div class="sidebar-block">
                        <h3>Autres actualités</h3>
                        <div class="sidebar-news-list">
                            <?php foreach ($autresActualites as $autre): ?>
                            <?php
                            $dateAutre = strtotime($autre['published_at'] ?? $autre['created_at']);
                            ?>
                            <a href="<?= url('actualite?slug=' . $autre['slug']) ?>" class="sidebar-news-item">
                                <?php if ($autre['image']): ?>
                                    <img src="<?= upload_url('news/' . $autre['image']) ?>" alt="">
                                <?php else: ?>
                                    <div class="sidebar-news-placeholder">📰</div>
                                <?php endif; ?>
                                <div>
                                    <span class="sidebar-news-date"><?= date('d/m/Y', $dateAutre) ?></span>
                                    <h4><?= e($autre['title']) ?></h4>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="sidebar-block sidebar-cta">
                        <h3>Restez informés</h3>
                        <p>Inscrivez-vous à notre newsletter pour recevoir nos actualités.</p>
                        <a href="<?= url('nous-rejoindre') ?>" class="btn-cta-final">S'inscrire</a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- ========== CTA ========== -->
    <section class="cta-final">
        <div class="container">
            <div class="cta-final-box">
                <div class="cta-final-content">
                    <span class="cta-emoji-final">🤝</span>
                    <h2>Envie de participer ?</h2>
                    <p>Rejoignez notre équipe de bénévoles ou participez à nos prochains événements.</p>
                    <div class="cta-buttons">
                        <a href="<?= url('nous-rejoindre') ?>" class="btn-cta-final">Nous rejoindre</a>
                        <a href="<?= url('agenda') ?>" class="btn-cta-secondary">Voir l'agenda</a>
                    </div>
                </div>
                <div class="cta-photo-final">
                    <div class="photo-placeholder-final">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : équipe<br>bénévoles</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include ROOT_PATH . '/components/footer.php'; ?>

    <?php include ROOT_PATH . '/components/newsletter-modal.php'; ?>

</body>
</html>
