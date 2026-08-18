<?php
/**
 * MCF8 Secure Database Connection Handler
 * Establishes standard PDO connection settings with real prepared statements.
 * Keep this outside the public directory.
 *
 * @package MCF8-Web
 */

require_once __DIR__ . '/config.php';

$db = null;
$db_error = null;

$db_host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$db_port = $_ENV['DB_PORT'] ?? '5432';
$db_name = $_ENV['DB_NAME'] ?? 'mcf8_db';
$db_user = $_ENV['DB_USER'] ?? 'mcf8_user';
$db_pass = $_ENV['DB_PASS'] ?? '';
$db_sslmode = $_ENV['DB_SSLMODE'] ?? '';

// Support a single DATABASE_URL (e.g. provided by Render) that may contain all connection parts
$database_url = $_ENV['DATABASE_URL'] ?? '';
if ($database_url) {
    $parts = parse_url($database_url);
    if ($parts !== false) {
        $db_host = $parts['host'] ?? $db_host;
        $db_port = $parts['port'] ?? $db_port;
        $db_name = isset($parts['path']) ? ltrim($parts['path'], '/') : $db_name;
        $db_user = $parts['user'] ?? $db_user;
        $db_pass = $parts['pass'] ?? $db_pass;
        if (!empty($parts['query'])) {
            parse_str($parts['query'], $q);
            if (!empty($q['sslmode'])) {
                $db_sslmode = $q['sslmode'];
            }
        }
    }
}

try {
    // Setup secure PostgreSQL DSN and include sslmode when provided (useful for managed DBs like Render)
    $dsn = "pgsql:host={$db_host};port={$db_port};dbname={$db_name}";
    if (!empty($db_sslmode)) {
        $dsn .= ";sslmode={$db_sslmode}";
    }
    
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $db = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    $db_error = $e->getMessage();
}
