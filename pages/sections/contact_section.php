<section class="contact-page" id="iletisim">
    <div class="contact-header">
        <span class="section-label">— BİZE ULAŞIN —</span>
        <h1>İletişim</h1>
    </div>

    <div class="contact-content">
        <div class="contact-form">
            <form action="" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="name">Adınız</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">E-posta (isteğe bağlı)</label>
                    <input type="email" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="message">Mesajınız</label>
                    <textarea id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Gönder</button>
            </form>
        </div>
        <div class="contact-info">
            <div class="info-card">
                <h3>Telefon</h3>
                <p><a href="tel:<?php echo get_setting('phone'); ?>"><?php echo get_setting('phone') ?: 'Telefon bilgisi girilmemiş.'; ?></a></p>
            </div>
            <div class="info-card">
                <h3>Adres</h3>
                <p><?php echo get_setting('address') ?: 'Adres bilgisi girilmemiş.'; ?></p>
            </div>
            <div class="info-card">
                <h3>Bizi Takip Edin</h3>
                <div class="social-links">
                    <?php if (get_setting('instagram')): ?><a href="<?php echo get_setting('instagram'); ?>" target="_blank">Instagram</a><?php endif; ?>
                    <?php if (get_setting('facebook')): ?><a href="<?php echo get_setting('facebook'); ?>" target="_blank">Facebook</a><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
