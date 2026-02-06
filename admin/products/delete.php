<?php
/**
 * Suppression produit - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

$user = auth_user();

// Récupérer le produit
$id = (int)($_GET['id'] ?? 0);
$product = dbFetchOne('SELECT * FROM products WHERE id = ?', [$id]);

if (!$product) {
    header('Location: ' . admin_url('products') . '?error=Produit introuvable');
    exit;
}

// Vérifier les droits (admin ou auteur)
if (!auth_is_admin() && $product['author_id'] != $user['id']) {
    header('Location: ' . admin_url('products') . '?error=Accès non autorisé');
    exit;
}

// Supprimer l'image si présente
if ($product['image']) {
    deleteImage($product['image'], 'products');
}

// Supprimer le produit
dbExecute('DELETE FROM products WHERE id = ?', [$id]);

header('Location: ' . admin_url('products') . '?success=Produit supprimé');
exit;
