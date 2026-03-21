<?php
/**
 * Admin - Modifier une etape de la frise
 * 1000 Mains et Merveilles
 */

auth_require();
$user = auth_user();

$id = (int)($_GET['id'] ?? 0);
$entry = dbFetchOne('SELECT * FROM timeline_entries WHERE id = ?', [$id]);

if (!$entry) {
    header('Location: ' . admin_url('timeline') . '?error=Etape introuvable');
    exit;
}

$data = $entry;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $data['year'] = trim($_POST['year'] ?? '');
    $data['title'] = trim($_POST['title'] ?? '');
    $data['description'] = trim($_POST['description'] ?? '');
    $data['sort_order'] = (int)($_POST['sort_order'] ?? 0);

    // Validation
    if (empty($data['year'])) $errors[] = 'L\'annee est obligatoire.';
    if (empty($data['title'])) $errors[] = 'Le titre est obligatoire.';
    if (empty($data['description'])) $errors[] = 'La description est obligatoire.';

    if (empty($errors)) {
        dbExecute(
            'UPDATE timeline_entries SET year = ?, title = ?, description = ?, sort_order = ? WHERE id = ?',
            [$data['year'], $data['title'], $data['description'], $data['sort_order'], $id]
        );
        header('Location: ' . admin_url('timeline') . '?success=Etape modifiee avec succes');
        exit;
    }
}

$pageTitle = 'Modifier : ' . $entry['title'];
include ROOT_PATH . '/admin/includes/header.php';
?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $err): ?>
            <p><?= e($err) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="page-header">
    <a href="<?= admin_url('timeline') ?>" class="btn btn-outline">← Retour a la liste</a>
</div>

<form method="post" class="admin-form">
    <?= csrf_field() ?>

    <div class="form-row">
        <div class="form-group" style="flex: 0 0 120px;">
            <label for="year">Annee *</label>
            <input type="text" id="year" name="year" value="<?= e($data['year']) ?>" required placeholder="2024" maxlength="10">
        </div>
        <div class="form-group" style="flex: 0 0 100px;">
            <label for="sort_order">Ordre</label>
            <input type="number" id="sort_order" name="sort_order" value="<?= (int)$data['sort_order'] ?>" min="0">
        </div>
        <div class="form-group" style="flex: 1;">
            <label for="title">Titre *</label>
            <input type="text" id="title" name="title" value="<?= e($data['title']) ?>" required placeholder="Ex: Creation de l'association">
        </div>
    </div>

    <div class="form-group">
        <label for="description">Description *</label>
        <textarea id="description" name="description" rows="4" required placeholder="Decrivez cette etape de l'histoire..."><?= e($data['description']) ?></textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="<?= admin_url('timeline') ?>" class="btn btn-outline">Annuler</a>
    </div>
</form>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
