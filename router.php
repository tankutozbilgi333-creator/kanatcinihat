<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . '/public' . $uri;

if (file_exists($file) && !is_dir($file)) {
    if (php_sapi_name() === 'cli-server') {
        $mime_types = [
            'css' => 'text/css',
            'js'  => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg'=> 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon',
            'webp'=> 'image/webp',
            'woff'=> 'font/woff',
            'woff2'=>'font/woff2',
        ];
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if (isset($mime_types[$ext])) {
            header('Content-Type: ' . $mime_types[$ext]);
        }
        readfile($file);
        return true;
    }
    return false;
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
require __DIR__ . '/public/index.php';
