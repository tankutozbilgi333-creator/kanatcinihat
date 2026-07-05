<?php require_once __DIR__ . '/../../includes/header.php';
$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$order = get_order($order_id);

if (!$order) {
    redirect(SITE_URL . '/admin/orders');
}

$items = get_order_items($order_id);
?>

<div class="admin-order-detail">
    <div class="admin-page-header">
        <h1>Sipariş Detayı #<?php echo $order['id']; ?></h1>
        <a href="/admin/orders" class="btn btn-secondary">Geri Dön</a>
    </div>

    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Müşteri</h3>
            <p style="font-size:1.1rem;"><?php echo $order['customer_name']; ?></p>
        </div>
        <div class="stat-card">
            <h3>Telefon</h3>
            <p style="font-size:1.1rem;"><?php echo $order['customer_phone']; ?></p>
        </div>
        <div class="stat-card">
            <h3>Tutar</h3>
            <p style="font-size:1.1rem; color: var(--color-primary);">₺<?php echo number_format($order['total_price'], 2); ?></p>
        </div>
        <div class="stat-card">
            <h3>Durum</h3>
            <p style="font-size:1.1rem;">
                <?php
                $status_labels = ['new' => 'Yeni', 'preparing' => 'Hazırlanıyor', 'done' => 'Tamamlandı', 'cancelled' => 'İptal'];
                echo $status_labels[$order['status']] ?? $order['status'];
                ?>
            </p>
        </div>
    </div>

    <div class="stat-card" style="margin-top: 1rem; padding: 1.5rem;">
        <h3>Teslimat Adresi</h3>
        <p><?php echo $order['customer_address']; ?></p>
        <?php if ($order['note']): ?>
            <h3 style="margin-top: 1rem;">Not</h3>
            <p><?php echo $order['note']; ?></p>
        <?php endif; ?>
    </div>

    <h2 style="margin: 2rem 0 1rem;">Sipariş Kalemleri</h2>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Ürün</th>
                <th>Adet</th>
                <th>Birim Fiyat</th>
                <th>Toplam</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo $item['product_name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₺<?php echo number_format($item['unit_price'], 2); ?></td>
                    <td>₺<?php echo number_format($item['quantity'] * $item['unit_price'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align:right;">Toplam:</th>
                <th>₺<?php echo number_format($order['total_price'], 2); ?></th>
            </tr>
        </tfoot>
    </table>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
