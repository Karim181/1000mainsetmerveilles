<?php
/**
 * Suppression événement - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

$user = auth_user();

$id = (int)($_GET['id'] ?? 0);
$event = dbFetchOne('SELECT * FROM events WHERE id = ?', [$id]);

if (!$event) {
    header('Location: ' . admin_url('events') . '?error=Événement introuvable');
    exit;
}

// Vérifier les droits (admin ou auteur)
if (!auth_is_admin() && $event['author_id'] != $user['id']) {
    header('Location: ' . admin_url('events') . '?error=Accès non autorisé');
    exit;
}

// Supprimer l'image si elle existe
if ($event['image']) {
    deleteImage($event['image'], 'events');
}

// Supprimer l'événement
dbExecute('DELETE FROM events WHERE id = ?', [$id]);

header('Location: ' . admin_url('events') . '?success=Événement supprimé');
exit;
