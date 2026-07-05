<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<div class="admin-products">
    <div class="admin-page-header">
        <h1>Ürün Yönetimi</h1>
        <a href="/admin/product_edit" class="btn btn-primary">+ Yeni Ürün</a>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Görsel</th>
                <th>Ürün Adı</th>
                <th>Kategori</th>
                <th>Fiyat</th>
                <th>Rozet</th>
                <th>Durum</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php $products = get_products(); ?>
            <?php if (empty($products)): ?>
                <tr><td colspan="8">Henüz ürün eklenmemiş.</td></tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td>
                            <?php if ($product['image_path']): ?>
                                <img src="<?php echo SITE_URL; ?>/assets/uploads/<?php echo $product['image_path']; ?>" alt="<?php echo $product['name']; ?>" width="50">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['category_name'] ?? 'Kategorisiz'; ?></td>
                        <td>₺<?php echo number_format($product['price'], 2); ?></td>
                        <td><?php echo $product['badge'] ?: '-'; ?></td>
                        <td><?php echo $product['is_active'] ? 'Aktif' : 'Pasif'; ?></td>
                        <td class="actions">
                            <a href="/admin/product_edit?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-edit">Düzenle</a>
                            <form method="POST" action="/admin/product_delete" style="display:inline;" onsubmit="return confirmDelete('<?php echo addslashes($product['name']); ?>')">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
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
