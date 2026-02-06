<?php
declare(strict_types=1);

/**
 * Connexion Base de Données PDO
 * 1000 Mains et Merveilles
 */

/**
 * Retourne l'instance PDO (singleton).
 *
 * @return PDO
 * @throws PDOException Si la connexion échoue
 */
function db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            DB_HOST,
            DB_NAME,
            DB_CHARSET
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            if (ENVIRONMENT === 'development') {
                throw $e;
            }
            // En production, log l'erreur et affiche message générique
            error_log('Database connection failed: ' . $e->getMessage());
            die('Erreur de connexion à la base de données.');
        }
    }

    return $pdo;
}

/**
 * Exécute une requête préparée et retourne tous les résultats.
 *
 * @param string $sql Requête SQL avec placeholders
 * @param array $params Paramètres à binder
 * @return array Résultats
 */
function dbFetchAll(string $sql, array $params = []): array
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Exécute une requête préparée et retourne un seul résultat.
 *
 * @param string $sql Requête SQL avec placeholders
 * @param array $params Paramètres à binder
 * @return array|null Résultat ou null
 */
function dbFetchOne(string $sql, array $params = []): ?array
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result ?: null;
}

/**
 * Exécute une requête (INSERT, UPDATE, DELETE) et retourne le nombre de lignes affectées.
 *
 * @param string $sql Requête SQL avec placeholders
 * @param array $params Paramètres à binder
 * @return int Nombre de lignes affectées
 */
function dbExecute(string $sql, array $params = []): int
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->rowCount();
}

/**
 * Retourne le dernier ID inséré.
 *
 * @return string
 */
function dbLastId(): string
{
    return db()->lastInsertId();
}
