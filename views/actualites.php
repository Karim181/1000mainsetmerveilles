<?php
/**
 * Page Actualités - Liste publique des actualités
 * 1000 Mains et Merveilles
 */

// Mois en français
$moisFr = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

// Récupérer les actualités publiées
$actualites = dbFetchAll(
    'SELECT * FROM news
     WHERE status = "published"
     ORDER BY published_at DESC, created_at DESC'
);

// Récupérer les 3 dernières pour "À la une"
$aLaUne = array_slice($actualites, 0, 3);
$autresActualites = array_slice($actualites, 3);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualités | 1000 Mains et Merveilles</title>
    <meta name="description" content="Toutes les actualités de l'association 1000 Mains et Merveilles. Découvrez nos dernières nouvelles, événements et projets.">

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

    <!-- ========== HERO ========== -->
    <section class="page-hero">
        <div class="container">
            <div class="page-hero-content">
                <div class="page-hero-text">
                    <span class="hero-label-final">Blog</span>
                    <h1>Nos <span class="highlight-turquoise">actualités</span></h1>
                    <p class="hero-description-final">Retrouvez toutes les nouvelles de l'association : projets, événements passés, témoignages et bien plus encore.</p>
                </div>
                <div class="page-hero-photo">
                    <div class="photo-placeholder-final hero-page-size">
                        <div class="photo-icon-final">📰</div>
                        <p>Photo : équipe<br>association</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="wave-final">
            <svg viewBox="0 0 1440 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#faf8f5" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,165.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- ========== À LA UNE ========== -->
    <?php if (!empty($aLaUne)): ?>
    <section class="actualites-une">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-orange">À la une 📰</span>
                <h2>Les dernières <span class="highlight-turquoise">nouvelles</span></h2>
            </div>

            <div class="une-grid">
                <?php foreach ($aLaUne as $index => $news): ?>
                <?php
                $dateNews = strtotime($news['published_at'] ?? $news['created_at']);
                $jour = date('d', $dateNews);
                $mois = $moisFr[(int)date('n', $dateNews)];
                $annee = date('Y', $dateNews);
                ?>
                <article class="une-card <?= $index === 0 ? 'une-card-large' : '' ?>">
                    <?php if ($news['image']): ?>
                        <div class="une-image">
                            <img src="<?= upload_url('news/' . $news['image']) ?>" alt="<?= e($news['title']) ?>">
                        </div>
                    <?php else: ?>
                        <div class="une-image une-image-placeholder">
                            <div class="photo-placeholder-final">
                                <div class="photo-icon-final">📰</div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="une-content">
                        <span class="une-date"><?= $jour ?> <?= $mois ?> <?= $annee ?></span>
                        <h3><?= e($news['title']) ?></h3>
                        <?php if ($news['excerpt']): ?>
                            <p><?= e($news['excerpt']) ?></p>
                        <?php else: ?>
                            <p><?= e(substr(strip_tags($news['content']), 0, 150)) ?>...</p>
                        <?php endif; ?>
                        <a href="<?= url('actualite?slug=' . $news['slug']) ?>" class="une-link">Lire la suite →</a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ========== TOUTES LES ACTUALITES ========== -->
    <?php if (!empty($autresActualites)): ?>
    <section class="actualites-liste">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-turquoise">Archives</span>
                <h2>Toutes nos <span class="highlight-turquoise">actualités</span></h2>
            </div>

            <div class="actualites-grid">
                <?php foreach ($autresActualites as $news): ?>
                <?php
                $dateNews = strtotime($news['published_at'] ?? $news['created_at']);
                $jour = date('d', $dateNews);
                $mois = $moisFr[(int)date('n', $dateNews)];
                $annee = date('Y', $dateNews);
                ?>
                <article class="actualite-card">
                    <?php if ($news['image']): ?>
                        <div class="actualite-image">
                            <img src="<?= upload_url('news/' . $news['image']) ?>" alt="<?= e($news['title']) ?>">
                        </div>
                    <?php else: ?>
                        <div class="actualite-image actualite-image-placeholder">
                            <div class="photo-placeholder-final actualite-placeholder-size">
                                <div class="photo-icon-final">📰</div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="actualite-content">
                        <span class="actualite-date"><?= $jour ?> <?= $mois ?> <?= $annee ?></span>
                        <h3><?= e($news['title']) ?></h3>
                        <?php if ($news['excerpt']): ?>
                            <p><?= e(substr($news['excerpt'], 0, 100)) ?>...</p>
                        <?php endif; ?>
                        <a href="<?= url('actualite?slug=' . $news['slug']) ?>" class="actualite-link">Lire →</a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ========== MESSAGE SI VIDE ========== -->
    <?php if (empty($actualites)): ?>
    <section class="actualites-vide">
        <div class="container">
            <div class="vide-message">
                <span class="vide-icon">📰</span>
                <h2>Pas encore d'actualités</h2>
                <p>Nos premières actualités arrivent bientôt ! En attendant, découvrez notre association.</p>
                <a href="<?= url('la-ressourcerie') ?>" class="btn-cta-final">Découvrir la ressourcerie</a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ========== CTA ========== -->
    <section class="cta-final">
        <div class="container">
            <div class="cta-final-box">
                <div class="cta-final-content">
                    <span class="cta-emoji-final">💌</span>
                    <h2>Restez informés !</h2>
                    <p>Inscrivez-vous à notre newsletter pour ne manquer aucune actualité de l'association.</p>
                    <div class="cta-buttons">
                        <a href="<?= url('nous-rejoindre') ?>" class="btn-cta-final">S'inscrire à la newsletter</a>
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

    <!-- ========== FOOTER ========== -->
    <footer class="footer-final">
        <div class="container">
            <div class="footer-final-grid">
                <div class="footer-main-final">
                    <img src="<?= asset('images/1000-mains-et-merveilles-2.png') ?>" alt="Logo" class="footer-logo-final">
                    <p class="footer-tagline-final">Ensemble, donnons une seconde vie aux objets et créons du lien</p>
                </div>
                <div class="footer-links-final">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="<?= url() ?>">Qui sommes-nous ?</a></li>
                        <li><a href="<?= url('la-ressourcerie') ?>">La Ressourcerie</a></li>
                        <li><a href="<?= url('dons') ?>">Faire un don</a></li>
                        <li><a href="<?= url('agenda') ?>">Agenda</a></li>
                    </ul>
                </div>
                <div class="footer-links-final">
                    <h4>Nous contacter</h4>
                    <ul>
                        <li><a href="<?= url('nous-rejoindre') ?>">Nous rejoindre</a></li>
                    </ul>
                </div>
                <div class="footer-newsletter-final">
                    <h4>Newsletter</h4>
                    <p>Restez informés de nos actualités</p>
                    <form class="newsletter-final" action="#" method="post">
                        <input type="email" placeholder="Votre email" required>
                        <button type="submit">→</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom-final">
                <p>&copy; 2026 1000 Mains et Merveilles - Association loi 1901</p>
                <div class="footer-legal-final">
                    <a href="<?= url('mentions-legales') ?>">Mentions légales</a>
                    <a href="<?= url('confidentialite') ?>">Confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
