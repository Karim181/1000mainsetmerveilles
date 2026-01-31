<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maquette 6 - 1000 Mains et Merveilles</title>
    
    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/favicon-32x32.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('images/apple-icon-180x180.png') ?>">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/home.css') ?>">
    
    <!-- Fonts - Police extra-ronde -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Badge Maquette Test 
    <div class="badge-maquette-test">
        ✨ MAQUETTE 6 FINALE : Section DONS + Formes arrondies + 3 lieux (Chavenay 🆕)
    </div>-->

    <!-- ========== NAVBAR ARRONDIE ========== -->
    <nav class="navbar-final">
        <div class="container">
            <div class="navbar-content">
                <!-- Logo adaptatif -->
                <a href="<?= url() ?>" class="navbar-logo-final">
                    <div class="logo-final-circle">
                        <img src="<?= asset('images/1000-mains-et-merveilles-2.png') ?>" alt="1000 Mains et Merveilles">
                    </div>
                    <span class="logo-text-final">
                        <strong>1000 Mains</strong>
                        <small>et Merveilles</small>
                    </span>
                </a>

                <!-- Menu -->
                <ul class="navbar-menu-final">
                    <li><a href="<?= url('qui-sommes-nous') ?>" class="<?= is_page('qui-sommes-nous') ? 'nav-active' : '' ?>">Qui sommes-nous ?</a></li>
                    <li><a href="<?= url('la-ressourcerie') ?>" class="<?= is_page('la-ressourcerie') ? 'nav-active' : '' ?>">La Ressourcerie</a></li>
                    <li><a href="<?= url('dons') ?>" class="nav-highlight">📦 Faire un don</a></li>
                    <li><a href="<?= url('agenda') ?>" class="<?= is_page('agenda') ? 'nav-active' : '' ?>">Agenda</a></li>
                    <li><a href="<?= url('nous-rejoindre') ?>" class="btn-nav-final">Nous rejoindre 👋</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ========== HERO ARRONDI ========== -->
    <section class="hero-final">
        <div class="container">
            <div class="hero-final-content">
                <!-- Texte -->
                <div class="hero-text-final">
                    <span class="hero-label-final">🌻 Lorem ipsum</span>
                    <h1>Lorem ipsum dolor<br>sit amet <span class="highlight-turquoise">consectetur</span></h1>
                    <p class="hero-description-final">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <div class="hero-buttons-final">
                        <a href="<?= url('qui-sommes-nous') ?>" class="btn-primary-final">Lorem ipsum</a>
                        <a href="<?= url('dons') ?>" class="btn-secondary-final">📦 Lorem ipsum</a>
                    </div>
                </div>
                
                <!-- Photo -->
                <div class="hero-photo-final">
                    <div class="photo-placeholder-final hero-size">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : Lorem ipsum<br>dolor sit amet</p>
                    </div>
                    
                    <div class="stat-bubble-final bubble-1-final">
                        <span class="stat-emoji-final">👥</span>
                        <div>
                            <strong>200+</strong>
                            <span>Lorem</span>
                        </div>
                    </div>
                    <div class="stat-bubble-final bubble-2-final">
                        <span class="stat-emoji-final">🌱</span>
                        <div>
                            <strong>12 ans</strong>
                            <span>Lorem</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Vague arrondie -->
        <div class="wave-final">
            <svg viewBox="0 0 1440 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#ffffff" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,165.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- ========== 🎯 SECTION DONS - PRIORITÉ #1 ========== -->
    <section class="section-dons">
        <div class="container">
            <div class="section-header-dons">
                <span class="section-tag-final tag-orange">📦 Lorem ipsum</span>
                <h2>Lorem ipsum <span class="highlight-turquoise">dolor sit amet</span> ?</h2>
                <p class="section-subtitle">Lorem ipsum dolor sit amet consectetur adipiscing elit</p>
            </div>
            
            <div class="dons-grid">
                <!-- Bloc 1 : QUOI -->
                <article class="don-card">
                    <div class="don-icon">📦</div>
                    <h3>Lorem ipsum ?</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt.</p>
                    <a href="<?= url('dons') ?>" class="link-final">Lorem ipsum →</a>
                </article>

                <!-- Bloc 2 : OÙ -->
                <article class="don-card">
                    <div class="don-icon">📍</div>
                    <h3>Lorem ipsum ?</h3>
                    <div class="locations-list">
                        <div class="location-item">
                            <strong>🏪 St-Germain-en-Laye</strong>
                            <span>Lorem ipsum dolor</span>
                        </div>
                        <div class="location-item">
                            <strong>🏪 Plaisir</strong>
                            <span>Lorem ipsum dolor</span>
                        </div>
                        <div class="location-item location-new">
                            <strong>🏪 Chavenay 🆕</strong>
                            <span>Lorem ipsum dolor</span>
                        </div>
                    </div>
                    <a href="<?= url('dons') ?>" class="link-final">Lorem ipsum →</a>
                </article>

                <!-- Bloc 3 : QUAND -->
                <article class="don-card">
                    <div class="don-icon">🕐</div>
                    <h3>Lorem ipsum ?</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt.</p>
                    <a href="<?= url('dons') ?>" class="link-final">Lorem ipsum →</a>
                </article>

                <!-- Bloc 4 : COMMENT -->
                <article class="don-card">
                    <div class="don-icon">✅</div>
                    <h3>Lorem ipsum ?</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt.</p>
                    <a href="<?= url('dons') ?>" class="link-final">Lorem ipsum →</a>
                </article>
            </div>
            
            <!-- CTA dons -->
            <div class="dons-cta">
                <a href="<?= url('dons') ?>" class="btn-dons-large">📦 Lorem ipsum dolor sit amet</a>
            </div>
        </div>
        
        <!-- Ondulation bas -->
        <div class="ondulation-bas">
            <svg viewBox="0 0 1440 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#faf8f5" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,165.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- ========== PRÉSENTATION ========== -->
    <section class="presentation-final">
        <div class="container">
            <div class="presentation-grid-final">
                <!-- Photo -->
                <div class="presentation-photo-final">
                    <div class="photo-placeholder-final square-final">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : Lorem<br>ipsum dolor</p>
                    </div>
                </div>
                
                <!-- Texte -->
                <div class="presentation-text-final">
                    <span class="section-tag-final tag-turquoise">Lorem 💙</span>
                    <h2>Lorem ipsum <span class="highlight-turquoise">dolor sit</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    
                    <!-- Valeurs -->
                    <div class="values-list-final">
                        <div class="value-item-final value-blue">
                            <span class="value-emoji-final">🤝</span>
                            <div>
                                <strong>Lorem ipsum</strong>
                                <p>Lorem ipsum dolor</p>
                            </div>
                        </div>
                        <div class="value-item-final value-turquoise">
                            <span class="value-emoji-final">🌍</span>
                            <div>
                                <strong>Lorem ipsum</strong>
                                <p>Lorem ipsum dolor</p>
                            </div>
                        </div>
                        <div class="value-item-final value-orange">
                            <span class="value-emoji-final">❤️</span>
                            <div>
                                <strong>Lorem ipsum</strong>
                                <p>Lorem ipsum dolor</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== 2 ACTIVITÉS (Ressourcerie + Ateliers) ========== -->
    <section class="activites-final">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-orange">Lorem ✨</span>
                <h2>Lorem <span class="highlight-turquoise">ipsum</span></h2>
                <p>Lorem ipsum dolor sit amet consectetur</p>
            </div>
            
            <div class="cards-final-grid">
                <!-- Card 1 - Ressourcerie -->
                <article class="card-final card-blue">
                    <div class="card-photo-final">
                        <div class="photo-placeholder-final card-size-final">
                            <div class="photo-icon-final">📸</div>
                            <p>Photo : Lorem<br>ipsum</p>
                        </div>
                    </div>
                    <div class="card-final-content">
                        <h3>🏪 La Ressourcerie</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore.</p>
                        <a href="<?= url('la-ressourcerie') ?>" class="link-final">Lorem ipsum →</a>
                    </div>
                </article>

                <!-- Card 2 - Ateliers Créatifs -->
                <article class="card-final card-orange">
                    <div class="card-photo-final">
                        <div class="photo-placeholder-final card-size-final">
                            <div class="photo-icon-final">📸</div>
                            <p>Photo : Lorem<br>ipsum</p>
                        </div>
                    </div>
                    <div class="card-final-content">
                        <h3>✨ Ateliers Créatifs</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore.</p>
                        <a href="<?= url('agenda') ?>" class="link-final">Lorem ipsum →</a>
                    </div>
                </article>
            </div>
        </div>
        
        <!-- Ondulation -->
        <div class="ondulation-activites">
            <svg viewBox="0 0 1440 150" xmlns="http://www.w3.org/2000/svg">
                <path fill="#2b519f" d="M0,64L48,74.7C96,85,192,107,288,112C384,117,480,107,576,90.7C672,75,768,53,864,48C960,43,1056,53,1152,64C1248,75,1344,85,1392,90.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- ========== CTA ========== -->
    <section class="cta-final">
        <div class="container">
            <div class="cta-final-box">
                <div class="cta-final-content">
                    <span class="cta-emoji-final">🤗</span>
                    <h2>Lorem ipsum dolor</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <a href="<?= url('nous-rejoindre') ?>" class="btn-cta-final">Lorem ipsum 💛</a>
                </div>
                <div class="cta-photo-final">
                    <div class="photo-placeholder-final">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : Lorem<br>ipsum dolor</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== FOOTER ========== -->
    <footer class="footer-final">
        <div class="container">
            <div class="footer-final-grid">
                <!-- Colonne principale -->
                <div class="footer-main-final">
                    <img src="<?= asset('images/1000-mains-et-merveilles-2.png') ?>" alt="Logo" class="footer-logo-final">
                    <p class="footer-tagline-final">Ensemble, donnons une seconde vie aux objets et creons du lien 💙</p>
                </div>

                <!-- Liens -->
                <div class="footer-links-final">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="<?= url('qui-sommes-nous') ?>">Qui sommes-nous ?</a></li>
                        <li><a href="<?= url('la-ressourcerie') ?>">La Ressourcerie</a></li>
                        <li><a href="<?= url('dons') ?>">📦 Faire un don</a></li>
                        <li><a href="<?= url('agenda') ?>">Agenda</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="footer-links-final">
                    <h4>Nous contacter</h4>
                    <ul>
                        <li><a href="<?= url('nous-rejoindre') ?>">Nous rejoindre</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="footer-newsletter-final">
                    <h4>Newsletter 📬</h4>
                    <p>Restez informes de nos actualites</p>
                    <form class="newsletter-final" action="#" method="post">
                        <input type="email" placeholder="Votre email" required>
                        <button type="submit">→</button>
                    </form>
                </div>
            </div>

            <!-- Bottom -->
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