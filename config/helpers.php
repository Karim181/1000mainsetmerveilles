<?php
declare(strict_types=1);

/**
 * Helpers de base
 * 1000 Mains et Merveilles
 * 
 * - ROOT_PATH : chemin système du projet
 * - BASE_URL  : chemin URL du projet
 * - url()     : routes propres (/services)
 * - asset()   : fichiers statiques dans /assets
 */

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(__DIR__ . '/..'));
}

if (!defined('BASE_URL')) {
    $script = $_SERVER['SCRIPT_NAME'] ?? '/';
    $base   = rtrim(dirname($script), '/');
    define('BASE_URL', $base === '' ? '/' : $base . '/');
}

/**
 * Génère une URL de route propre.
 *
 * En prod avec mod_rewrite : /services, /contact, /
 * En fallback : /index.php?page=services
 *
 * @param string $route Nom de la route (ex: 'services', 'contact')
 * @param array $query Paramètres query string optionnels
 * @return string URL complète
 *
 * Exemples :
 * url('home')     → /
 * url('services') → /services
 * url('contact', ['from' => 'hero']) → /contact?from=hero
 */
function url(string $route = 'home', array $query = []): string
{
    // Mode pretty URL (avec mod_rewrite)
    $pretty = true;

    // Nettoyage du nom de route
    $route = trim($route, '/');

    // Cas page d'accueil
    if ($route === '' || $route === 'home') {
        $path = '';
    } else {
        $path = $route;
    }

    if ($pretty) {
        // URLs du type /services ou /services?foo=bar
        $base = rtrim(BASE_URL, '/');
        $queryString = http_build_query($query);

        // / pour home, /services pour le reste
        $url = $base . '/' . $path;

        return $url . ($queryString ? '?' . $queryString : '');
    }

    // Fallback : /index.php?page=services
    $query = ['page' => $route ?: 'home'] + $query;
    return BASE_URL . 'index.php?' . http_build_query($query);
}

/**
 * Génère une URL vers un asset (CSS, JS, image, font).
 *
 * @param string $path Chemin relatif dans /assets/
 * @return string URL complète
 *
 * Exemples :
 * asset('css/style.css') → /1000mains/assets/css/style.css
 * asset('images/logo.png') → /1000mains/assets/images/logo.png
 */
function asset(string $path): string
{
    return BASE_URL . 'assets/' . ltrim($path, '/');
}

/**
 * Génère l'URL d'action pour un formulaire.
 *
 * @param string $path Chemin de l'action
 * @return string URL complète
 *
 * Exemples :
 * form_action('api/contact') → /1000mains/api/contact
 */
function form_action(string $path): string
{
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

/**
 * Échapper HTML (protection XSS).
 *
 * @param string $string Chaîne à échapper
 * @return string Chaîne sécurisée
 *
 * Exemples :
 * e('<script>alert("XSS")</script>') → &lt;script&gt;alert("XSS")&lt;/script&gt;
 */
function e(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Vérifier si on est sur une page donnée (utile pour navbar active).
 *
 * @param string $page Nom de la page
 * @return bool True si on est sur cette page
 *
 * Exemples :
 * is_page('home') → true si sur la page d'accueil
 * is_page('agenda') → true si sur la page agenda
 */
function is_page(string $page): bool
{
    return ($_GET['page'] ?? 'home') === $page;
}

/**
 * Inclure un component (navbar, footer, card...).
 *
 * @param string $name Nom du component (sans .php)
 * @param array $data Données à passer au component
 * @return void
 *
 * Exemples :
 * component('navbar')
 * component('card', ['title' => 'Mon titre', 'image' => 'photo.jpg'])
 */
function component(string $name, array $data = []): void
{
    extract($data);
    $componentPath = COMPONENTS_PATH . '/' . $name . '.php';
    
    if (file_exists($componentPath)) {
        require $componentPath;
    } else {
        if (ENVIRONMENT === 'development') {
            echo "<!-- Component not found: $name -->";
        }
    }
}

/**
 * Dump and die - Affiche des variables et arrête l'exécution (debug).
 *
 * @param mixed ...$vars Variables à afficher
 * @return void
 *
 * Exemples :
 * dd($user); → Affiche $user et arrête
 * dd($user, $posts, $_SERVER); → Affiche plusieurs variables
 */
function dd(...$vars): void
{
    if (ENVIRONMENT === 'development') {
        echo '<pre style="background: #1e1e1e; color: #dcdcdc; padding: 20px; margin: 20px; border-radius: 8px; font-family: monospace;">';
        foreach ($vars as $var) {
            var_dump($var);
            echo "\n---\n\n";
        }
        echo '</pre>';
        die();
    } else {
        // En production, ne rien afficher
        die();
    }
}