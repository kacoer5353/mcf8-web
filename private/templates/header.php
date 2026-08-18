<?php
/**
 * MCF8 Header Template
 * Renders the top navigation bar, links, copy IP triggers, and handles flash message rendering.
 * Keep this outside the public directory.
 *
 * @package MCF8-Web
 */

require_once __DIR__ . '/../config.php';

// Retrieve session flash notifications
$flash_success = $_SESSION['flash_success'] ?? null;
$flash_error = $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash_success'], $_SESSION['flash_error']);

// Guarantee CSRF token presence for all session views
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Oficjalna strona serwera Minecraft mcf8. Dołącz do nas już dzisiaj! Jeden tryb: OP Factions + SV bez ułatwień pay-to-win.">
    <title><?php if (!empty($full_title)) { echo htmlspecialchars($full_title); } else { echo htmlspecialchars($config['server_name']) . ' | ' . htmlspecialchars($page_title ?? '1 tryb: OP Factions + SV'); } ?></title>
    
    <!-- Include styles from public path -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Dynamic Header & Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">
                <?php if (!empty($config['use_logo_img']) && file_exists(__DIR__ . '/../../public/' . $config['logo_img'])): ?>
                    <img src="<?= htmlspecialchars($config['logo_img']) ?>" alt="MCF8 Logo" class="logo-image">
                <?php else: ?>
                    <?= $config['logo_html'] ?>
                <?php endif; ?>
            </a>
            
            <ul class="nav-menu">
                <li><a href="index.php" class="nav-link <?= ($active_page === 'home') ? 'active' : '' ?>">Start</a></li>
                <li><a href="o-nas.php" class="nav-link <?= ($active_page === 'about') ? 'active' : '' ?>">O nas</a></li>
                <li><a href="ranking.php" class="nav-link <?= ($active_page === 'ranking') ? 'active' : '' ?>">Ranking</a></li>
                <li><a href="ostatnie-smierci.php" class="nav-link <?= ($active_page === 'deaths') ? 'active' : '' ?>">Zgony</a></li>
                <li><a href="media.php" class="nav-link <?= ($active_page === 'media') ? 'active' : '' ?>">Sociale</a></li>
                <li><a href="contact.php" class="nav-link <?= ($active_page === 'contact') ? 'active' : '' ?>">Kontakt</a></li>
            </ul>

            <div class="nav-actions">
                <!-- IP Copy Button -->
                <div class="ip-copier" data-ip="<?= htmlspecialchars($config['mc_ip']) ?>">
                    <span class="ip-text"><?= htmlspecialchars($config['mc_ip']) ?></span>
                    <span class="ip-badge">Skopiuj</span>
                </div>
                <!-- Discord Quick Join -->
                <a href="<?= htmlspecialchars($config['discord_url']) ?>" target="_blank" class="btn btn-discord">
                    <svg width="16" height="16" viewBox="0 0 127.14 96.36" fill="currentColor">
                        <path d="M107.7,8.07A105.15,105.15,0,0,0,77.26,0a77.19,77.19,0,0,0-3.3,6.83A96.67,96.67,0,0,0,53.22,6.83,77.19,77.19,0,0,0,49.88,0,105.15,105.15,0,0,0,19.44,8.07C3.66,31.58-1.95,54.65,1,77.53a107.4,107.4,0,0,0,32,16.29,82.84,82.84,0,0,0,6.83-11.11,68.8,68.8,0,0,1-10.75-5.13c.91-.66,1.8-1.34,2.65-2a76.77,76.77,0,0,0,71.07,0c.85.69,1.74,1.37,2.65,2a68.42,68.42,0,0,1-10.75,5.14,83,83,0,0,0,6.83,11.11,107.28,107.28,0,0,0,32-16.29C129.66,48.42,123.39,25.66,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53S36.18,40.36,42.45,40.36,53.83,46,53.83,53,48.72,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.24,60,73.24,53S78.41,40.36,84.69,40.36,96.07,46,96.07,53,91,65.69,84.69,65.69Z"/>
                    </svg>
                    Discord
                </a>
            </div>
        </div>
    </nav>

    <!-- Flash message alerts dynamically displayed on load -->
    <?php if ($flash_success): ?>
        <div class="flash-container" style="margin-top: 100px;">
            <div class="flash-message flash-success">
                <span class="icon">✓</span>
                <span><?= htmlspecialchars($flash_success) ?></span>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($flash_error): ?>
        <div class="flash-container" style="margin-top: 100px;">
            <div class="flash-message flash-error">
                <span class="icon">✗</span>
                <span><?= htmlspecialchars($flash_error) ?></span>
            </div>
        </div>
    <?php endif; ?>
