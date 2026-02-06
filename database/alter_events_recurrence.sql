USE `1000mains`;

-- ============================================
-- AJOUT CHAMPS RÉCURRENCE - TABLE EVENTS
-- 1000 Mains et Merveilles
-- ============================================

-- Ajouter les champs pour la récurrence
ALTER TABLE events
ADD COLUMN is_recurring TINYINT(1) DEFAULT 0 AFTER status,
ADD COLUMN recurrence_info VARCHAR(255) NULL AFTER is_recurring;

-- Exemples de valeurs pour recurrence_info :
-- "Tous les mercredis"
-- "Chaque 1er samedi du mois"
-- "Un jeudi sur deux"
-- "Tous les jours de 10h à 12h"

-- Vérification
DESCRIBE events;
