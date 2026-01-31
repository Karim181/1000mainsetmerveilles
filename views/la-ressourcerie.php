<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ressourcerie en Yvelines - Boutique solidaire a Plaisir | 1000 Mains et Merveilles</title>
    <meta name="description" content="Ressourcerie solidaire a Plaisir (78). Achetez des objets de seconde main a prix doux. Depot de dons a Chavenay. Reemploi, economie circulaire et lien social.">

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/favicon-32x32.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('images/apple-icon-180x180.png') ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/la-ressourcerie.css') ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <?php include ROOT_PATH . '/components/navbar.php'; ?>

    <!-- ========== HERO SEO ========== -->
    <section class="page-hero">
        <div class="container">
            <div class="page-hero-content">
                <div class="page-hero-text">
                    <span class="hero-label-final">🏪 Boutique solidaire</span>
                    <h1>La Ressourcerie <span class="highlight-turquoise">en Yvelines</span></h1>
                    <p class="hero-description-final">Achetez malin, donnez utile. Notre ressourcerie donne une seconde vie aux objets du quotidien a prix solidaire, a Plaisir (78).</p>
                </div>
                <div class="page-hero-photo">
                    <div class="photo-placeholder-final hero-page-size">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : interieur<br>boutique ressourcerie</p>
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

    <!-- ========== QU'EST-CE QU'UNE RESSOURCERIE ? (Pedagogie SEO) ========== -->
    <section class="ress-pedagogie">
        <div class="container">
            <div class="ress-pedagogie-grid">
                <div class="ress-pedagogie-text">
                    <span class="section-tag-final tag-turquoise">Le concept 🌱</span>
                    <h2>Qu'est-ce qu'une <span class="highlight-turquoise">ressourcerie</span> ?</h2>
                    <p>Une ressourcerie est un lieu dedie au reemploi : elle collecte les objets dont vous n'avez plus besoin, les valorise (nettoyage, petite reparation, mise en valeur) et les remet en vente a prix solidaire.</p>
                    <p>Contrairement a une dechetterie, rien n'est detruit. Contrairement a une brocante, la demarche est associative et solidaire. L'objectif : reduire les dechets tout en creant du lien social.</p>

                    <div class="ress-parcours">
                        <div class="parcours-step">
                            <span class="parcours-icon">📦</span>
                            <div>
                                <strong>Collecte</strong>
                                <p>Vous deposez vos objets</p>
                            </div>
                        </div>
                        <div class="parcours-arrow">→</div>
                        <div class="parcours-step">
                            <span class="parcours-icon">🔧</span>
                            <div>
                                <strong>Valorisation</strong>
                                <p>Tri, nettoyage, reparation</p>
                            </div>
                        </div>
                        <div class="parcours-arrow">→</div>
                        <div class="parcours-step">
                            <span class="parcours-icon">🏷️</span>
                            <div>
                                <strong>Vente solidaire</strong>
                                <p>Prix accessibles a tous</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ress-pedagogie-photo">
                    <div class="photo-placeholder-final square-final">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : benevoles<br>en action tri</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== ENCART CHAVENAY ========== -->
    <section class="ress-info-encart">
        <div class="container">
            <div class="info-encart-card">
                <span class="encart-icon">📍</span>
                <div class="encart-text">
                    <strong>Retrouvez-nous a Chavenay !</strong>
                    <p>La boutique de Plaisir a ferme ses portes. Nous vous accueillons desormais a notre depot de Chavenay.</p>
                </div>
                <a href="#chavenay" class="encart-link">Voir le depot →</a>
            </div>
        </div>
    </section>

    <!-- ========== BOUTIQUE PLAISIR (70%) ========== -->
    <section class="ress-boutique">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-orange">Notre boutique 🛍️</span>
                <h2>Ressourcerie de <span class="highlight-turquoise">Plaisir</span></h2>
                <p>Notre lieu principal pour acheter et deposer vos dons</p>
            </div>

            <div class="boutique-main-grid">
                <!-- Infos pratiques -->
                <div class="boutique-infos">
                    <div class="boutique-info-card">
                        <div class="info-icon">📍</div>
                        <div class="info-content">
                            <h3>Adresse</h3>
                            <p>Zone d'activite, Plaisir (78370)</p>
                            <p class="info-detail">Acces facile, parking gratuit</p>
                        </div>
                    </div>

                    <div class="boutique-info-card">
                        <div class="info-icon">🕐</div>
                        <div class="info-content">
                            <h3>Horaires</h3>
                            <p><strong>Boutique :</strong> Mardi au samedi, 10h - 18h</p>
                            <p><strong>Depot de dons :</strong> Mardi au samedi, 10h - 17h</p>
                            <p class="info-detail">Ferme les dimanches et lundis</p>
                        </div>
                    </div>

                    <div class="boutique-info-card">
                        <div class="info-icon">💳</div>
                        <div class="info-content">
                            <h3>Paiement</h3>
                            <p>Especes et carte bancaire acceptees</p>
                        </div>
                    </div>
                </div>

                <!-- Photo boutique -->
                <div class="boutique-photo">
                    <div class="photo-placeholder-final square-final">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : facade ou<br>interieur boutique Plaisir</p>
                    </div>
                </div>
            </div>

            <!-- Ce qu'on trouve -->
            <div class="boutique-categories">
                <h3>Ce que vous trouverez chez nous</h3>
                <div class="categories-grid">
                    <div class="categorie-item">
                        <span class="categorie-icon">🪑</span>
                        <span>Meubles</span>
                    </div>
                    <div class="categorie-item">
                        <span class="categorie-icon">👗</span>
                        <span>Vetements</span>
                    </div>
                    <div class="categorie-item">
                        <span class="categorie-icon">📚</span>
                        <span>Livres</span>
                    </div>
                    <div class="categorie-item">
                        <span class="categorie-icon">🍽️</span>
                        <span>Vaisselle</span>
                    </div>
                    <div class="categorie-item">
                        <span class="categorie-icon">🧸</span>
                        <span>Jouets</span>
                    </div>
                    <div class="categorie-item">
                        <span class="categorie-icon">🖼️</span>
                        <span>Decoration</span>
                    </div>
                    <div class="categorie-item">
                        <span class="categorie-icon">💡</span>
                        <span>Luminaires</span>
                    </div>
                    <div class="categorie-item">
                        <span class="categorie-icon">🎵</span>
                        <span>Loisirs</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== DEPOT CHAVENAY (15%) ========== -->
    <section class="ress-chavenay">
        <div class="container">
            <div class="chavenay-card">
                <div class="chavenay-badge">En preparation</div>
                <div class="chavenay-content">
                    <div class="chavenay-text">
                        <h2>Depot de dons a <span class="highlight-turquoise">Chavenay</span></h2>
                        <p>Un nouveau point de depot pour faciliter vos dons. Deposez vos objets pres de chez vous, nous nous occupons du reste.</p>
                        <div class="chavenay-infos">
                            <div class="chavenay-info">
                                <span>📍</span>
                                <p>Chavenay (78450)</p>
                            </div>
                            <div class="chavenay-info">
                                <span>📦</span>
                                <p>Depot de dons uniquement (pas de vente sur place)</p>
                            </div>
                        </div>
                    </div>
                    <div class="chavenay-photo">
                        <div class="photo-placeholder-final">
                            <div class="photo-icon-final">📸</div>
                            <p>Photo : lieu<br>Chavenay</p>
                        </div>
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
                    <span class="cta-emoji-final">📦</span>
                    <h2>Envie de donner ou d'acheter ?</h2>
                    <p>Venez decouvrir notre boutique a Plaisir ou deposez vos dons a Chavenay. Chaque objet merite une seconde vie !</p>
                    <div class="cta-buttons">
                        <a href="<?= url('dons') ?>" class="btn-cta-final">📦 Faire un don</a>
                        <a href="<?= url('nous-rejoindre') ?>" class="btn-cta-secondary">Devenir benevole 💛</a>
                    </div>
                </div>
                <div class="cta-photo-final">
                    <div class="photo-placeholder-final">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : client<br>heureux boutique</p>
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
