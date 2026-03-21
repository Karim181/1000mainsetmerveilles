-- =============================================
-- 1000 Mains et Merveilles - Donnees initiales
-- =============================================

USE `1000mains`;

-- =============================================
-- Admin par defaut
-- Email: admin@1000mains.fr
-- Mot de passe: Admin123!
-- (a changer apres premiere connexion)
-- =============================================
INSERT INTO `users` (`email`, `password`, `name`, `role`) VALUES
('admin@1000mains.fr', '$2y$12$MpAw6CfkhH2w.6/hd7lZWeNz.IsSKcEnCGadQTqhlGXxFAIhK9z0O', 'Administrateur', 'admin');

-- =============================================
-- Categories produits
-- =============================================
INSERT INTO `categories` (`name`, `slug`, `icon`, `sort_order`) VALUES
('Meubles', 'meubles', '🪑', 1),
('Luminaires', 'luminaires', '💡', 2),
('Decoration', 'decoration', '🖼️', 3),
('Vetements', 'vetements', '👗', 4),
('Livres', 'livres', '📚', 5),
('Jeux & Jouets', 'jeux-jouets', '🎮', 6),
('Vaisselle', 'vaisselle', '🍽️', 7),
('Bricolage', 'bricolage', '🔧', 8),
('Loisirs creatifs', 'loisirs-creatifs', '🎨', 9),
('Divers', 'divers', '📦', 10);

-- =============================================
-- Fin des donnees initiales
-- =============================================
