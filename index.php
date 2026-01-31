<?php
/**
 * Point d'entrée unique du site
 * 1000 Mains et Merveilles
 */

// 1. Charger helpers EN PREMIER (définit ROOT_PATH et BASE_URL)
require_once __DIR__ . '/config/helpers.php';

// 2. Charger configuration
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/traffic.php';

// 3. Déterminer la page demandée et logger l'accès
$page = traffic_resolve_page();
traffic_log($page);

// 4. Mettre la page dans $_GET pour le router
$_GET['page'] = $page;

// 5. Routing
require_once __DIR__ . '/config/router.php';
route();