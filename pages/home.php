<?php
// İletişim form gönderimi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    require_once __DIR__ . '/../includes/functions.php';
    validate_csrf();
    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $message = sanitize_input($_POST['message'] ?? '');
    if ($name && $message) {
        create_message($name, $email, $message);
        set_flash_message('success', 'Mesajınız başarıyla gönderildi.');
        redirect('/#iletisim');
    } else {
        set_flash_message('error', 'Lütfen ad ve mesaj alanlarını doldurun.');
        redirect('/#iletisim');
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<?php require __DIR__ . '/sections/hero.php'; ?>
<?php require __DIR__ . '/sections/menu_section.php'; ?>
<?php require __DIR__ . '/sections/branch_section.php'; ?>
<?php require __DIR__ . '/sections/contact_section.php'; ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="/assets/js/cart.js"></script>
<script>
    var lat = <?php echo get_setting('latitude') ?: '37.0662'; ?>;
    var lng = <?php echo get_setting('longitude') ?: '37.3833'; ?>;
    var map = L.map('map').setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);
    L.marker([lat, lng]).addTo(map);

    // Smooth scroll for anchor links
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                var target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
        // Scroll to anchor on page load (if URL has hash)
        if (window.location.hash) {
            var target = document.querySelector(window.location.hash);
            if (target) {
                setTimeout(function() {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            }
        }
    });
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
