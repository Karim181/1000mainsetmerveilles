<?php
/**
 * Seed des utilisateurs admin au démarrage Docker
 * Génère les hashes bcrypt dans le même process PHP qui les vérifiera
 */

$maxRetries = 30;
$pdo = null;

// Attendre que MySQL soit prêt
for ($i = 0; $i < $maxRetries; $i++) {
    try {
        $pdo = new PDO(
            'mysql:host=' . (getenv('DB_HOST') ?: 'db') . ';dbname=' . (getenv('DB_NAME') ?: '1000mains'),
            getenv('DB_USER') ?: '1000mains',
            getenv('DB_PASS') ?: '1000mains_staging',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        break;
    } catch (PDOException $e) {
        echo "En attente de MySQL... ($i/$maxRetries)\n";
        sleep(2);
    }
}

if (!$pdo) {
    echo "ERREUR : impossible de se connecter a MySQL apres $maxRetries tentatives.\n";
    exit(1);
}

// Utilisateurs à créer/mettre à jour
$users = [
    [
        'email' => 'admin@1000mains.fr',
        'password' => 'Admin123!',
        'name' => 'Administrateur',
        'role' => 'admin',
    ],
    [
        'email' => 'editeur@1000mains.fr',
        'password' => 'Editeur123!',
        'name' => 'Editeur',
        'role' => 'editor',
    ],
];

foreach ($users as $u) {
    // Vérifier si l'utilisateur existe déjà
    $stmt = $pdo->prepare('SELECT id, password FROM users WHERE email = ?');
    $stmt->execute([$u['email']]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    $hash = password_hash($u['password'], PASSWORD_BCRYPT);

    if ($existing) {
        // Vérifier si le hash actuel fonctionne
        if (password_verify($u['password'], $existing['password'])) {
            echo "[OK] {$u['email']} : hash existant valide, aucun changement.\n";
            continue;
        }
        // Mettre à jour le hash
        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE email = ?');
        $stmt->execute([$hash, $u['email']]);
        echo "[FIX] {$u['email']} : hash corrige.\n";
    } else {
        // Créer l'utilisateur
        $stmt = $pdo->prepare('INSERT INTO users (email, password, name, role, created_at) VALUES (?, ?, ?, ?, NOW())');
        $stmt->execute([$u['email'], $hash, $u['name'], $u['role']]);
        echo "[NEW] {$u['email']} : utilisateur cree.\n";
    }

    // Vérification finale
    $stmt = $pdo->prepare('SELECT password FROM users WHERE email = ?');
    $stmt->execute([$u['email']]);
    $check = $stmt->fetch(PDO::FETCH_ASSOC);
    $ok = password_verify($u['password'], $check['password']) ? 'OK' : 'FAIL';
    echo "     Verification password_verify : {$ok}\n";
}

echo "\nSeed utilisateurs termine.\n";
