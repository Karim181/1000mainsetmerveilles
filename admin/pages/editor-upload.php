<?php
/**
 * Upload image AJAX pour GrapesJS - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['data' => []]);
    exit;
}

// Verifier CSRF
$token = $_POST['csrf_token'] ?? '';
if (!$token || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
    http_response_code(403);
    echo json_encode(['error' => 'Token CSRF invalide']);
    exit;
}

if (empty($_FILES['image'])) {
    echo json_encode(['data' => []]);
    exit;
}

$result = uploadImage($_FILES['image'], 'pages');

if ($result['success']) {
    // GrapesJS attend le format { data: ['url'] }
    echo json_encode([
        'data' => [upload_url('pages/' . $result['filename'])]
    ]);
} else {
    http_response_code(400);
    echo json_encode(['error' => $result['error']]);
}
