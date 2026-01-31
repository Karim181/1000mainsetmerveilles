<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page introuvable - 1000 Mains et Merveilles</title>
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/404.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <?php include ROOT_PATH . '/components/navbar.php'; ?>

    <section class="page-404">
        <div class="container">
            <div class="page-404-content">
                <span class="error-emoji">🔍</span>
                <h1>Page introuvable</h1>
                <p>La page que vous cherchez n'existe pas ou a ete deplacee.</p>
                <a href="<?= url() ?>" class="btn-primary-final">Retour a l'accueil</a>
            </div>
        </div>
    </section>

    <footer class="footer-final">
        <div class="container">
            <div class="footer-bottom-final">
                <p>&copy; 2026 1000 Mains et Merveilles &bull; Association loi 1901 💙</p>
            </div>
        </div>
    </footer>

</body>
</html>
