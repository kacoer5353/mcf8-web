<?php
/**
 * MCF8 Minecraft Server Website - About Us Page
 * Details the server philosophy, features, and competitive game modes.
 *
 * @package MCF8-Web
 */

$active_page = 'about';
$page_title = 'O nas';

require_once __DIR__ . '/../private/config.php';
require_once __DIR__ . '/../private/templates/header.php';
?>

<section style="padding-top: 150px;">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">KIM JESTEŚMY</span>
            <h1 class="section-title">O serwerze <span>mcf8</span></h1>
        </div>

        <!-- Main Intro Panel -->
        <div style="max-width: 800px; margin: 0 auto 80px auto; text-align: center;">
            <p style="font-size: 1.25rem; line-height: 1.8; color: var(--text-white); margin-bottom: 24px;">
                Serwer <strong>mcf8.orc.host</strong> powstał jako odpowiedź na współczesne, przeładowane
                mikrotransakcjami i ułatwieniami serwery Minecraft. Stawiamy na czysty gameplay, unikalny design oraz
                zbalansowaną rywalizację.
            </p>
            <p style="color: var(--text-muted); font-size: 1.05rem; line-height: 1.7;">
                Nasz motyw przewodni to <strong>wodny minimalizm</strong> – zarówno w wyglądzie strony i gry, jak i w
                mechanice obronnej baz. Tutaj każdy gracz zaczyna na równych warunkach. Całkowicie wykluczyliśmy rangi
                premium typu VIP czy SVIP wpływające na rozgrywkę. O Twojej sile decyduje wyłącznie spryt, koordynacja i
                doświadczenie.
            </p>
        </div>

        <!-- Features Grid with a single combined mode -->
        <div class="modes-grid" style="margin-bottom: 80px;">
            <div class="single-mode-wrap">
                <div class="mode-card">
                    <div class="mode-icon">⚔</div>
                    <h3 class="mode-title">OP Factions + SV</h3>
                    <p class="mode-desc" style="margin-bottom: 20px;">
                        Jeden spójny tryb, który łączy w sobie agresywną grę gildyjną i mocne elementy survivalowego
                        rankingu. To połączenie strategii, PvP, ekonomii i ścisłej rywalizacji o dominację na serwerze.
                    </p>
                    <ul class="mode-features" style="margin-bottom: 24px;">
                        <li>Jeden spójny tryb: OP Factions + SV</li>
                        <li>Brak rang premium (VIP/SVIP) wpływu na rozgrywkę</li>
                        <li>Poziom rywalizacji oparty na umiejętnościach, strategii i zgraniu</li>
                        <li>Regularne eventy, boss fighty i dynamiczne wyzwania</li>
                        <li>Wysoka konkurencja i czysty, uczciwy gameplay</li>
                        <li>Zajmuj tereny, czuj sie bezpiecznie.</li>
                        <li><strong>Na czym polega OP Factions?</strong> Rozgrywka opiera się na tworzeniu potężnych
                            gildii, budowaniu bezpiecznych baz (claimowaniu terenów), prowadzeniu wojen o dominację,
                            masowych walkach PvP oraz zarządzaniu wspólnym skarbcem i ekonomią.</li>
                        <li><strong>Elementy Survivalu (SV):</strong> Surowy start, zbieranie surowców z dzikiego
                            świata, walka o przetrwanie oraz parcie w górę w rankingach graczy i gildii.</li>
                        <li><strong>Zmodyfikowane mechaniki:</strong> Autorskie i odświeżone systemy rozgrywki, które
                            nadają serwerowi unikalny dynamizm i głębię taktyczną.</li>
                        <li><strong>Łatwiejsze zdobywanie itemków:</strong> Przyspieszony rozwój i zbalansowane źródła
                            cennego ekwipunku, dzięki którym szybciej przygotujesz się do walki bez nudnego,
                            wielogodzinnego kopania.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Server Values section -->
        <div class="diag-panel" style="max-width: 900px;">
            <div class="diag-header">
                <div class="diag-title-group">
                    <span class="diag-console-icon">&gt;_</span>
                    <span class="diag-title">filozofia_mcf8.sh</span>
                </div>
            </div>
            <div style="padding: 10px 0; line-height: 1.8;">
                <h4 style="color: var(--aqua); margin-bottom: 12px; font-family: var(--font-retro); font-size: 0.8rem;">
                    [NASZE WARTOŚCI]</h4>
                <p style="margin-bottom: 16px;"><strong style="color: var(--text-white);">1. Transparentność i
                        Równość:</strong> Wszyscy gracze podlegają tym samym zasadom. Zgłoszenia bugów są weryfikowane
                    publicznie, a administracja nie ingeruje w uczciwą rywalizację.</p>
                <p style="margin-bottom: 16px;"><strong style="color: var(--text-white);">2. Optymalizacja i
                        Stabilność:</strong> Nasz silnik gry jest skonfigurowany pod kątem jak najmniejszych opóźnień
                    (TPS: 20.0). Zapewniamy płynne walki PvP nawet przy dużych starciach gildyjnych.</p>
                <p><strong style="color: var(--text-white);">3. Aktywna Społeczność:</strong> Cały projekt rozwijany
                    jest przy współudziale graczy. Sugestie zmian są regularnie poddawane pod głosowanie na naszym
                    serwerze Discord.</p>
            </div>
        </div>
    </div>
</section>

<?php
require_once __DIR__ . '/../private/templates/footer.php';
?>