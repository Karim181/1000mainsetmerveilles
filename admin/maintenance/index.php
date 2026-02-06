<?php
/**
 * Maintenance - Admin
 * 1000 Mains et Merveilles
 */

auth_require_admin(); // Réservé aux admins uniquement

$success = '';
$error = '';
$showConfirm = false;
$purgeType = '';

// Étape 1 : Demande de purge
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_purge'])) {
    csrf_check();
    $purgeType = $_POST['purge_type'] ?? '';

    if (in_array($purgeType, ['products', 'news', 'events', 'all'])) {
        $showConfirm = true;
    } else {
        $error = 'Type de purge invalide.';
    }
}

// Étape 2 : Confirmation de purge
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_purge'])) {
    csrf_check();
    $purgeType = $_POST['purge_type'] ?? '';
    $confirmWord = trim($_POST['confirm_word'] ?? '');

    // Le mot de confirmation doit être "SUPPRIMER"
    if ($confirmWord !== 'SUPPRIMER') {
        $error = 'Le mot de confirmation est incorrect. Tapez exactement : SUPPRIMER';
        $showConfirm = true;
    } else {
        $deleted = 0;

        switch ($purgeType) {
            case 'products':
                // Supprimer les images des produits
                $products = dbFetchAll('SELECT image FROM products WHERE image IS NOT NULL');
                foreach ($products as $p) {
                    if ($p['image']) deleteImage($p['image'], 'products');
                }
                $deleted = dbExecute('DELETE FROM products');
                $success = "$deleted produit(s) supprimé(s).";
                break;

            case 'news':
                // Supprimer les images des actualités
                $news = dbFetchAll('SELECT image FROM news WHERE image IS NOT NULL');
                foreach ($news as $n) {
                    if ($n['image']) deleteImage($n['image'], 'news');
                }
                $deleted = dbExecute('DELETE FROM news');
                $success = "$deleted actualité(s) supprimée(s).";
                break;

            case 'events':
                // Supprimer les images des événements
                $events = dbFetchAll('SELECT image FROM events WHERE image IS NOT NULL');
                foreach ($events as $e) {
                    if ($e['image']) deleteImage($e['image'], 'events');
                }
                $deleted = dbExecute('DELETE FROM events');
                $success = "$deleted événement(s) supprimé(s).";
                break;

            case 'all':
                // Supprimer toutes les images
                $products = dbFetchAll('SELECT image FROM products WHERE image IS NOT NULL');
                foreach ($products as $p) {
                    if ($p['image']) deleteImage($p['image'], 'products');
                }
                $news = dbFetchAll('SELECT image FROM news WHERE image IS NOT NULL');
                foreach ($news as $n) {
                    if ($n['image']) deleteImage($n['image'], 'news');
                }
                $events = dbFetchAll('SELECT image FROM events WHERE image IS NOT NULL');
                foreach ($events as $e) {
                    if ($e['image']) deleteImage($e['image'], 'events');
                }

                $d1 = dbExecute('DELETE FROM products');
                $d2 = dbExecute('DELETE FROM news');
                $d3 = dbExecute('DELETE FROM events');
                $success = "Purge complète : $d1 produit(s), $d2 actualité(s), $d3 événement(s) supprimé(s).";
                break;

            default:
                $error = 'Type de purge invalide.';
        }
    }
}

// Compter les éléments
$counts = [
    'products' => dbFetchOne('SELECT COUNT(*) as c FROM products')['c'],
    'news' => dbFetchOne('SELECT COUNT(*) as c FROM news')['c'],
    'events' => dbFetchOne('SELECT COUNT(*) as c FROM events')['c'],
];

$pageTitle = 'Maintenance';
include ROOT_PATH . '/admin/includes/header.php';
?>

<?php if ($success): ?>
    <div class="alert alert-success"><?= e($success) ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-error"><?= e($error) ?></div>
<?php endif; ?>

<div class="admin-card">
    <h2>🔧 Maintenance de la base de données</h2>
    <p class="maintenance-warning">⚠️ Les actions de purge sont <strong>irréversibles</strong>. Utilisez-les avec précaution.</p>

    <div class="maintenance-stats">
        <div class="stat-item">
            <span class="stat-icon">🛍️</span>
            <span class="stat-count"><?= $counts['products'] ?></span>
            <span class="stat-label">Produits</span>
        </div>
        <div class="stat-item">
            <span class="stat-icon">📰</span>
            <span class="stat-count"><?= $counts['news'] ?></span>
            <span class="stat-label">Actualités</span>
        </div>
        <div class="stat-item">
            <span class="stat-icon">📅</span>
            <span class="stat-count"><?= $counts['events'] ?></span>
            <span class="stat-label">Événements</span>
        </div>
    </div>
</div>

