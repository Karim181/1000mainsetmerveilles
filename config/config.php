<?php
/**
 * Configuration Phase 1 - Maquette
 * 1000 Mains et Merveilles
 */

// Environnement (development / production)
define('ENVIRONMENT', 'development');

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
// Phase 2 : À activer lors du backend
// =====================================
/*
// Configuration BDD
define('DB_HOST', 'localhost');
define('DB_NAME', '1000mains');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Configuration emails
define('CONTACT_EMAIL', 'contact@1000mainsetmerveilles.fr');
define('ADMIN_EMAIL', 'admin@1000mainsetmerveilles.fr');

// Sécurité
define('CSRF_TOKEN_NAME', 'csrf_token');
*/