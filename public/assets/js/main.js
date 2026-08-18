/**
 * MCF8 Minecraft Server Website Client Script
 * Handles: Clipboard Copying, Scrolling Interactions, and Server Status API Polling.
 *
 * @package MCF8-Web
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Navbar Scroll Transition
    const navbar = document.querySelector('.navbar');
    const handleScroll = () => {
        if (!navbar) return;
        if (window.scrollY > 20) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    };
    window.addEventListener('scroll', handleScroll);
    handleScroll();

    // 2. Clipboard Copier logic
    const copiers = document.querySelectorAll('.ip-copier');
    copiers.forEach(copier => {
        copier.addEventListener('click', () => {
            const ipToCopy = copier.getAttribute('data-ip') || 'play.mcf8';
            const badge = copier.querySelector('.ip-badge');
            
            navigator.clipboard.writeText(ipToCopy)
                .then(() => {
                    const originalText = badge.textContent;
                    badge.textContent = 'Skopiowano!';
                    badge.style.backgroundColor = '#10b981';
                    badge.style.color = '#ffffff';

                    setTimeout(() => {
                        badge.textContent = originalText;
                        badge.style.backgroundColor = '';
                        badge.style.color = '';
                    }, 2000);
                })
                .catch(err => {
                    console.error('Failed to copy text: ', err);
                });
        });
    });

    // 3. Minecraft Server Status API Polling
    const serverIP = window.serverConfig?.ip || 'play.mcf8';
    const apiUrl = `https://api.mcsrvstat.us/2/${serverIP}`;

    // Elements to update
    const statusDots = document.querySelectorAll('.status-dot');
    const statusTexts = document.querySelectorAll('.status-text');
    const playerCounts = document.querySelectorAll('.player-count');
    
    // Diagnostic elements
    const diagIp = document.getElementById('diag-ip');
    const diagStatus = document.getElementById('diag-status');
    const diagPing = document.getElementById('diag-ping');
    const diagVersion = document.getElementById('diag-version');
    const diagPlayers = document.getElementById('diag-players');
    const motdContainer = document.getElementById('diag-motd');

    const updateStatusUI = (data, latency) => {
        // Update general status indicators
        statusDots.forEach(dot => {
            dot.className = data.online ? 'status-dot online' : 'status-dot offline';
        });

        statusTexts.forEach(text => {
            text.textContent = data.online ? 'ONLINE' : 'OFFLINE';
        });

        playerCounts.forEach(count => {
            count.textContent = data.online ? `${data.players.online} / ${data.players.max}` : '0 / 0';
        });

        // Update diagnostics panel if present on page
        if (diagStatus) {
            diagStatus.textContent = data.online ? 'ONLINE' : 'OFFLINE';
            diagStatus.className = data.online ? 'diag-value highlight' : 'diag-value';
            if (!data.online) diagStatus.style.color = '#ef4444';
        }
        if (diagPlayers) diagPlayers.textContent = data.online ? `${data.players.online} / ${data.players.max}` : '0 / 0';
        if (diagVersion) diagVersion.textContent = data.online ? (data.version || '1.20+') : 'N/A';
        if (diagPing) diagPing.textContent = `${latency}ms`;
        
        if (motdContainer) {
            if (data.online && data.motd && data.motd.clean) {
                motdContainer.innerHTML = data.motd.clean.join('<br>');
            } else {
                motdContainer.textContent = 'Połączenie przekroczyło limit czasu. Spróbuj ponownie później.';
                motdContainer.style.color = '#94a3b8';
            }
        }
    };

    const setOfflineUI = () => {
        statusDots.forEach(dot => {
            dot.className = 'status-dot offline';
        });
        statusTexts.forEach(text => {
            text.textContent = 'OFFLINE';
        });
        playerCounts.forEach(count => {
            count.textContent = '0 / 0';
        });

        if (diagStatus) {
            diagStatus.textContent = 'OFFLINE';
            diagStatus.className = 'diag-value';
            diagStatus.style.color = '#ef4444';
        }
        if (diagPlayers) diagPlayers.textContent = '0 / 0';
        if (diagVersion) diagVersion.textContent = 'N/A';
        if (diagPing) diagPing.textContent = 'TIMEOUT';
        if (motdContainer) {
            motdContainer.textContent = 'Połączenie przekroczyło limit czasu. Serwer może być wyłączony.';
            motdContainer.style.color = '#94a3b8';
        }
    };

    const queryServerStatus = () => {
        const startTime = Date.now();
        fetch(apiUrl)
            .then(response => {
                if (!response.ok) throw new Error('API server error');
                return response.json();
            })
            .then(data => {
                const latency = Date.now() - startTime;
                updateStatusUI(data, latency);
            })
            .catch(error => {
                console.warn('Unable to query Minecraft API: ', error);
                setOfflineUI();
            });
    };

    // Run query on load
    if (diagIp) {
        diagIp.textContent = serverIP;
    }
    
    // Perform fetch poll
    queryServerStatus();
});
