<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<div class="admin-orders">
    <div class="admin-page-header">
        <h1>Sipariş Yönetimi</h1>
    </div>

    <?php $orders = get_orders(); ?>
    <?php if (empty($orders)): ?>
        <p>Henüz sipariş bulunmuyor.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Sipariş No</th>
                    <th>Müşteri</th>
                    <th>Telefon</th>
                    <th>Tutar</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td><?php echo $order['customer_name']; ?></td>
                        <td><?php echo $order['customer_phone']; ?></td>
                        <td>₺<?php echo number_format($order['total_price'], 2); ?></td>
                        <td>
                            <select class="order-status-select" data-order-id="<?php echo $order['id']; ?>">
                                <option value="new" <?php echo $order['status'] === 'new' ? 'selected' : ''; ?>>Yeni</option>
                                <option value="preparing" <?php echo $order['status'] === 'preparing' ? 'selected' : ''; ?>>Hazırlanıyor</option>
                                <option value="done" <?php echo $order['status'] === 'done' ? 'selected' : ''; ?>>Tamamlandı</option>
                                <option value="cancelled" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>İptal</option>
                            </select>
                        </td>
                        <td><?php echo date('d.m.Y H:i', strtotime($order['created_at'])); ?></td>
                        <td><a href="/admin/order_detail?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-primary">Detay</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
