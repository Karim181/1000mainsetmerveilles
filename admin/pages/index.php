<?php
/**
 * Liste des pages editables - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

// Pages editables
$pages = [
    'home' => ['name' => 'Accueil', 'icon' => '🏠'],
    'qui-sommes-nous' => ['name' => 'Qui sommes-nous', 'icon' => '💙'],
    'la-ressourcerie' => ['name' => 'La Ressourcerie', 'icon' => '🏪'],
    'dons' => ['name' => 'Faire un don', 'icon' => '📦'],
    'venir-chiner' => ['name' => 'Venir chiner', 'icon' => '🛍️'],
    'nous-rejoindre' => ['name' => 'Nous rejoindre', 'icon' => '🤝'],
];

// Compter les contenus par page
$counts = [];
try {
    $rows = dbFetchAll('SELECT page_slug, COUNT(*) as cnt FROM page_contents GROUP BY page_slug');
    foreach ($rows as $row) {
        $counts[$row['page_slug']] = $row['cnt'];
    }
} catch (\Exception $e) {
    // Table pas encore creee
}

$pageTitle = 'Pages du site';
include ROOT_PATH . '/admin/includes/header.php';
?>

<div class="admin-card">
    <div class="card-header">
        <h2>Modifier les contenus des pages</h2>
        <p style="color: #8b7e74; margin-top: 5px;">Editez les textes et images principaux de chaque page du site.</p>
    </div>

    <div class="pages-grid">
        <?php foreach ($pages as $slug => $page): ?>
        <a href="<?= admin_url('pages/edit') ?>?slug=<?= $slug ?>" class="page-card">
            <span class="page-card-icon"><?= $page['icon'] ?></span>
            <h3><?= e($page['name']) ?></h3>
            <span class="page-card-count"><?= $counts[$slug] ?? 0 ?> bloc<?= ($counts[$slug] ?? 0) > 1 ? 's' : '' ?> editable<?= ($counts[$slug] ?? 0) > 1 ? 's' : '' ?></span>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<style>
.pages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 25px;
}

.page-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 30px 20px;
    background: #f8f6f3;
    border-radius: 20px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.page-card:hover {
    border-color: var(--admin-primary);
    background: white;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
}

.page-card-icon {
    font-size: 36px;
    margin-bottom: 12px;
}

.page-card h3 {
    font-size: 16px;
    font-weight: 700;
    color: var(--admin-text);
    margin-bottom: 8px;
}

.page-card-count {
    font-size: 13px;
    color: #8b7e74;
}
</style>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
