<?php
/**
 * MCF8 Minecraft Server Website - Player Leaderboard Ranking
 * Fetches rankings from the MySQL database, calculates KDR, and queries MC skins.
 *
 * @package MCF8-Web
 */

$active_page = 'ranking';
$page_title = 'Ranking Graczy';

require_once __DIR__ . '/../private/db.php';

$players = [];
$ranking_error = null;

if ($db !== null) {
    try {
        // Query players sorted by ranking points
        $stmt = $db->query('SELECT username, kills, deaths, points FROM players_ranking ORDER BY points DESC LIMIT 100');
        $players = $stmt->fetchAll();
    } catch (PDOException $e) {
        $ranking_error = 'Nie udało się pobrać statystyk graczy z bazy danych.';
    }
} else {
    $ranking_error = 'Brak połączenia z bazą danych rankingu.';
}

require_once __DIR__ . '/../private/templates/header.php';
?>

    <!-- Leaderboard section -->
    <section style="padding-top: 150px;">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">TABLICA LIDERÓW</span>
                <h1 class="section-title">Ranking <span>Graczy</span></h1>
            </div>

            <?php if ($ranking_error !== null): ?>
                <div class="flash-message flash-error" style="max-width: 800px; margin: 0 auto 30px auto;">
                    <span class="icon">⚠</span>
                    <span><?= htmlspecialchars($ranking_error) ?></span>
                </div>
            <?php else: ?>
                <!-- Table Leaderboard Wrapper -->
                <div class="leaderboard-wrapper" style="max-width: 900px; margin: 0 auto;">
                    <table class="leaderboard-table">
                        <thead>
                            <tr>
                                <th style="width: 80px; text-align: center;">Pozycja</th>
                                <th style="width: 60px;">Główka</th>
                                <th>Gracz</th>
                                <th style="text-align: right;">Punkty</th>
                                <th style="text-align: right;">Zabójstwa</th>
                                <th style="text-align: right;">Śmierci</th>
                                <th style="text-align: right;">K/D Ratio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($players)): ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px 0;">
                                        Brak danych do wyświetlenia. Zagraj na serwerze, aby pojawić się w rankingu!
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($players as $index => $player): 
                                    $rank = $index + 1;
                                    $username = $player['username'];
                                    $kills = (int)$player['kills'];
                                    $deaths = (int)$player['deaths'];
                                    $points = (int)$player['points'];
                                    
                                    // KDR Calculation with safe zero-division check
                                    $kdr = ($deaths > 0) ? ($kills / $deaths) : $kills;
                                    
                                    // Rank style class assignments for podium
                                    $badge_class = '';
                                    if ($rank === 1) $badge_class = 'rank-gold';
                                    elseif ($rank === 2) $badge_class = 'rank-silver';
                                    elseif ($rank === 3) $badge_class = 'rank-bronze';
                                    
                                    // Minecraft avatar provider
                                    $avatar_url = "https://mc-heads.net/avatar/" . urlencode($username) . "/32";
                                ?>
                                    <tr>
                                        <td style="text-align: center;">
                                            <?php if ($rank <= 3): ?>
                                                <span class="rank-badge <?= $badge_class ?>"><?= $rank ?></span>
                                            <?php else: ?>
                                                <span class="rank-normal"><?= $rank ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <img src="<?= htmlspecialchars($avatar_url) ?>" alt="<?= htmlspecialchars($username) ?>" class="player-head" loading="lazy">
                                        </td>
                                        <td class="player-name">
                                            <?= htmlspecialchars($username) ?>
                                        </td>
                                        <td style="text-align: right; font-weight: 700; color: var(--aqua);">
                                            <?= number_format($points) ?> pkt
                                        </td>
                                        <td style="text-align: right; color: var(--text-white);">
                                            <?= number_format($kills) ?>
                                        </td>
                                        <td style="text-align: right; color: var(--text-muted);">
                                            <?= number_format($deaths) ?>
                                        </td>
                                        <td style="text-align: right; font-weight: 600; color: <?= ($kdr >= 1.5) ? 'var(--success)' : 'var(--text-main)' ?>;">
                                            <?= number_format($kdr, 2) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </section>

<?php
require_once __DIR__ . '/../private/templates/footer.php';
?>
