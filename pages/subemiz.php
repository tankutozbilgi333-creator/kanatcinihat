<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="branch-page">
    <div class="branch-header">
        <span class="section-label">— NEREDE BİZ? —</span>
        <h1>Şubemiz ve Ulaşım</h1>
    </div>

    <div class="branch-content">
        <div class="branch-info">
            <div class="info-card">
                <h3>Adres</h3>
                <p><?php echo get_setting('address') ?: 'Adres bilgisi girilmemiş.'; ?></p>
            </div>
            <div class="info-card">
                <h3>Telefon</h3>
                <p><a href="tel:<?php echo get_setting('phone'); ?>"><?php echo get_setting('phone') ?: 'Telefon bilgisi girilmemiş.'; ?></a></p>
            </div>
            <div class="info-card">
                <h3>Çalışma Saatleri</h3>
                <p><?php echo get_setting('working_hours') ?: 'Çalışma saatleri girilmemiş.'; ?></p>
            </div>
            <a href="tel:<?php echo get_setting('phone'); ?>" class="btn btn-primary">Ara</a>
        </div>
        <div class="branch-map">
            <div id="map" style="height: 400px; border-radius: 12px;"></div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var lat = <?php echo get_setting('latitude') ?: '37.0662'; ?>;
    var lng = <?php echo get_setting('longitude') ?: '37.3833'; ?>;
    var map = L.map('map').setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);
    L.marker([lat, lng]).addTo(map);
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
