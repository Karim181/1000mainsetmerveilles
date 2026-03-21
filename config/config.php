<?php
/**
 * Configuration Phase 1 - Maquette
 * 1000 Mains et Merveilles
 */

// Environnement (development / staging / production)
define('ENVIRONMENT', getenv('APP_ENV') ?: 'development');

// Affichage erreurs selon environnement
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Chemins (ROOT_PATH et BASE_URL sont dans helpers.php)
define('ASSETS_PATH', ROOT_PATH . '/assets');
define('VIEWS_PATH', ROOT_PATH . '/views');
define('COMPONENTS_PATH', ROOT_PATH . '/components');

// Logs (optionnel)
define('ENABLE_TRAFFIC_LOG', true);
define('LOG_PATH', ROOT_PATH . '/logs');

// =====================================
// Configuration BDD
// =====================================
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: '1000mains');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_CHARSET', 'utf8mb4');

// =====================================
// Configuration emails
// =====================================
define('CONTACT_EMAIL', 'contact@1000mainsetmerveilles.fr');
define('ADMIN_EMAIL', 'admin@1000mainsetmerveilles.fr');

// =====================================
// Sécurité
// =====================================
define('CSRF_TOKEN_NAME', 'csrf_token');

// URL secrète pour accéder à l'admin (sans slashes)
// Changez cette valeur pour sécuriser l'accès
define('ADMIN_SLUG', 'gestion');

// =====================================
// Uploads
// =====================================
define('UPLOAD_PATH', ROOT_PATH . '/uploads');
define('UPLOAD_MAX_SIZE', 2 * 1024 * 1024); // 2 Mo