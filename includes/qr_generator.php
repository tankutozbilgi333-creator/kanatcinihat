<?php

require_once __DIR__ . '/phpqrcode.php';

function generate_qr_code($url, $size = 300, $filename = null) {
    QRcode::png($url, $filename, QR_ECLEVEL_L, $size > 300 ? floor($size / 15) : 10, 2);
}

function output_qr_code($url, $size = 300) {
    header('Content-Type: image/png');
    QRcode::png($url, false, QR_ECLEVEL_L, $size > 300 ? floor($size / 15) : 10, 2);
    exit;
}
