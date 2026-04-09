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
        <div class="page-card">
            <span class="page-card-icon"><?= $page['icon'] ?></span>
            <h3><?= e($page['name']) ?></h3>
            <span class="page-card-count"><?= $counts[$slug] ?? 0 ?> bloc<?= ($counts[$slug] ?? 0) > 1 ? 's' : '' ?> editable<?= ($counts[$slug] ?? 0) > 1 ? 's' : '' ?></span>
            <div class="page-card-actions">
                <a href="<?= admin_url('pages/edit') ?>?slug=<?= $slug ?>" class="page-btn page-btn-fields">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Champs
                </a>
                <a href="<?= admin_url('pages/editor') ?>?slug=<?= $slug ?>" class="page-btn page-btn-visual">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                    Editeur visuel
                </a>
            </div>
        </div>
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

.page-card-actions {
    display: flex;
    gap: 8px;
    margin-top: 15px;
    width: 100%;
}

.page-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 8px 10px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}

.page-btn-fields {
    background: #f0eee9;
    color: var(--admin-text);
}

.page-btn-fields:hover {
    background: var(--admin-primary);
    color: white;
}

.page-btn-visual {
    background: #e8f5e9;
    color: #2e7d32;
}

.page-btn-visual:hover {
    background: #4CAF50;
    color: white;
}
</style>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
