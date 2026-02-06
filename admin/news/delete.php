<?php
/**
 * Suppression actualité - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

$user = auth_user();

$id = (int)($_GET['id'] ?? 0);
$article = dbFetchOne('SELECT * FROM news WHERE id = ?', [$id]);

if (!$article) {
    header('Location: ' . admin_url('news') . '?error=Actualité introuvable');
    exit;
}

// Vérifier les droits (admin ou auteur)
if (!auth_is_admin() && $article['author_id'] != $user['id']) {
    header('Location: ' . admin_url('news') . '?error=Accès non autorisé');
    exit;
}

// Supprimer l'image si elle existe
if ($article['image']) {
    deleteImage($article['image'], 'news');
}

// Supprimer l'actualité
dbExecute('DELETE FROM news WHERE id = ?', [$id]);

header('Location: ' . admin_url('news') . '?success=Actualité supprimée');
exit;
