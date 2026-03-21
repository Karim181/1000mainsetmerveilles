<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(page_content('nous-rejoindre', 'page-title', 'Nous rejoindre - 1000 Mains et Merveilles')) ?></title>
    <meta name="description" content="<?= e(page_content('nous-rejoindre', 'page-meta', 'Rejoignez l aventure 1000 Mains et Merveilles. Devenez benevole ou partenaire de notre association de reemploi solidaire.')) ?>">

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/favicon-32x32.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('images/apple-icon-180x180.png') ?>">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/nous-rejoindre.css') ?>">

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
                    <span class="hero-label-final">🤝 <?= page_content('nous-rejoindre', 'hero-label', 'Rejoignez-nous') ?></span>
                    <h1><?= page_content('nous-rejoindre', 'hero-title', 'Ensemble, <span class="highlight-turquoise">agissons</span>') ?></h1>
                    <p class="hero-description-final"><?= page_content('nous-rejoindre', 'hero-description', 'Devenez benevole, proposez un atelier ou contactez-nous pour toute question. Chaque main compte !') ?></p>
                    <?php include ROOT_PATH . '/components/hero-chiffres.php'; ?>
                </div>
                <div class="page-hero-photo">
                    <?php $heroImg = page_image('nous-rejoindre', 'hero-image'); ?>
                    <?php if ($heroImg): ?>
                        <img src="<?= upload_url('pages/' . $heroImg) ?>" alt="Nous rejoindre" class="hero-page-img" style="width: 100%; border-radius: 30px;">
                    <?php else: ?>
                        <div class="photo-placeholder-final hero-page-size">
                            <div class="photo-icon-final">📸</div>
                            <p>Photo : equipe<br>benevoles</p>
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

    <!-- ========== SECTION DEVENIR BENEVOLE ========== -->
    <section class="rejoindre-benevole">
        <div class="container">
            <div class="section-header-final">
                <span class="section-tag-final tag-turquoise"><?= page_content('nous-rejoindre', 'tag-benevolat', 'Benevolat') ?></span>
                <h2>Devenez <span class="highlight-turquoise">benevole</span></h2>
                <p>Rejoignez une equipe dynamique et engagee pour le reemploi et la solidarite.</p>
            </div>

            <div class="benevole-grid">
                <div class="benevole-card">
                    <div class="benevole-icon">🏪</div>
                    <h3>En boutique</h3>
                    <p>Accueil des clients, mise en rayon, conseil, encaissement. Partagez votre bonne humeur !</p>
                </div>
                <div class="benevole-card">
                    <div class="benevole-icon">📦</div>
                    <h3>Tri et valorisation</h3>
                    <p>Tri des dons, nettoyage, petites reparations, mise en valeur des objets.</p>
                </div>
                <div class="benevole-card">
                    <div class="benevole-icon">🎨</div>
                    <h3>Animation d'ateliers</h3>
                    <p>Partagez vos talents : couture, bricolage, creation, reparation...</p>
                </div>
                <div class="benevole-card">
                    <div class="benevole-icon">💻</div>
                    <h3>Communication</h3>
                    <p>Reseaux sociaux, photos, evenements, relations presse...</p>
                </div>
            </div>

            <div class="benevole-infos">
                <div class="benevole-info-item">
                    <span>📍</span>
                    <p><strong>Lieu :</strong> Chavenay (78450)</p>
                </div>
                <div class="benevole-info-item">
                    <span>🕐</span>
                    <p><strong>Engagement :</strong> Quelques heures par semaine ou par mois, selon vos disponibilites</p>
                </div>
                <div class="benevole-info-item">
                    <span>🤝</span>
                    <p><strong>Ambiance :</strong> Conviviale, bienveillante, ouverte a tous</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SECTION FORMULAIRE DE CONTACT ========== -->
    <section class="rejoindre-contact">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-form-wrapper">
                    <div class="section-header-final text-left">
                        <span class="section-tag-final tag-orange"><?= page_content('nous-rejoindre', 'tag-contact', 'Contact') ?></span>
                        <h2>Ecrivez-<span class="highlight-turquoise">nous</span></h2>
                        <p>Une question, une suggestion, envie de nous rejoindre ? Remplissez le formulaire ci-dessous.</p>
                    </div>

                    <form class="contact-form" action="#" method="post" id="contactForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nom">Nom *</label>
                                <input type="text" id="nom" name="nom" required placeholder="Votre nom">
                            </div>
                            <div class="form-group">
                                <label for="prenom">Prenom *</label>
                                <input type="text" id="prenom" name="prenom" required placeholder="Votre prenom">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" required placeholder="votre@email.fr">
                            </div>
                            <div class="form-group">
                                <label for="telephone">Telephone</label>
                                <input type="tel" id="telephone" name="telephone" placeholder="06 00 00 00 00">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sujet">Sujet *</label>
                            <select id="sujet" name="sujet" required>
                                <option value="">Choisissez un sujet</option>
                                <option value="benevole">Devenir benevole</option>
                                <option value="atelier">Proposer un atelier</option>
                                <option value="don">Question sur les dons</option>
                                <option value="boutique">Question sur la boutique</option>
                                <option value="partenariat">Proposition de partenariat</option>
                                <option value="autre">Autre demande</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" rows="5" required placeholder="Votre message..."></textarea>
                        </div>

                        <!-- Case newsletter mise en avant -->
                        <div class="form-group form-newsletter">
                            <input type="checkbox" id="newsletter" name="newsletter">
                            <label for="newsletter">
                                <span class="newsletter-icon">📬</span>
                                <span class="newsletter-text">
                                    <strong>Je souhaite recevoir la newsletter</strong>
                                    <small>Actualites, ateliers, evenements... environ 1 fois par mois</small>
                                </span>
                            </label>
                        </div>

                        <div class="form-group form-checkbox">
                            <input type="checkbox" id="rgpd" name="rgpd" required>
                            <label for="rgpd">J'accepte que mes donnees soient utilisees pour repondre a ma demande. <a href="<?= url('confidentialite') ?>">Politique de confidentialite</a></label>
                        </div>

                        <button type="submit" class="btn-cta-final">Envoyer le message</button>
                    </form>
                </div>

                <div class="contact-infos">
                    <div class="contact-info-card">
                        <h3>Nos coordonnees</h3>
                        <div class="contact-info-item">
                            <span>📍</span>
                            <div>
                                <strong>Adresse</strong>
                                <p>Chavenay (78450)<br>Yvelines, Ile-de-France</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <span>📧</span>
                            <div>
                                <strong>Email</strong>
                                <p>contact@1000mainsetmerveilles.fr</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <span>🕐</span>
                            <div>
                                <strong>Horaires</strong>
                                <p>Nous repondons sous 48h<br>(jours ouvrables)</p>
                            </div>
                        </div>
                    </div>

                    <div class="contact-social">
                        <h4>Suivez-nous</h4>
                        <div class="social-links">
                            <a href="#" class="social-link" title="Facebook">📘</a>
                            <a href="#" class="social-link" title="Instagram">📷</a>
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
                    <span class="cta-emoji-final">🤝</span>
                    <h2>Pret a nous rejoindre ?</h2>
                    <p>Que vous souhaitiez donner de votre temps, proposer un atelier ou simplement nous rencontrer, nous serons ravis de vous accueillir !</p>
                    <div class="cta-buttons">
                        <a href="<?= url('agenda') ?>" class="btn-cta-final">Voir nos ateliers</a>
                        <a href="<?= url('la-ressourcerie') ?>" class="btn-cta-secondary">Visiter la ressourcerie</a>
                    </div>
                </div>
                <div class="cta-photo-final">
                    <div class="photo-placeholder-final">
                        <div class="photo-icon-final">📸</div>
                        <p>Photo : accueil<br>benevoles</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include ROOT_PATH . '/components/footer.php'; ?>

    <?php include ROOT_PATH . '/components/newsletter-modal.php'; ?>

</body>
</html>
