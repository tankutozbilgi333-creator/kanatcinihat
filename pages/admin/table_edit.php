<?php
require_once __DIR__ . '/../../includes/admin_auth.php';

$edit_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$table = null;

if ($edit_id) {
    $table = get_table($edit_id);
    if (!$table) {
        redirect(SITE_URL . '/admin/tables');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validate_csrf();
    $data = [
        'table_number' => (int)$_POST['table_number'],
        'capacity' => (int)$_POST['capacity'],
        'status' => $_POST['status'] ?? 'active'
    ];

    if ($edit_id) {
        update_table($edit_id, $data);
        set_flash_message('success', 'Masa başarıyla güncellendi.');
    } else {
        create_table($data);
        set_flash_message('success', 'Masa başarıyla eklendi.');
    }

    redirect(SITE_URL . '/admin/tables');
}

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="admin-table-form">
    <div class="admin-page-header">
        <h1><?php echo $edit_id ? 'Masa Düzenle' : 'Yeni Masa Ekle'; ?></h1>
        <a href="/admin/tables" class="btn btn-secondary">Geri Dön</a>
    </div>

    <form action="" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="table_number">Masa Numarası</label>
            <input type="number" id="table_number" name="table_number" value="<?php echo $table['table_number'] ?? ''; ?>" required min="1">
        </div>

        <div class="form-group">
            <label for="capacity">Kapasite (Kişi Sayısı)</label>
            <input type="number" id="capacity" name="capacity" value="<?php echo $table['capacity'] ?? ''; ?>" required min="1">
        </div>

        <div class="form-group">
            <label for="status">Durum</label>
            <select id="status" name="status">
                <option value="active" <?php echo ($table && $table['status'] === 'active') ? 'selected' : ''; ?>>Aktif</option>
                <option value="maintenance" <?php echo ($table && $table['status'] === 'maintenance') ? 'selected' : ''; ?>>Bakımda</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary"><?php echo $edit_id ? 'Güncelle' : 'Kaydet'; ?></button>
    </form>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
