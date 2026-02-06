USE `1000mains`;

-- ============================================
-- DONNÉES DE TEST - ACTUALITÉS
-- 1000 Mains et Merveilles
-- ============================================

-- Supprimer les actualités existantes (optionnel)
-- DELETE FROM news;

-- Actualités publiées
INSERT INTO news (title, slug, content, excerpt, status, author_id, published_at, created_at) VALUES

-- Actualité 1 - À la une
('Inauguration de notre nouvel espace atelier',
'inauguration-nouvel-espace-atelier',
'Nous sommes ravis de vous annoncer l''ouverture de notre nouvel espace dédié aux ateliers créatifs !

Après plusieurs mois de travaux et d''aménagement, notre ressourcerie dispose désormais d''un espace de 50m² entièrement équipé pour accueillir nos ateliers de couture, bricolage et loisirs créatifs.

Cet espace lumineux et convivial peut accueillir jusqu''à 12 personnes simultanément. Il est équipé de :
- 6 machines à coudre
- Un établi de bricolage complet
- Des rangements pour le matériel créatif
- Un coin détente pour les pauses

Venez découvrir ce nouvel espace lors de nos prochains ateliers ! L''inscription est gratuite pour les adhérents.

Nous remercions chaleureusement tous les bénévoles qui ont participé à ce projet ainsi que nos partenaires.',
'Découvrez notre nouvel espace de 50m² dédié aux ateliers créatifs, entièrement équipé pour la couture, le bricolage et les loisirs créatifs.',
'published', 1, NOW() - INTERVAL 2 DAY, NOW() - INTERVAL 2 DAY),

-- Actualité 2
('Bilan de notre collecte de printemps : un succès !',
'bilan-collecte-printemps-succes',
'La collecte de printemps organisée le mois dernier a été un véritable succès grâce à votre générosité !

En chiffres, c''est :
- Plus de 500 kg d''objets collectés
- 150 donateurs
- 80% des objets déjà revalorisés ou en cours de réparation

Parmi les pépites récupérées : des meubles vintage des années 60, une collection de vinyles en excellent état, et même un vélo ancien qui a été entièrement restauré par notre équipe.

Ces objets ont maintenant une seconde vie et seront bientôt disponibles dans notre boutique solidaire.

Un grand merci à tous les bénévoles qui ont participé à cette journée, ainsi qu''aux habitants du quartier pour leur générosité !

Prochaine collecte prévue en septembre. Restez connectés !',
'Plus de 500 kg d''objets collectés lors de notre collecte de printemps. Merci à tous les donateurs et bénévoles !',
'published', 1, NOW() - INTERVAL 5 DAY, NOW() - INTERVAL 5 DAY),

-- Actualité 3
('Nouveau partenariat avec la Mairie',
'nouveau-partenariat-mairie',
'Nous avons le plaisir de vous annoncer la signature d''une convention de partenariat avec la Mairie !

Ce partenariat va nous permettre de :
- Développer nos actions de sensibilisation dans les écoles
- Organiser des événements dans l''espace public
- Bénéficier d''un soutien logistique pour nos collectes
- Renforcer notre visibilité auprès des habitants

La première action concrète de ce partenariat sera l''organisation d''une journée "Zéro Déchet" en centre-ville le mois prochain.

Nous remercions Madame le Maire et toute l''équipe municipale pour leur confiance et leur engagement en faveur de l''économie circulaire.',
'Une convention de partenariat signée avec la Mairie pour développer nos actions de sensibilisation.',
'published', 1, NOW() - INTERVAL 10 DAY, NOW() - INTERVAL 10 DAY),

-- Actualité 4
('Retour en images sur l''atelier customisation textile',
'retour-images-atelier-customisation-textile',
'L''atelier customisation textile du 15 janvier a réuni 10 participants enthousiastes !

Au programme de cette après-midi créative :
- Techniques de teinture naturelle
- Broderie et patchwork
- Transformation de vieux t-shirts en sacs

Chacun est reparti avec sa création unique et de nouvelles compétences pour donner une seconde vie à ses vêtements.

Le prochain atelier textile aura lieu le mois prochain. Les inscriptions sont ouvertes, n''hésitez pas à nous contacter !

Merci à Marie, notre animatrice bénévole, pour son expertise et sa bonne humeur.',
'10 participants à notre atelier customisation textile. Teinture, broderie et transformation au programme !',
'published', 1, NOW() - INTERVAL 15 DAY, NOW() - INTERVAL 15 DAY),

-- Actualité 5
('Recherche bénévoles pour le tri et la valorisation',
'recherche-benevoles-tri-valorisation',
'Notre équipe s''agrandit et nous recherchons de nouveaux bénévoles !

Nous avons besoin de renfort pour :
- Le tri des dons (vêtements, objets, livres)
- La petite réparation et le nettoyage
- L''étiquetage et la mise en rayon
- L''accueil des clients et donateurs

Pas besoin de compétences particulières, juste de la motivation et quelques heures par semaine à nous consacrer.

Les avantages :
- Une ambiance conviviale et bienveillante
- La satisfaction de donner du sens à son temps
- Des formations aux techniques de réparation
- Des réductions sur nos produits

Intéressé(e) ? Contactez-nous ou passez directement à la ressourcerie pour en discuter !',
'Rejoignez notre équipe de bénévoles ! Tri, réparation, accueil... Toutes les bonnes volontés sont les bienvenues.',
'published', 1, NOW() - INTERVAL 20 DAY, NOW() - INTERVAL 20 DAY),

-- Actualité 6
('Les pépites de la semaine : meubles vintage',
'pepites-semaine-meubles-vintage',
'Cette semaine, notre boutique vous réserve de belles surprises côté mobilier !

Arrivages récents :
- Buffet en chêne années 50, parfait état
- Paire de chaises Thonet, assises refaites
- Table de ferme en pin, plateau massif
- Commode art déco avec miroir

Tous ces meubles ont été nettoyés, réparés si nécessaire, et sont prêts à rejoindre votre intérieur.

Prix solidaires garantis : de 15€ à 80€ selon les pièces.

Premier arrivé, premier servi ! Nos horaires : du mardi au samedi, 10h-18h.',
'Buffet années 50, chaises Thonet, table de ferme... De belles pièces vintage à prix solidaires.',
'published', 1, NOW() - INTERVAL 25 DAY, NOW() - INTERVAL 25 DAY),

-- Actualité 7 (plus ancienne)
('Bonne année 2026 !',
'bonne-annee-2026',
'Toute l''équipe de 1000 Mains et Merveilles vous souhaite une excellente année 2026 !

Que cette nouvelle année soit riche en :
- Belles trouvailles
- Créations réussies
- Rencontres enrichissantes
- Gestes éco-responsables

Merci à tous nos adhérents, bénévoles, donateurs et clients pour votre soutien tout au long de l''année 2025.

Ensemble, continuons à donner une seconde vie aux objets !

La ressourcerie rouvre ses portes le 3 janvier. À très bientôt !',
'Toute l''équipe vous souhaite une belle année 2026, riche en trouvailles et en créations !',
'published', 1, '2026-01-01 10:00:00', '2026-01-01 10:00:00');

-- Vérification
SELECT COUNT(*) as total_actualites FROM news WHERE status = 'published';
SELECT id, title, status, published_at FROM news ORDER BY published_at DESC;
