<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<div class="admin-dashboard">
    <h1>Admin Paneli</h1>
    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Toplam Ürün</h3>
            <p class="stat-number"><?php echo get_product_count(); ?></p>
        </div>
        <div class="stat-card">
            <h3>Aktif Sipariş</h3>
            <p class="stat-number"><?php echo get_order_count('new'); ?></p>
        </div>
        <div class="stat-card">
            <h3>Okunmamış Mesaj</h3>
            <p class="stat-number"><?php echo get_unread_message_count(); ?></p>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
