<?php
/**
 * MCF8 Minecraft Server Website - Recent Deaths Log
 * Displays a live-feed style list of the latest 30 server deaths with player heads.
 *
 * @package MCF8-Web
 */

$active_page = 'deaths';
$page_title = 'Ostatnie Zgony';

require_once __DIR__ . '/../private/db.php';

$deaths = [];
$deaths_error = null;

if ($db !== null) {
    try {
        $stmt = $db->query('SELECT victim, killer, death_message, killed_at FROM recent_deaths ORDER BY killed_at DESC LIMIT 30');
        $deaths = $stmt->fetchAll();
    } catch (PDOException $e) {
        $deaths_error = 'Nie udało się pobrać rejestru zgonów z bazy danych.';
    }
} else {
    $deaths_error = 'Brak połączenia z bazą danych rejestru zgonów.';
}

/**
 * Returns a human-readable relative time string.
 *
 * @param string $timestamp Datetime string.
 * @return string Relative time description.
 */
function getRelativeTime($timestamp) {
    $time = strtotime($timestamp);
    $diff = time() - $time;
    
    if ($diff < 1) {
        return 'przed chwilą';
    }
    
    if ($diff < 60) {
        return 'przed chwilą';
    }
    
    $diff_minutes = round($diff / 60);
    if ($diff_minutes < 60) {
        return $diff_minutes . ' min. temu';
    }
    
    $diff_hours = round($diff / 3600);
    if ($diff_hours < 24) {
        return $diff_hours . ' godz. temu';
    }
    
    $diff_days = round($diff / 86400);
    if ($diff_days < 7) {
        return $diff_days . ' dni temu';
    }
    
    return date('d.m.Y H:i', $time);
}

require_once __DIR__ . '/../private/templates/header.php';
?>

    <!-- Recent Deaths Section -->
    <section style="padding-top: 150px;">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">ZDARZENIA NA SERWERZE</span>
                <h1 class="section-title">Ostatnie <span>Śmierci</span></h1>
            </div>

            <?php if ($deaths_error !== null): ?>
                <div class="flash-message flash-error" style="max-width: 800px; margin: 0 auto 30px auto;">
                    <span class="icon">⚠</span>
                    <span><?= htmlspecialchars($deaths_error) ?></span>
                </div>
            <?php else: ?>
                <!-- Deaths feed wrapper -->
                <div class="deaths-feed-container" style="max-width: 800px; margin: 0 auto;">
                    <?php if (empty($deaths)): ?>
                        <div class="diag-panel" style="text-align: center; color: var(--text-muted); padding: 48px;">
                            Brak niedawnych zgonów na serwerze. Spokojna ta tafli wody...
                        </div>
                    <?php else: ?>
                        <?php foreach ($deaths as $death): 
                            $victim = $death['victim'];
                            $killer = $death['killer'];
                            $message = $death['death_message'];
                            $time_string = getRelativeTime($death['killed_at']);
                            
                            // Query URLs for avatars
                            $victim_avatar = "https://mc-heads.net/avatar/" . urlencode($victim) . "/32";
                            $killer_avatar = !empty($killer) ? "https://mc-heads.net/avatar/" . urlencode($killer) . "/32" : null;
                        ?>
                            <!-- Single Death Row Element -->
                            <div class="death-row">
                                <div class="death-row-left">
                                    <img src="<?= htmlspecialchars($victim_avatar) ?>" alt="<?= htmlspecialchars($victim) ?>" class="death-avatar victim-avatar" title="Ofiara: <?= htmlspecialchars($victim) ?>" loading="lazy">
                                    <div class="death-msg-content">
                                        <span class="death-message-text"><?= htmlspecialchars($message) ?></span>
                                        <span class="death-time"><?= htmlspecialchars($time_string) ?></span>
                                    </div>
                                </div>
                                <?php if ($killer_avatar): ?>
                                    <div class="death-row-right">
                                        <span class="death-killer-label">Zabójca:</span>
                                        <img src="<?= htmlspecialchars($killer_avatar) ?>" alt="<?= htmlspecialchars($killer) ?>" class="death-avatar killer-avatar" title="Zabójca: <?= htmlspecialchars($killer) ?>" loading="lazy">
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

<?php
require_once __DIR__ . '/../private/templates/footer.php';
?>
