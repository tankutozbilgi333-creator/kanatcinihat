<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanatçı Nihat</title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/main.css">
    <?php if (isset($is_admin_area) && $is_admin_area): ?>
        <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin.css">
        <meta name="csrf-token" content="<?php echo generate_csrf_token(); ?>">
    <?php endif; ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <?php if (isset($is_admin_area) && $is_admin_area): ?>
        <header class="admin-header">
            <nav class="admin-nav">
                <div class="admin-logo">Kanatçı Nihat Admin</div>
                <ul>
                    <li><a href="<?php echo SITE_URL; ?>/admin">Dashboard</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/admin/products">Ürünler</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/admin/orders">Siparişler</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/admin/reservations">Rezervasyonlar</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/admin/tables">Masalar</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/admin/messages">Mesajlar</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/admin/settings">Ayarlar</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/admin/logout">Çıkış</a></li>
                </ul>
            </nav>
        </header>
    <?php else: ?>
        <header class="site-header">
            <nav class="main-nav">
                <div class="logo">Kanatçı Nihat</div>
                <button class="menu-toggle">☰</button>
                <ul>
                    <li><a href="<?php echo SITE_URL; ?>/#anasayfa">Anasayfa</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/#menu">Menü</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/#subemiz">Şubemiz</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/#iletisim">İletişim</a></li>
                </ul>
            </nav>
        </header>
    <?php endif; ?>

    <main>
    <?php $flash_success = get_flash_message('success'); ?>
    <?php $flash_error = get_flash_message('error'); ?>
    <?php if ($flash_success): ?>
        <div class="alert alert-success"><?php echo $flash_success['message']; ?></div>
    <?php endif; ?>
    <?php if ($flash_error): ?>
        <div class="alert alert-danger"><?php echo $flash_error['message']; ?></div>
    <?php endif; ?>