<?php
require_once __DIR__ . '/../../../includes/admin_auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['status'])) {
    $token = $_POST['_csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        http_response_code(403);
        echo 'CSRF doğrulaması başarısız';
        exit;
    }
    $id = (int)$_POST['id'];
    $status = sanitize_input($_POST['status']);
    update_order_status($id, $status);
    echo 'OK';
} else {
    http_response_code(400);
    echo 'Hatalı istek';
}
