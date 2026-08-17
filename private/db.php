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

try {
    // Setup secure PostgreSQL DSN
    $dsn = "pgsql:host={$db_host};port={$db_port};dbname={$db_name}";
    
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $db = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    $db_error = $e->getMessage();
}
