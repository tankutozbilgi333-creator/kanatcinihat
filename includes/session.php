<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Flash mesajları için functions.php dosyasındaki fonksiyonlar kullanılacak.
// Burası sadece oturumu başlatmak için.

?>