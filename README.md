# Kanatçı Nihat - Proje Durumu

Kanatçı Nihat web sitesi projesinin mevcut durumu.

## ✅ Tamamlanan Aşamalar

### Aşama 1: Proje Kurulumu ve Temel Altyapı
- Proje dizin yapısı (public, includes, pages, database, config)
- `.htaccess` URL yönlendirme + hassas klasör/dosya erişim engeli
- `public/index.php` ana yönlendirici (alt dizin desteği ile)
- `config/app.php` uygulama ayarları (DB yolu, site URL, admin şifre)
- `includes/db.php` SQLite bağlantısı + schema oluşturma
- `includes/functions.php` tüm CRUD + yardımcı fonksiyonlar
- `includes/session.php` PHP oturum başlatma
- `includes/admin_auth.php` admin giriş/çıkış/yetkilendirme
- `includes/header.php` & `footer.php` ortak layout (admin/site ayrımı)
- `public/assets/css/main.css` ana stiller (renk paleti, tipografi, butonlar, formlar, responsive)
- `database/seed.php` örnek kategoriler, ürünler ve varsayılan ayarlar

### Aşama 2: Yönetim Paneli
- Admin giriş (PHP Session + password_hash)
- Dashboard (ürün/sipariş/mesaj istatistikleri)
- Ürün yönetimi (listeleme, ekleme, düzenleme, silme, görsel yükleme)
- Sipariş yönetimi (listeleme, detay, AJAX durum güncelleme)
- Mesaj yönetimi (listeleme, AJAX okundu işaretleme)
- Site ayarları (adres, telefon, sosyal medya, koordinatlar, QR kod)
- `public/assets/css/admin.css` admin paneline özel stiller
- `public/assets/js/admin.js` silme onayı, fotoğraf önizleme, AJAX işlemleri

### Aşama 3: Genel Web Sitesi
- `pages/home.php` Anasayfa (hero, CTA, öne çıkan ürünler, hakkımızda, harita önizleme)
- `pages/menu.php` Menü (kategori filtreleri, ürün kartları, sepet paneli, sipariş modalı)
- `pages/branch.php` Şubemiz (Leaflet.js harita, adres, telefon, çalışma saatleri)
- `pages/contact.php` İletişim (form + SQLite kaydı, sosyal medya linkleri)
- `pages/qr-menu.php` QR menü (minimal, navbar/footer yok)
- `pages/order_process.php` Sipariş işleme (POST)
- `pages/404.php` 404 hata sayfası
- `public/assets/css/menu.css` menü/sepet/modal stilleri
- `public/assets/js/main.js` filtre sekmeleri, scroll efekti, hamburger menü
- `public/assets/js/cart.js` localStorage sepet yönetimi (ekleme, çıkarma, miktar, toplam, sipariş modalı)

### Aşama 4: Gelişmiş Özellikler

#### QR Kod Üretimi
- `includes/phpqrcode.php` kütüphanesi
- `includes/qr_generator.php` QR kod wrapper
- Admin ayarlar sayfasında QR önizleme + indirme (`/admin/qr_download`, `/admin/qr_preview`)

#### Güvenlik Önlemleri
- **CSRF Token:** Tüm admin formları + genel formlar (iletişim, sipariş) + AJAX istekleri
- **Dosya Yükleme:** finfo MIME kontrolü, getimagesize doğrulama, random_bytes ile dosya adı
- **Uploads Koruması:** `.htaccess` ile PHP çalıştırma engeli
- **HTTP Başlıkları:** X-Content-Type-Options, X-Frame-Options, X-XSS-Protection, Referrer-Policy
- **Hassas Dosya Engeli:** .sqlite, .md, .env, .log dosyalarına erişim engeli
- **Admin Şifre:** password_hash / password_verify
- **SQL Enjeksiyon:** PDO prepared statements
- **Girdi Sanitizasyonu:** htmlspecialchars çıktıda, sanitize_for_db veritabanı öncesi

#### Test ve İyileştirmeler
- Tüm PHP dosyalarında syntax kontrolü (31 dosya, 0 hata)
- Anasayfa Plan.md'deki tasarıma uygun hale getirildi
- Header/footer tüm admin sayfalarına eklendi
- Alt dizin desteği için routing düzeltildi
- Footer iletişim bilgileri dinamik hale getirildi
- Responsive tasarım düzenlemeleri (mobil menü, kart grid, hero, about, branch)

## 📁 Proje Dosya Yapısı

```
kanatci-nihat/
├── public/                     # Web root
│   ├── index.php               # Ana yönlendirici
│   └── assets/
│       ├── css/ (main.css, menu.css, admin.css)
│       ├── js/   (main.js, cart.js, admin.js)
│       ├── images/
│       └── uploads/ (.htaccess ile PHP korumalı)
├── includes/
│   ├── header.php              # Site/Admin layout başlık
│   ├── footer.php              # Site/Admin layout altbilgi
│   ├── db.php                  # Veritabanı bağlantı
│   ├── functions.php           # Tüm CRUD + yardımcı fonksiyonlar
│   ├── session.php             # Oturum başlatma
│   ├── admin_auth.php          # Admin giriş/çıkış
│   ├── qr_generator.php        # QR kod üretimi
│   └── phpqrcode.php           # QR kütüphanesi
├── pages/
│   ├── home.php, menu.php, branch.php, contact.php
│   ├── qr-menu.php, order_process.php, 404.php
│   └── admin/
│       ├── login.php, dashboard.php
│       ├── products.php, product_edit.php, product_delete.php
│       ├── orders.php, order_detail.php
│       ├── messages.php, settings.php
│       ├── qr_download.php, qr_preview.php
│       └── _handlers/ (order_update_status, message_mark_read)
├── database/
│   ├── kanatci.sqlite          # SQLite veritabanı
│   └── seed.php                # Örnek veriler
├── config/
│   └── app.php                 # Uygulama ayarları
└── .htaccess                   # URL yönlendirme + güvenlik
```

## 👤 Admin Giriş Bilgileri
- **URL:** `/admin/login`
- **Kullanıcı:** `admin`
- **Şifre:** `123456` (config/app.php içinde password_hash ile saklanır)
