<?php
require_once __DIR__ . '/../../../includes/admin_auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    validate_csrf();
    $id = (int)$_POST['id'];
    delete_table($id);
    set_flash_message('success', 'Masa başarıyla silindi.');
}

redirect(SITE_URL . '/admin/tables');
