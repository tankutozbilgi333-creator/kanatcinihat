<?php

require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/functions.php';

// Giriş işlemi (header çıktısından ÖNCE)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validate_csrf();
    $username = sanitize_input($_POST['username']);
    $password = $_POST['password'];

    if (admin_login($username, $password)) {
        redirect(SITE_URL . '/admin');
    }
}

require_once __DIR__ . '/../../includes/header.php';

$flash_error = get_flash_message('error');

?>

<div class="admin-login-container">
    <h2>Admin Girişi</h2>
    <?php if ($flash_error): ?>
        <div class="alert alert-danger"><?php echo $flash_error['message']; ?></div>
    <?php endif; ?>
    <form action="/admin/login" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Giriş Yap</button>
    </form>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>