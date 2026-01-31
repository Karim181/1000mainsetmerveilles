<?php
/**
 * Gestion du trafic et logs d'accès
 * 1000 Mains et Merveilles
 */

/**
 * Résoudre la page demandée depuis l'URL
 */
function traffic_resolve_page() {
    // Récupérer l'URI
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
    // Retirer le chemin de base
    $base_path = parse_url(BASE_URL, PHP_URL_PATH) ?? '';
    if (!empty($base_path) && strpos($uri, $base_path) === 0) {
        $uri = substr($uri, strlen($base_path));
    }
    
    // Nettoyer
    $uri = trim($uri, '/');
    
    // Si vide = page d'accueil
    if (empty($uri)) {
        return 'home';
    }
    
    // Sinon retourner l'URI nettoyée
    return $uri;
}

/**
 * Logger un accès page
 */
function traffic_log($page) {
    // Si désactivé dans config
    if (!ENABLE_TRAFFIC_LOG) {
        return;
    }
    
    // Créer dossier logs si nécessaire
    if (!is_dir(LOG_PATH)) {
        mkdir(LOG_PATH, 0755, true);
    }
    
    // Données à logger
    $data = [
        'date' => date('Y-m-d H:i:s'),
        'page' => $page,
        'ip' => traffic_get_ip(),
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
        'referer' => $_SERVER['HTTP_REFERER'] ?? 'Direct',
        'method' => $_SERVER['REQUEST_METHOD'] ?? 'GET'
    ];
    
    // Format CSV
    $log_line = implode('|', $data) . PHP_EOL;
    
    // Écrire dans fichier
    $log_file = LOG_PATH . '/traffic_' . date('Y-m') . '.log';
    file_put_contents($log_file, $log_line, FILE_APPEND | LOCK_EX);
}

/**
 * Obtenir IP réelle du visiteur
 */
function traffic_get_ip() {
    // Vérifier différentes sources (proxy, cloudflare, etc.)
    $ip_keys = [
        'HTTP_CF_CONNECTING_IP', // Cloudflare
        'HTTP_X_FORWARDED_FOR',  // Proxy
        'HTTP_CLIENT_IP',
        'REMOTE_ADDR'
    ];
    
    foreach ($ip_keys as $key) {
        if (isset($_SERVER[$key])) {
            $ip = $_SERVER[$key];
            
            // Si liste d'IPs (proxy chain), prendre la première
            if (strpos($ip, ',') !== false) {
                $ip = trim(explode(',', $ip)[0]);
            }
            
            // Valider l'IP
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
    
    return 'Unknown';
}

/**
 * Vérifier si IP est bloquée (optionnel, anti-spam)
 */
function traffic_is_blocked($ip = null) {
    if ($ip === null) {
        $ip = traffic_get_ip();
    }
    
    // Liste IPs bloquées (à gérer via BDD en Phase 2)
    $blocked_ips = [
        // '123.456.789.0'
    ];
    
    return in_array($ip, $blocked_ips);
}

/**
 * Bloquer accès si IP blacklistée
 */
function traffic_block_if_blacklisted() {
    if (traffic_is_blocked()) {
        http_response_code(403);
        die('Accès refusé');
    }
}

/**
 * Obtenir statistiques trafic (basique, Phase 1)
 */
function traffic_get_stats($month = null) {
    if ($month === null) {
        $month = date('Y-m');
    }
    
    $log_file = LOG_PATH . '/traffic_' . $month . '.log';
    
    if (!file_exists($log_file)) {
        return [
            'total_visits' => 0,
            'unique_ips' => 0,
            'pages' => []
        ];
    }
    
    $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    $ips = [];
    $pages = [];
    
    foreach ($lines as $line) {
        $parts = explode('|', $line);
        
        if (count($parts) >= 3) {
            $ip = $parts[2];
            $page = $parts[1];
            
            $ips[$ip] = true;
            
            if (!isset($pages[$page])) {
                $pages[$page] = 0;
            }
            $pages[$page]++;
        }
    }
    
    return [
        'total_visits' => count($lines),
        'unique_ips' => count($ips),
        'pages' => $pages
    ];
}