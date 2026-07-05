<?php

define('DB_PATH', __DIR__ . '/../database/kanatci.sqlite');

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$base_path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
define('SITE_URL', $protocol . '://' . $host . $base_path);

// Admin kullanıcı bilgileri
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD_HASH', password_hash('123456', PASSWORD_DEFAULT));

?>