<?php
$settings = get_all_settings();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validate_csrf();
    foreach ($_POST as $key => $value) {
        if ($key !== 'save') {
            set_setting($key, sanitize_input($value));
        }
    }
    set_flash_message('success', 'Ayarlar başarıyla kaydedildi.');
    redirect(SITE_URL . '/admin/settings');
}

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="admin-settings">
    <div class="admin-page-header">
        <h1>Site Ayarları</h1>
    </div>

    <form action="" method="POST" class="admin-product-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="site_title">Restoran Adı</label>
            <input type="text" id="site_title" name="site_title" value="<?php echo $settings['site_title'] ?? 'Kanatçı Nihat'; ?>">
        </div>

        <div class="form-group">
            <label for="site_slogan">Slogan</label>
            <input type="text" id="site_slogan" name="site_slogan" value="<?php echo $settings['site_slogan'] ?? 'Gaziantep\'in En Lezzetli Kanadı'; ?>">
        </div>

        <div class="form-group">
            <label for="address">Adres</label>
            <textarea id="address" name="address" rows="2"><?php echo $settings['address'] ?? ''; ?></textarea>
        </div>

        <div class="form-group">
            <label for="phone">Telefon</label>
            <input type="text" id="phone" name="phone" value="<?php echo $settings['phone'] ?? ''; ?>">
        </div>

        <div class="form-group">
            <label for="email">E-posta</label>
            <input type="email" id="email" name="email" value="<?php echo $settings['email'] ?? ''; ?>">
        </div>

        <div class="form-group">
            <label for="latitude">Enlem (Latitude)</label>
            <input type="text" id="latitude" name="latitude" value="<?php echo $settings['latitude'] ?? ''; ?>" placeholder="Örn: 37.0662">
        </div>

        <div class="form-group">
            <label for="longitude">Boylam (Longitude)</label>
            <input type="text" id="longitude" name="longitude" value="<?php echo $settings['longitude'] ?? ''; ?>" placeholder="Örn: 37.3833">
        </div>

        <div class="form-group">
            <label for="working_hours">Çalışma Saatleri</label>
            <input type="text" id="working_hours" name="working_hours" value="<?php echo $settings['working_hours'] ?? ''; ?>" placeholder="Örn: 10:00 - 23:00">
        </div>

        <div class="form-group">
            <label for="instagram">Instagram</label>
            <input type="text" id="instagram" name="instagram" value="<?php echo $settings['instagram'] ?? ''; ?>">
        </div>

        <div class="form-group">
            <label for="facebook">Facebook</label>
            <input type="text" id="facebook" name="facebook" value="<?php echo $settings['facebook'] ?? ''; ?>">
        </div>

        <div class="form-group">
            <label for="twitter">Twitter</label>
            <input type="text" id="twitter" name="twitter" value="<?php echo $settings['twitter'] ?? ''; ?>">
        </div>

        <button type="submit" name="save" class="btn btn-primary">Ayarları Kaydet</button>
    </form>

    <div class="qr-section" style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--color-border);">
        <h2 style="font-family: var(--font-heading); margin-bottom: 1rem;">QR Kod</h2>
        <p style="color: var(--color-text-muted); margin-bottom: 1rem;">Müşterileriniz QR kod okutarak menüye erişebilir.</p>
        <div class="qr-preview" style="margin-bottom: 1rem;">
            <img src="/admin/qr_preview" alt="QR Kod" style="border: 1px solid var(--color-border); border-radius: 8px; padding: 8px; background: #fff; max-width: 200px;">
        </div>
        <a href="/admin/qr_download" class="btn btn-primary">QR Kodu İndir</a>
    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
