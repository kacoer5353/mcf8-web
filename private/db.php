<?php
/**
 * MCF8 Secure Database Connection Handler
 * Uses only INTERNAL_DATABASE_URL (Render internal) for PostgreSQL connections.
 * Keep this outside the public directory.
 *
 * @package MCF8-Web
 */

require_once __DIR__ . '/config.php';

$db = null;
$db_error = null;

// INTERNAL_DATABASE_URL is required. Example:
// postgres://user:password@host:5432/dbname?sslmode=require
$internal_db_url = getenv('INTERNAL_DATABASE_URL') ?: '';

if (empty($internal_db_url)) {
    $db_error = 'INTERNAL_DATABASE_URL not set';
} else {
    $parts = parse_url($internal_db_url);
    if ($parts === false || !isset($parts['host'])) {
        $db_error = 'INTERNAL_DATABASE_URL is malformed';
    } else {
        $db_host = $parts['host'];
        $db_port = $parts['port'] ?? '5432';
        $db_name = isset($parts['path']) ? ltrim($parts['path'], '/') : '';
        $db_user = $parts['user'] ?? '';
        $db_pass = $parts['pass'] ?? '';
        $db_sslmode = '';
        if (!empty($parts['query'])) {
            parse_str($parts['query'], $q);
            $db_sslmode = $q['sslmode'] ?? '';
        }

        try {
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
    }
}
