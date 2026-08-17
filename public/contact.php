<?php
/**
 * MCF8 Minecraft Server Website - Contact & Bug Tracker
 * Handles message recording and error reporting, storing entries in the MySQL DB.
 *
 * @package MCF8-Web
 */

$active_page = 'contact';
$page_title = 'Kontakt & Błędy';

require_once __DIR__ . '/../private/db.php';

// Generate CSRF token if empty
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Generate captcha if empty
if (!isset($_SESSION['captcha_num1']) || !isset($_SESSION['captcha_num2'])) {
    $_SESSION['captcha_num1'] = rand(1, 9);
    $_SESSION['captcha_num2'] = rand(1, 9);
}

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // A. CSRF Token Verification
    $submitted_token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'], $submitted_token)) {
        $_SESSION['flash_error'] = 'Błąd weryfikacji sesji. Odśwież stronę i spróbuj ponownie.';
        header('Location: contact.php');
        exit;
    }

    // B. Honeypot check
    if (!empty($_POST['website_url'])) {
        $_SESSION['flash_error'] = 'Wykryto próbę spamu. Zgłoszenie odrzucone.';
        header('Location: contact.php');
        exit;
    }

    // C. CAPTCHA Security validation
    $submitted_captcha = isset($_POST['anti_spam']) ? (int)$_POST['anti_spam'] : -1;
    $expected_captcha = (int)$_SESSION['captcha_num1'] + (int)$_SESSION['captcha_num2'];

    // Regenerate CAPTCHA digits immediately for the next request
    $_SESSION['captcha_num1'] = rand(1, 9);
    $_SESSION['captcha_num2'] = rand(1, 9);

    if ($submitted_captcha !== $expected_captcha) {
        $_SESSION['flash_error'] = 'Błędny wynik działania matematycznego. Spróbuj ponownie.';
        header('Location: contact.php');
        exit;
    }

    // D. Identify Action & Process Form
    $action = $_POST['action'] ?? '';

    if ($action === 'contact') {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');

        // Server-side validation
        if (empty($name) || empty($email) || empty($message)) {
            $_SESSION['flash_error'] = 'Uzupełnij wszystkie wymagane pola w formularzu kontaktowym.';
            header('Location: contact.php');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_error'] = 'Nieprawidłowy format adresu e-mail.';
            header('Location: contact.php');
            exit;
        }

        if (strlen($name) > 100 || strlen($message) > 5000) {
            $_SESSION['flash_error'] = 'Treść lub nazwa przekracza dopuszczalne limity znaków.';
            header('Location: contact.php');
            exit;
        }

        // Connect to Database and insert values securely
        if ($db === null) {
            $_SESSION['flash_error'] = 'Baza danych jest niedostępna. Spróbuj wysłać wiadomość później.';
            header('Location: contact.php');
            exit;
        }

        try {
            $stmt = $db->prepare('INSERT INTO contact_messages (name, email, message, ip_address) VALUES (:name, :email, :message, :ip)');
            $stmt->execute([
                ':name'     => $name,
                ':email'    => $email,
                ':message'  => $message,
                ':ip'       => $_SERVER['REMOTE_ADDR']
            ]);
            $_SESSION['flash_success'] = 'Wiadomość została wysłana pomyślnie!';
        } catch (PDOException $e) {
            $_SESSION['flash_error'] = 'Wystąpił błąd zapisu w bazie danych. Twoja wiadomość nie została zapisana.';
        }

    } elseif ($action === 'bugreport') {
        $mc_username = trim($_POST['minecraft_username'] ?? '');
        $discord_tag = trim($_POST['discord_tag'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $steps       = trim($_POST['steps_to_reproduce'] ?? '');
        $severity    = trim($_POST['severity'] ?? 'low');

        // Server-side validation
        if (empty($mc_username) || empty($discord_tag) || empty($description) || empty($steps)) {
            $_SESSION['flash_error'] = 'Uzupełnij wszystkie pola w zgłoszeniu błędu.';
            header('Location: contact.php');
            exit;
        }

        if (!in_array($severity, ['low', 'medium', 'high', 'critical'])) {
            $severity = 'low';
        }

        if (strlen($mc_username) > 16 || strlen($discord_tag) > 100 || strlen($description) > 5000 || strlen($steps) > 5000) {
            $_SESSION['flash_error'] = 'Przekroczono dopuszczalne limity znaków w polach formularza.';
            header('Location: contact.php');
            exit;
        }

        // Connect to Database and insert values securely
        if ($db === null) {
            $_SESSION['flash_error'] = 'Baza danych jest niedostępna. Spróbuj wysłać zgłoszenie później.';
            header('Location: contact.php');
            exit;
        }

        try {
            $stmt = $db->prepare('INSERT INTO bug_reports (minecraft_username, discord_tag, description, steps_to_reproduce, severity, ip_address) VALUES (:mc_user, :discord, :desc, :steps, :severity, :ip)');
            $stmt->execute([
                ':mc_user'  => $mc_username,
                ':discord'  => $discord_tag,
                ':desc'     => $description,
                ':steps'    => $steps,
                ':severity' => $severity,
                ':ip'       => $_SERVER['REMOTE_ADDR']
            ]);
            $_SESSION['flash_success'] = 'Błąd został pomyślnie zgłoszony. Dziękujemy za pomoc!';
        } catch (PDOException $e) {
            $_SESSION['flash_error'] = 'Wystąpił błąd zapisu zgłoszenia w bazie danych.';
        }
    }

    header('Location: contact.php');
    exit;
}

$captcha_num1 = $_SESSION['captcha_num1'];
$captcha_num2 = $_SESSION['captcha_num2'];

require_once __DIR__ . '/../private/templates/header.php';
?>

    <section id="forms" style="padding-top: 150px;">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">CENTRUM ZGŁOSZEŃ</span>
                <h1 class="section-title">Napisz do nas <span>/</span> Zgłoś błąd</h1>
            </div>

            <?php if ($db_error !== null): ?>
                <div class="flash-message flash-error" style="max-width: 800px; margin: 0 auto 30px auto;">
                    <span class="icon">⚠</span>
                    <span>Błąd połączenia z bazą danych: formularze są tymczasowo nieaktywne. Statystyki gry są niedostępne.</span>
                </div>
            <?php endif; ?>

            <div class="forms-container">
                <!-- Form 1: Contact Form -->
                <div class="form-panel">
                    <div class="form-header">
                        <h3 class="form-title">Wyślij wiadomość</h3>
                        <p class="form-desc">Masz pytanie dotyczące serwera? Napisz do nas bezpośrednio.</p>
                    </div>

                    <form action="contact.php" method="POST">
                        <input type="hidden" name="action" value="contact">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                        
                        <!-- Honeypot anti-spam hidden field -->
                        <input type="text" name="website_url" class="hp-field" placeholder="Do not fill this" autocomplete="off" tabindex="-1">

                        <div class="form-group">
                            <label class="form-label" for="contact-name">Twoje Imię / Nick</label>
                            <input type="text" id="contact-name" name="name" class="form-input" placeholder="np. Kacper5343" required maxlength="100">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="contact-email">Adres E-mail</label>
                            <input type="email" id="contact-email" name="email" class="form-input" placeholder="np. example@com.pl" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="contact-message">Treść Wiadomości</label>
                            <textarea id="contact-message" name="message" class="form-textarea" placeholder="Wpisz treść swojej wiadomości..." required maxlength="5000"></textarea>
                        </div>

                        <!-- Anti-spam math captcha -->
                        <div class="form-group">
                            <label class="form-label" for="contact-captcha">Weryfikacja anty-spamowa</label>
                            <div class="captcha-container">
                                <div class="captcha-question"><?= htmlspecialchars($captcha_num1) ?> + <?= htmlspecialchars($captcha_num2) ?> =</div>
                                <input type="number" id="contact-captcha" name="anti_spam" class="form-input" placeholder="?" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" <?= ($db === null) ? 'disabled' : '' ?>>
                            Wyślij Wiadomość
                        </button>
                    </form>
                </div>

                <!-- Form 2: Bugtracker Form -->
                <div class="form-panel">
                    <div class="form-header">
                        <h3 class="form-title">Zgłoś błąd (Bugtracker)</h3>
                        <p class="form-desc">Zauważyłeś lukę lub błąd? Zgłoś go, abyśmy mogli go natychmiast usunąć.</p>
                    </div>

                    <form action="contact.php" method="POST">
                        <input type="hidden" name="action" value="bugreport">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                        
                        <!-- Honeypot anti-spam hidden field -->
                        <input type="text" name="website_url" class="hp-field" placeholder="Do not fill this" autocomplete="off" tabindex="-1">

                        <div class="form-group">
                            <label class="form-label" for="bug-username">Twój Nick z Minecrafta</label>
                            <input type="text" id="bug-username" name="minecraft_username" class="form-input" placeholder="np. Steve" required maxlength="16">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="bug-discord">Twój Tag Discord</label>
                            <input type="text" id="bug-discord" name="discord_tag" class="form-input" placeholder="np. nick#0000 lub nick" required maxlength="100">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="bug-severity">Waga Błędu</label>
                            <select id="bug-severity" name="severity" class="form-select">
                                <option value="low">Niska (Błąd kosmetyczny / wizualny)</option>
                                <option value="medium" selected>Średnia (Błąd mechaniki nie wpływa krytycznie)</option>
                                <option value="high">Wysoka (Błąd ekonomiczny / uniemożliwiający grę)</option>
                                <option value="critical">Krytyczna (Duplikacja przedmiotów / crash serwera)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="bug-desc">Opis Błędu</label>
                            <textarea id="bug-desc" name="description" class="form-textarea" placeholder="Co dokładnie się dzieje?" required maxlength="5000"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="bug-steps">Kroki do odtworzenia</label>
                            <textarea id="bug-steps" name="steps_to_reproduce" class="form-textarea" placeholder="1. Zrób X&#10;2. Uruchom Y&#10;3. Błąd się pojawia" required maxlength="5000"></textarea>
                        </div>

                        <!-- Anti-spam math captcha -->
                        <div class="form-group">
                            <label class="form-label" for="bug-captcha">Weryfikacja anty-spamowa</label>
                            <div class="captcha-container">
                                <div class="captcha-question"><?= htmlspecialchars($captcha_num1) ?> + <?= htmlspecialchars($captcha_num2) ?> =</div>
                                <input type="number" id="bug-captcha" name="anti_spam" class="form-input" placeholder="?" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" <?= ($db === null) ? 'disabled' : '' ?>>
                            Wyślij Zgłoszenie
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php
require_once __DIR__ . '/../private/templates/footer.php';
?>
