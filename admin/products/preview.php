<?php
/**
 * Prévisualisation produit - Admin
 * 1000 Mains et Merveilles
 */

auth_require();

// Récupérer le produit
$id = (int)($_GET['id'] ?? 0);
$product = dbFetchOne(
    'SELECT p.*, c.name as category_name, c.icon as category_icon
     FROM products p
     LEFT JOIN categories c ON p.category_id = c.id
     WHERE p.id = ?',
    [$id]
);

if (!$product) {
    header('Location: ' . admin_url('products') . '?error=Produit introuvable');
    exit;
}

$pageTitle = 'Prévisualisation : ' . $product['name'];
include ROOT_PATH . '/admin/includes/header.php';
?>

<?php $user = auth_user(); ?>
<div class="preview-actions">
    <a href="<?= admin_url('products/edit?id=' . $product['id']) ?>" class="btn btn-primary">✏️ Modifier</a>
    <a href="<?= admin_url('products') ?>" class="btn btn-secondary">← Retour à la liste</a>
    <?php if (auth_is_admin() || $product['author_id'] == $user['id']): ?>
        <a href="<?= admin_url('products/delete?id=' . $product['id']) ?>" class="btn btn-danger" onclick="return confirm('Supprimer ce produit ?')">🗑️ Supprimer</a>
    <?php endif; ?>

    <?php if ($product['status'] === 'available'): ?>
        <span class="badge badge-success" style="margin-left: auto; font-size: 1rem; padding: 10px 20px;">✅ Ce produit est publié et visible</span>
    <?php else: ?>
        <span class="badge badge-warning" style="margin-left: auto; font-size: 1rem; padding: 10px 20px;">⚠️ Statut : <?= $product['status'] === 'sold' ? 'Vendu' : 'Réservé' ?></span>
    <?php endif; ?>
</div>

<div class="preview-container">
    <div class="preview-label">Aperçu du rendu public</div>

    <div class="preview-content">
        <!-- Simulation du rendu public -->
        <div class="product-preview">
            <div class="product-preview-image">
                <?php if ($product['image']): ?>
                    <img src="<?= upload_url('products/' . $product['image']) ?>" alt="<?= e($product['name']) ?>">
                <?php else: ?>
                    <div class="product-preview-placeholder">
                        <span>📷</span>
                        <p>Pas d'image</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="product-preview-info">
                <span class="product-preview-category"><?= $product['category_icon'] ?> <?= e($product['category_name']) ?></span>

                <h1 class="product-preview-title"><?= e($product['name']) ?></h1>

                <div class="product-preview-price"><?= number_format($product['price'], 2, ',', ' ') ?> €</div>

                <?php if ($product['is_featured']): ?>
                    <div class="product-preview-badge">⭐ Pépite de la semaine</div>
                <?php endif; ?>

                <?php if ($product['description']): ?>
                    <div class="product-preview-description">
                        <h3>Description</h3>
                        <p><?= nl2br(e($product['description'])) ?></p>
                    </div>
                <?php endif; ?>

                <div class="product-preview-status">
                    <?php if ($product['status'] === 'available'): ?>
                        <span class="status-available">✅ Disponible en boutique</span>
                    <?php elseif ($product['status'] === 'reserved'): ?>
                        <span class="status-reserved">🔒 Réservé</span>
                    <?php else: ?>
                        <span class="status-sold">❌ Vendu</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.preview-actions {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    align-items: center;
}

.preview-container {
    background: #f8fafc;
    border: 2px dashed var(--admin-border);
    border-radius: 12px;
    overflow: hidden;
}

.preview-label {
    background: var(--admin-primary);
    color: white;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 0.9rem;
}

.preview-content {
    padding: 30px;
    background: white;
}

/* Simulation du style public */
.product-preview {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    max-width: 900px;
    margin: 0 auto;
    font-family: 'DM Sans', sans-serif;
}

.product-preview-image img {
    width: 100%;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.product-preview-placeholder {
    width: 100%;
    aspect-ratio: 1;
    background: linear-gradient(135deg, #f0f4f8 0%, #e2e8f0 100%);
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
}

.product-preview-placeholder span {
    font-size: 4rem;
    margin-bottom: 10px;
}

.product-preview-category {
    display: inline-block;
    background: #f0f4f8;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    color: #64748b;
    margin-bottom: 15px;
}

.product-preview-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 15px;
    line-height: 1.2;
}

.product-preview-price {
    font-size: 2.5rem;
    font-weight: 700;
    color: #10b981;
    margin-bottom: 20px;
}

.product-preview-badge {
    display: inline-block;
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    font-weight: 600;
    margin-bottom: 20px;
}

.product-preview-description {
    margin-top: 25px;
    padding-top: 25px;
    border-top: 1px solid #e2e8f0;
}

.product-preview-description h3 {
    font-size: 1.1rem;
    color: #64748b;
    margin-bottom: 10px;
}

.product-preview-description p {
    color: #475569;
    line-height: 1.7;
}

.product-preview-status {
    margin-top: 25px;
    padding: 15px 20px;
    background: #f8fafc;
    border-radius: 10px;
    font-weight: 600;
}

.status-available { color: #10b981; }
.status-reserved { color: #f59e0b; }
.status-sold { color: #ef4444; }

@media (max-width: 768px) {
    .product-preview {
        grid-template-columns: 1fr;
    }

    .preview-actions {
        flex-wrap: wrap;
    }
}
</style>

<?php include ROOT_PATH . '/admin/includes/footer.php'; ?>
