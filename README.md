# mcf8-web

Krótki opis

Projekt "mcf8-web" to prosta strona serwera Minecraft (PHP + Apache) przygotowana do uruchomienia w Dockerze. Zawiera publiczny katalog `public/`, konfigurację w `private/` oraz skrypt inicjalizacji bazy `schema.sql`. Grafiki, style i skrypty znajdują się w `public/assets/`.

Szybkie uruchomienie

1. Zainstaluj Docker i Docker Compose.
2. W katalogu projektu uruchom: `docker compose up -d --build`.
3. Strona będzie dostępna pod http://localhost:8000, a phpMyAdmin pod http://localhost:8080.

To wszystko — README utrzymane krótko i na temat. Jeśli chcesz, rozbuduję go o dodatkowe instrukcje (konfiguracja .env, backup bazy, deployment).
