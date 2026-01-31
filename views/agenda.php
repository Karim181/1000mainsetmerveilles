<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda - Ateliers et evenements | 1000 Mains et Merveilles</title>
    <meta name="description" content="Decouvrez nos ateliers creatifs et evenements. Participez a nos activites de reemploi et de creation dans les Yvelines.">

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/favicon-32x32.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('images/apple-icon-180x180.png') ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/agenda.css') ?>">

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
                    <span class="hero-label-final">Agenda</span>
                    <h1>Nos <span class="highlight-turquoise">evenements</span></h1>
                    <p class="hero-description-final">Ateliers creatifs, evenements speciaux, rencontres... Decouvrez tout ce qui se passe chez 1000 Mains et Merveilles.</p>
                </div>
                <div class="page-hero-photo">
                    <div class="photo-placeholder-final hero-page-size">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : atelier<br>en cours</p>
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

    <!-- ========== GRILLE AGENDA 2x2 ========== -->
    <section class="agenda-grid-wrapper">
        <div class="container">
            <div class="agenda-grid-layout">

                <!-- SECTION 1 : ATELIERS CREATIFS -->
                <div class="agenda-grid-cell agenda-ateliers">
                    <div class="grid-cell-header">
                        <span class="section-tag-final tag-turquoise">Ateliers creatifs</span>
                        <h2>Apprenez, creez, <span class="highlight-turquoise">partagez</span></h2>
                    </div>
                    <div class="ateliers-list">
                        <div class="atelier-item">
                            <span class="atelier-icon">🧵</span>
                            <div>
                                <h3>Couture & Retouche</h3>
                                <p>Reparer, transformer et customiser vos vetements.</p>
                            </div>
                        </div>
                        <div class="atelier-item">
                            <span class="atelier-icon">🪑</span>
                            <div>
                                <h3>Relooking meubles</h3>
                                <p>Peinture, patine, techniques de renovation.</p>
                            </div>
                        </div>
                        <div class="atelier-item">
                            <span class="atelier-icon">🎨</span>
                            <div>
                                <h3>Loisirs creatifs</h3>
                                <p>Deco, bijoux, objets recup...</p>
                            </div>
                        </div>
                        <div class="atelier-item">
                            <span class="atelier-icon">🔧</span>
                            <div>
                                <h3>Reparation</h3>
                                <p>Electromenager, velos, objets du quotidien.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2 : PROGRAMME DU MOIS -->
                <div class="agenda-grid-cell agenda-programme">
                    <div class="grid-cell-header">
                        <span class="section-tag-final tag-orange">Programme</span>
                        <h2>Evenements du <span class="highlight-turquoise">mois</span></h2>
                    </div>
                    <div class="programme-liste">
                        <div class="evenement-mini">
                            <div class="evenement-date-mini">
                                <span class="jour">15</span>
                                <span class="mois">FEV</span>
                            </div>
                            <div class="evenement-info-mini">
                                <h3>Atelier couture - Initiation</h3>
                                <span>📍 Chavenay • 🕐 14h - 17h</span>
                            </div>
                        </div>
                        <div class="evenement-mini">
                            <div class="evenement-date-mini">
                                <span class="jour">22</span>
                                <span class="mois">FEV</span>
                            </div>
                            <div class="evenement-info-mini">
                                <h3>Relooking meuble - Patine</h3>
                                <span>📍 Chavenay • 🕐 10h - 13h</span>
                            </div>
                        </div>
                        <div class="evenement-mini">
                            <div class="evenement-date-mini">
                                <span class="jour">01</span>
                                <span class="mois">MAR</span>
                            </div>
                            <div class="evenement-info-mini">
                                <h3>Reparation velo</h3>
                                <span>📍 Chavenay • 🕐 14h - 17h</span>
                            </div>
                        </div>
                    </div>
                    <p class="programme-note">Dates susceptibles de modifications</p>
                </div>

                <!-- SECTION 3 : AUTRES EVENEMENTS -->
                <div class="agenda-grid-cell agenda-evenements">
                    <div class="grid-cell-header">
                        <span class="section-tag-final tag-turquoise">Evenements speciaux</span>
                        <h2>Autres <span class="highlight-turquoise">rendez-vous</span></h2>
                    </div>
                    <div class="evenements-speciaux-list">
                        <div class="evenement-special-item">
                            <span class="evenement-special-icon">🎉</span>
                            <div>
                                <h3>Vente speciale printemps</h3>
                                <p>Grande vente avec promotions sur tout le magasin.</p>
                                <span class="evenement-special-date">Mars 2026</span>
                            </div>
                        </div>
                        <div class="evenement-special-item">
                            <span class="evenement-special-icon">🚪</span>
                            <div>
                                <h3>Portes ouvertes</h3>
                                <p>Decouvrez les coulisses de la ressourcerie.</p>
                                <span class="evenement-special-date">Printemps 2026</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 4 : PROPOSER UN ATELIER -->
                <div class="agenda-grid-cell agenda-proposer">
                    <div class="grid-cell-header">
                        <span class="section-tag-final tag-orange">Participez !</span>
                        <h2>Vous avez un <span class="highlight-turquoise">talent</span> ?</h2>
                    </div>
                    <div class="proposer-content">
                        <p>Vous maitrisez une technique, un savoir-faire ? Proposez d'animer un atelier benevole ! Couture, bricolage, creation, reparation... Toutes les idees sont les bienvenues.</p>
                        <a href="<?= url('nous-rejoindre') ?>" class="btn-cta-final">Proposer un atelier</a>
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
                    <span class="cta-emoji-final">📅</span>
                    <h2>Envie de participer ?</h2>
                    <p>Contactez-nous pour vous inscrire a un atelier ou pour en savoir plus sur nos evenements.</p>
                    <div class="cta-buttons">
                        <a href="<?= url('nous-rejoindre') ?>" class="btn-cta-final">Nous contacter</a>
                        <a href="<?= url('la-ressourcerie') ?>" class="btn-cta-secondary">Visiter la ressourcerie</a>
                    </div>
                </div>
                <div class="cta-photo-final">
                    <div class="photo-placeholder-final">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : groupe<br>atelier</p>
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
                    <p class="footer-tagline-final">Ensemble, donnons une seconde vie aux objets et creons du lien</p>
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
                    <p>Restez informes de nos actualites</p>
                    <form class="newsletter-final" action="#" method="post">
                        <input type="email" placeholder="Votre email" required>
                        <button type="submit">→</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom-final">
                <p>&copy; 2026 1000 Mains et Merveilles - Association loi 1901</p>
                <div class="footer-legal-final">
                    <a href="<?= url('mentions-legales') ?>">Mentions legales</a>
                    <a href="<?= url('confidentialite') ?>">Confidentialite</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
