<?php
require_once __DIR__ . '/../includes/header.php';
?>

<div class="reservation-page">
    <div class="reservation-header">
        <span class="section-label">— REZERVASYON —</span>
        <h1>Masa Ayırtın</h1>
        <p>Özel günlerinizde veya canınız çektiğinde yerinizi ayırtmak için rezervasyon formunu doldurun.</p>
    </div>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_reservation'])): ?>
        <?php
        validate_csrf();
        $table_id = (int)$_POST['table_id'];
        $date = sanitize_for_db($_POST['date']);
        $time = sanitize_for_db($_POST['time']);
        $guest_count = (int)$_POST['guest_count'];

        if (!is_table_available($table_id, $date, $time)) {
            set_flash_message('error', 'Seçilen masa artık müsait değil. Lütfen tekrar deneyin.');
            redirect(SITE_URL . '/rezervasyon');
        }

        $name = sanitize_for_db($_POST['name']);
        $phone = sanitize_for_db($_POST['phone']);
        $note = sanitize_for_db($_POST['note'] ?? '');

        create_reservation([
            'name' => $name,
            'phone' => $phone,
            'guest_count' => $guest_count,
            'reservation_date' => $date,
            'reservation_time' => $time,
            'table_id' => $table_id,
            'note' => $note
        ]);

        set_flash_message('success', 'Rezervasyon talebiniz alındı! En kısa sürede sizinle iletişime geçip onaylayacağız.');
        redirect(SITE_URL . '/rezervasyon');
        ?>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_availability'])): ?>
        <?php
        validate_csrf();
        $date = sanitize_for_db($_POST['date']);
        $time = sanitize_for_db($_POST['time']);
        $guest_count = (int)$_POST['guest_count'];

        $selected_date = $date;
        $selected_time = $time;
        $selected_guests = $guest_count;

        $available_tables = get_available_tables($date, $time, $guest_count);
        ?>
        <div class="reservation-form-card">
            <div class="reservation-summary">
                <span><strong>Tarih:</strong> <?php echo date('d.m.Y', strtotime($date)); ?></span>
                <span><strong>Saat:</strong> <?php echo $time; ?></span>
                <span><strong>Kişi:</strong> <?php echo $guest_count; ?></span>
                <a href="<?php echo SITE_URL; ?>/rezervasyon" class="btn btn-sm btn-secondary">Geri Dön</a>
            </div>

            <?php if (empty($available_tables)): ?>
                <div class="reservation-empty">
                    <p>Maalesef seçtiğiniz tarih ve saatte uygun masa bulunamadı.</p>
                    <p>Lütfen farklı bir tarih veya saat deneyin.</p>
                    <a href="<?php echo SITE_URL; ?>/rezervasyon" class="btn btn-primary">Tekrar Dene</a>
                </div>
            <?php else: ?>
                <form method="post" class="reservation-form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="create_reservation" value="1">
                    <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">
                    <input type="hidden" name="time" value="<?php echo htmlspecialchars($time); ?>">
                    <input type="hidden" name="guest_count" value="<?php echo $guest_count; ?>">

                    <div class="form-group">
                        <label>Müsait Masalar</label>
                        <div class="table-list">
                            <?php foreach ($available_tables as $table): ?>
                                <label class="table-option">
                                    <input type="radio" name="table_id" value="<?php echo $table['id']; ?>" required>
                                    <span class="table-option-content">
                                        <span class="table-option-number">Masa <?php echo $table['table_number']; ?></span>
                                        <span class="table-option-capacity"><?php echo $table['capacity']; ?> Kişilik</span>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Adınız Soyadınız</label>
                            <input type="text" id="name" name="name" required placeholder="Adınız Soyadınız">
                        </div>
                        <div class="form-group">
                            <label for="phone">Telefon Numaranız</label>
                            <input type="tel" id="phone" name="phone" required placeholder="05XX XXX XX XX">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="note">Not (İsteğe Bağlı)</label>
                        <textarea id="note" name="note" rows="3" placeholder="Varsa eklemek istedikleriniz..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Rezervasyonu Tamamla</button>
                </form>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <div class="reservation-form-card">
            <form method="post" class="reservation-form">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="check_availability" value="1">

                <div class="form-row">
                    <div class="form-group">
                        <label for="date">Tarih</label>
                        <input type="date" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="time">Saat</label>
                        <input type="time" id="time" name="time" required>
                    </div>
                    <div class="form-group">
                        <label for="guest_count">Kişi Sayısı</label>
                        <input type="number" id="guest_count" name="guest_count" required min="1" max="50" placeholder="Kişi sayısı">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Müsait Masaları Göster</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
