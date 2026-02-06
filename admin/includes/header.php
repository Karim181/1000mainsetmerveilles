<?php
/**
 * Header Admin
 * 1000 Mains et Merveilles
 */

$user = auth_user();

// Détecter la section active depuis l'URL
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$adminSlug = ADMIN_SLUG;

// Parser l'URL pour trouver la section
$currentSection = 'dashboard';
if (preg_match("#/$adminSlug/([a-z\-]+)#", $requestUri, $matches)) {
    $currentSection = $matches[1];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Admin') ?> - 1000 Mains et Merveilles</title>
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-logo">
                <img src="<?= asset('images/1000-mains-et-merveilles-2.png') ?>" alt="Logo">
            </div>

            <nav class="sidebar-nav">
                <a href="<?= admin_url() ?>" class="nav-item <?= $currentSection === 'dashboard' ? 'active' : '' ?>">
                    <span class="nav-icon">📊</span>
                    <span>Dashboard</span>
                </a>

                <div class="nav-section">Contenu</div>

                <a href="<?= admin_url('products') ?>" class="nav-item <?= $currentSection === 'products' ? 'active' : '' ?>">
                    <span class="nav-icon">🛍️</span>
                    <span>Produits</span>
                </a>

                <a href="<?= admin_url('categories') ?>" class="nav-item <?= $currentSection === 'categories' ? 'active' : '' ?>">
                    <span class="nav-icon">📁</span>
                    <span>Catégories</span>
                </a>

                <a href="<?= admin_url('news') ?>" class="nav-item <?= $currentSection === 'news' ? 'active' : '' ?>">
                    <span class="nav-icon">📰</span>
                    <span>Actualités</span>
                </a>

                <a href="<?= admin_url('events') ?>" class="nav-item <?= $currentSection === 'events' ? 'active' : '' ?>">
                    <span class="nav-icon">📅</span>
                    <span>Événements</span>
                </a>

                <?php if (auth_is_admin()): ?>
                <div class="nav-section">Administration</div>

                <a href="<?= admin_url('users') ?>" class="nav-item <?= $currentSection === 'users' ? 'active' : '' ?>">
                    <span class="nav-icon">👥</span>
                    <span>Utilisateurs</span>
                </a>

                <a href="<?= admin_url('maintenance') ?>" class="nav-item <?= $currentSection === 'maintenance' ? 'active' : '' ?>">
                    <span class="nav-icon">🔧</span>
                    <span>Maintenance</span>
                </a>
                <?php endif; ?>
            </nav>

            <div class="sidebar-footer">
                <a href="<?= url() ?>" class="nav-item" target="_blank">
                    <span class="nav-icon">🌐</span>
                    <span>Voir le site</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="admin-main">
            <!-- Top Bar -->
            <header class="admin-topbar">
                <button class="sidebar-toggle" id="sidebarToggle">☰</button>

                <h1 class="page-title"><?= e($pageTitle ?? 'Admin') ?></h1>

                <div class="topbar-user">
                    <span class="user-name"><?= e($user['name']) ?></span>
                    <span class="user-role badge badge-<?= $user['role'] === 'admin' ? 'purple' : 'blue' ?>"><?= $user['role'] === 'admin' ? 'Admin' : 'Éditeur' ?></span>
                    <a href="<?= admin_url('logout') ?>" class="btn-logout" title="Déconnexion">🚪</a>
                </div>
            </header>

            <!-- Content -->
            <main class="admin-content">
