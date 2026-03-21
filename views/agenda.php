<?php
/**
 * Page Agenda - Affichage public des événements
 * 1000 Mains et Merveilles
 */

// Mois en français
$moisFr = ['', 'JAN', 'FÉV', 'MAR', 'AVR', 'MAI', 'JUIN', 'JUIL', 'AOÛT', 'SEP', 'OCT', 'NOV', 'DÉC'];
$moisFrLong = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

// Récupérer les événements à venir (publiés)
$evenementsAVenir = dbFetchAll(
    'SELECT * FROM events
     WHERE status = "published" AND start_date >= NOW()
     ORDER BY start_date ASC
     LIMIT 6'
);

// Récupérer les prochains événements pour le programme du mois
$programmeMois = dbFetchAll(
    'SELECT * FROM events
     WHERE status = "published" AND start_date >= NOW()
     ORDER BY start_date ASC
     LIMIT 4'
);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda - Ateliers et événements | 1000 Mains et Merveilles</title>
    <meta name="description" content="Découvrez nos ateliers créatifs et événements. Participez à nos activités de réemploi et de création dans les Yvelines.">

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
                    <h1>Nos <span class="highlight-turquoise">événements</span></h1>
                    <p class="hero-description-final">Ateliers créatifs, événements spéciaux, rencontres... Découvrez tout ce qui se passe chez 1000 Mains et Merveilles.</p>
                    <?php include ROOT_PATH . '/components/hero-chiffres.php'; ?>
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
                        <span class="section-tag-final tag-turquoise">Ateliers créatifs</span>
                        <h2>Apprenez, créez, <span class="highlight-turquoise">partagez</span></h2>
                    </div>
                    <div class="ateliers-list">
                        <div class="atelier-item">
                            <span class="atelier-icon">🧵</span>
                            <div>
                                <h3>Couture & Retouche</h3>
                                <p>Réparer, transformer et customiser vos vêtements.</p>
                            </div>
                        </div>
                        <div class="atelier-item">
                            <span class="atelier-icon">🪑</span>
                            <div>
                                <h3>Relooking meubles</h3>
                                <p>Peinture, patine, techniques de rénovation.</p>
                            </div>
                        </div>
                        <div class="atelier-item">
                            <span class="atelier-icon">🎨</span>
                            <div>
                                <h3>Loisirs créatifs</h3>
                                <p>Déco, bijoux, objets récup...</p>
                            </div>
                        </div>
                        <div class="atelier-item">
                            <span class="atelier-icon">🔧</span>
                            <div>
                                <h3>Réparation</h3>
                                <p>Électroménager, vélos, objets du quotidien.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2 : PROGRAMME DU MOIS -->
                <div class="agenda-grid-cell agenda-programme">
                    <div class="grid-cell-header">
                        <span class="section-tag-final tag-orange">Programme</span>
                        <h2>Événements du <span class="highlight-turquoise">mois</span></h2>
                    </div>
                    <div class="programme-liste">
                        <?php if (empty($programmeMois)): ?>
                            <p class="empty-message">Aucun événement programmé pour le moment.</p>
                        <?php else: ?>
                            <?php foreach ($programmeMois as $event): ?>
                            <?php
                            $dateEvent = strtotime($event['start_date']);
                            $jour = date('d', $dateEvent);
                            $mois = $moisFr[(int)date('n', $dateEvent)];
                            ?>
                            <div class="evenement-mini">
                                <div class="evenement-date-mini">
                                    <span class="jour"><?= $jour ?></span>
                                    <span class="mois"><?= $mois ?></span>
                                </div>
                                <div class="evenement-info-mini">
                                    <h3><?= e($event['title']) ?><?php if (!empty($event['is_recurring'])): ?> <span class="badge-recurring">🔄</span><?php endif; ?></h3>
                                    <span>
                                        <?php if (!empty($event['is_recurring']) && $event['recurrence_info']): ?>
                                            🔄 <?= e($event['recurrence_info']) ?>
                                        <?php else: ?>
                                            <?php if ($event['location']): ?>📍 <?= e($event['location']) ?> • <?php endif; ?>
                                            🕐 <?= date('H\hi', $dateEvent) ?>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <p class="programme-note">Dates susceptibles d'être modifiées</p>
                </div>

                <!-- SECTION 3 : AUTRES EVENEMENTS -->
                <div class="agenda-grid-cell agenda-evenements">
                    <div class="grid-cell-header">
                        <span class="section-tag-final tag-turquoise">Événements spéciaux</span>
                        <h2>Autres <span class="highlight-turquoise">rendez-vous</span></h2>
                    </div>
                    <div class="evenements-speciaux-list">
                        <div class="evenement-special-item">
                            <span class="evenement-special-icon">🎉</span>
                            <div>
                                <h3>Vente spéciale printemps</h3>
                                <p>Grande vente avec promotions sur tout le magasin.</p>
                                <span class="evenement-special-date">Mars 2026</span>
                            </div>
                        </div>
                        <div class="evenement-special-item">
                            <span class="evenement-special-icon">🚪</span>
                            <div>
                                <h3>Portes ouvertes</h3>
                                <p>Découvrez les coulisses de la ressourcerie.</p>
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
                        <p>Vous maîtrisez une technique, un savoir-faire ? Proposez d'animer un atelier bénévole ! Couture, bricolage, création, réparation... Toutes les idées sont les bienvenues.</p>
                        <a href="<?= url('nous-rejoindre') ?>" class="btn-cta-final">Proposer un atelier</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========== TOUS LES EVENEMENTS A VENIR ========== -->
    <?php if (!empty($evenementsAVenir)): ?>
    <section class="agenda-tous-evenements">
        <div class="container">
            <div class="section-header-with-toggle">
                <div class="section-header-final">
                    <span class="section-tag-final tag-turquoise">À venir 📅</span>
                    <h2>Tous nos <span class="highlight-turquoise">événements</span></h2>
                    <p>Retrouvez ici l'ensemble de nos prochains rendez-vous</p>
                </div>
                <!-- Toggle vue liste/grille -->
                <div class="view-toggle">
                    <button class="view-btn active" data-view="liste" title="Vue liste">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                        <span>Liste</span>
                    </button>
                    <button class="view-btn" data-view="grille" title="Vue grille">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                        </svg>
                        <span>Grille</span>
                    </button>
                </div>
            </div>

            <!-- Conteneur des événements (vue liste par défaut) -->
            <div class="evenements-container view-liste" id="evenements-container">
                <?php foreach ($evenementsAVenir as $event): ?>
                <?php
                $dateEvent = strtotime($event['start_date']);
                $jour = date('d', $dateEvent);
                $mois = $moisFrLong[(int)date('n', $dateEvent)];
                $moisCourt = $moisFr[(int)date('n', $dateEvent)];
                $annee = date('Y', $dateEvent);
                ?>
                <article class="evenement-card" data-id="<?= $event['id'] ?>">
                    <!-- Vue Liste -->
                    <div class="evenement-vue-liste">
                        <div class="evenement-date-large">
                            <span class="jour"><?= $jour ?></span>
                            <span class="mois"><?= $mois ?></span>
                            <span class="annee"><?= $annee ?></span>
                        </div>
                        <div class="evenement-content-large">
                            <h3><?= e($event['title']) ?></h3>
                            <div class="evenement-meta">
                                <?php if (!empty($event['is_recurring']) && $event['recurrence_info']): ?>
                                    <span class="meta-recurring">🔄 <?= e($event['recurrence_info']) ?></span>
                                <?php endif; ?>
                                <span>🕐 <?= date('H\hi', $dateEvent) ?><?php if ($event['end_date']): ?> - <?= date('H\hi', strtotime($event['end_date'])) ?><?php endif; ?></span>
                                <?php if ($event['location']): ?>
                                    <span>📍 <?= e($event['location']) ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if ($event['description']): ?>
                                <p><?= e(substr($event['description'], 0, 150)) ?><?= strlen($event['description']) > 150 ? '...' : '' ?></p>
                            <?php endif; ?>
                        </div>
                        <?php if ($event['image']): ?>
                        <div class="evenement-image-large">
                            <img src="<?= upload_url('events/' . $event['image']) ?>" alt="<?= e($event['title']) ?>">
                        </div>
                        <?php endif; ?>
                    </div>
                    <!-- Vue Grille -->
                    <div class="evenement-vue-grille">
                        <?php if ($event['image']): ?>
                        <div class="evenement-image-grille">
                            <img src="<?= upload_url('events/' . $event['image']) ?>" alt="<?= e($event['title']) ?>">
                            <div class="evenement-date-badge">
                                <span class="jour"><?= $jour ?></span>
                                <span class="mois"><?= $moisCourt ?></span>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="evenement-image-grille evenement-image-placeholder">
                            <div class="evenement-date-badge">
                                <span class="jour"><?= $jour ?></span>
                                <span class="mois"><?= $moisCourt ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="evenement-content-grille">
                            <h3><?= e($event['title']) ?></h3>
                            <div class="evenement-infos-grille">
                                <span>🕐 <?= date('H\hi', $dateEvent) ?></span>
                                <?php if ($event['location']): ?>
                                    <span>📍 <?= e($event['location']) ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($event['is_recurring']) && $event['recurrence_info']): ?>
                                <span class="badge-recurring-grille">🔄 <?= e($event['recurrence_info']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ========== CTA ========== -->
    <section class="cta-final">
        <div class="container">
            <div class="cta-final-box">
                <div class="cta-final-content">
                    <span class="cta-emoji-final">📅</span>
                    <h2>Envie de participer ?</h2>
                    <p>Contactez-nous pour vous inscrire à un atelier ou pour en savoir plus sur nos événements.</p>
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

    <?php include ROOT_PATH . '/components/footer.php'; ?>

<script>
// Toggle vue liste/grille
document.querySelectorAll('.view-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var view = this.dataset.view;
        var container = document.getElementById('evenements-container');

        // Mettre à jour les boutons
        document.querySelectorAll('.view-btn').forEach(function(b) {
            b.classList.remove('active');
        });
        this.classList.add('active');

        // Mettre à jour le conteneur
        container.classList.remove('view-liste', 'view-grille');
        container.classList.add('view-' + view);

        // Sauvegarder la préférence
        localStorage.setItem('agenda-view', view);
    });
});

// Restaurer la préférence au chargement
document.addEventListener('DOMContentLoaded', function() {
    var savedView = localStorage.getItem('agenda-view');
    if (savedView) {
        var btn = document.querySelector('.view-btn[data-view="' + savedView + '"]');
        if (btn) btn.click();
    }
});
</script>

    <?php include ROOT_PATH . '/components/newsletter-modal.php'; ?>

</body>
</html>
