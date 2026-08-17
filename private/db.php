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
$db_port = $_ENV['DB_PORT'] ?? '3306';
$db_name = $_ENV['DB_NAME'] ?? 'mcf8_db';
$db_user = $_ENV['DB_USER'] ?? 'mcf8_user';
$db_pass = $_ENV['DB_PASS'] ?? '';

try {
    // Setup secure UTF-8 data source name
    $dsn = "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset=utf8mb4";
    
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on SQL issues
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch rows as associative arrays
        PDO::ATTR_EMULATE_PREPARES   => false,                  // True prepared statements for SQLi prevention
    ];
    
    $db = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    // Catch database errors to log but allow page layout logic to function
    $db_error = $e->getMessage();
}
