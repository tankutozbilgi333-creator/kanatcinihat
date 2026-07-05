<?php
require_once __DIR__ . '/../../includes/header.php';

$status_filter = isset($_GET['status']) ? sanitize_for_db($_GET['status']) : null;
$reservations = get_reservations($status_filter);
?>
<div class="admin-reservations">
    <div class="admin-page-header">
        <h1>Rezervasyon Yönetimi</h1>
        <div class="filter-tabs">
            <a href="?status=" class="btn btn-sm <?php echo !$status_filter ? 'btn-primary' : 'btn-secondary'; ?>">Tümü</a>
            <a href="?status=pending" class="btn btn-sm <?php echo $status_filter === 'pending' ? 'btn-primary' : 'btn-secondary'; ?>">Bekleyen</a>
            <a href="?status=confirmed" class="btn btn-sm <?php echo $status_filter === 'confirmed' ? 'btn-primary' : 'btn-secondary'; ?>">Onaylanan</a>
            <a href="?status=cancelled" class="btn btn-sm <?php echo $status_filter === 'cancelled' ? 'btn-primary' : 'btn-secondary'; ?>">İptal</a>
        </div>
    </div>

    <?php if (empty($reservations)): ?>
        <p>Rezervasyon bulunmuyor.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Müşteri</th>
                    <th>Telefon</th>
                    <th>Kişi</th>
                    <th>Tarih</th>
                    <th>Saat</th>
                    <th>Masa</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $res): ?>
                    <tr class="reservation-row reservation-<?php echo $res['status']; ?>">
                        <td><?php echo $res['id']; ?></td>
                        <td><?php echo htmlspecialchars($res['name']); ?></td>
                        <td><?php echo htmlspecialchars($res['phone']); ?></td>
                        <td><?php echo $res['guest_count']; ?></td>
                        <td><?php echo date('d.m.Y', strtotime($res['reservation_date'])); ?></td>
                        <td><?php echo $res['reservation_time']; ?></td>
                        <td><?php echo $res['table_number'] ? 'Masa ' . $res['table_number'] : '-'; ?></td>
                        <td>
                            <span class="reservation-status status-<?php echo $res['status']; ?>">
                                <?php if ($res['status'] === 'pending'): ?>Bekliyor
                                <?php elseif ($res['status'] === 'confirmed'): ?>Onaylandı
                                <?php else: ?>İptal
                                <?php endif; ?>
                            </span>
                        </td>
                        <td class="actions">
                            <?php if ($res['status'] === 'pending'): ?>
                                <button class="btn btn-sm btn-success reservation-action" data-id="<?php echo $res['id']; ?>" data-action="confirm">Onayla</button>
                                <button class="btn btn-sm btn-delete reservation-action" data-id="<?php echo $res['id']; ?>" data-action="cancel">İptal Et</button>
                            <?php elseif ($res['status'] === 'confirmed'): ?>
                                <button class="btn btn-sm btn-delete reservation-action" data-id="<?php echo $res['id']; ?>" data-action="cancel">İptal Et</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if ($res['note']): ?>
                    <tr class="reservation-note-row">
                        <td colspan="9"><strong>Not:</strong> <?php echo htmlspecialchars($res['note']); ?></td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
