<?php
/**
 * Édition événement - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

$user = auth_user();

// Récupérer l'événement
$id = (int)($_GET['id'] ?? 0);
$event = dbFetchOne('SELECT * FROM events WHERE id = ?', [$id]);

if (!$event) {
    header('Location: ' . admin_url('events') . '?error=Événement introuvable');
    exit;
}

// Vérifier les droits (admin ou auteur)
if (!auth_is_admin() && $event['author_id'] != $user['id']) {
    header('Location: ' . admin_url('events') . '?error=Accès non autorisé');
    exit;
}

// Extraire date et heure séparément
$startDate = $event['start_date'] ? date('Y-m-d', strtotime($event['start_date'])) : '';
$startTime = $event['start_date'] ? date('H:i', strtotime($event['start_date'])) : '10:00';
$endDate = $event['end_date'] ? date('Y-m-d', strtotime($event['end_date'])) : '';
$endTime = $event['end_date'] ? date('H:i', strtotime($event['end_date'])) : '';

$categories = [
    'atelier' => 'Atelier créatif',
    'evenement' => 'Événement',
    'special' => 'Événement spécial',
];

$errors = [];
$data = array_merge($event, [
    'start_date' => $startDate,
    'start_time' => $startTime,
    'end_date' => $endDate,
    'end_time' => $endTime,
    'is_recurring' => $event['is_recurring'] ?? 0,
    'recurrence_info' => $event['recurrence_info'] ?? '',
]);

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $data = array_merge($event, [
        'title' => trim($_POST['title'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'location' => trim($_POST['location'] ?? ''),
        'start_date' => $_POST['start_date'] ?? '',
        'start_time' => $_POST['start_time'] ?? '10:00',
        'end_date' => $_POST['end_date'] ?? '',
        'end_time' => $_POST['end_time'] ?? '',
        'category' => $_POST['category'] ?? 'evenement',
        'status' => $_POST['status'] ?? 'draft',
        'is_recurring' => isset($_POST['is_recurring']) ? 1 : 0,
        'recurrence_info' => trim($_POST['recurrence_info'] ?? ''),
    ]);

    // Validation
    if (empty($data['title'])) {
        $errors[] = 'Le titre est obligatoire.';
    }

    if (empty($data['description'])) {
        $errors[] = 'La description est obligatoire.';
    }

    if (empty($data['start_date'])) {
        $errors[] = 'La date de début est obligatoire.';
    }

    // Mise à jour du slug si le titre a changé
    $slug = $event['slug'];
    if ($data['title'] !== $event['title']) {
        $slug = slugify($data['title']);
        $existingSlug = dbFetchOne('SELECT id FROM events WHERE slug = ? AND id != ?', [$slug, $id]);
        if ($existingSlug) {
            $slug .= '-' . time();
        }
    }

    // Formater les dates
    $startDateTime = null;
    $endDateTime = null;

    if ($data['start_date']) {
        $startDateTime = $data['start_date'] . ' ' . ($data['start_time'] ?: '00:00') . ':00';
    }

    if ($data['end_date']) {
        $endDateTime = $data['end_date'] . ' ' . ($data['end_time'] ?: '23:59') . ':00';
    }

    // Upload image
    $imageName = $event['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = uploadImage($_FILES['image'], 'events');
        if ($uploadResult['success']) {
            // Supprimer l'ancienne image
            if ($event['image']) {
                deleteImage($event['image'], 'events');
            }
            $imageName = $uploadResult['filename'];
        } else {
            $errors[] = $uploadResult['error'];
        }
    }

    // Suppression image si demandé
    if (isset($_POST['delete_image']) && $event['image']) {
        deleteImage($event['image'], 'events');
        $imageName = null;
    }

    // Mise à jour si pas d'erreurs
    if (empty($errors)) {
        $sql = 'UPDATE events SET
                title = ?, slug = ?, description = ?, location = ?,
                start_date = ?, end_date = ?, image = ?, category = ?, status = ?,
                is_recurring = ?, recurrence_info = ?, updated_at = NOW()
                WHERE id = ?';

        dbExecute($sql, [
            $data['title'],
            $slug,
            $data['description'],
            $data['location'],
            $startDateTime,
            $endDateTime,
            $imageName,
            $data['category'],
            $data['status'],
            $data['is_recurring'],
            $data['recurrence_info'] ?: null,
            $id,
        ]);

        // Redirection selon le bouton cliqué
        if (isset($_POST['save_and_preview'])) {
            header('Location: ' . admin_url('events/preview?id=' . $id));
        } else {
            header('Location: ' . admin_url('events') . '?success=Événement mis à jour');
        }
        exit;
    }
}

$pageTitle = 'Modifier : ' . $event['title'];
include ROOT_PATH . '/admin/includes/header.php';
?>

<div class="admin-card">
    <div class="card-header">
        <h2>Modifier l'événement</h2>
        <a href="<?= admin_url('events/preview?id=' . $event['id']) ?>" class="btn btn-secondary">👁️ Prévisualiser</a>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= e($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="title">Titre *</label>
            <input type="text" id="title" name="title" value="<?= e($data['title']) ?>" class="form-control" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="start_date">Date de début *</label>
                <input type="date" id="start_date" name="start_date" value="<?= e($data['start_date']) ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="start_time">Heure de début</label>
                <input type="time" id="start_time" name="start_time" value="<?= e($data['start_time']) ?>" class="form-control">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="end_date">Date de fin</label>
                <input type="date" id="end_date" name="end_date" value="<?= e($data['end_date']) ?>" class="form-control">
                <small class="form-help">Optionnel pour les événements d'une journée</small>
            </div>
            <div class="form-group">
                <label for="end_time">Heure de fin</label>
                <input type="time" id="end_time" name="end_time" value="<?= e($data['end_time']) ?>" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="location">Lieu</label>
            <input type="text" id="location" name="location" value="<?= e($data['location']) ?>" class="form-control" placeholder="Ex: Ressourcerie de Saint-Germain">
        </div>

        <div class="form-group recurring-group">
            <label class="checkbox-label">
                <input type="checkbox" name="is_recurring" id="is_recurring" value="1" <?= $data['is_recurring'] ? 'checked' : '' ?>>
                <span>Événement récurrent</span>
            </label>
            <div class="recurring-details" id="recurring-details" style="<?= $data['is_recurring'] ? '' : 'display: none;' ?>">
                <input type="text" name="recurrence_info" id="recurrence_info" value="<?= e($data['recurrence_info']) ?>" class="form-control" placeholder="Ex: Tous les mercredis, Chaque 1er samedi du mois...">
                <small class="form-help">Décrivez la fréquence (affiché sur le site)</small>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description *</label>
            <textarea id="description" name="description" class="form-control" rows="8" required><?= e($data['description']) ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category">Catégorie *</label>
                <select id="category" name="category" class="form-control">
                    <?php foreach ($categories as $val => $label): ?>
                        <option value="<?= $val ?>" <?= ($data['category'] ?? 'evenement') === $val ? 'selected' : '' ?>><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Statut</label>
                <select id="status" name="status" class="form-control">
                    <option value="draft" <?= $data['status'] === 'draft' ? 'selected' : '' ?>>Brouillon</option>
                    <option value="published" <?= $data['status'] === 'published' ? 'selected' : '' ?>>Publié</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="image">Image</label>
                <?php if ($data['image']): ?>
                    <div class="current-image">
                        <img src="<?= upload_url('events/' . $data['image']) ?>" alt="" class="preview-image">
                        <label class="checkbox-label">
                            <input type="checkbox" name="delete_image" value="1">
                            Supprimer cette image
                        </label>
                    </div>
                <?php endif; ?>
                <input type="file" id="image" name="image" class="form-control" accept="image/jpeg,image/png,image/webp">
                <small class="form-help">Formats acceptés : JPG, PNG, WebP. Max 2 Mo.</small>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" name="save" class="btn btn-primary">💾 Enregistrer</button>
            <button type="submit" name="save_and_preview" class="btn btn-secondary">👁️ Enregistrer et prévisualiser</button>
            <a href="<?= admin_url('events') ?>" class="btn btn-link">Annuler</a>
        </div>
    </form>
</div>

<script>
document.getElementById('is_recurring').addEventListener('change', function() {
    document.getElementById('recurring-details').style.display = this.checked ? 'block' : 'none';
});
</script>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
