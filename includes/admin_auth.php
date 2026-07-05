<?php

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/../config/app.php';

function is_admin_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function admin_login($username, $password) {
    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        set_flash_message('success', 'Giriş başarılı!');
        return true;
    }
    set_flash_message('error', 'Kullanıcı adı veya şifre hatalı.');
    return false;
}

function admin_logout() {
    session_unset();
    session_destroy();
    redirect(SITE_URL . '/admin/login');
}
