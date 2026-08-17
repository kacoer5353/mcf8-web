<?php
/**
 * MCF8 Footer Template
 * Renders the page footer, links, social SVGs, and mounts the config parameter scripts.
 * Keep this outside the public directory.
 *
 * @package MCF8-Web
 */

require_once __DIR__ . '/../config.php';
?>
    <!-- Footer Section -->
    <footer class="footer">
        <div class="container footer-content">
            <a href="index.php" class="logo">
                <?php if (!empty($config['use_logo_img']) && file_exists(__DIR__ . '/../../public/' . $config['logo_img'])): ?>
                    <img src="<?= htmlspecialchars($config['logo_img']) ?>" alt="MCF8 Logo" class="logo-image">
                <?php else: ?>
                    <?= $config['logo_html'] ?>
                <?php endif; ?>
            </a>
            
            <ul class="footer-links">
                <li><a href="#" class="footer-link">Regulamin</a></li>
                <li><a href="o-nas.php" class="footer-link">O nas</a></li>
                <li><a href="ranking.php" class="footer-link">Ranking</a></li>
                <li><a href="ostatnie-smierci.php" class="footer-link">Zgony</a></li>
                <li><a href="media.php" class="footer-link">Sociale</a></li>
                <li><a href="contact.php" class="footer-link">Kontakt</a></li>
            </ul>

            <div class="footer-socials">
                <!-- GitHub Icon Link -->
                <a href="<?= htmlspecialchars($config['github_url']) ?>" target="_blank" class="social-icon" aria-label="GitHub Repository">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                    </svg>
                </a>
                
                <!-- Discord Icon Link -->
                <a href="<?= htmlspecialchars($config['discord_url']) ?>" target="_blank" class="social-icon" aria-label="Discord Server">
                    <svg width="20" height="20" viewBox="0 0 127.14 96.36" fill="currentColor">
                        <path d="M107.7,8.07A105.15,105.15,0,0,0,77.26,0a77.19,77.19,0,0,0-3.3,6.83A96.67,96.67,0,0,0,53.22,6.83,77.19,77.19,0,0,0,49.88,0,105.15,105.15,0,0,0,19.44,8.07C3.66,31.58-1.95,54.65,1,77.53a107.4,107.4,0,0,0,32,16.29,82.84,82.84,0,0,0,6.83-11.11,68.8,68.8,0,0,1-10.75-5.13c.91-.66,1.8-1.34,2.65-2a76.77,76.77,0,0,0,71.07,0c.85.69,1.74,1.37,2.65,2a68.42,68.42,0,0,1-10.75,5.14,83,83,0,0,0,6.83,11.11,107.28,107.28,0,0,0,32-16.29C129.66,48.42,123.39,25.66,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53S36.18,40.36,42.45,40.36,53.83,46,53.83,53,48.72,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.24,60,73.24,53S78.41,40.36,84.69,40.36,96.07,46,96.07,53,91,65.69,84.69,65.69Z"/>
                    </svg>
                </a>
            </div>

            <p class="footer-copy">
                &copy; <?= date('Y') ?> <?= htmlspecialchars($config['server_name']) ?>. Wszelkie prawa zastrzeżone. 
                Minecraft jest znakiem towarowym Mojang Synergies AB. Strona nie jest powiązana z Mojang.
            </p>
        </div>
    </footer>

    <!-- Pass configuration context from PHP to JS status query system -->
    <script>
        window.serverConfig = {
            ip: <?= json_encode($config['mc_ip']) ?>
        };
    </script>
    <script src="assets/js/main.js"></script>
</body>
</html>
