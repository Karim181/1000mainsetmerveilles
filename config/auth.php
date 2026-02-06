<?php
declare(strict_types=1);

/**
 * Système d'authentification
 * 1000 Mains et Merveilles
 */

// Démarrer la session si pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_secure'   => ENVIRONMENT === 'production',
        'cookie_samesite' => 'Lax',
    ]);
}

/**
 * Connecte un utilisateur.
 *
 * @param string $email
 * @param string $password
 * @return array|null User data si succès, null sinon
 */
function auth_login(string $email, string $password): ?array
{
    $user = dbFetchOne(
        'SELECT id, email, password, name, role FROM users WHERE email = ?',
        [$email]
    );

    if (!$user || !password_verify($password, $user['password'])) {
        return null;
    }

    // Mettre à jour last_login
    dbExecute('UPDATE users SET last_login = NOW() WHERE id = ?', [$user['id']]);

    // Créer session en BDD
    $sessionId = bin2hex(random_bytes(32));
    $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

    dbExecute(
        'INSERT INTO sessions (id, user_id, expires_at) VALUES (?, ?, ?)',
        [$sessionId, $user['id'], $expiresAt]
    );

    // Stocker en session PHP
    $_SESSION['session_id'] = $sessionId;
    $_SESSION['user_id'] = $user['id'];

    // Retourner user sans mot de passe
    unset($user['password']);
    return $user;
}

/**
 * Déconnecte l'utilisateur.
 */
function auth_logout(): void
{
    if (isset($_SESSION['session_id'])) {
        // Supprimer session en BDD
        dbExecute('DELETE FROM sessions WHERE id = ?', [$_SESSION['session_id']]);
    }

    // Détruire session PHP
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
    session_destroy();
}

/**
 * Vérifie si l'utilisateur est connecté.
 *
 * @return bool
 */
function auth_check(): bool
{
    if (!isset($_SESSION['session_id'], $_SESSION['user_id'])) {
        return false;
    }

    // Vérifier session en BDD
    $session = dbFetchOne(
        'SELECT id FROM sessions WHERE id = ? AND user_id = ? AND expires_at > NOW()',
        [$_SESSION['session_id'], $_SESSION['user_id']]
    );

    return $session !== null;
}

/**
 * Retourne l'utilisateur connecté ou null.
 *
 * @return array|null
 */
function auth_user(): ?array
{
    if (!auth_check()) {
        return null;
    }

    return dbFetchOne(
        'SELECT id, email, name, role, created_at, last_login FROM users WHERE id = ?',
        [$_SESSION['user_id']]
    );
}

/**
 * Vérifie si l'utilisateur est admin.
 *
 * @return bool
 */
function auth_is_admin(): bool
{
    $user = auth_user();
    return $user !== null && $user['role'] === 'admin';
}

/**
 * Exige une authentification, redirige vers login sinon.
 */
function auth_require(): void
{
    if (!auth_check()) {
        header('Location: ' . admin_url('login'));
        exit;
    }
}

/**
 * Exige le rôle admin, redirige sinon.
 */
function auth_require_admin(): void
{
    auth_require();
    if (!auth_is_admin()) {
        header('Location: ' . admin_url());
        exit;
    }
}

// =============================================
// Protection CSRF
// =============================================

/**
 * Génère ou retourne le token CSRF.
 *
 * @return string
 */
function csrf_token(): string
{
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/**
 * Génère un champ hidden CSRF pour les formulaires.
 *
 * @return string HTML
 */
function csrf_field(): string
{
    return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . csrf_token() . '">';
}

/**
 * Vérifie le token CSRF.
 *
 * @return bool
 */
function csrf_verify(): bool
{
    $token = $_POST[CSRF_TOKEN_NAME] ?? '';
    return hash_equals($_SESSION[CSRF_TOKEN_NAME] ?? '', $token);
}

/**
 * Vérifie CSRF et arrête si invalide.
 */
function csrf_check(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !csrf_verify()) {
        http_response_code(403);
        die('Token CSRF invalide.');
    }
}
