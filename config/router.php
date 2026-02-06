<?php
/**
 * Système de routing dynamique
 * 1000 Mains et Merveilles
 */

/**
 * Router principal
 */
function route(): void
{
    $page = $_GET['page'] ?? 'home';

    // Nettoyer le nom de page (sécurité : a-z, 0-9, tirets et slashes)
    $page = preg_replace('/[^a-z0-9\-\/]/', '', strtolower($page));
    $page = trim($page, '/');

    // Bloquer l'accès direct à /admin/
    if ($page === 'admin' || strpos($page, 'admin/') === 0) {
        http_response_code(404);
        require ROOT_PATH . '/views/404.php';
        return;
    }

    // Router admin (URL sécurisée)
    if ($page === ADMIN_SLUG || strpos($page, ADMIN_SLUG . '/') === 0) {
        route_admin($page);
        return;
    }

    // Router public
    route_public($page);
}

/**
 * Router pour le backoffice admin
 */
function route_admin(string $page): void
{
    // Charger les dépendances admin
    require_once ROOT_PATH . '/config/database.php';
    require_once ROOT_PATH . '/config/auth.php';

    // Extraire le chemin admin (après le slug)
    $adminPath = $page === ADMIN_SLUG ? '' : substr($page, strlen(ADMIN_SLUG) + 1);
    $parts = $adminPath ? explode('/', $adminPath) : [];

    // Déterminer le controller et l'action
    $section = $parts[0] ?? 'dashboard';
    $action = $parts[1] ?? 'index';

    // Nettoyer
    $section = preg_replace('/[^a-z0-9\-]/', '', $section);
    $action = preg_replace('/[^a-z0-9\-]/', '', $action);

    // Mapper les routes admin
    $adminRoutes = [
        'dashboard' => ['index' => '/admin/index.php'],
        'login' => ['index' => '/admin/login.php'],
        'logout' => ['index' => '/admin/logout.php'],
        'products' => [
            'index' => '/admin/products/index.php',
            'create' => '/admin/products/create.php',
            'edit' => '/admin/products/edit.php',
            'delete' => '/admin/products/delete.php',
            'preview' => '/admin/products/preview.php',
        ],
        'categories' => [
            'index' => '/admin/categories/index.php',
        ],
        'news' => [
            'index' => '/admin/news/index.php',
            'create' => '/admin/news/create.php',
            'edit' => '/admin/news/edit.php',
            'delete' => '/admin/news/delete.php',
            'preview' => '/admin/news/preview.php',
        ],
        'events' => [
            'index' => '/admin/events/index.php',
            'create' => '/admin/events/create.php',
            'edit' => '/admin/events/edit.php',
            'delete' => '/admin/events/delete.php',
            'preview' => '/admin/events/preview.php',
        ],
        'users' => [
            'index' => '/admin/users/index.php',
            'create' => '/admin/users/create.php',
            'edit' => '/admin/users/edit.php',
            'delete' => '/admin/users/delete.php',
        ],
        'maintenance' => [
            'index' => '/admin/maintenance/index.php',
        ],
    ];

    // Cas spécial : /gestion/ → dashboard
    if ($section === '' || $section === 'dashboard') {
        $section = 'dashboard';
        $action = 'index';
    }

    // Login et logout n'ont pas besoin d'auth
    $publicAdminPages = ['login', 'logout'];

    // Vérifier si la route existe
    if (!isset($adminRoutes[$section][$action])) {
        http_response_code(404);
        require ROOT_PATH . '/views/404.php';
        return;
    }

    $filePath = ROOT_PATH . $adminRoutes[$section][$action];

    if (!file_exists($filePath)) {
        http_response_code(404);
        require ROOT_PATH . '/views/404.php';
        return;
    }

    // Charger le fichier admin
    require $filePath;
}

/**
 * Router pour les pages publiques
 */
function route_public(string $page): void
{
    // Pages publiques nécessitant la base de données
    $pagesWithDb = ['venir-chiner', 'agenda', 'actualites', 'actualite', 'produit'];
    if (in_array($page, $pagesWithDb)) {
        require_once ROOT_PATH . '/config/database.php';
    }

    // Redirections 301 (ancien site WordPress)
    $redirects = [
        'qui-sommes-nous' => 'home',
        'ressourcerie-saint-germain' => 'la-ressourcerie',
        'ressourcerie-plaisir' => 'la-ressourcerie',
        'nos-ateliers-collectifs' => 'agenda',
        'contact' => 'nous-rejoindre',
        'newsletter' => 'nous-rejoindre',
    ];

    // Pages en attente de création → redirection temporaire vers home
    $pending = ['mentions-legales', 'confidentialite'];
    if (in_array($page, $pending) && !file_exists(ROOT_PATH . '/views/' . $page . '.php')) {
        header('Location: ' . url('home'), true, 302);
        exit;
    }

    if (isset($redirects[$page])) {
        header('Location: ' . url($redirects[$page]), true, 301);
        exit;
    }

    // Cas page d'accueil
    if ($page === '' || $page === 'home') {
        $page = 'home';
    }

    // Construire le chemin de la vue
    $viewPath = ROOT_PATH . '/views/' . $page . '.php';

    // Si la vue existe, la charger
    if (file_exists($viewPath)) {
        require $viewPath;
    } else {
        // Sinon 404
        http_response_code(404);
        require ROOT_PATH . '/views/404.php';
    }
}
