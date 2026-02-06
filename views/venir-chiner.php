<?php
/**
 * Page Venir Chiner - Affichage public des produits
 * 1000 Mains et Merveilles
 */

// Récupérer les pépites (produits mis en avant et disponibles)
$pepites = dbFetchAll(
    'SELECT p.*, c.name as category_name, c.icon as category_icon
     FROM products p
     LEFT JOIN categories c ON p.category_id = c.id
     WHERE p.is_featured = 1 AND p.status = "available"
     ORDER BY p.created_at DESC
     LIMIT 4'
);

// Récupérer les arrivages récents (produits disponibles non featured, des 7 derniers jours)
$arrivages = dbFetchAll(
    'SELECT p.*, c.name as category_name, c.icon as category_icon
     FROM products p
     LEFT JOIN categories c ON p.category_id = c.id
     WHERE p.status = "available" AND p.is_featured = 0
     ORDER BY p.created_at DESC
     LIMIT 6'
);

// Récupérer les catégories avec le nombre de produits
$categories = dbFetchAll(
    'SELECT c.*, COUNT(p.id) as products_count, MIN(p.price) as min_price
     FROM categories c
     LEFT JOIN products p ON c.id = p.category_id AND p.status = "available"
     GROUP BY c.id
     ORDER BY c.sort_order'
);

// Récupérer les produits vendus récemment
$vendus = dbFetchAll(
    'SELECT p.*, c.name as category_name, c.icon as category_icon
     FROM products p
     LEFT JOIN categories c ON p.category_id = c.id
     WHERE p.status = "sold"
     ORDER BY p.sold_at DESC
     LIMIT 6'
);

