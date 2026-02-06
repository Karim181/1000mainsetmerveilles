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
    // Détection automatique du BASE_URL
    // Fonctionne pour : vhost, sous-dossier local, production

    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
    $requestUri = $_SERVER['REQUEST_URI'] ?? '/';

    // Extraire le chemin du script (sans /index.php)
    $scriptDir = rtrim(dirname($scriptName), '/\\');

    // Si le REQUEST_URI ne commence pas par le scriptDir, c'est un vhost
    // Sinon c'est un accès via sous-dossier
    if ($scriptDir === '' || strpos($requestUri, $scriptDir) === 0) {
        $base = $scriptDir;
    } else {
        $base = '';
    }

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
 * Génère une URL vers un fichier uploadé.
 *
 * @param string $path Chemin relatif dans /uploads/
 * @return string URL complète
 *
 * Exemples :
 * upload_url('products/image.jpg') → /uploads/products/image.jpg
 */
function upload_url(string $path): string
{
    return BASE_URL . 'uploads/' . ltrim($path, '/');
}

/**
 * Génère une URL vers l'admin sécurisé.
 *
 * @param string $path Chemin dans l'admin (ex: 'products', 'products/create')
 * @return string URL complète
 *
 * Exemples :
 * admin_url()                  → /gestion/
 * admin_url('products')        → /gestion/products
 * admin_url('products/create') → /gestion/products/create
 */
function admin_url(string $path = ''): string
{
    $base = rtrim(BASE_URL, '/') . '/' . ADMIN_SLUG;
    if ($path === '') {
        return $base . '/';
    }
    return $base . '/' . ltrim($path, '/');
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

/**
 * Génère un slug URL-friendly à partir d'une chaîne.
 *
 * @param string $text Texte à convertir
 * @return string Slug
 *
 * Exemples :
 * slugify('Commode Vintage Années 60') → 'commode-vintage-annees-60'
 */
function slugify(string $text): string
{
    // Translitération des caractères accentués
    $text = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $text);

    // Remplacer les caractères non alphanumériques par des tirets
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);

    // Supprimer les tirets en début et fin
    $text = trim($text, '-');

    return $text;
}

/**
 * Upload une image avec validation.
 *
 * @param array $file Fichier $_FILES['field']
 * @param string $folder Sous-dossier dans uploads/
 * @return array ['success' => bool, 'filename' => string|null, 'error' => string|null]
 */
function uploadImage(array $file, string $folder): array
{
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $maxSize = UPLOAD_MAX_SIZE;

    // Vérifier le type MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, $allowedTypes)) {
        return ['success' => false, 'filename' => null, 'error' => 'Type de fichier non autorisé. Utilisez JPG, PNG ou WebP.'];
    }

    // Vérifier la taille
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'filename' => null, 'error' => 'Fichier trop volumineux. Maximum ' . ($maxSize / 1024 / 1024) . ' Mo.'];
    }

    // Créer le dossier si nécessaire
    $uploadDir = UPLOAD_PATH . '/' . $folder;
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Générer un nom unique
    $extension = match($mimeType) {
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        default => 'jpg'
    };
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $destination = $uploadDir . '/' . $filename;

    // Déplacer le fichier
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return ['success' => true, 'filename' => $filename, 'error' => null];
    }

    return ['success' => false, 'filename' => null, 'error' => 'Erreur lors de l\'upload.'];
}

/**
 * Supprime une image uploadée.
 *
 * @param string $filename Nom du fichier
 * @param string $folder Sous-dossier dans uploads/
 * @return bool
 */
function deleteImage(string $filename, string $folder): bool
{
    $path = UPLOAD_PATH . '/' . $folder . '/' . $filename;
    if (file_exists($path)) {
        return unlink($path);
    }
    return false;
}