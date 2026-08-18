<?php
/**
 * MCF8 Private Config Loader
 * Loads environment parameters and sets application configuration properties.
 * Keep this outside the public directory.
 *
 * @package MCF8-Web
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Loads custom env parser to import configuration.
 *
 * @param string $path Filepath to the .env file.
 */
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);

        // Ignore empty lines and comment lines
        if (empty($line) || strpos($line, '#') === 0) {
            continue;
        }

        // Split on the first equals sign
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $val = trim($parts[1]);

            // Strip enclosing quotes if present
            if (preg_match('/^"(.*)"$/', $val, $matches) || preg_match('/^\'(.*)\'$/', $val, $matches)) {
                $val = $matches[1];
            }

            $_ENV[$key] = $val;
            putenv("$key=$val");
        }
    }
}

// Load env from the root workspace folder (parent of /private)
loadEnv(__DIR__ . '/../.env');

// Core configuration variables
$config = [
    'server_name' => 'mcf8',
    'tagline'     => '1 tryb: OP Factions + SV',
    'logo_html'   => '<span class="logo-aqua">mcf8</span><span class="logo-white"></span>',
    
    // Graphical logo options
    'use_logo_img' => true,
    'logo_img'     => 'assets/img/logo.svg', // Path relative to public/
    
    'mc_ip'       => $_ENV['MC_SERVER_IP'] ?? 'play.mcf8.pl',
    'mc_port'     => (int)($_ENV['MC_SERVER_PORT'] ?? 25565),
    
    'discord_url' => $_ENV['DISCORD_URL'] ?? 'https://discord.gg/mcf8',
    'github_url'  => $_ENV['GITHUB_URL'] ?? 'https://github.com/kacper/mcf8-web',
    
    'api' => [
        'status_url' => 'https://api.mcsrvstat.us/2/',
    ]
];
