<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venir chiner - Pepites et objets de seconde main | 1000 Mains et Merveilles</title>
    <meta name="description" content="Decouvrez nos pepites du moment et les arrivages recents dans notre ressourcerie a Plaisir (78). Meubles, vetements, deco, livres... a prix solidaires.">

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
                    <p class="hero-description-final">Des objets uniques, des prix solidaires. Decouvrez nos pepites du moment et les derniers arrivages dans notre ressourcerie.</p>
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
                <h2>Les pepites <span class="highlight-turquoise">en rayon</span></h2>
                <p>Nos trouvailles preferees du moment, disponibles en boutique</p>
            </div>

            <div class="pepites-grid">
                <article class="pepite-card">
                    <div class="pepite-photo">
                        <div class="photo-placeholder-final pepite-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                        <span class="pepite-badge badge-disponible">En rayon</span>
                    </div>
                    <div class="pepite-info">
                        <span class="pepite-categorie">🪑 Meubles</span>
                        <h3>Commode vintage annees 60</h3>
                        <p>Tres bon etat, bois massif, 3 tiroirs. Ideal pour une chambre ou un salon.</p>
                        <span class="pepite-prix">45 &euro;</span>
                    </div>
                </article>

                <article class="pepite-card">
                    <div class="pepite-photo">
                        <div class="photo-placeholder-final pepite-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                        <span class="pepite-badge badge-disponible">En rayon</span>
                    </div>
                    <div class="pepite-info">
                        <span class="pepite-categorie">🖼️ Decoration</span>
                        <h3>Miroir Art Deco dore</h3>
                        <p>Cadre en bois sculpte, miroir biseaute. Une piece unique pour votre interieur.</p>
                        <span class="pepite-prix">25 &euro;</span>
                    </div>
                </article>

                <article class="pepite-card">
                    <div class="pepite-photo">
                        <div class="photo-placeholder-final pepite-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                        <span class="pepite-badge badge-disponible">En rayon</span>
                    </div>
                    <div class="pepite-info">
                        <span class="pepite-categorie">💡 Luminaires</span>
                        <h3>Lampe industrielle metal</h3>
                        <p>Style atelier, metal brosse, abat-jour orientable. Parfait pour un bureau.</p>
                        <span class="pepite-prix">18 &euro;</span>
                    </div>
                </article>

                <article class="pepite-card">
                    <div class="pepite-photo">
                        <div class="photo-placeholder-final pepite-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                        <span class="pepite-badge badge-disponible">En rayon</span>
                    </div>
                    <div class="pepite-info">
                        <span class="pepite-categorie">🍽️ Vaisselle</span>
                        <h3>Service a the porcelaine</h3>
                        <p>6 tasses et soucoupes, motif floral, fabrication francaise. Complet et intact.</p>
                        <span class="pepite-prix">15 &euro;</span>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- ========== ARRIVAGES RECENTS ========== -->
    <section class="chiner-arrivages">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-turquoise">Fraichement arrives 📦</span>
                <h2>Les arrivages <span class="highlight-turquoise">recents</span></h2>
                <p>Les derniers objets arrives en boutique cette semaine</p>
            </div>

            <div class="arrivages-grid">
                <article class="arrivage-card">
                    <div class="arrivage-photo">
                        <div class="photo-placeholder-final arrivage-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                    </div>
                    <div class="arrivage-info">
                        <span class="arrivage-date">📅 Lundi 27 janvier</span>
                        <h3>Lot de livres jeunesse</h3>
                        <p>Une vingtaine de livres pour enfants en excellent etat.</p>
                    </div>
                </article>

                <article class="arrivage-card">
                    <div class="arrivage-photo">
                        <div class="photo-placeholder-final arrivage-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                    </div>
                    <div class="arrivage-info">
                        <span class="arrivage-date">📅 Lundi 27 janvier</span>
                        <h3>Table basse en chene</h3>
                        <p>Style campagne, plateau en bois massif, pieds tournes.</p>
                    </div>
                </article>

                <article class="arrivage-card">
                    <div class="arrivage-photo">
                        <div class="photo-placeholder-final arrivage-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                    </div>
                    <div class="arrivage-info">
                        <span class="arrivage-date">📅 Samedi 25 janvier</span>
                        <h3>Vetements hiver femme</h3>
                        <p>Manteaux, pulls et echarpes de marque, toutes tailles.</p>
                    </div>
                </article>

                <article class="arrivage-card">
                    <div class="arrivage-photo">
                        <div class="photo-placeholder-final arrivage-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                    </div>
                    <div class="arrivage-info">
                        <span class="arrivage-date">📅 Samedi 25 janvier</span>
                        <h3>Jeux de societe</h3>
                        <p>Monopoly, Scrabble, Cluedo... tous complets et en bon etat.</p>
                    </div>
                </article>

                <article class="arrivage-card">
                    <div class="arrivage-photo">
                        <div class="photo-placeholder-final arrivage-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                    </div>
                    <div class="arrivage-info">
                        <span class="arrivage-date">📅 Jeudi 23 janvier</span>
                        <h3>Vaisselle retro</h3>
                        <p>Assiettes, bols et plats des annees 70, motifs colores.</p>
                    </div>
                </article>

                <article class="arrivage-card">
                    <div class="arrivage-photo">
                        <div class="photo-placeholder-final arrivage-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                    </div>
                    <div class="arrivage-info">
                        <span class="arrivage-date">📅 Jeudi 23 janvier</span>
                        <h3>Cadres et tableaux</h3>
                        <p>Reproductions et cadres anciens, differentes tailles.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- ========== NOS CATEGORIES ========== -->
    <section class="chiner-categories">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-orange">Nos rayons 🏷️</span>
                <h2>Explorez nos <span class="highlight-turquoise">categories</span></h2>
                <p>Tout un univers d'objets a decouvrir a prix solidaires</p>
            </div>

            <div class="categories-showcase">
                <article class="categorie-showcase-card">
                    <div class="categorie-showcase-icon">🪑</div>
                    <h3>Meubles</h3>
                    <p>Tables, chaises, commodes, armoires, etageres... Du vintage au contemporain.</p>
                    <span class="categorie-fourchette">A partir de 5 &euro;</span>
                </article>

                <article class="categorie-showcase-card">
                    <div class="categorie-showcase-icon">👗</div>
                    <h3>Vetements</h3>
                    <p>Homme, femme, enfant. Toutes saisons, toutes tailles, grandes marques.</p>
                    <span class="categorie-fourchette">A partir de 1 &euro;</span>
                </article>

                <article class="categorie-showcase-card">
                    <div class="categorie-showcase-icon">📚</div>
                    <h3>Livres</h3>
                    <p>Romans, BD, mangas, livres jeunesse, beaux livres, guides pratiques.</p>
                    <span class="categorie-fourchette">A partir de 0,50 &euro;</span>
                </article>

                <article class="categorie-showcase-card">
                    <div class="categorie-showcase-icon">🍽️</div>
                    <h3>Vaisselle</h3>
                    <p>Services complets, pieces uniques, verres, couverts, ustensiles de cuisine.</p>
                    <span class="categorie-fourchette">A partir de 1 &euro;</span>
                </article>

                <article class="categorie-showcase-card">
                    <div class="categorie-showcase-icon">🧸</div>
                    <h3>Jouets</h3>
                    <p>Peluches, jeux de societe, puzzles, figurines, jeux educatifs.</p>
                    <span class="categorie-fourchette">A partir de 1 &euro;</span>
                </article>

                <article class="categorie-showcase-card">
                    <div class="categorie-showcase-icon">🖼️</div>
                    <h3>Decoration</h3>
                    <p>Cadres, miroirs, vases, bibelots, objets d'art, linge de maison.</p>
                    <span class="categorie-fourchette">A partir de 2 &euro;</span>
                </article>

                <article class="categorie-showcase-card">
                    <div class="categorie-showcase-icon">💡</div>
                    <h3>Luminaires</h3>
                    <p>Lampes de bureau, lampadaires, appliques, abat-jour, suspensions.</p>
                    <span class="categorie-fourchette">A partir de 5 &euro;</span>
                </article>

                <article class="categorie-showcase-card">
                    <div class="categorie-showcase-icon">🎵</div>
                    <h3>Loisirs</h3>
                    <p>CD, vinyles, instruments, sport, jardinage, bricolage et plus encore.</p>
                    <span class="categorie-fourchette">A partir de 1 &euro;</span>
                </article>
            </div>
        </div>
    </section>

    <!-- ========== PEPITES VENDUES ========== -->
    <section class="chiner-vendues">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-turquoise">Deja parties ! 🎉</span>
                <h2>Les pepites <span class="highlight-turquoise">vendues</span></h2>
                <p>Elles ont trouve preneur... Ne ratez pas les prochaines !</p>
            </div>

            <div class="vendues-grid">
                <article class="vendue-card">
                    <div class="vendue-photo">
                        <div class="photo-placeholder-final vendue-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                        <span class="pepite-badge badge-vendu">Vendu</span>
                    </div>
                    <div class="vendue-info">
                        <h3>Fauteuil club cuir</h3>
                        <span class="vendue-prix">35 &euro;</span>
                    </div>
                </article>

                <article class="vendue-card">
                    <div class="vendue-photo">
                        <div class="photo-placeholder-final vendue-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                        <span class="pepite-badge badge-vendu">Vendu</span>
                    </div>
                    <div class="vendue-info">
                        <h3>Machine a coudre Singer</h3>
                        <span class="vendue-prix">40 &euro;</span>
                    </div>
                </article>

                <article class="vendue-card">
                    <div class="vendue-photo">
                        <div class="photo-placeholder-final vendue-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                        <span class="pepite-badge badge-vendu">Vendu</span>
                    </div>
                    <div class="vendue-info">
                        <h3>Velo enfant 20 pouces</h3>
                        <span class="vendue-prix">20 &euro;</span>
                    </div>
                </article>

                <article class="vendue-card">
                    <div class="vendue-photo">
                        <div class="photo-placeholder-final vendue-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                        <span class="pepite-badge badge-vendu">Vendu</span>
                    </div>
                    <div class="vendue-info">
                        <h3>Collection Tintin (12 tomes)</h3>
                        <span class="vendue-prix">18 &euro;</span>
                    </div>
                </article>

                <article class="vendue-card">
                    <div class="vendue-photo">
                        <div class="photo-placeholder-final vendue-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                        <span class="pepite-badge badge-vendu">Vendu</span>
                    </div>
                    <div class="vendue-info">
                        <h3>Buffet annees 50</h3>
                        <span class="vendue-prix">60 &euro;</span>
                    </div>
                </article>

                <article class="vendue-card">
                    <div class="vendue-photo">
                        <div class="photo-placeholder-final vendue-photo-size">
                            <div class="photo-icon-final">📸</div>
                        </div>
                        <span class="pepite-badge badge-vendu">Vendu</span>
                    </div>
                    <div class="vendue-info">
                        <h3>Service Limoges 24 pieces</h3>
                        <span class="vendue-prix">30 &euro;</span>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- ========== OU VENIR CHINER ========== -->
    <section class="chiner-lieu">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-orange">Nous trouver 📍</span>
                <h2>Ou venir <span class="highlight-turquoise">chiner</span> ?</h2>
                <p>Notre boutique vous accueille a Plaisir</p>
            </div>

            <div class="lieu-grid">
                <div class="lieu-infos">
                    <div class="lieu-info-card">
                        <div class="info-icon">📍</div>
                        <div class="info-content">
                            <h3>Adresse</h3>
                            <p>Zone d'activite, Plaisir (78370)</p>
                            <p class="info-detail">Acces facile, parking gratuit</p>
                        </div>
                    </div>

                    <div class="lieu-info-card">
                        <div class="info-icon">🕐</div>
                        <div class="info-content">
                            <h3>Horaires boutique</h3>
                            <p><strong>Mardi au samedi :</strong> 10h - 18h</p>
                            <p class="info-detail">Ferme les dimanches et lundis</p>
                        </div>
                    </div>

                    <div class="lieu-info-card">
                        <div class="info-icon">💳</div>
                        <div class="info-content">
                            <h3>Paiement</h3>
                            <p>Especes et carte bancaire acceptees</p>
                        </div>
                    </div>

                    <div class="lieu-info-card">
                        <div class="info-icon">♻️</div>
                        <div class="info-content">
                            <h3>Notre engagement</h3>
                            <p>100% des benefices financent nos actions solidaires et environnementales</p>
                        </div>
                    </div>
                </div>

                <div class="lieu-map">
                    <div class="photo-placeholder-final lieu-map-size">
                        <div class="photo-icon-final">🗺️</div>
                        <p>Carte / Plan d'acces<br>Google Maps</p>
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
                    <h2>Ne ratez aucune pepite !</h2>
                    <p>Suivez-nous sur les reseaux sociaux pour decouvrir nos arrivages en temps reel, ou inscrivez-vous a notre newsletter.</p>
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
