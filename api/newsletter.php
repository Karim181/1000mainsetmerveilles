<?php
/**
 * API Newsletter - Inscription
 * 1000 Mains et Merveilles
 */

define('ROOT_PATH', realpath(__DIR__ . '/..'));
require ROOT_PATH . '/config/helpers.php';
require ROOT_PATH . '/config/config.php';
require ROOT_PATH . '/config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Methode non autorisee']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$firstName = trim($input['first_name'] ?? '');
$lastName = trim($input['last_name'] ?? '');
$email = trim($input['email'] ?? '');

// Validation
$errors = [];
if ($firstName === '') $errors[] = 'Le prenom est requis.';
if ($lastName === '') $errors[] = 'Le nom est requis.';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Adresse email invalide.';

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

try {
    // Verifier si deja inscrit
    $existing = dbFetchOne('SELECT id, status FROM newsletter_subscribers WHERE email = ?', [$email]);

    if ($existing) {
        if ($existing['status'] === 'unsubscribed') {
            // Re-activer l'inscription
            dbExecute(
                'UPDATE newsletter_subscribers SET first_name = ?, last_name = ?, status = "active", created_at = NOW() WHERE id = ?',
                [$firstName, $lastName, $existing['id']]
            );
            echo json_encode(['success' => true, 'message' => 'Reinscription effectuee !']);
        } else {
            echo json_encode(['success' => true, 'message' => 'Vous etes deja inscrit(e) !']);
        }
    } else {
        dbExecute(
            'INSERT INTO newsletter_subscribers (first_name, last_name, email) VALUES (?, ?, ?)',
            [$firstName, $lastName, $email]
        );
        echo json_encode(['success' => true, 'message' => 'Inscription reussie !']);
    }
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erreur serveur']);
}
