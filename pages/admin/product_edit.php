<?php
require_once __DIR__ . '/../../includes/admin_auth.php';

$edit_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$product = null;
$categories = get_categories();

if ($edit_id) {
    $product = get_product($edit_id);
    if (!$product) {
        redirect(SITE_URL . '/admin/products');
    }
}

// Form gönderimi (header öncesi)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validate_csrf();
    $data = [
        'category_id' => (int)$_POST['category_id'],
        'name' => sanitize_input($_POST['name']),
        'description' => sanitize_input($_POST['description']),
        'price' => (float)$_POST['price'],
        'image_path' => $product['image_path'] ?? '',
        'badge' => sanitize_input($_POST['badge']),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
        'sort_order' => (int)$_POST['sort_order']
    ];

    // Görsel yükleme
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $upload = upload_image($_FILES['image'], __DIR__ . '/../../public/assets/uploads');
        if ($upload['success']) {
            $data['image_path'] = $upload['path'];
        } else {
            set_flash_message('error', $upload['error']);
        }
    }

    if ($edit_id) {
        update_product($edit_id, $data);
        set_flash_message('success', 'Ürün başarıyla güncellendi.');
    } else {
        create_product($data);
        set_flash_message('success', 'Ürün başarıyla eklendi.');
    }

    redirect(SITE_URL . '/admin/products');
}

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="admin-product-form">
    <div class="admin-page-header">
        <h1><?php echo $edit_id ? 'Ürün Düzenle' : 'Yeni Ürün Ekle'; ?></h1>
        <a href="/admin/products" class="btn btn-secondary">Geri Dön</a>
    </div>

    <form action="" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="name">Ürün Adı</label>
            <input type="text" id="name" name="name" value="<?php echo $product['name'] ?? ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="category_id">Kategori</label>
            <select id="category_id" name="category_id" required>
                <option value="">Kategori Seç</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo ($product && $product['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                        <?php echo $cat['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Açıklama</label>
            <textarea id="description" name="description" rows="3"><?php echo $product['description'] ?? ''; ?></textarea>
        </div>

        <div class="form-group">
            <label for="price">Fiyat (₺)</label>
            <input type="number" id="price" name="price" step="0.01" value="<?php echo $product['price'] ?? ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="image">Görsel</label>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">
            <?php if ($product && $product['image_path']): ?>
                <div class="image-preview">
                    <img src="<?php echo SITE_URL; ?>/assets/uploads/<?php echo $product['image_path']; ?>" alt="Önizleme" width="100">
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="badge">Rozet</label>
            <select id="badge" name="badge">
                <option value="">Yok</option>
                <option value="popular" <?php echo ($product && $product['badge'] === 'popular') ? 'selected' : ''; ?>>Popüler ⭐</option>
                <option value="new" <?php echo ($product && $product['badge'] === 'new') ? 'selected' : ''; ?>>Yeni 🔥</option>
                <option value="spicy" <?php echo ($product && $product['badge'] === 'spicy') ? 'selected' : ''; ?>>Acılı 🌶️</option>
            </select>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" <?php echo (!$product || $product['is_active']) ? 'checked' : ''; ?>>
                Aktif
            </label>
        </div>

        <div class="form-group">
            <label for="sort_order">Sıralama</label>
            <input type="number" id="sort_order" name="sort_order" value="<?php echo $product['sort_order'] ?? 0; ?>">
        </div>

        <button type="submit" class="btn btn-primary"><?php echo $edit_id ? 'Güncelle' : 'Kaydet'; ?></button>
    </form>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
