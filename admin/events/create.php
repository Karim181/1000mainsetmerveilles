<?php
/**
 * Création événement - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

$user = auth_user();

$errors = [];
$data = [
    'title' => '',
    'description' => '',
    'location' => '',
    'start_date' => '',
    'start_time' => '10:00',
    'end_date' => '',
    'end_time' => '',
    'status' => 'draft',
    'is_recurring' => 0,
    'recurrence_info' => '',
];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $data = [
        'title' => trim($_POST['title'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'location' => trim($_POST['location'] ?? ''),
        'start_date' => $_POST['start_date'] ?? '',
        'start_time' => $_POST['start_time'] ?? '10:00',
        'end_date' => $_POST['end_date'] ?? '',
        'end_time' => $_POST['end_time'] ?? '',
        'status' => $_POST['status'] ?? 'draft',
        'is_recurring' => isset($_POST['is_recurring']) ? 1 : 0,
        'recurrence_info' => trim($_POST['recurrence_info'] ?? ''),
    ];

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

    // Génération du slug
    $slug = slugify($data['title']);
    $existingSlug = dbFetchOne('SELECT id FROM events WHERE slug = ?', [$slug]);
    if ($existingSlug) {
        $slug .= '-' . time();
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
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = uploadImage($_FILES['image'], 'events');
        if ($uploadResult['success']) {
            $imageName = $uploadResult['filename'];
        } else {
            $errors[] = $uploadResult['error'];
        }
    }

    // Insertion si pas d'erreurs
    if (empty($errors)) {
        $sql = 'INSERT INTO events (title, slug, description, location, start_date, end_date, image, status, is_recurring, recurrence_info, author_id, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())';

        dbExecute($sql, [
            $data['title'],
            $slug,
            $data['description'],
            $data['location'],
            $startDateTime,
            $endDateTime,
            $imageName,
            $data['status'],
            $data['is_recurring'],
            $data['recurrence_info'] ?: null,
            $user['id'],
        ]);

        $eventId = dbLastId();

        // Redirection selon le bouton cliqué
        if (isset($_POST['save_and_preview'])) {
            header('Location: ' . admin_url('events/preview?id=' . $eventId));
        } else {
            header('Location: ' . admin_url('events') . '?success=Événement créé avec succès');
        }
        exit;
    }
}

$pageTitle = 'Nouvel événement';
include ROOT_PATH . '/admin/includes/header.php';
?>

<div class="admin-card">
    <h2>Créer un événement</h2>

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
                <label for="status">Statut</label>
                <select id="status" name="status" class="form-control">
                    <option value="draft" <?= $data['status'] === 'draft' ? 'selected' : '' ?>>Brouillon</option>
                    <option value="published" <?= $data['status'] === 'published' ? 'selected' : '' ?>>Publié</option>
                </select>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
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
