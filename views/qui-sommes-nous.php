<?php
/**
 * Page Qui sommes-nous
 * 1000 Mains et Merveilles
 */

// Charger les étapes de la frise depuis la DB
$timelineEntries = dbFetchAll('SELECT * FROM timeline_entries ORDER BY sort_order ASC, year ASC');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(page_content('qui-sommes-nous', 'page-title', 'Qui sommes-nous - 1000 Mains et Merveilles')) ?></title>
    <meta name="description" content="<?= e(page_content('qui-sommes-nous', 'page-meta', 'Decouvrez l histoire et les valeurs de 1000 Mains et Merveilles, association de reemploi solidaire dans les Yvelines.')) ?>">

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

    <!-- ========== HERO PAGE ========== -->
    <section class="page-hero">
        <div class="container">
            <div class="page-hero-content">
                <div class="page-hero-text">
                    <span class="hero-label-final">💙 <?= page_content('qui-sommes-nous', 'hero-label', 'Notre histoire') ?></span>
                    <h1><?= page_content('qui-sommes-nous', 'hero-title', 'Qui sommes-nous <span class="highlight-turquoise">?</span>') ?></h1>
                    <p class="hero-description-final"><?= page_content('qui-sommes-nous', 'hero-description', 'Une association engagee depuis plus de 12 ans pour le reemploi, la solidarite et le lien social sur le territoire des Yvelines.') ?></p>
                    <?php include ROOT_PATH . '/components/hero-chiffres.php'; ?>
                </div>
                <div class="page-hero-photo">
                    <?php $heroImg = page_image('qui-sommes-nous', 'hero-image'); ?>
                    <?php if ($heroImg): ?>
                        <img src="<?= upload_url('pages/' . $heroImg) ?>" alt="Qui sommes-nous" class="hero-page-img" style="width: 100%; border-radius: 30px;">
                    <?php else: ?>
                        <div class="photo-placeholder-final hero-page-size">
                            <div class="photo-icon-final">📸</div>
                            <p>Photo : equipe<br>benevoles ensemble</p>
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

    <!-- ========== NOTRE MISSION ========== -->
    <section class="about-mission">
        <div class="container">
            <div class="about-mission-grid">
                <div class="about-mission-photo">
                    <?php $missionImg = page_image('qui-sommes-nous', 'mission-image'); ?>
                    <?php if ($missionImg): ?>
                        <img src="<?= upload_url('pages/' . $missionImg) ?>" alt="Notre mission" style="width: 100%; border-radius: 20px;">
                    <?php else: ?>
                        <div class="photo-placeholder-final square-final">
                            <div class="photo-icon-final">📸</div>
                            <p>Photo : atelier<br>reparation</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="about-mission-text">
                    <span class="section-tag-final tag-turquoise"><?= page_content('qui-sommes-nous', 'tag-mission', 'Notre mission 🌱') ?></span>
                    <h2><?= page_content('qui-sommes-nous', 'mission-title', 'Donner une <span class="highlight-turquoise">seconde vie</span> aux objets') ?></h2>
                    <p><?= page_content('qui-sommes-nous', 'mission-text', '1000 Mains et Merveilles est une association loi 1901 qui oeuvre pour le reemploi et la reduction des dechets. Nous collectons, valorisons et redistribuons des objets du quotidien a prix solidaire.\n\nNotre action s\'inscrit dans une demarche d\'economie circulaire et de solidarite locale, en proposant des objets de qualite accessibles a tous.') ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== NOTRE HISTOIRE (Timeline) ========== -->
    <section class="about-histoire">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-orange"><?= page_content('qui-sommes-nous', 'tag-histoire', 'Notre parcours 📅') ?></span>
                <h2>Notre <span class="highlight-turquoise">histoire</span></h2>
                <p>Les grandes etapes de notre aventure</p>
            </div>

            <?php if (!empty($timelineEntries)): ?>
            <div class="timeline-accordion">
                <?php foreach ($timelineEntries as $i => $entry): ?>
                <div class="accordion-item <?= $i === 0 ? 'active' : '' ?>">
                    <button class="accordion-header" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
                        <span class="accordion-year"><?= e($entry['year']) ?></span>
                        <span class="accordion-title"><?= e($entry['title']) ?></span>
                        <span class="accordion-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </span>
                    </button>
                    <div class="accordion-body">
                        <p><?= e($entry['description']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="empty-message">La frise chronologique sera bientot disponible.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- ========== NOS VALEURS ========== -->
    <section class="about-valeurs">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-turquoise"><?= page_content('qui-sommes-nous', 'tag-valeurs', 'Nos valeurs ❤️') ?></span>
                <h2>Ce qui nous <span class="highlight-turquoise">anime</span></h2>
                <p>Trois piliers guident notre action au quotidien</p>
            </div>

            <div class="valeurs-grid">
                <article class="valeur-card valeur-card-blue">
                    <div class="valeur-icon">🤝</div>
                    <h3>Solidarite</h3>
                    <p>Nous creons du lien social en rendant accessible a tous des objets de qualite. Chaque don, chaque achat, chaque atelier est une occasion de tisser des liens.</p>
                </article>

                <article class="valeur-card valeur-card-turquoise">
                    <div class="valeur-icon">🌍</div>
                    <h3>Ecologie</h3>
                    <p>Reduire les dechets, prolonger la vie des objets, sensibiliser au reemploi : notre engagement ecologique est au coeur de chaque action.</p>
                </article>

                <article class="valeur-card valeur-card-orange">
                    <div class="valeur-icon">✨</div>
                    <h3>Creativite</h3>
                    <p>A travers nos ateliers et notre ressourcerie, nous encourageons la creativite et le savoir-faire. Transformer, reparer, reinventer : c'est notre quotidien.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- ========== NOTRE EQUIPE ========== -->
    <section class="about-equipe">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-orange"><?= page_content('qui-sommes-nous', 'tag-equipe', 'Notre equipe 👥') ?></span>
                <h2>Une equipe <span class="highlight-turquoise">engagee</span></h2>
                <p>Plus de 200 benevoles mobilises au quotidien</p>
            </div>

            <div class="equipe-grid">
                <article class="equipe-card">
                    <div class="equipe-photo">
                        <div class="photo-placeholder-final equipe-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                    </div>
                    <div class="equipe-info">
                        <span class="equipe-stat">200+</span>
                        <h3>Benevoles</h3>
                        <p>Le coeur battant de notre association, presents chaque jour pour accueillir, trier et accompagner.</p>
                    </div>
                </article>

                <article class="equipe-card">
                    <div class="equipe-photo">
                        <div class="photo-placeholder-final equipe-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                    </div>
                    <div class="equipe-info">
                        <span class="equipe-stat">2</span>
                        <h3>Lieux actuels</h3>
                        <p>Plaisir (boutique de vente) et Chavenay (depot de dons) : deux espaces pour accueillir vos dons et vous proposer des merveilles.</p>
                        <p class="equipe-note">Historiquement presents a Saint-Germain-en-Laye, nous sommes dans une demarche de retour et cherchons un nouveau local dans cette ville ou a proximite.</p>
                    </div>
                </article>

                <article class="equipe-card">
                    <div class="equipe-photo">
                        <div class="photo-placeholder-final equipe-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                    </div>
                    <div class="equipe-info">
                        <span class="equipe-stat">12 ans</span>
                        <h3>D'experience</h3>
                        <p>Depuis 2012, nous oeuvrons pour un monde plus solidaire et plus respectueux de l'environnement.</p>
                    </div>
                </article>
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

    <script>
    document.querySelectorAll('.accordion-header').forEach(btn => {
        btn.addEventListener('click', () => {
            const item = btn.closest('.accordion-item');
            const isActive = item.classList.contains('active');
            // Fermer tous les items
            document.querySelectorAll('.accordion-item').forEach(i => i.classList.remove('active'));
            document.querySelectorAll('.accordion-header').forEach(b => b.setAttribute('aria-expanded', 'false'));
            // Ouvrir si pas déjà actif
            if (!isActive) {
                item.classList.add('active');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });
    </script>

</body>
</html>