<?php if ($showConfirm): ?>
<!-- Étape 2 : Confirmation -->
<div class="admin-card purge-confirm-card">
    <h2>⚠️ Confirmation requise</h2>

    <div class="purge-confirm-message">
        <?php
        $typeLabels = [
            'products' => 'tous les produits (' . $counts['products'] . ')',
            'news' => 'toutes les actualités (' . $counts['news'] . ')',
            'events' => 'tous les événements (' . $counts['events'] . ')',
            'all' => 'TOUTES les données (produits, actualités, événements)',
        ];
        ?>
        <p>Vous êtes sur le point de supprimer <strong><?= $typeLabels[$purgeType] ?></strong>.</p>
        <p>Cette action est <strong>irréversible</strong>. Les images associées seront également supprimées.</p>
        <p>Pour confirmer, tapez <code>SUPPRIMER</code> dans le champ ci-dessous :</p>
    </div>

    <form method="POST" class="purge-confirm-form">
        <?= csrf_field() ?>
        <input type="hidden" name="purge_type" value="<?= e($purgeType) ?>">

        <div class="form-group">
            <input type="text" name="confirm_word" class="form-control purge-input" placeholder="Tapez SUPPRIMER" autocomplete="off" required>
        </div>

        <div class="form-actions">
            <button type="submit" name="confirm_purge" class="btn btn-danger">🗑️ Confirmer la suppression</button>
            <a href="<?= admin_url('maintenance') ?>" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<?php else: ?>
<!-- Étape 1 : Sélection du type de purge -->
<div class="admin-card">
    <h2>🗑️ Purger les données</h2>

    <div class="purge-options">
        <form method="POST" class="purge-form">
            <?= csrf_field() ?>
            <input type="hidden" name="purge_type" value="products">
            <button type="submit" name="request_purge" class="purge-option" <?= $counts['products'] == 0 ? 'disabled' : '' ?>>
                <span class="purge-icon">🛍️</span>
                <span class="purge-title">Purger les produits</span>
                <span class="purge-count"><?= $counts['products'] ?> élément(s)</span>
            </button>
        </form>

        <form method="POST" class="purge-form">
            <?= csrf_field() ?>
            <input type="hidden" name="purge_type" value="news">
            <button type="submit" name="request_purge" class="purge-option" <?= $counts['news'] == 0 ? 'disabled' : '' ?>>
                <span class="purge-icon">📰</span>
                <span class="purge-title">Purger les actualités</span>
                <span class="purge-count"><?= $counts['news'] ?> élément(s)</span>
            </button>
        </form>

        <form method="POST" class="purge-form">
            <?= csrf_field() ?>
            <input type="hidden" name="purge_type" value="events">
            <button type="submit" name="request_purge" class="purge-option" <?= $counts['events'] == 0 ? 'disabled' : '' ?>>
                <span class="purge-icon">📅</span>
                <span class="purge-title">Purger les événements</span>
                <span class="purge-count"><?= $counts['events'] ?> élément(s)</span>
            </button>
        </form>

        <form method="POST" class="purge-form">
            <?= csrf_field() ?>
            <input type="hidden" name="purge_type" value="all">
            <button type="submit" name="request_purge" class="purge-option purge-danger" <?= ($counts['products'] + $counts['news'] + $counts['events']) == 0 ? 'disabled' : '' ?>>
                <span class="purge-icon">💀</span>
                <span class="purge-title">Purger TOUT</span>
                <span class="purge-count"><?= $counts['products'] + $counts['news'] + $counts['events'] ?> élément(s) au total</span>
            </button>
        </form>
    </div>
</div>
<?php endif; ?>

<style>
.maintenance-warning {
    background: #fff3cd;
    border: 1px solid #ffc107;
    border-radius: 8px;
    padding: 15px;
    color: #856404;
    margin-bottom: 25px;
}

.maintenance-stats {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.stat-item {
    background: var(--admin-bg);
    padding: 20px 30px;
    border-radius: 12px;
    text-align: center;
    flex: 1;
    min-width: 150px;
}

.stat-icon {
    font-size: 2rem;
    display: block;
    margin-bottom: 10px;
}

.stat-count {
    font-size: 2rem;
    font-weight: 700;
    color: var(--admin-primary);
    display: block;
}

.stat-label {
    color: var(--admin-text-light);
    font-size: 0.9rem;
}

.purge-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.purge-form {
    display: contents;
}

.purge-option {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 25px 20px;
    background: white;
    border: 2px solid var(--admin-border);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.purge-option:hover:not(:disabled) {
    border-color: #dc3545;
    background: #fff5f5;
}

.purge-option:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.purge-danger {
    border-color: #dc3545;
    background: #fff5f5;
}

.purge-danger:hover:not(:disabled) {
    background: #ffe0e0;
}

.purge-icon {
    font-size: 2.5rem;
    margin-bottom: 10px;
}

.purge-title {
    font-weight: 600;
    color: var(--admin-text);
    margin-bottom: 5px;
}

.purge-count {
    font-size: 0.85rem;
    color: var(--admin-text-light);
}

.purge-confirm-card {
    border: 2px solid #dc3545;
    background: #fff5f5;
}

.purge-confirm-message {
    margin-bottom: 25px;
}

.purge-confirm-message code {
    background: #dc3545;
    color: white;
    padding: 4px 12px;
    border-radius: 4px;
    font-weight: 700;
}

.purge-input {
    max-width: 300px;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: 600;
}

.purge-confirm-form .form-actions {
    margin-top: 20px;
}
</style>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
