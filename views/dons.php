<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faire un don - Objets ou financier | 1000 Mains et Merveilles</title>
    <meta name="description" content="Donnez une seconde vie a vos objets ou soutenez notre association par un don financier. Depot a Plaisir et Chavenay (78). Association de reemploi solidaire.">

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/favicon-32x32.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('images/apple-icon-180x180.png') ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/dons.css') ?>">

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
                    <span class="hero-label-final">📦 Donner utile</span>
                    <h1>Faire un <span class="highlight-turquoise">don</span></h1>
                    <p class="hero-description-final">Donnez une seconde vie a vos objets ou soutenez notre action par un don financier. Chaque geste compte pour la solidarite et l'environnement.</p>
                </div>
                <div class="page-hero-photo">
                    <div class="photo-placeholder-final hero-page-size">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : depot<br>de dons objets</p>
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

    <!-- ========== DONS D'OBJETS ========== -->
    <section class="dons-objets">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-turquoise">Don d'objets 🎁</span>
                <h2>Deposez vos <span class="highlight-turquoise">objets</span></h2>
                <p>Vos objets meritent une seconde vie. Deposez-les dans nos points de collecte.</p>
            </div>

            <div class="dons-objets-grid">
                <!-- Ce qu'on accepte -->
                <div class="dons-liste-card dons-accepte">
                    <h3>✅ Ce que nous acceptons</h3>
                    <ul class="dons-liste">
                        <li>Meubles en bon etat</li>
                        <li>Vetements propres et utilisables</li>
                        <li>Vaisselle, ustensiles de cuisine</li>
                        <li>Livres, CD, DVD, vinyles</li>
                        <li>Jouets et jeux complets</li>
                        <li>Decoration, cadres, luminaires</li>
                        <li>Petit electromenager fonctionnel</li>
                        <li>Linge de maison propre</li>
                    </ul>
                </div>

                <!-- Ce qu'on n'accepte pas -->
                <div class="dons-liste-card dons-refuse">
                    <h3>❌ Ce que nous ne prenons pas</h3>
                    <ul class="dons-liste">
                        <li>Objets casses ou inutilisables</li>
                        <li>Matelas, sommiers</li>
                        <li>Gros electromenager (frigo, lave-linge...)</li>
                        <li>Produits chimiques ou dangereux</li>
                        <li>Vetements taches ou dechires</li>
                        <li>Materiaux de construction</li>
                    </ul>
                </div>
            </div>

            <!-- Points de depot -->
            <div class="dons-depots">
                <h3>Ou deposer vos dons ?</h3>
                <div class="dons-depots-grid">
                    <div class="depot-card">
                        <div class="depot-icon">🏪</div>
                        <h4>Boutique de Plaisir</h4>
                        <p class="depot-adresse">Zone d'activite, Plaisir (78370)</p>
                        <p class="depot-horaires"><strong>Depot :</strong> Mardi au samedi, 10h - 17h</p>
                        <a href="<?= url('la-ressourcerie') ?>" class="depot-link">Voir les details →</a>
                    </div>
                    <div class="depot-card">
                        <div class="depot-icon">📦</div>
                        <h4>Depot de Chavenay</h4>
                        <p class="depot-adresse">Chavenay (78450)</p>
                        <p class="depot-horaires">Point de depot uniquement</p>
                        <span class="depot-badge">En preparation</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== DON FINANCIER ========== -->
    <section class="dons-financier">
        <div class="container">
            <div class="dons-financier-card">
                <div class="dons-financier-content">
                    <span class="section-tag-final tag-orange">Don financier 💛</span>
                    <h2>Soutenez notre <span class="highlight-turquoise">action</span></h2>
                    <p>Votre soutien financier nous permet de poursuivre notre mission : collecter, valoriser et redistribuer des objets a prix solidaire. Chaque don contribue a financer nos actions de reemploi et de solidarite.</p>
                    <ul class="dons-financier-avantages">
                        <li>🌱 Financez nos actions de reemploi</li>
                        <li>🤝 Soutenez l'insertion et le lien social</li>
                        <li>📄 Recevez un recu fiscal (deduction d'impots)</li>
                    </ul>
                    <a href="https://www.helloasso.com/associations/1000-mains-et-merveilles/formulaires/1" target="_blank" rel="noopener noreferrer" class="btn-helloasso">
                        Faire un don sur HelloAsso 💛
                    </a>
                    <p class="dons-securise">🔒 Paiement securise via HelloAsso</p>
                </div>
                <div class="dons-financier-photo">
                    <div class="photo-placeholder-final square-final">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : benevoles<br>action solidaire</p>
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
                    <span class="cta-emoji-final">🙏</span>
                    <h2>Merci pour votre generosite !</h2>
                    <p>Que ce soit un objet ou un soutien financier, chaque don fait la difference. Ensemble, donnons une seconde vie aux objets.</p>
                    <div class="cta-buttons">
                        <a href="<?= url('nous-rejoindre') ?>" class="btn-cta-final">Devenir benevole 💛</a>
                        <a href="<?= url('la-ressourcerie') ?>" class="btn-cta-secondary">🏪 Visiter la boutique</a>
                    </div>
                </div>
                <div class="cta-photo-final">
                    <div class="photo-placeholder-final">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : equipe<br>souriante</p>
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
