<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

// URL rotasını belirle (alt dizin desteği ile)
$script_name = $_SERVER['SCRIPT_NAME'];
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_path = rtrim(dirname($script_name), '\/');
$route = '/' . trim(substr($request_uri, strlen($base_path)), '/');

// Admin sayfaları
if (strpos($route, '/admin') === 0) {
    $is_admin_area = true;
    require_once __DIR__ . '/../includes/admin_auth.php';

    $admin_page = trim(substr($route, 6), '/') ?: 'dashboard';

    // Çıkış işlemi
    if ($admin_page === 'logout') {
        admin_logout();
    }

    // Login sayfası hariç oturum kontrolü
    if ($admin_page !== 'login' && !is_admin_logged_in()) {
        redirect(SITE_URL . '/admin/login');
    }

    // AJAX handler'ları (POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $handler_file = __DIR__ . '/../pages/admin/_handlers/' . $admin_page . '.php';
        if (file_exists($handler_file)) {
            require_once $handler_file;
            exit;
        }
    }

    $admin_file = __DIR__ . '/../pages/admin/' . $admin_page . '.php';
    if (file_exists($admin_file)) {
        require_once $admin_file;
    } else {
        http_response_code(404);
        echo '404 - Sayfa Bulunamadı';
    }
} else {
    // Genel sayfalar
    $page = trim($route, '/') ?: 'home';

    // Tek sayfa anchor yönlendirmeleri
    $anchor_map = [
        'menu' => '#menu',
        'subemiz' => '#subemiz',
        'iletisim' => '#iletisim',
    ];
    if (isset($anchor_map[$page]) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        redirect('/' . $anchor_map[$page]);
    }

    if ($page === 'siparis' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once __DIR__ . '/../pages/order_process.php';
    } else {
        $file_path = __DIR__ . '/../pages/' . $page . '.php';
        if (file_exists($file_path)) {
            require_once $file_path;
        } else {
            http_response_code(404);
            require_once __DIR__ . '/../pages/404.php';
        }
    }
}
