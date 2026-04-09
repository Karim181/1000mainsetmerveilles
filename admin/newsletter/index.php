<?php
/**
 * Liste des inscrits newsletter - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

// Export CSV
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    $subscribers = dbFetchAll('SELECT first_name, last_name, email, status, created_at FROM newsletter_subscribers ORDER BY created_at DESC');

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="newsletter_' . date('Y-m-d') . '.csv"');

    $output = fopen('php://output', 'w');
    // BOM UTF-8 pour Excel
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    fputcsv($output, ['Prenom', 'Nom', 'Email', 'Statut', 'Date inscription'], ';');

    foreach ($subscribers as $sub) {
        fputcsv($output, [
            $sub['first_name'],
            $sub['last_name'],
            $sub['email'],
            $sub['status'] === 'active' ? 'Actif' : 'Desinscrit',
            $sub['created_at'],
        ], ';');
    }

    fclose($output);
    exit;
}

$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';

$subscribers = dbFetchAll('SELECT * FROM newsletter_subscribers ORDER BY created_at DESC');
$totalActive = 0;
foreach ($subscribers as $s) {
    if ($s['status'] === 'active') $totalActive++;
}

$pageTitle = 'Newsletter';
include ROOT_PATH . '/admin/includes/header.php';
?>

<?php if ($success): ?>
    <div class="alert alert-success"><?= e($success) ?></div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="alert alert-error"><?= e($error) ?></div>
<?php endif; ?>

<div class="admin-card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2>Contacts newsletter</h2>
            <p style="color: #8b7e74; margin-top: 5px;"><?= $totalActive ?> inscrit<?= $totalActive > 1 ? 's' : '' ?> actif<?= $totalActive > 1 ? 's' : '' ?> sur <?= count($subscribers) ?> total</p>
        </div>
        <a href="<?= admin_url('newsletter') ?>?export=csv" class="btn btn-primary" style="display: flex; align-items: center; gap: 6px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Exporter CSV
        </a>
    </div>

    <?php if (empty($subscribers)): ?>
        <p style="padding: 40px; text-align: center; color: #8b7e74;">Aucun inscrit pour le moment.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Prenom</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscribers as $sub): ?>
                    <tr>
                        <td><?= e($sub['first_name']) ?></td>
                        <td><?= e($sub['last_name']) ?></td>
                        <td><a href="mailto:<?= e($sub['email']) ?>"><?= e($sub['email']) ?></a></td>
                        <td>
                            <?php if ($sub['status'] === 'active'): ?>
                                <span class="badge badge-green">Actif</span>
                            <?php else: ?>
                                <span class="badge badge-gray">Desinscrit</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($sub['created_at'])) ?></td>
                        <td>
                            <a href="<?= admin_url('newsletter/delete') ?>?id=<?= $sub['id'] ?>&csrf_token=<?= csrf_token() ?>" class="btn-icon btn-danger" onclick="return confirm('Supprimer ce contact ?')" title="Supprimer">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
