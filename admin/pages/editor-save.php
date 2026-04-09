<?php
/**
 * Sauvegarde AJAX editeur visuel - Admin
 * 1000 Mains et Merveilles
 *
 * Recoit les champs modifies et met a jour page_contents.
 */

auth_require();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Methode non autorisee']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'error' => 'Donnees invalides']);
    exit;
}

// Verifier CSRF
$token = $input['csrf_token'] ?? '';
if (!$token || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
    echo json_encode(['success' => false, 'error' => 'Token CSRF invalide']);
    exit;
}

$pageSlug = $input['page_slug'] ?? '';
$fields = $input['fields'] ?? [];

$allowedPages = ['home', 'qui-sommes-nous', 'la-ressourcerie', 'dons', 'venir-chiner', 'nous-rejoindre'];
if (!in_array($pageSlug, $allowedPages)) {
    echo json_encode(['success' => false, 'error' => 'Page non autorisee']);
    exit;
}

if (empty($fields) || !is_array($fields)) {
    echo json_encode(['success' => false, 'error' => 'Aucun champ a sauvegarder']);
    exit;
}

$user = auth_user();
$updated = 0;

try {
    foreach ($fields as $field) {
        $id = (int)($field['id'] ?? 0);
        $value = $field['value'] ?? '';

        if ($id <= 0) continue;

        // Verifier que le champ appartient bien a cette page
        $existing = dbFetchOne(
            'SELECT id, content_type FROM page_contents WHERE id = ? AND page_slug = ?',
            [$id, $pageSlug]
        );

        if (!$existing) continue;

        // Ne pas modifier les champs image par ce endpoint
        if ($existing['content_type'] === 'image') continue;

        dbExecute(
            'UPDATE page_contents SET content_text = ?, updated_by = ?, updated_at = NOW() WHERE id = ?',
            [$value, $user['id'], $id]
        );
        $updated++;
    }

    echo json_encode(['success' => true, 'updated' => $updated]);
} catch (\Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Erreur base de donnees : ' . $e->getMessage()]);
}
