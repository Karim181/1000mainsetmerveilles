<?php
/**
 * Upload image AJAX pour editeur visuel - Admin
 * 1000 Mains et Merveilles
 *
 * Recoit une image + content_id, upload le fichier
 * et met a jour content_image dans page_contents.
 */

auth_require();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Methode non autorisee']);
    exit;
}

// Verifier CSRF
$token = $_POST['csrf_token'] ?? '';
if (!$token || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Token CSRF invalide']);
    exit;
}

if (empty($_FILES['image'])) {
    echo json_encode(['success' => false, 'error' => 'Aucune image envoyee']);
    exit;
}

$contentId = (int)($_POST['content_id'] ?? 0);
$pageSlug = $_POST['page_slug'] ?? '';

$allowedPages = ['home', 'qui-sommes-nous', 'la-ressourcerie', 'dons', 'venir-chiner', 'nous-rejoindre'];
if (!in_array($pageSlug, $allowedPages)) {
    echo json_encode(['success' => false, 'error' => 'Page non autorisee']);
    exit;
}

// Verifier que le champ existe et est de type image
$existing = dbFetchOne(
    'SELECT id, content_image FROM page_contents WHERE id = ? AND page_slug = ? AND content_type = ?',
    [$contentId, $pageSlug, 'image']
);

if (!$existing) {
    echo json_encode(['success' => false, 'error' => 'Champ image introuvable']);
    exit;
}

// Upload
$result = uploadImage($_FILES['image'], 'pages');

if (!$result['success']) {
    echo json_encode(['success' => false, 'error' => $result['error']]);
    exit;
}

// Supprimer l'ancienne image si elle existe
if (!empty($existing['content_image'])) {
    deleteImage($existing['content_image'], 'pages');
}

// Mettre a jour en base
$user = auth_user();
dbExecute(
    'UPDATE page_contents SET content_image = ?, updated_by = ?, updated_at = NOW() WHERE id = ?',
    [$result['filename'], $user['id'], $contentId]
);

echo json_encode([
    'success' => true,
    'filename' => $result['filename'],
    'url' => upload_url('pages/' . $result['filename']),
]);
