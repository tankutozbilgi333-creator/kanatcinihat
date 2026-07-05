    </main>

    <?php if (isset($is_admin_area) && $is_admin_area): ?>
        <footer class="admin-footer">
            <p>&copy; <?php echo date('Y'); ?> Kanatçı Nihat Admin. Tüm Hakları Saklıdır.</p>
        </footer>
        <script src="<?php echo SITE_URL; ?>/assets/js/admin.js"></script>
    <?php else: ?>
        <footer class="site-footer">
            <div class="footer-content">
                <div class="footer-section about">
                    <h3>Kanatçı Nihat</h3>
                    <p>Gaziantep'in eşsiz lezzetiyle hazırlanan tavuk kanatlarımızla damaklarınızda unutulmaz bir tat bırakıyoruz.</p>
                </div>
                <div class="footer-section links">
                    <h3>Hızlı Linkler</h3>
                    <ul>
                        <li><a href="<?php echo SITE_URL; ?>/#anasayfa">Anasayfa</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/#menu">Menü</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/#subemiz">Şubemiz</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/#iletisim">İletişim</a></li>
                    </ul>
                </div>
                <div class="footer-section contact">
                    <h3>İletişim</h3>
                    <p><?php echo get_setting('address') ?: 'Adres bilgisi'; ?></p>
                    <p><?php echo get_setting('phone') ?: 'Telefon bilgisi'; ?></p>
                    <p><?php echo get_setting('email') ?: 'Email bilgisi'; ?></p>
                </div>
                <div class="footer-section social">
                    <h3>Takip Et</h3>
                    <?php if (get_setting('instagram')): ?><a href="<?php echo get_setting('instagram'); ?>" target="_blank">Instagram</a> | <?php endif; ?>
                    <?php if (get_setting('facebook')): ?><a href="<?php echo get_setting('facebook'); ?>" target="_blank">Facebook</a><?php endif; ?>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; <?php echo date('Y'); ?> Kanatçı Nihat. Tüm Hakları Saklıdır.
            </div>
        </footer>
        <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
    <?php endif; ?>
</body>
</html>