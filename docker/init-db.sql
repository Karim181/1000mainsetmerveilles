-- =============================================
-- 1000 Mains et Merveilles - Init Docker
-- Schema + Seed (tout-en-un)
-- =============================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

USE `1000mains`;

-- =============================================
-- Table: users
-- =============================================
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `role` ENUM('admin', 'editor') NOT NULL DEFAULT 'editor',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `last_login` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: sessions
-- =============================================
CREATE TABLE IF NOT EXISTS `sessions` (
    `id` VARCHAR(64) NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `expires_at` DATETIME NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_sessions_user` (`user_id`),
    KEY `idx_sessions_expires` (`expires_at`),
    CONSTRAINT `fk_sessions_user` FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: categories
-- =============================================
CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL,
    `icon` VARCHAR(10) NULL COMMENT 'Emoji',
    `image` VARCHAR(255) NULL COMMENT 'Photo de la categorie',
    `sort_order` INT NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_categories_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: products
-- =============================================
CREATE TABLE IF NOT EXISTS `products` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `description` TEXT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `category_id` INT UNSIGNED NOT NULL,
    `image` VARCHAR(255) NULL,
    `status` ENUM('available', 'sold', 'reserved') NOT NULL DEFAULT 'available',
    `is_featured` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Pepite de la semaine',
    `author_id` INT UNSIGNED NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    `sold_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_products_slug` (`slug`),
    KEY `idx_products_category` (`category_id`),
    KEY `idx_products_status` (`status`),
    KEY `idx_products_featured` (`is_featured`),
    KEY `idx_products_author` (`author_id`),
    CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`)
        REFERENCES `categories` (`id`),
    CONSTRAINT `fk_products_author` FOREIGN KEY (`author_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: news (actualites)
-- =============================================
CREATE TABLE IF NOT EXISTS `news` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    `excerpt` VARCHAR(500) NULL COMMENT 'Resume pour liste',
    `image` VARCHAR(255) NULL,
    `status` ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
    `author_id` INT UNSIGNED NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    `published_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_news_slug` (`slug`),
    KEY `idx_news_status` (`status`),
    KEY `idx_news_published` (`published_at`),
    KEY `idx_news_author` (`author_id`),
    CONSTRAINT `fk_news_author` FOREIGN KEY (`author_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: events (agenda)
-- =============================================
CREATE TABLE IF NOT EXISTS `events` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `location` VARCHAR(255) NULL,
    `start_date` DATETIME NOT NULL,
    `end_date` DATETIME NULL,
    `image` VARCHAR(255) NULL,
    `status` ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
    `author_id` INT UNSIGNED NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_events_slug` (`slug`),
    KEY `idx_events_status` (`status`),
    KEY `idx_events_start` (`start_date`),
    KEY `idx_events_author` (`author_id`),
    CONSTRAINT `fk_events_author` FOREIGN KEY (`author_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: page_contents
-- =============================================
CREATE TABLE IF NOT EXISTS `page_contents` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `page_slug` VARCHAR(100) NOT NULL,
    `section_key` VARCHAR(100) NOT NULL,
    `content_type` ENUM('text', 'textarea', 'image') NOT NULL DEFAULT 'text',
    `content_text` TEXT NULL,
    `content_image` VARCHAR(255) NULL,
    `label` VARCHAR(255) NOT NULL,
    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    `updated_by` INT UNSIGNED NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_page_section` (`page_slug`, `section_key`),
    CONSTRAINT `fk_page_contents_user` FOREIGN KEY (`updated_by`)
        REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================
-- Table: timeline_entries (frise chronologique)
-- =============================================
CREATE TABLE IF NOT EXISTS `timeline_entries` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `year` VARCHAR(10) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_timeline_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- =============================================
-- Donnees initiales
-- =============================================

-- Admin par defaut (admin@1000mains.fr / Admin123!)
-- Editeur par defaut (editeur@1000mains.fr / Editeur123!)
INSERT INTO `users` (`email`, `password`, `name`, `role`) VALUES
('admin@1000mains.fr', '$2y$10$q8oe7qns7WPLdsb9wxjLIO6dtlV2pXeuM.yK/lkUjizUDx9xT6rIy', 'Administrateur', 'admin'),
('editeur@1000mains.fr', '$2y$10$jPgO5KFNIRNOsVmVmTy8cO97w0PZWACLHglHdutGtyfurp7jFTtKS', 'Editeur', 'editor');

-- Categories produits
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

-- Contenus editables des pages
INSERT INTO `page_contents` (`page_slug`, `section_key`, `content_type`, `content_text`, `label`) VALUES
('home', 'hero-label', 'text', 'Reemploi solidaire dans les Yvelines', 'Accueil - Hero label'),
('home', 'hero-title', 'text', 'Donnez une <span class="highlight-turquoise">seconde vie</span> aux objets', 'Accueil - Hero titre'),
('home', 'hero-description', 'textarea', 'Boutique a prix doux, depot de dons, ateliers creatifs : rejoignez une aventure humaine et ecologique pres de chez vous.', 'Accueil - Hero description'),
('home', 'hero-image', 'image', NULL, 'Accueil - Hero photo'),
('qui-sommes-nous', 'hero-label', 'text', 'Notre histoire', 'QSN - Hero label'),
('qui-sommes-nous', 'hero-title', 'text', 'Qui sommes-nous <span class="highlight-turquoise">?</span>', 'QSN - Hero titre'),
('qui-sommes-nous', 'hero-description', 'textarea', 'Une association engagee depuis plus de 12 ans pour le reemploi, la solidarite et le lien social sur le territoire des Yvelines.', 'QSN - Hero description'),
('qui-sommes-nous', 'hero-image', 'image', NULL, 'QSN - Hero photo'),
('la-ressourcerie', 'hero-label', 'text', 'Boutique solidaire', 'Ressourcerie - Hero label'),
('la-ressourcerie', 'hero-title', 'text', 'La Ressourcerie <span class="highlight-turquoise">en Yvelines</span>', 'Ressourcerie - Hero titre'),
('la-ressourcerie', 'hero-description', 'textarea', 'Achetez malin, donnez utile. Notre ressourcerie donne une seconde vie aux objets du quotidien a prix solidaire, a Plaisir (78).', 'Ressourcerie - Hero description'),
('la-ressourcerie', 'hero-image', 'image', NULL, 'Ressourcerie - Hero photo'),
('dons', 'hero-label', 'text', 'Donner utile', 'Dons - Hero label'),
('dons', 'hero-title', 'text', 'Faire un <span class="highlight-turquoise">don</span>', 'Dons - Hero titre'),
('dons', 'hero-description', 'textarea', 'Donnez une seconde vie a vos objets ou soutenez notre action par un don financier. Chaque geste compte pour la solidarite et l''environnement.', 'Dons - Hero description'),
('dons', 'hero-image', 'image', NULL, 'Dons - Hero photo'),
('home', 'page-title', 'text', '1000 Mains et Merveilles - Association de reemploi solidaire', 'Accueil - Titre de la page (balise title)'),
('home', 'page-meta', 'textarea', 'Association de reemploi solidaire dans les Yvelines. Boutique a prix doux, ateliers creatifs et depot de dons a Plaisir et Chavenay.', 'Accueil - Meta description (SEO)'),
('home', 'actions-title', 'text', 'Trois piliers pour une <span class="highlight-turquoise">action solidaire</span>', 'Accueil - Titre section actions'),
('qui-sommes-nous', 'page-title', 'text', 'Qui sommes-nous - 1000 Mains et Merveilles', 'QSN - Titre de la page (balise title)'),
('qui-sommes-nous', 'page-meta', 'textarea', 'Decouvrez l''histoire et les valeurs de 1000 Mains et Merveilles, association de reemploi solidaire dans les Yvelines.', 'QSN - Meta description (SEO)'),
('qui-sommes-nous', 'mission-title', 'text', 'Donner une <span class="highlight-turquoise">seconde vie</span> aux objets', 'QSN - Titre mission'),
('qui-sommes-nous', 'mission-text', 'textarea', '1000 Mains et Merveilles est une association loi 1901 qui oeuvre pour le reemploi et la reduction des dechets.', 'QSN - Texte mission'),
('qui-sommes-nous', 'mission-image', 'image', NULL, 'QSN - Photo section mission'),
('la-ressourcerie', 'page-title', 'text', 'La Ressourcerie - 1000 Mains et Merveilles', 'Ressourcerie - Titre de la page (balise title)'),
('la-ressourcerie', 'page-meta', 'textarea', 'Achetez malin, donnez utile. Notre ressourcerie donne une seconde vie aux objets du quotidien a prix solidaire, a Plaisir (78).', 'Ressourcerie - Meta description (SEO)'),
('la-ressourcerie', 'pedagogie-text', 'textarea', 'Une ressourcerie est un lieu dedie au reemploi : elle collecte les objets dont vous n''avez plus besoin, les valorise et les remet en vente a prix solidaire.', 'Ressourcerie - Texte pedagogique'),
('dons', 'page-title', 'text', 'Faire un don - 1000 Mains et Merveilles', 'Dons - Titre de la page (balise title)'),
('dons', 'page-meta', 'textarea', 'Donnez une seconde vie a vos objets ou soutenez notre action. Depot de dons a Chavenay et Plaisir dans les Yvelines.', 'Dons - Meta description (SEO)'),
('venir-chiner', 'page-title', 'text', 'Venir chiner - 1000 Mains et Merveilles', 'Chiner - Titre de la page (balise title)'),
('venir-chiner', 'page-meta', 'textarea', 'Decouvrez nos trouvailles a prix solidaires dans notre boutique de Plaisir (78). Meubles, deco, vetements et plus.', 'Chiner - Meta description (SEO)'),
('nous-rejoindre', 'page-title', 'text', 'Nous rejoindre - 1000 Mains et Merveilles', 'Rejoindre - Titre de la page (balise title)'),
('nous-rejoindre', 'page-meta', 'textarea', 'Rejoignez l''aventure 1000 Mains et Merveilles. Devenez benevole ou partenaire de notre association de reemploi solidaire.', 'Rejoindre - Meta description (SEO)'),
('venir-chiner', 'hero-label', 'text', 'Nos trouvailles', 'Chiner - Hero label'),
('venir-chiner', 'hero-title', 'text', 'Venir <span class="highlight-turquoise">chiner</span>', 'Chiner - Hero titre'),
('venir-chiner', 'hero-description', 'textarea', 'Des objets uniques, des prix solidaires. Decouvrez nos pepites du moment et les derniers arrivages dans notre ressourcerie.', 'Chiner - Hero description'),
('venir-chiner', 'hero-image', 'image', NULL, 'Chiner - Hero photo'),
('nous-rejoindre', 'hero-label', 'text', 'Rejoignez-nous', 'Rejoindre - Hero label'),
('nous-rejoindre', 'hero-title', 'text', 'Ensemble, <span class="highlight-turquoise">agissons</span>', 'Rejoindre - Hero titre'),
('nous-rejoindre', 'hero-description', 'textarea', 'Devenez benevole, proposez un atelier ou contactez-nous pour toute question. Chaque main compte !', 'Rejoindre - Hero description'),
('nous-rejoindre', 'hero-image', 'image', NULL, 'Rejoindre - Hero photo'),
('home', 'nav-label', 'text', 'Accueil', 'Accueil - Libelle dans la navbar'),
('qui-sommes-nous', 'nav-label', 'text', 'Qui sommes-nous ?', 'QSN - Libelle dans la navbar'),
('la-ressourcerie', 'nav-label', 'text', 'La Ressourcerie', 'Ressourcerie - Libelle dans la navbar'),
('venir-chiner', 'nav-label', 'text', 'Venir chiner', 'Chiner - Libelle dans la navbar'),
('dons', 'nav-label', 'text', 'Faire un don', 'Dons - Libelle dans la navbar'),
('nous-rejoindre', 'nav-label', 'text', 'Nous rejoindre', 'Rejoindre - Libelle dans la navbar'),
-- Pastilles (tags de section)
('home', 'tag-actions', 'text', 'Ce que nous faisons 🌱', 'Accueil - Pastille section actions'),
('home', 'tag-pepites', 'text', 'A ne pas manquer 💎', 'Accueil - Pastille section pepites'),
('home', 'pepites-title', 'text', 'Les pepites <span class="highlight-turquoise">de la semaine</span>', 'Accueil - Titre section pepites'),
('home', 'pepites-subtitle', 'text', 'Nos coups de coeur du moment, disponibles en boutique', 'Accueil - Sous-titre section pepites'),
('home', 'tag-categories', 'text', 'Nos rayons 🏷️', 'Accueil - Pastille section categories'),
('home', 'categories-title', 'text', 'Explorez nos <span class="highlight-turquoise">categories</span>', 'Accueil - Titre section categories'),
('home', 'categories-subtitle', 'text', 'Tout un univers d''objets a decouvrir a prix solidaires', 'Accueil - Sous-titre section categories'),
('qui-sommes-nous', 'tag-mission', 'text', 'Notre mission 🌱', 'QSN - Pastille section mission'),
('qui-sommes-nous', 'tag-pepites', 'text', 'A ne pas manquer 💎', 'QSN - Pastille section pepites'),
('qui-sommes-nous', 'tag-categories', 'text', 'Nos rayons 🏷️', 'QSN - Pastille section categories'),
('qui-sommes-nous', 'tag-valeurs', 'text', 'Nos valeurs ❤️', 'QSN - Pastille section valeurs'),
('qui-sommes-nous', 'tag-equipe', 'text', 'Notre equipe 👥', 'QSN - Pastille section equipe'),
('qui-sommes-nous', 'tag-histoire', 'text', 'Notre parcours 📅', 'QSN - Pastille section histoire'),
('la-ressourcerie', 'tag-concept', 'text', 'Le concept 🌱', 'Ressourcerie - Pastille section concept'),
('la-ressourcerie', 'tag-boutique', 'text', 'Notre boutique 🛍️', 'Ressourcerie - Pastille section boutique'),
('dons', 'tag-objets', 'text', 'Don d''objets 🎁', 'Dons - Pastille section don objets'),
('dons', 'tag-financier', 'text', 'Don financier 💛', 'Dons - Pastille section don financier'),
('venir-chiner', 'tag-pepites', 'text', 'Coups de coeur 💎', 'Chiner - Pastille section pepites'),
('venir-chiner', 'tag-arrivages', 'text', 'Fraichement arrives 📦', 'Chiner - Pastille section arrivages'),
('venir-chiner', 'tag-rayons', 'text', 'Nos rayons 🏷️', 'Chiner - Pastille section rayons'),
('venir-chiner', 'tag-vendus', 'text', 'Deja parties ! 🎉', 'Chiner - Pastille section vendus'),
('venir-chiner', 'tag-lieu', 'text', 'Nous trouver 📍', 'Chiner - Pastille section lieu'),
('nous-rejoindre', 'tag-benevolat', 'text', 'Benevolat', 'Rejoindre - Pastille section benevolat'),
('nous-rejoindre', 'tag-contact', 'text', 'Contact', 'Rejoindre - Pastille section contact');

-- Frise chronologique
INSERT INTO `timeline_entries` (`year`, `title`, `description`, `sort_order`) VALUES
('2012', 'Creation de l''association', 'Naissance de 1000 Mains et Merveilles avec une poignee de benevoles passionnes par le reemploi et la solidarite dans les Yvelines.', 1),
('2014', 'Premiers ateliers', 'Lancement des ateliers creatifs : couture, reparation, customisation. Le lien social se tisse autour du faire-ensemble.', 2),
('2016', 'Installation a Saint-Germain-en-Laye', 'Ouverture de notre premier local a Saint-Germain-en-Laye. La ressourcerie prend forme et accueille ses premiers donateurs et clients.', 3),
('2019', 'Boutique de Plaisir', 'Notre ressourcerie ouvre ses portes a Plaisir. Un lieu plus grand pour accueillir plus de merveilles et de benevoles.', 4),
('2022', 'Depot a Chavenay', 'Ouverture d''un point de depot a Chavenay pour faciliter les dons sur le territoire et augmenter notre capacite de collecte.', 5),
('2024', 'Vers un retour a Saint-Germain', 'Nous sommes dans une demarche active de retour a Saint-Germain-en-Laye ou a proximite, pour retrouver notre ancrage historique.', 6);
