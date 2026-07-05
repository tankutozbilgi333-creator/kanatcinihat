<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . '/public' . $uri;

if (file_exists($file) && !is_dir($file)) {
    return false;
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
require __DIR__ . '/public/index.php';
