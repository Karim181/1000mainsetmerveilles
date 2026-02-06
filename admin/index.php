<?php
/**
 * Dashboard Admin
 * 1000 Mains et Merveilles
 */

auth_require();

$user = auth_user();

// Mois français abrégés
$moisAbrev = ['', 'jan', 'fév', 'mar', 'avr', 'mai', 'juin', 'juil', 'août', 'sept', 'oct', 'nov', 'déc'];

// Statistiques
$stats = [
    'products' => dbFetchOne('SELECT COUNT(*) as count FROM products')['count'] ?? 0,
    'products_available' => dbFetchOne('SELECT COUNT(*) as count FROM products WHERE status = "available"')['count'] ?? 0,
    'news' => dbFetchOne('SELECT COUNT(*) as count FROM news')['count'] ?? 0,
    'events' => dbFetchOne('SELECT COUNT(*) as count FROM events WHERE start_date >= NOW()')['count'] ?? 0,
    'users' => dbFetchOne('SELECT COUNT(*) as count FROM users')['count'] ?? 0,
];

// Derniers produits ajoutés
$latestProducts = dbFetchAll('SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC LIMIT 5');

// Prochains événements
$upcomingEvents = dbFetchAll('SELECT * FROM events WHERE status = "published" AND start_date >= NOW() ORDER BY start_date ASC LIMIT 5');

$pageTitle = 'Dashboard';
include __DIR__ . '/includes/header.php';
?>

<div class="dashboard-grid">
    <!-- Stats Cards -->
    <div class="stats-row">
        <div class="stat-card stat-blue">
            <div class="stat-icon">🛍️</div>
            <div class="stat-info">
                <span class="stat-value"><?= $stats['products_available'] ?></span>
                <span class="stat-label">Produits disponibles</span>
            </div>
        </div>

        <div class="stat-card stat-green">
            <div class="stat-icon">📰</div>
            <div class="stat-info">
                <span class="stat-value"><?= $stats['news'] ?></span>
                <span class="stat-label">Actualités</span>
            </div>
        </div>

        <div class="stat-card stat-orange">
            <div class="stat-icon">📅</div>
            <div class="stat-info">
                <span class="stat-value"><?= $stats['events'] ?></span>
                <span class="stat-label">Événements à venir</span>
            </div>
        </div>

        <?php if (auth_is_admin()): ?>
        <div class="stat-card stat-purple">
            <div class="stat-icon">👥</div>
            <div class="stat-info">
                <span class="stat-value"><?= $stats['users'] ?></span>
                <span class="stat-label">Utilisateurs</span>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Quick Actions -->
    <div class="admin-card">
        <h2>Actions rapides</h2>
        <div class="quick-actions">
            <a href="<?= admin_url('products/create') ?>" class="quick-action">
                <span class="qa-icon">➕</span>
                <span>Nouveau produit</span>
            </a>
            <a href="<?= admin_url('news/create') ?>" class="quick-action">
                <span class="qa-icon">📝</span>
                <span>Nouvelle actualité</span>
            </a>
            <a href="<?= admin_url('events/create') ?>" class="quick-action">
                <span class="qa-icon">📅</span>
                <span>Nouvel événement</span>
            </a>
        </div>
    </div>

    <!-- Derniers produits -->
    <div class="admin-card">
        <div class="card-header">
            <h2>Derniers produits ajoutés</h2>
            <a href="<?= admin_url('products') ?>" class="btn-link">Voir tout →</a>
        </div>
        <?php if (empty($latestProducts)): ?>
            <p class="empty-state">Aucun produit pour le moment.</p>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($latestProducts as $product): ?>
                    <tr>
                        <td><?= e($product['name']) ?></td>
                        <td><?= e($product['category_name'] ?? '-') ?></td>
                        <td><?= number_format($product['price'], 2, ',', ' ') ?> €</td>
                        <td>
                            <span class="badge badge-<?= $product['status'] === 'available' ? 'success' : ($product['status'] === 'sold' ? 'danger' : 'warning') ?>">
                                <?= $product['status'] === 'available' ? 'Disponible' : ($product['status'] === 'sold' ? 'Vendu' : 'Réservé') ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Prochains événements -->
    <div class="admin-card">
        <div class="card-header">
            <h2>Prochains événements</h2>
            <a href="<?= admin_url('events') ?>" class="btn-link">Voir tout →</a>
        </div>
        <?php if (empty($upcomingEvents)): ?>
            <p class="empty-state">Aucun événement à venir.</p>
        <?php else: ?>
            <ul class="event-list">
                <?php foreach ($upcomingEvents as $event): ?>
                <li class="event-item">
                    <div class="event-date">
                        <span class="event-day"><?= date('d', strtotime($event['start_date'])) ?></span>
                        <span class="event-month"><?= $moisAbrev[(int)date('n', strtotime($event['start_date']))] ?></span>
                    </div>
                    <div class="event-info">
                        <strong><?= e($event['title']) ?></strong>
                        <?php if ($event['location']): ?>
                            <span class="event-location">📍 <?= e($event['location']) ?></span>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