// Mois en français
$moisFr = ['', 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venir chiner - Pépites et objets de seconde main | 1000 Mains et Merveilles</title>
    <meta name="description" content="Découvrez nos pépites du moment et les arrivages récents dans notre ressourcerie à Plaisir (78). Meubles, vêtements, déco, livres... à prix solidaires.">

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/favicon-32x32.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('images/apple-icon-180x180.png') ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/venir-chiner.css') ?>">

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
                    <span class="hero-label-final">🛍️ Nos trouvailles</span>
                    <h1>Venir <span class="highlight-turquoise">chiner</span></h1>
                    <p class="hero-description-final">Des objets uniques, des prix solidaires. Découvrez nos pépites du moment et les derniers arrivages dans notre ressourcerie.</p>
                </div>
                <div class="page-hero-photo">
                    <div class="photo-placeholder-final hero-page-size">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : rayons de la<br>boutique avec des objets</p>
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

    <!-- ========== PEPITES EN RAYON ========== -->
    <section class="chiner-pepites">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-orange">Coups de coeur 💎</span>
                <h2>Les pépites <span class="highlight-turquoise">en rayon</span></h2>
                <p>Nos trouvailles préférées du moment, disponibles en boutique</p>
            </div>

            <div class="pepites-grid">
                <?php if (empty($pepites)): ?>
                    <p class="empty-message">Aucune pépite en ce moment. Revenez bientôt !</p>
                <?php else: ?>
                    <?php foreach ($pepites as $product): ?>
                    <article class="pepite-card">
                        <div class="pepite-photo">
                            <?php if ($product['image']): ?>
                                <img src="<?= upload_url('products/' . $product['image']) ?>" alt="<?= e($product['name']) ?>" class="pepite-img">
                            <?php else: ?>
                                <div class="photo-placeholder-final pepite-photo-size">
                                    <div class="photo-icon-final">📸</div>
                                </div>
                            <?php endif; ?>
                            <span class="pepite-badge badge-disponible">En rayon</span>
                        </div>
                        <div class="pepite-info">
                            <span class="pepite-categorie"><?= $product['category_icon'] ?> <?= e($product['category_name']) ?></span>
                            <h3><?= e($product['name']) ?></h3>
                            <?php if ($product['description']): ?>
                                <p><?= e(substr($product['description'], 0, 100)) ?><?= strlen($product['description']) > 100 ? '...' : '' ?></p>
                            <?php endif; ?>
                            <span class="pepite-prix"><?= number_format($product['price'], 0, ',', ' ') ?> €</span>
                        </div>
                    </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ========== ARRIVAGES RECENTS ========== -->
    <section class="chiner-arrivages">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-turquoise">Fraîchement arrivés 📦</span>
                <h2>Les arrivages <span class="highlight-turquoise">récents</span></h2>
                <p>Les derniers objets arrivés en boutique</p>
            </div>

            <div class="arrivages-grid">
                <?php if (empty($arrivages)): ?>
                    <p class="empty-message">Pas de nouveaux arrivages pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($arrivages as $product): ?>
                    <article class="arrivage-card">
                        <div class="arrivage-photo">
                            <?php if ($product['image']): ?>
                                <img src="<?= upload_url('products/' . $product['image']) ?>" alt="<?= e($product['name']) ?>" class="arrivage-img">
                            <?php else: ?>
                                <div class="photo-placeholder-final arrivage-photo-size">
                                    <div class="photo-icon-final">📸</div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="arrivage-info">
                            <?php
                            $dateCreation = strtotime($product['created_at']);
                            $jour = date('d', $dateCreation);
                            $mois = $moisFr[(int)date('n', $dateCreation)];
                            ?>
                            <span class="arrivage-date">📅 <?= $jour ?> <?= $mois ?></span>
                            <h3><?= e($product['name']) ?></h3>
                            <?php if ($product['description']): ?>
                                <p><?= e(substr($product['description'], 0, 80)) ?><?= strlen($product['description']) > 80 ? '...' : '' ?></p>
                            <?php endif; ?>
                        </div>
                    </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ========== NOS CATEGORIES ========== -->
    <section class="chiner-categories">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-orange">Nos rayons 🏷️</span>
                <h2>Explorez nos <span class="highlight-turquoise">catégories</span></h2>
                <p>Tout un univers d'objets à découvrir à prix solidaires</p>
            </div>

            <div class="categories-showcase">
                <?php foreach ($categories as $cat): ?>
                <article class="categorie-showcase-card">
                    <div class="categorie-showcase-icon"><?= $cat['icon'] ?: '📦' ?></div>
                    <h3><?= e($cat['name']) ?></h3>
                    <p><?= $cat['products_count'] ?> article<?= $cat['products_count'] > 1 ? 's' : '' ?> disponible<?= $cat['products_count'] > 1 ? 's' : '' ?></p>
                    <?php if ($cat['min_price']): ?>
                        <span class="categorie-fourchette">À partir de <?= number_format($cat['min_price'], 0, ',', ' ') ?> €</span>
                    <?php endif; ?>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ========== PEPITES VENDUES ========== -->
    <?php if (!empty($vendus)): ?>
    <section class="chiner-vendues">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-turquoise">Déjà parties ! 🎉</span>
                <h2>Les pépites <span class="highlight-turquoise">vendues</span></h2>
                <p>Elles ont trouvé preneur... Ne ratez pas les prochaines !</p>
            </div>

            <div class="vendues-grid">
                <?php foreach ($vendus as $product): ?>
                <article class="vendue-card">
                    <div class="vendue-photo">
                        <?php if ($product['image']): ?>
                            <img src="<?= upload_url('products/' . $product['image']) ?>" alt="<?= e($product['name']) ?>" class="vendue-img">
                        <?php else: ?>
                            <div class="photo-placeholder-final vendue-photo-size">
                                <div class="photo-icon-final">📸</div>
                            </div>
                        <?php endif; ?>
                        <span class="pepite-badge badge-vendu">Vendu</span>
                    </div>
                    <div class="vendue-info">
                        <h3><?= e($product['name']) ?></h3>
                        <span class="vendue-prix"><?= number_format($product['price'], 0, ',', ' ') ?> €</span>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ========== OU VENIR CHINER ========== -->
    <section class="chiner-lieu">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-orange">Nous trouver 📍</span>
                <h2>Où venir <span class="highlight-turquoise">chiner</span> ?</h2>
                <p>Notre boutique vous accueille à Plaisir</p>
            </div>

            <div class="lieu-grid">
                <div class="lieu-infos">
                    <div class="lieu-info-card">
                        <div class="info-icon">📍</div>
                        <div class="info-content">
                            <h3>Adresse</h3>
                            <p>Zone d'activité, Plaisir (78370)</p>
                            <p class="info-detail">Accès facile, parking gratuit</p>
                        </div>
                    </div>

                    <div class="lieu-info-card">
                        <div class="info-icon">🕐</div>
                        <div class="info-content">
                            <h3>Horaires boutique</h3>
                            <p><strong>Mardi au samedi :</strong> 10h - 18h</p>
                            <p class="info-detail">Fermé les dimanches et lundis</p>
                        </div>
                    </div>

                    <div class="lieu-info-card">
                        <div class="info-icon">💳</div>
                        <div class="info-content">
                            <h3>Paiement</h3>
                            <p>Espèces et carte bancaire acceptées</p>
                        </div>
                    </div>

                    <div class="lieu-info-card">
                        <div class="info-icon">♻️</div>
                        <div class="info-content">
                            <h3>Notre engagement</h3>
                            <p>100% des bénéfices financent nos actions solidaires et environnementales</p>
                        </div>
                    </div>
                </div>

                <div class="lieu-map">
                    <div class="photo-placeholder-final lieu-map-size">
                        <div class="photo-icon-final">🗺️</div>
                        <p>Carte / Plan d'accès<br>Google Maps</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== CTA ========== -->
    <section class="cta-final">
        <div class="container">
            <div class="cta-final-box">
                <div class="cta-final-content">
                    <span class="cta-emoji-final">💎</span>
                    <h2>Ne ratez aucune pépite !</h2>
                    <p>Suivez-nous sur les réseaux sociaux pour découvrir nos arrivages en temps réel, ou inscrivez-vous à notre newsletter.</p>
                    <div class="cta-buttons">
                        <a href="<?= url('nous-rejoindre') ?>" class="btn-cta-final">Suivez-nous 📱</a>
                        <a href="<?= url('dons') ?>" class="btn-cta-secondary">📦 Faire un don</a>
                    </div>
                </div>
                <div class="cta-photo-final">
                    <div class="photo-placeholder-final">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : client<br>heureux avec son achat</p>
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
                    <p class="footer-tagline-final">Ensemble, donnons une seconde vie aux objets et créons du lien 💙</p>
                </div>
                <div class="footer-links-final">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="<?= url() ?>">Qui sommes-nous ?</a></li>
                        <li><a href="<?= url('la-ressourcerie') ?>">La Ressourcerie</a></li>
                        <li><a href="<?= url('venir-chiner') ?>">Venir chiner</a></li>
                        <li><a href="<?= url('dons') ?>">📦 Faire un don</a></li>
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
                    <h4>Newsletter 📬</h4>
                    <p>Restez informés de nos actualités</p>
                    <form class="newsletter-final" action="#" method="post">
                        <input type="email" placeholder="Votre email" required>
                        <button type="submit">→</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom-final">
                <p>&copy; 2026 1000 Mains et Merveilles &bull; Association loi 1901 💙</p>
                <div class="footer-legal-final">
                    <a href="<?= url('mentions-legales') ?>">Mentions légales</a>
                    <a href="<?= url('confidentialite') ?>">Confidentialité</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
