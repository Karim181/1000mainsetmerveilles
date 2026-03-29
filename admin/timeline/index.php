<?php
/**
 * Admin - Gestion de la frise chronologique
 * 1000 Mains et Merveilles
 */

auth_require();
$user = auth_user();

// Messages flash
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';

// Récupérer toutes les entrées
$entries = dbFetchAll('SELECT * FROM timeline_entries ORDER BY sort_order ASC, year ASC');

$pageTitle = 'Notre histoire';
include ROOT_PATH . '/admin/includes/header.php';
?>

<?php if ($success): ?>
    <div class="alert alert-success"><?= e($success) ?></div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="alert alert-error"><?= e($error) ?></div>
<?php endif; ?>

<div class="page-header">
    <div>
        <p class="page-subtitle">Gerez les etapes affichees en accordeon sur la page "Qui sommes-nous".</p>
    </div>
    <a href="<?= admin_url('timeline/create') ?>" class="btn btn-primary">+ Ajouter une etape</a>
</div>

<?php if (empty($entries)): ?>
    <div class="empty-state">
        <div class="empty-icon">📅</div>
        <h3>Aucune etape dans l'historique</h3>
        <p>Ajoutez la premiere etape de votre histoire.</p>
        <a href="<?= admin_url('timeline/create') ?>" class="btn btn-primary">+ Ajouter une etape</a>
    </div>
<?php else: ?>
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th width="60">Ordre</th>
                    <th width="80">Annee</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th width="140">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entries as $entry): ?>
                <tr>
                    <td><span class="badge badge-blue"><?= (int)$entry['sort_order'] ?></span></td>
                    <td><strong><?= e($entry['year']) ?></strong></td>
                    <td><?= e($entry['title']) ?></td>
                    <td class="text-muted"><?= e(mb_substr($entry['description'], 0, 80)) ?>...</td>
                    <td>
                        <div class="actions-group">
                            <a href="<?= admin_url('timeline/edit') ?>?id=<?= $entry['id'] ?>" class="btn btn-sm btn-outline" title="Modifier">Modifier</a>
                            <a href="<?= admin_url('timeline/delete') ?>?id=<?= $entry['id'] ?>" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Supprimer cette etape ?')">Suppr.</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
