<?php
require_once __DIR__ . '/../../../includes/admin_auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['action'])) {
    $token = $_POST['_csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        http_response_code(403);
        echo 'CSRF doğrulaması başarısız';
        exit;
    }
    $id = (int)$_POST['id'];
    $action = $_POST['action'];

    if ($action === 'confirm') {
        update_reservation_status($id, 'confirmed');
        echo 'OK';
    } elseif ($action === 'cancel') {
        update_reservation_status($id, 'cancelled');
        echo 'OK';
    } else {
        http_response_code(400);
        echo 'Geçersiz işlem';
    }
} else {
    http_response_code(400);
    echo 'Hatalı istek';
}
