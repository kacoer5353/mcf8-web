<?php
/**
 * MCF8 Minecraft Server Website - Media & Connections Page
 * Features large styled call-to-actions linking players to Discord, IP, and GitHub.
 *
 * @package MCF8-Web
 */

$active_page = 'media';
$page_title = 'Sociale & Połączenie';

require_once __DIR__ . '/../private/config.php';
require_once __DIR__ . '/../private/templates/header.php';
?>

    <!-- Connections and Media List -->
    <section style="padding-top: 150px;">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">NASZE SOCIALE</span>
                <h1 class="section-title">Połącz się z <span>mcf8</span></h1>
            </div>

            <!-- Media card container -->
            <div class="modes-grid" style="grid-template-columns: repeat(3, 1fr); gap: 24px; max-width: 1000px; margin: 0 auto;">
                
                <!-- Card 1: Discord Connection -->
                <div class="mode-card" style="padding: 32px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: space-between; min-height: 380px;">
                    <div>
                        <div class="mode-icon" style="color: var(--blue-accent); text-shadow: 0 0 15px rgba(59, 130, 246, 0.4);">
                            <svg width="48" height="48" viewBox="0 0 127.14 96.36" fill="currentColor" style="display: block; margin: 0 auto 16px auto;">
                                <path d="M107.7,8.07A105.15,105.15,0,0,0,77.26,0a77.19,77.19,0,0,0-3.3,6.83A96.67,96.67,0,0,0,53.22,6.83,77.19,77.19,0,0,0,49.88,0,105.15,105.15,0,0,0,19.44,8.07C3.66,31.58-1.95,54.65,1,77.53a107.4,107.4,0,0,0,32,16.29,82.84,82.84,0,0,0,6.83-11.11,68.8,68.8,0,0,1-10.75-5.13c.91-.66,1.8-1.34,2.65-2a76.77,76.77,0,0,0,71.07,0c.85.69,1.74,1.37,2.65,2a68.42,68.42,0,0,1-10.75,5.14,83,83,0,0,0,6.83,11.11,107.28,107.28,0,0,0,32-16.29C129.66,48.42,123.39,25.66,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53S36.18,40.36,42.45,40.36,53.83,46,53.83,53,48.72,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.24,60,73.24,53S78.41,40.36,84.69,40.36,96.07,46,96.07,53,91,65.69,84.69,65.69Z"/>
                            </svg>
                        </div>
                        <h3 class="mode-title" style="font-size: 1.4rem; margin-bottom: 12px;">Discord</h3>
                        <p class="mode-desc" style="font-size: 0.9rem; margin-bottom: 24px; color: var(--text-muted); line-height: 1.5;">
                            Nasze centrum społeczności. Rozmawiaj z graczami, twórz sojusze, zgłaszaj propozycje i bierz udział w ankietach administracji.
                        </p>
                    </div>
                    <a href="<?= htmlspecialchars($config['discord_url']) ?>" target="_blank" class="btn btn-discord" style="width: 100%;">
                        Dołącz do serwera
                    </a>
                </div>

                <!-- Card 2: Minecraft Connection Details -->
                <div class="mode-card" style="padding: 32px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: space-between; min-height: 380px;">
                    <div>
                        <div class="mode-icon">🎮</div>
                        <h3 class="mode-title" style="font-size: 1.4rem; margin-bottom: 12px;">Minecraft IP</h3>
                        <p class="mode-desc" style="font-size: 0.9rem; margin-bottom: 24px; color: var(--text-muted); line-height: 1.5;">
                            Skorzystaj z poniższego adresu, aby połączyć się z serwerem bezpośrednio w grze Minecraft (zalecana wersja 1.20 lub nowsza).
                        </p>
                    </div>
                    <div class="ip-copier btn btn-primary" data-ip="<?= htmlspecialchars($config['mc_ip']) ?>" style="width: 100%; cursor: pointer;">
                        <span class="ip-text" style="font-size: 0.75rem;"><?= htmlspecialchars($config['mc_ip']) ?></span>
                        <span class="ip-badge" style="font-size: 0.65rem;">Kopiuj</span>
                    </div>
                </div>

                <!-- Card 3: GitHub Code Repository -->
                <div class="mode-card" style="padding: 32px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: space-between; min-height: 380px;">
                    <div>
                        <div class="mode-icon" style="color: var(--text-white);">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: block; margin: 0 auto 16px auto;">
                                <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                            </svg>
                        </div>
                        <h3 class="mode-title" style="font-size: 1.4rem; margin-bottom: 12px;">GitHub</h3>
                        <p class="mode-desc" style="font-size: 0.9rem; margin-bottom: 24px; color: var(--text-muted); line-height: 1.5;">
                            Nasza strona internetowa i konfiguracje są w pełni open-source. Kod źródłowy oraz aktualizacje znajdziesz w repozytorium GitHub.
                        </p>
                    </div>
                    <a href="<?= htmlspecialchars($config['github_url']) ?>" target="_blank" class="btn btn-secondary" style="width: 100%; border-color: var(--text-muted); color: var(--text-white);">
                        Zobacz Repozytorium
                    </a>
                </div>

            </div>
        </div>
    </section>

<?php
require_once __DIR__ . '/../private/templates/footer.php';
?>
