<?php
// Mesaj detay sayfası
if (isset($_GET['view'])) {
    $message = get_message((int)$_GET['view']);
    if (!$message) {
        redirect(SITE_URL . '/admin/messages');
    }
    mark_message_read((int)$_GET['view']);
    require_once __DIR__ . '/../../includes/header.php';
?>
<div class="admin-orders">
    <div class="admin-page-header">
        <h1>Mesaj Detayı</h1>
        <a href="/admin/messages" class="btn btn-secondary">Geri Dön</a>
    </div>
    <div class="order-detail" style="max-width:600px;">
        <p><strong>Gönderen:</strong> <?php echo $message['name']; ?></p>
        <p><strong>E-posta:</strong> <?php echo $message['email'] ?: '-'; ?></p>
        <p><strong>Tarih:</strong> <?php echo date('d.m.Y H:i', strtotime($message['created_at'])); ?></p>
        <div style="margin-top:1rem; padding:1rem; background:#f5f5f5; border-radius:8px;">
            <?php echo nl2br($message['message']); ?>
        </div>
    </div>
</div>
<?php
    require_once __DIR__ . '/../../includes/footer.php';
    exit;
}

require_once __DIR__ . '/../../includes/header.php';
?>
<div class="admin-orders">
    <div class="admin-page-header">
        <h1>Mesaj Yönetimi</h1>
    </div>

    <?php $messages = get_messages(); ?>
    <?php if (empty($messages)): ?>
        <p>Henüz mesaj bulunmuyor.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ad</th>
                    <th>E-posta</th>
                    <th>Mesaj</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $msg): ?>
                    <tr style="<?php echo $msg['is_read'] ? '' : 'font-weight: bold;'; ?>">
                        <td><?php echo $msg['id']; ?></td>
                        <td><?php echo $msg['name']; ?></td>
                        <td><?php echo $msg['email'] ?: '-'; ?></td>
                        <td><?php echo mb_substr($msg['message'], 0, 50); ?>...</td>
                        <td><?php echo $msg['is_read'] ? 'Okundu' : 'Okunmadı'; ?></td>
                        <td><?php echo date('d.m.Y H:i', strtotime($msg['created_at'])); ?></td>
                        <td>
                            <a href="/admin/messages?view=<?php echo $msg['id']; ?>" class="btn btn-sm btn-primary">Görüntüle</a>
                            <?php if (!$msg['is_read']): ?>
                                <button class="btn btn-sm btn-secondary mark-read-btn" data-message-id="<?php echo $msg['id']; ?>">Okundu İşaretle</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
