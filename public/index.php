<?php
/**
 * MCF8 Minecraft Server Website - Landing Page
 * Displays the main interface (Hero, modes details, server diagnostics).
 *
 * @package MCF8-Web
 */

$active_page = 'home';
$page_title = '1 tryb: OP Factions + SV';
// Custom full title for the homepage (overrides the default "server.pl | page_title" pattern)
$full_title = 'mcf8 | Najlepszy serwer w polsce.';

require_once __DIR__ . '/../private/config.php';
require_once __DIR__ . '/../private/templates/header.php';
?>

    <!-- Hero Section -->
    <header class="hero">
        <div class="hero-content">
            <span class="hero-subtitle">JEDEN TRYB: OP FACTIONS + SV</span>
            <h1 class="hero-title">Witaj na <span><?= htmlspecialchars($config['server_name']) ?></span></h1>
            <p class="hero-desc">
                Odkryj wodny minimalizm i czysty gameplay. Na serwerze działa jeden tryb: <strong>OP Factions + SV</strong> – pełna rywalizacja, wysoka strategia i brak premium-boostów, które miałyby wpływać na wynik.
            </p>
            <div class="hero-buttons">
                <!-- IP Copy Button -->
                <div class="ip-copier btn btn-primary" data-ip="<?= htmlspecialchars($config['mc_ip']) ?>">
                    <span class="ip-text"><?= htmlspecialchars($config['mc_ip']) ?></span>
                    <span class="ip-badge">Skopiuj IP</span>
                </div>
                <a href="#about" class="btn btn-secondary">Poznaj Tryb</a>
                <a href="ranking.php" class="btn btn-secondary" style="border-color: var(--blue-accent); color: var(--blue-accent);">Ranking Graczy</a>
            </div>
            
            <!-- Real-time server state badge -->
            <div class="server-badge-container">
                <span class="status-dot online"></span>
                <span>Status: <span class="status-text">Pobieranie...</span></span>
                <span style="color: var(--border);">|</span>
                <span>Graczy: <span class="player-count">-</span></span>
            </div>
        </div>
    </header>

    <!-- About Section / Gamemodes details -->
    <section id="about">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">JEDEN TRYB</span>
                <h2 class="section-title">Nasz <span>Tryb</span></h2>
            </div>

            <div class="modes-grid">
                <div class="single-mode-wrap">
                    <div class="mode-card">
                        <div class="mode-icon">⚔</div>
                        <h3 class="mode-title">OP Factions + SV</h3>
                        <p class="mode-desc">
                            Połączenie klasycznej rywalizacji gildyjnej z mocnym elementem survivalowego rankingu. Każdy mecz, każdy atak i każda decyzja wpływają na wynik na tej samej mapie i w tej samej rozgrywce.
                        </p>
                        <ul class="mode-features">
                            <li>Jeden spójny tryb: OP Factions + SV</li>
                            <li>Brak rang premium (VIP/SVIP) wpływu na rozgrywkę</li>
                            <li>Poziom rywalizacji oparty na umiejętnościach, strategii i zgraniu</li>
                            <li>Regularne eventy, boss fighty i dynamiczne wyzwania</li>
                            <li>Wysoka konkurencja i czysty, uczciwy gameplay</li>
                            <li>Zajmuj tereny, czuj sie bezpiecznie.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Diagnostics / Connection Diagnostics -->
    <section id="diagnostics" style="background: rgba(3, 7, 18, 0.4);">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">DIAGNOSTYKA SERWEROWA</span>
                <h2 class="section-title">Czy serwer jest <span>Online</span>?</h2>
            </div>

            <div class="diag-panel">
                <div class="diag-header">
                    <div class="diag-title-group">
                        <span class="diag-console-icon">&gt;_</span>
                        <span class="diag-title">mcf8 diagnostics console</span>
                    </div>
                    <span class="status-dot online"></span>
                </div>
                
                <div class="diag-grid">
                    <div class="diag-item">
                        <span class="diag-label">Adres serwera:</span>
                        <span class="diag-value" id="diag-ip">Pobieranie...</span>
                    </div>
                    <div class="diag-item">
                        <span class="diag-label">Status połączenia:</span>
                        <span class="diag-value highlight" id="diag-status">SPRAWDZANIE...</span>
                    </div>
                    <div class="diag-item">
                        <span class="diag-label">Czas odpowiedzi (Ping):</span>
                        <span class="diag-value" id="diag-ping">--ms</span>
                    </div>
                    <div class="diag-item">
                        <span class="diag-label">Wersja gry:</span>
                        <span class="diag-value" id="diag-version">--</span>
                    </div>
                    <div class="diag-item">
                        <span class="diag-label">Zalogowani gracze:</span>
                        <span class="diag-value highlight" id="diag-players">--</span>
                    </div>
                    <div class="diag-item">
                        <span class="diag-label">Typ zapytań API:</span>
                        <span class="diag-value">JSON GET HTTPS</span>
                    </div>
                    
                    <div class="motd-container" id="diag-motd">
                        Łączenie z serwerem diagnostycznym w celu pobrania wiadomości MOTD...
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
require_once __DIR__ . '/../private/templates/footer.php';
?>
