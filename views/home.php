<?php
/**
 * Page d'accueil - Landing page
 * 1000 Mains et Merveilles
 */

// Récupérer les pépites (rotation hebdomadaire automatique)
$pepites = dbFetchAll(
    'SELECT p.*, c.name as category_name, c.icon as category_icon
     FROM products p
     LEFT JOIN categories c ON p.category_id = c.id
     WHERE p.status = "available"
     ORDER BY RAND(YEARWEEK(NOW()))
     LIMIT 3'
);

// Récupérer les catégories avec compteur
$categories = dbFetchAll(
    'SELECT c.*, COUNT(p.id) as products_count
     FROM categories c
     LEFT JOIN products p ON c.id = p.category_id AND p.status = "available"
     GROUP BY c.id
     ORDER BY c.sort_order'
);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(page_content('home', 'page-title', '1000 Mains et Merveilles - Association de reemploi solidaire')) ?></title>
    <meta name="description" content="<?= e(page_content('home', 'page-meta', 'Association de reemploi solidaire dans les Yvelines. Boutique a prix doux, ateliers creatifs et depot de dons a Plaisir et Chavenay.')) ?>">

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/favicon-32x32.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('images/apple-icon-180x180.png') ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/home.css') ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <?php include ROOT_PATH . '/components/navbar.php'; ?>

    <!-- ========== HERO PRINCIPAL ========== -->
    <section class="landing-hero">
        <div class="container">
            <div class="landing-hero-content">
                <div class="landing-hero-text">
                    <span class="hero-label-final">💙 <?= page_content('home', 'hero-label', 'Reemploi solidaire dans les Yvelines') ?></span>
                    <h1><?= page_content('home', 'hero-title', 'Donnez une <span class="highlight-turquoise">seconde vie</span> aux objets') ?></h1>
                    <p class="hero-description-final"><?= page_content('home', 'hero-description', 'Boutique a prix doux, depot de dons, ateliers creatifs : rejoignez une aventure humaine et ecologique pres de chez vous.') ?></p>
                    <div class="landing-hero-cta">
                        <a href="<?= url('venir-chiner') ?>" class="btn-primary-final">Decouvrir la boutique</a>
                        <a href="<?= url('dons') ?>" class="btn-secondary-final">Faire un don</a>
                    </div>
                    <?php include ROOT_PATH . '/components/hero-chiffres.php'; ?>
                </div>
                <div class="landing-hero-photo">
                    <?php $heroImg = page_image('home', 'hero-image'); ?>
                    <?php if ($heroImg): ?>
                        <img src="<?= upload_url('pages/' . $heroImg) ?>" alt="1000 Mains et Merveilles" class="hero-page-img" style="width: 100%; border-radius: 30px;">
                    <?php else: ?>
                        <div class="photo-placeholder-final hero-page-size">
                            <div class="photo-icon-final">📸</div>
                            <p>Photo : boutique<br>accueillante</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="wave-final">
            <svg viewBox="0 0 1440 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#faf8f5" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,165.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- ========== NOS ACTIONS ========== -->
    <section class="landing-actions">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-turquoise"><?= page_content('home', 'tag-actions', 'Ce que nous faisons 🌱') ?></span>
                <h2><?= page_content('home', 'actions-title', 'Trois piliers pour une <span class="highlight-turquoise">action solidaire</span>') ?></h2>
            </div>

            <div class="landing-actions-grid">
                <article class="landing-action-card">
                    <div class="landing-action-icon">🏪</div>
                    <h3>La Ressourcerie</h3>
                    <p>Un lieu ou les objets retrouvent une seconde vie. Nous collectons, valorisons et revendons a prix solidaire.</p>
                    <a href="<?= url('la-ressourcerie') ?>" class="landing-action-link">En savoir plus →</a>
                </article>

                <article class="landing-action-card">
                    <div class="landing-action-icon">🎨</div>
                    <h3>Ateliers creatifs</h3>
                    <p>Apprenez a reparer, transformer et creer lors de nos ateliers ouverts a tous, petits et grands.</p>
                    <a href="<?= url('agenda') ?>" class="landing-action-link">Voir le programme →</a>
                </article>

                <article class="landing-action-card">
                    <div class="landing-action-icon">🤝</div>
                    <h3>Solidarite locale</h3>
                    <p>Plus de 200 benevoles engages pour creer du lien social et rendre le reemploi accessible a tous.</p>
                    <a href="<?= url('qui-sommes-nous') ?>" class="landing-action-link">Decouvrir l'asso →</a>
                </article>
            </div>
        </div>
    </section>

    <!-- ========== PEPITES DE LA SEMAINE ========== -->
    <section class="home-pepites">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-orange"><?= page_content('home', 'tag-pepites', 'A ne pas manquer 💎') ?></span>
                <h2><?= page_content('home', 'pepites-title', 'Les pepites <span class="highlight-turquoise">de la semaine</span>') ?></h2>
                <p><?= page_content('home', 'pepites-subtitle', 'Nos coups de coeur du moment, disponibles en boutique') ?></p>
            </div>

            <div class="home-pepites-grid">
                <?php if (empty($pepites)): ?>
                    <p class="empty-message">Aucune pepite en ce moment. Revenez bientot !</p>
                <?php else: ?>
                    <?php foreach ($pepites as $product): ?>
                    <article class="home-pepite-card">
                        <div class="home-pepite-photo">
                            <?php if ($product['image']): ?>
                                <img src="<?= upload_url('products/' . $product['image']) ?>" alt="<?= e($product['name']) ?>" class="home-pepite-img">
                            <?php else: ?>
                                <div class="photo-placeholder-final home-pepite-photo-size">
                                    <div class="photo-icon-final">📸</div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="home-pepite-info">
                            <span class="home-pepite-cat"><?= $product['category_icon'] ?> <?= e($product['category_name']) ?></span>
                            <h3><?= e($product['name']) ?></h3>
                            <span class="home-pepite-prix"><?= number_format($product['price'], 0, ',', ' ') ?> &euro;</span>
                        </div>
                    </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="home-pepites-cta">
                <a href="<?= url('venir-chiner') ?>" class="btn-primary-final">Voir toutes nos pepites →</a>
            </div>
        </div>
    </section>

    <!-- ========== NOS CATEGORIES ========== -->
    <section class="home-categories">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-turquoise"><?= page_content('home', 'tag-categories', 'Nos rayons 🏷️') ?></span>
                <h2><?= page_content('home', 'categories-title', 'Explorez nos <span class="highlight-turquoise">categories</span>') ?></h2>
                <p><?= page_content('home', 'categories-subtitle', 'Tout un univers d\'objets a decouvrir a prix solidaires') ?></p>
            </div>

            <div class="home-categories-grid">
                <?php foreach ($categories as $cat): ?>
                <article class="home-categorie-card">
                    <?php if (!empty($cat['image'])): ?>
                        <div class="home-categorie-photo">
                            <img src="<?= upload_url('categories/' . $cat['image']) ?>" alt="<?= e($cat['name']) ?>" class="home-categorie-img">
                            <span class="home-categorie-emoji"><?= $cat['icon'] ?: '📦' ?></span>
                        </div>
                    <?php else: ?>
                        <div class="home-categorie-icon"><?= $cat['icon'] ?: '📦' ?></div>
                    <?php endif; ?>
                    <h3><?= e($cat['name']) ?></h3>
                    <p><?= $cat['products_count'] ?> article<?= $cat['products_count'] > 1 ? 's' : '' ?></p>
                </article>
                <?php endforeach; ?>
            </div>

            <div class="home-categories-cta">
                <a href="<?= url('venir-chiner') ?>" class="btn-primary-final">Voir toutes nos trouvailles →</a>
            </div>
        </div>
    </section>

    <!-- ========== RESEAUX SOCIAUX ========== -->
    <section class="home-social">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-turquoise">Suivez-nous</span>
                <h2>Retrouvez-nous sur les <span class="highlight-turquoise">reseaux</span></h2>
                <p>Arrivages, coulisses, evenements... ne manquez rien de notre actualite !</p>
            </div>
            <div class="home-social-grid">
                <a href="https://www.facebook.com/1000mainsetmerveilles" target="_blank" rel="noopener noreferrer" class="home-social-card home-social-facebook">
                    <div class="home-social-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </div>
                    <h3>Facebook</h3>
                    <p>Suivez nos actualites et evenements</p>
                </a>
                <a href="https://www.instagram.com/1000mainsetmerveilles" target="_blank" rel="noopener noreferrer" class="home-social-card home-social-instagram">
                    <div class="home-social-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </div>
                    <h3>Instagram</h3>
                    <p>Decouvrez nos pepites en photos</p>
                </a>
            </div>
        </div>
    </section>

    <!-- ========== CTA REJOINDRE ========== -->
    <section class="cta-final">
        <div class="container">
            <div class="cta-final-box">
                <div class="cta-final-content">
                    <span class="cta-emoji-final">🤗</span>
                    <h2>Envie de nous rejoindre ?</h2>
                    <p>Que vous souhaitiez donner de votre temps, de vos objets ou simplement decouvrir notre univers, vous etes les bienvenus !</p>
                    <div class="cta-buttons">
                        <a href="<?= url('nous-rejoindre') ?>" class="btn-cta-final">Devenir benevole 💛</a>
                        <a href="<?= url('dons') ?>" class="btn-cta-secondary">📦 Faire un don</a>
                    </div>
                </div>
                <div class="cta-photo-final">
                    <div class="photo-placeholder-final">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : accueil<br>chaleureux benevoles</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include ROOT_PATH . '/components/footer.php'; ?>

    <?php include ROOT_PATH . '/components/newsletter-modal.php'; ?>

</body>
</html>
