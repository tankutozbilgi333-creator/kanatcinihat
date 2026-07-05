<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<div class="admin-tables">
    <div class="admin-page-header">
        <h1>Masa Yönetimi</h1>
        <a href="/admin/table_edit" class="btn btn-primary">+ Yeni Masa</a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Masa No</th>
                <th>Kapasite</th>
                <th>Durum</th>
                <th>Oluşturulma</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php $tables = get_tables(); ?>
            <?php if (empty($tables)): ?>
                <tr><td colspan="6">Henüz masa eklenmemiş.</td></tr>
            <?php else: ?>
                <?php foreach ($tables as $table): ?>
                    <tr>
                        <td><?php echo $table['id']; ?></td>
                        <td>Masa <?php echo $table['table_number']; ?></td>
                        <td><?php echo $table['capacity']; ?> Kişilik</td>
                        <td>
                            <span class="reservation-status status-<?php echo $table['status'] === 'active' ? 'confirmed' : 'cancelled'; ?>">
                                <?php echo $table['status'] === 'active' ? 'Aktif' : 'Bakımda'; ?>
                            </span>
                        </td>
                        <td><?php echo date('d.m.Y', strtotime($table['created_at'])); ?></td>
                        <td class="actions">
                            <a href="/admin/table_edit?id=<?php echo $table['id']; ?>" class="btn btn-sm btn-edit">Düzenle</a>
                            <form method="POST" action="/admin/table_delete" style="display:inline;" onsubmit="return confirm('Masa <?php echo $table['table_number']; ?> silinecek. Emin misiniz?')">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo $table['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-delete">Sil</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
