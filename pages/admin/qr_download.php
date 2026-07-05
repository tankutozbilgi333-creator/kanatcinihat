<?php
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/qr_generator.php';

$qr_url = rtrim(SITE_URL, '/') . '/qr-menu';

$filename = 'kanatci-nihat-qr.png';

header('Content-Type: image/png');
header('Content-Disposition: attachment; filename="' . $filename . '"');

QRcode::png($qr_url, false, QR_ECLEVEL_L, 10, 2);
exit;
