<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1000 Mains et Merveilles - Association de reemploi solidaire</title>

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
                    <span class="hero-label-final">💙 Notre histoire</span>
                    <h1>Qui sommes-nous <span class="highlight-turquoise">?</span></h1>
                    <p class="hero-description-final">Une association engagee depuis plus de 12 ans pour le reemploi, la solidarite et le lien social sur le territoire des Yvelines.</p>
                </div>
                <div class="page-hero-photo">
                    <div class="photo-placeholder-final hero-page-size">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : equipe<br>benevoles ensemble</p>
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

    <!-- ========== NOTRE MISSION ========== -->
    <section class="about-mission">
        <div class="container">
            <div class="about-mission-grid">
                <div class="about-mission-photo">
                    <div class="photo-placeholder-final square-final">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : atelier<br>reparation</p>
                    </div>
                </div>
                <div class="about-mission-text">
                    <span class="section-tag-final tag-turquoise">Notre mission 🌱</span>
                    <h2>Donner une <span class="highlight-turquoise">seconde vie</span> aux objets</h2>
                    <p>1000 Mains et Merveilles est une association loi 1901 qui oeuvre pour le reemploi et la reduction des dechets. Nous collectons, valorisons et redistribuons des objets du quotidien a prix solidaire.</p>
                    <p>Notre action s'inscrit dans une demarche d'economie circulaire et de solidarite locale, en proposant des objets de qualite accessibles a tous.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== PEPITES DE LA SEMAINE ========== -->
    <section class="home-pepites">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-orange">A ne pas manquer 💎</span>
                <h2>Les pepites <span class="highlight-turquoise">de la semaine</span></h2>
                <p>Nos coups de coeur du moment, disponibles en boutique</p>
            </div>

            <div class="home-pepites-grid">
                <article class="home-pepite-card">
                    <div class="home-pepite-photo">
                        <div class="photo-placeholder-final home-pepite-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                    </div>
                    <div class="home-pepite-info">
                        <span class="home-pepite-cat">🪑 Meubles</span>
                        <h3>Commode vintage annees 60</h3>
                        <span class="home-pepite-prix">45 &euro;</span>
                    </div>
                </article>

                <article class="home-pepite-card">
                    <div class="home-pepite-photo">
                        <div class="photo-placeholder-final home-pepite-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                    </div>
                    <div class="home-pepite-info">
                        <span class="home-pepite-cat">🖼️ Decoration</span>
                        <h3>Miroir Art Deco dore</h3>
                        <span class="home-pepite-prix">25 &euro;</span>
                    </div>
                </article>

                <article class="home-pepite-card">
                    <div class="home-pepite-photo">
                        <div class="photo-placeholder-final home-pepite-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                    </div>
                    <div class="home-pepite-info">
                        <span class="home-pepite-cat">💡 Luminaires</span>
                        <h3>Lampe industrielle metal</h3>
                        <span class="home-pepite-prix">18 &euro;</span>
                    </div>
                </article>
            </div>

            <div class="home-pepites-cta">
                <a href="<?= url('venir-chiner') ?>" class="btn-primary-final">Voir toutes nos pepites →</a>
            </div>
        </div>
    </section>

    <!-- ========== NOS VALEURS ========== -->
    <section class="about-valeurs">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-orange">Nos valeurs ❤️</span>
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
                <span class="section-tag-final tag-turquoise">Notre equipe 👥</span>
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
                        <span class="equipe-stat">3</span>
                        <h3>Lieux</h3>
                        <p>Saint-Germain-en-Laye, Plaisir et Chavenay : trois espaces pour accueillir vos dons et vous proposer des merveilles.</p>
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

    <!-- ========== NOTRE HISTOIRE (Timeline) ========== -->
    <section class="about-histoire">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-orange">Notre parcours 📅</span>
                <h2>Notre <span class="highlight-turquoise">histoire</span></h2>
                <p>Les grandes etapes de notre aventure</p>
            </div>

            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-content">
                        <h3>Creation de l'association</h3>
                        <p>Naissance de 1000 Mains et Merveilles avec une poignee de benevoles passionnes par le reemploi.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <h3>Installation a Plaisir</h3>
                        <p>Notre ressourcerie ouvre ses portes et accueille ses premiers donateurs et clients.</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content">
                        <h3>Depot a Chavenay</h3>
                        <p>Un nouveau point de depot pour faciliter les dons pres de chez vous.</p>
                    </div>
                </div>
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

    <!-- ========== FOOTER ========== -->
    <footer class="footer-final">
        <div class="container">
            <div class="footer-final-grid">
                <div class="footer-main-final">
                    <img src="<?= asset('images/1000-mains-et-merveilles-2.png') ?>" alt="Logo" class="footer-logo-final">
                    <p class="footer-tagline-final">Ensemble, donnons une seconde vie aux objets et creons du lien 💙</p>
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
                    <p>Restez informes de nos actualites</p>
                    <form class="newsletter-final" action="#" method="post">
                        <input type="email" placeholder="Votre email" required>
                        <button type="submit">→</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom-final">
                <p>&copy; 2026 1000 Mains et Merveilles &bull; Association loi 1901 💙</p>
                <div class="footer-legal-final">
                    <a href="<?= url('mentions-legales') ?>">Mentions legales</a>
                    <a href="<?= url('confidentialite') ?>">Confidentialite</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
