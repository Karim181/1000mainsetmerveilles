<?php
/**
 * Système de routing dynamique
 * 1000 Mains et Merveilles
 */

function route(): void
{
    $page = $_GET['page'] ?? 'home';
    
    // Nettoyer le nom de page (sécurité : que a-z, 0-9 et tirets)
    $page = preg_replace('/[^a-z0-9\-]/', '', strtolower($page));
    
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
    $pending = ['la-ressourcerie', 'dons', 'agenda', 'nous-rejoindre', 'mentions-legales', 'confidentialite'];
    if (in_array($page, $pending) && !file_exists(ROOT_PATH . '/views/' . $page . '.php')) {
        header('Location: ' . url('home'), true, 302);
        exit;
    }
    
    if (isset($redirects[$page])) {
        header('Location: ' . url($redirects[$page]), true, 301);
        exit;
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