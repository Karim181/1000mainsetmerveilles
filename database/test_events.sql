USE `1000mains`;

-- ============================================
-- DONNÉES DE TEST - ÉVÉNEMENTS
-- 1000 Mains et Merveilles
-- ============================================

-- Supprimer les événements existants (optionnel)
-- DELETE FROM events;

-- Événements à venir (publiés)
INSERT INTO events (title, slug, description, location, start_date, end_date, status, author_id, created_at) VALUES

-- Événement 1 - Cette semaine
('Atelier couture : réparer ses vêtements',
'atelier-couture-reparer-vetements',
'Apprenez à réparer vos vêtements abîmés plutôt que de les jeter !

Au programme :
- Recoudre un bouton
- Réparer un accroc
- Faire un ourlet simple
- Poser une pièce décorative

Matériel fourni. Apportez un vêtement à réparer !

Atelier animé par Marie, couturière bénévole.
Inscription recommandée (places limitées à 8 personnes).',
'Ressourcerie - Espace Ateliers',
DATE_ADD(NOW(), INTERVAL 3 DAY) + INTERVAL 14 HOUR,
DATE_ADD(NOW(), INTERVAL 3 DAY) + INTERVAL 17 HOUR,
'published', 1, NOW()),

-- Événement 2 - Semaine prochaine
('Atelier relooking de meubles',
'atelier-relooking-meubles',
'Donnez une seconde vie à vos meubles anciens !

Techniques abordées :
- Préparation des surfaces (ponçage, sous-couche)
- Peinture à la craie
- Patine et effets vieillis
- Finitions et protection

Apportez un petit meuble (tabouret, chaise, petit tiroir) pour pratiquer.

Animé par Jean-Pierre, ébéniste amateur passionné.',
'Ressourcerie - Atelier Bricolage',
DATE_ADD(NOW(), INTERVAL 8 DAY) + INTERVAL 10 HOUR,
DATE_ADD(NOW(), INTERVAL 8 DAY) + INTERVAL 13 HOUR,
'published', 1, NOW()),

-- Événement 3 - Dans 2 semaines
('Repair Café - Électroménager',
'repair-cafe-electromenager',
'Notre Repair Café mensuel revient !

Venez avec vos appareils en panne :
- Petit électroménager (grille-pain, mixeur, aspirateur...)
- Lampes et luminaires
- Petits appareils électroniques

Nos réparateurs bénévoles vous aideront à diagnostiquer et réparer vos appareils.

Gratuit et ouvert à tous. Pas de réservation nécessaire.',
'Ressourcerie - Hall principal',
DATE_ADD(NOW(), INTERVAL 12 DAY) + INTERVAL 14 HOUR,
DATE_ADD(NOW(), INTERVAL 12 DAY) + INTERVAL 18 HOUR,
'published', 1, NOW()),

-- Événement 4 - Dans 3 semaines
('Atelier création bijoux récup',
'atelier-creation-bijoux-recup',
'Créez des bijoux uniques à partir de matériaux récupérés !

Ce que vous apprendrez :
- Transformer des chutes de tissu en boucles d''oreilles
- Créer des pendentifs avec des capsules
- Assembler des bracelets avec des perles dépareillées

Tout le matériel est fourni. Repartez avec vos créations !

Atelier convivial animé par Sophie.',
'Ressourcerie - Espace Ateliers',
DATE_ADD(NOW(), INTERVAL 18 DAY) + INTERVAL 14 HOUR + INTERVAL 30 MINUTE,
DATE_ADD(NOW(), INTERVAL 18 DAY) + INTERVAL 16 HOUR + INTERVAL 30 MINUTE,
'published', 1, NOW()),

-- Événement 5 - Dans 1 mois
('Grande braderie de printemps',
'grande-braderie-printemps',
'Notre grande braderie annuelle !

Promotions exceptionnelles sur tout le magasin :
- -30% sur les meubles
- -20% sur les vêtements
- -50% sur les livres

Animations tout au long de la journée :
- Atelier customisation gratuit (14h-16h)
- Tombola (1€ le ticket)
- Buvette et petite restauration

Venez nombreux !',
'Ressourcerie + Parvis extérieur',
DATE_ADD(NOW(), INTERVAL 25 DAY) + INTERVAL 9 HOUR,
DATE_ADD(NOW(), INTERVAL 25 DAY) + INTERVAL 18 HOUR,
'published', 1, NOW()),

-- Événement 6 - Dans 5 semaines
('Atelier upcycling : transformer ses t-shirts',
'atelier-upcycling-tshirts',
'Vos vieux t-shirts méritent mieux que la poubelle !

Transformations proposées :
- T-shirt en sac de courses
- T-shirt en coussin
- T-shirt en headband/bandeau
- Customisation avec teinture et pochoirs

Apportez 2-3 t-shirts que vous ne portez plus.

Atelier familial - enfants acceptés à partir de 10 ans accompagnés.',
'Ressourcerie - Espace Ateliers',
DATE_ADD(NOW(), INTERVAL 32 DAY) + INTERVAL 14 HOUR,
DATE_ADD(NOW(), INTERVAL 32 DAY) + INTERVAL 17 HOUR,
'published', 1, NOW()),

-- Événement 7 - Dans 6 semaines
('Portes ouvertes de la Ressourcerie',
'portes-ouvertes-ressourcerie',
'Découvrez les coulisses de notre ressourcerie !

Programme de la journée :
- 10h : Visite guidée de l''atelier de tri
- 11h : Démonstration de réparation
- 14h : Présentation de l''association
- 15h : Témoignages de bénévoles
- 16h : Goûter convivial

Entrée libre. Venez découvrir notre fonctionnement et peut-être rejoindre l''aventure !',
'Ressourcerie',
DATE_ADD(NOW(), INTERVAL 40 DAY) + INTERVAL 10 HOUR,
DATE_ADD(NOW(), INTERVAL 40 DAY) + INTERVAL 18 HOUR,
'published', 1, NOW()),

-- Événement 8 - Passé récent (pour test)
('Atelier fabrication de produits ménagers',
'atelier-produits-menagers',
'Fabriquez vos propres produits ménagers écologiques !

Recettes réalisées :
- Lessive maison
- Nettoyant multi-usage
- Liquide vaisselle

Ingrédients simples et naturels. Repartez avec vos flacons !',
'Ressourcerie - Espace Ateliers',
DATE_SUB(NOW(), INTERVAL 5 DAY) + INTERVAL 14 HOUR,
DATE_SUB(NOW(), INTERVAL 5 DAY) + INTERVAL 16 HOUR,
'published', 1, DATE_SUB(NOW(), INTERVAL 15 DAY));

-- Vérification
SELECT COUNT(*) as total_events FROM events WHERE status = 'published';
SELECT id, title, start_date,
       CASE WHEN start_date > NOW() THEN 'À venir' ELSE 'Passé' END as statut
FROM events
ORDER BY start_date DESC;
