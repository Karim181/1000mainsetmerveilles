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
function db(): ?PDO
{
    static $pdo = null;
    static $failed = false;

    if ($failed) {
        return null;
    }

    if ($pdo === null) {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            DB_HOST,
            DB_PORT,
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
            $failed = true;
            error_log('Database connection failed: ' . $e->getMessage());
            return null;
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
    $pdo = db();
    if ($pdo === null) return [];
    $stmt = $pdo->prepare($sql);
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
    $pdo = db();
    if ($pdo === null) return null;
    $stmt = $pdo->prepare($sql);
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
    $pdo = db();
    if ($pdo === null) return 0;
    $stmt = $pdo->prepare($sql);
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
    $pdo = db();
    if ($pdo === null) return '0';
    return $pdo->lastInsertId();
}
