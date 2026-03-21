<?php
/**
 * Admin - Supprimer une etape de la frise
 * 1000 Mains et Merveilles
 */

auth_require();

$id = (int)($_GET['id'] ?? 0);
$entry = dbFetchOne('SELECT * FROM timeline_entries WHERE id = ?', [$id]);

if (!$entry) {
    header('Location: ' . admin_url('timeline') . '?error=Etape introuvable');
    exit;
}

dbExecute('DELETE FROM timeline_entries WHERE id = ?', [$id]);

header('Location: ' . admin_url('timeline') . '?success=Etape supprimee');
exit;
