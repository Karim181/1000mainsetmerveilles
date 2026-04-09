<?php
/**
 * Suppression contact newsletter - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: ' . admin_url('newsletter') . '?error=' . urlencode('Contact introuvable.'));
    exit;
}

// Verifier CSRF via query string
$token = $_GET['csrf_token'] ?? '';
if (!$token || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
    header('Location: ' . admin_url('newsletter') . '?error=' . urlencode('Token CSRF invalide.'));
    exit;
}

dbExecute('DELETE FROM newsletter_subscribers WHERE id = ?', [$id]);
header('Location: ' . admin_url('newsletter') . '?success=' . urlencode('Contact supprime.'));
exit;
