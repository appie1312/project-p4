<?php
/**
 * Theater Aurora - Main Layout
 * 
 * @package TheaterAurora
 * @version 1.0.0
 * @author SyncFocus17
 * @created 2025-05-21
 */

use App\Core\Session;

// Initialize session if not already initialized
if (!isset($session)) {
    $session = Session::getInstance();
}

// Initialize default variables
$currentUser = $session->get('user', null);
$isStaff = $currentUser && ($currentUser['role'] === 'staff' || $currentUser['role'] === 'admin');
$pageTitle = $pageTitle ?? 'Theater Aurora';
$currentTime = new DateTime('now', new DateTimeZone('UTC'));
?>
<!DOCTYPE html>
<html lang="en" class="theme-<?= $session->get('theme', 'light') ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= htmlspecialchars($pageTitle) ?> | Theater Aurora</title>
    
    <!-- Meta Tags -->
    <meta name="description" content="Experience the magic of live theater at Theater Aurora. Book your tickets now for unforgettable performances.">
    <meta name="keywords" content="theater, performing arts, live shows, drama, musical, entertainment">
    <meta name="author" content="Theater Aurora">
    <meta name="theme-color" content="#1a1a2e">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?> | Theater Aurora">
    <meta property="og:description" content="Experience the magic of live theater at Theater Aurora. Book your tickets now for unforgettable performances.">
    <meta property="og:image" content="/assets/images/theater-og.jpg">
    <meta property="og:url" content="<?= $_ENV['APP_URL'] . $_SERVER['REQUEST_URI'] ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/images/favicon.png">
    <link rel="apple-touch-icon" href="/assets/images/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <!-- Page-specific CSS -->
    <?php if (isset($pageStyles)): ?>
        <?php foreach ($pageStyles as $style): ?>
            <link rel="stylesheet" href="<?= $style ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Progressive Web App -->
    <link rel="manifest" href="/manifest.json">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Custom Header Scripts -->
    <?= $headerScripts ?? '' ?>
</head>
<body class="<?= $bodyClass ?? '' ?>">
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-content">
            <i class="fas fa-theater-masks fa-spin"></i>
            <span>Loading...</span>
        </div>
    </div>

    <!-- Development Environment Banner -->
    <?php if ($_ENV['APP_ENV'] !== 'production'): ?>
        <div class="dev-banner">
            <div class="dev-banner-content">
                <i class="fas fa-code"></i>
                <span>Development Environment</span>
                <div class="dev-info">
                    <span>UTC: <?= $currentTime->format('Y-m-d H:i:s') ?></span>
                    <span>User: <?= htmlspecialchars($currentUser['email'] ?? 'Guest') ?></span>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Navigation -->
    <?php include __DIR__ . '/../components/navbar.php'; ?>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Flash Messages -->
        <?php if ($flash = $session->getFlash()): ?>
            <div class="flash-messages">
                <?php foreach ($flash as $type => $message): ?>
                    <div class="flash-message <?= $type ?>" role="alert">
                        <div class="flash-content">
                            <i class="fas fa-<?= $type === 'success' ? 'check-circle' : ($type === 'error' ? 'exclamation-circle' : 'info-circle') ?>"></i>
                            <span><?= htmlspecialchars($message) ?></span>
                        </div>
                        <button class="flash-close" aria-label="Close message">&times;</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Page Content -->
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <i class="fas fa-theater-masks"></i>
                    <h3>Theater Aurora</h3>
                    <p>Experience the magic of live performance</p>
                </div>

                <div class="footer-links">
                    <div class="footer-section">
                        <h4>Quick Links</h4>
                        <ul>
                            <li><a href="/shows">Shows</a></li>
                            <li><a href="/events">Events</a></li>
                            <li><a href="/about">About</a></li>
                            <li><a href="/contact">Contact</a></li>
                        </ul>
                    </div>

                    <div class="footer-section">
                        <h4>Support</h4>
                        <ul>
                            <li><a href="/faq">FAQ</a></li>
                            <li><a href="/terms">Terms of Service</a></li>
                            <li><a href="/privacy">Privacy Policy</a></li>
                            <li><a href="/accessibility">Accessibility</a></li>
                        </ul>
                    </div>

                    <div class="footer-section">
                        <h4>Connect</h4>
                        <div class="social-links">
                            <a href="#" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                            <a href="#" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> Theater Aurora. All rights reserved.</p>
                <div class="tech-stack">
                    <span>Powered by PHP <?= PHP_VERSION ?></span>
                    <span class="separator">|</span>
                    <span>Server Time (UTC): <?= $currentTime->format('Y-m-d H:i:s') ?></span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modals Container -->
    <div id="modalsContainer"></div>

    <!-- Cookie Consent -->
    <?php if (!$session->get('cookie_consent')): ?>
        <div class="cookie-consent" id="cookieConsent">
            <div class="cookie-content">
                <i class="fas fa-cookie-bite"></i>
                <p>We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies.</p>
                <div class="cookie-actions">
                    <button class="btn btn-primary" id="acceptCookies">Accept</button>
                    <button class="btn btn-outline" id="cookieSettings">Settings</button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Core Scripts -->
    <script src="/assets/js/app.js"></script>
    <script>
        // Initialize app with configuration
        window.App = {
            baseUrl: '<?= $_ENV['APP_URL'] ?>',
            csrfToken: '<?= $session->get('csrf_token') ?>',
            user: <?= $currentUser ? json_encode($currentUser) : 'null' ?>,
            debug: <?= $_ENV['APP_DEBUG'] ? 'true' : 'false' ?>,
            environment: '<?= $_ENV['APP_ENV'] ?>',
            currentTime: '<?= $currentTime->format('Y-m-d\TH:i:s\Z') ?>'
        };
    </script>

    <!-- Page-specific Scripts -->
    <?php if (isset($pageScripts)): ?>
        <?php foreach ($pageScripts as $script): ?>
            <script src="<?= $script ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Custom Footer Scripts -->
    <?= $footerScripts ?? '' ?>

    <!-- Performance Metrics (Development Only) -->
    <?php if ($_ENV['APP_ENV'] !== 'production'): ?>
        <script>
            console.log('Page Load Metrics:', {
                loadTime: window.performance.now(),
                resources: performance.getEntriesByType('resource').length,
                timestamp: '<?= $currentTime->format('Y-m-d H:i:s') ?>'
            });
        </script>
    <?php endif; ?>
</body>
</html>