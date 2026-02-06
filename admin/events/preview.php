<?php
/**
 * Prévisualisation événement - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

// Récupérer l'événement
$id = (int)($_GET['id'] ?? 0);
$event = dbFetchOne(
    'SELECT e.*, u.name as author_name
     FROM events e
     LEFT JOIN users u ON e.author_id = u.id
     WHERE e.id = ?',
    [$id]
);

if (!$event) {
    header('Location: ' . admin_url('events') . '?error=Événement introuvable');
    exit;
}

$isPast = strtotime($event['start_date']) < time();

$pageTitle = 'Prévisualisation : ' . $event['title'];
include ROOT_PATH . '/admin/includes/header.php';
?>

<?php $user = auth_user(); ?>
<div class="preview-actions">
    <a href="<?= admin_url('events/edit?id=' . $event['id']) ?>" class="btn btn-primary">✏️ Modifier</a>
    <a href="<?= admin_url('events') ?>" class="btn btn-secondary">← Retour à la liste</a>
    <?php if (auth_is_admin() || $event['author_id'] == $user['id']): ?>
        <a href="<?= admin_url('events/delete?id=' . $event['id']) ?>" class="btn btn-danger" onclick="return confirm('Supprimer cet événement ?')">🗑️ Supprimer</a>
    <?php endif; ?>

    <?php if ($event['status'] === 'published'): ?>
        <span class="badge badge-success" style="margin-left: auto; font-size: 1rem; padding: 10px 20px;">✅ Cet événement est publié</span>
    <?php else: ?>
        <span class="badge badge-warning" style="margin-left: auto; font-size: 1rem; padding: 10px 20px;">📝 Brouillon - non visible publiquement</span>
    <?php endif; ?>
</div>

<div class="preview-container">
    <div class="preview-label">Aperçu du rendu public</div>

    <div class="preview-content">
        <!-- Simulation du rendu public -->
        <div class="event-preview">
            <?php if ($event['image']): ?>
                <div class="event-preview-image">
                    <img src="<?= upload_url('events/' . $event['image']) ?>" alt="<?= e($event['title']) ?>">
                </div>
            <?php endif; ?>

            <div class="event-preview-info">
                <?php
                $moisFr = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                $startTimestamp = strtotime($event['start_date']);
                ?>
                <div class="event-preview-date-box">
                    <span class="event-day"><?= date('d', $startTimestamp) ?></span>
                    <span class="event-month"><?= $moisFr[(int)date('n', $startTimestamp)] ?></span>
                    <span class="event-year"><?= date('Y', $startTimestamp) ?></span>
                </div>

                <div class="event-preview-details">
                    <h1 class="event-preview-title"><?= e($event['title']) ?></h1>

                    <?php if ($isPast): ?>
                        <span class="badge badge-info" style="margin-bottom: 15px; display: inline-block;">Événement passé</span>
                    <?php endif; ?>

                    <div class="event-preview-meta">
                        <p class="event-time">
                            🕐 <?= date('H:i', strtotime($event['start_date'])) ?>
                            <?php if ($event['end_date']): ?>
                                - <?= date('H:i', strtotime($event['end_date'])) ?>
                            <?php endif; ?>
                        </p>

                        <?php if ($event['location']): ?>
                            <p class="event-location">📍 <?= e($event['location']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="event-preview-description">
                        <?= nl2br(e($event['description'])) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.preview-actions {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    align-items: center;
}

.preview-container {
    background: #f8fafc;
    border: 2px dashed var(--admin-border);
    border-radius: 12px;
    overflow: hidden;
}

.preview-label {
    background: var(--admin-primary);
    color: white;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 0.9rem;
}

.preview-content {
    padding: 30px;
    background: white;
}

/* Simulation du style public */
.event-preview {
    max-width: 900px;
    margin: 0 auto;
    font-family: 'DM Sans', sans-serif;
}

.event-preview-image {
    margin-bottom: 30px;
}

.event-preview-image img {
    width: 100%;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.event-preview-info {
    display: grid;
    grid-template-columns: 120px 1fr;
    gap: 30px;
}

.event-preview-date-box {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    height: fit-content;
}

.event-day {
    display: block;
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1;
}

.event-month {
    display: block;
    font-size: 1rem;
    text-transform: capitalize;
    margin-top: 5px;
}

.event-year {
    display: block;
    font-size: 0.9rem;
    opacity: 0.8;
}

.event-preview-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 15px;
    line-height: 1.2;
}

.event-preview-meta {
    display: flex;
    gap: 25px;
    margin-bottom: 25px;
    color: #64748b;
}

.event-preview-meta p {
    margin: 0;
}

.event-preview-description {
    color: #475569;
    line-height: 1.8;
    font-size: 1.05rem;
    padding-top: 25px;
    border-top: 1px solid #e2e8f0;
}

@media (max-width: 768px) {
    .event-preview-info {
        grid-template-columns: 1fr;
    }

    .event-preview-date-box {
        display: flex;
        gap: 10px;
        justify-content: center;
        align-items: baseline;
    }

    .event-day, .event-month, .event-year {
        display: inline;
    }

    .preview-actions {
        flex-wrap: wrap;
    }
}
</style>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
