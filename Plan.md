# 🍗 Kanatçı Nihat — Web Sitesi Proje Planı

## 1. Proje Özeti

**Marka:** Kanatçı Nihat  
**Amaç:** Tavuk kanat restoranı için modern, mobil uyumlu bir web sitesi + yönetim paneli  
**Referans Site:** BiMola Pizza (https://deepslung.com/#)  
**Dil:** Sadece Türkçe  
**Teknoloji Stack:**
- Frontend: HTML5 + CSS3 + Vanilla JavaScript
- Backend: PHP (temiz dosya yapısı)
- Veritabanı: SQLite
- Harita: Leaflet.js (OpenStreetMap)
- QR Kod: PHP ile dinamik üretim (phpqrcode veya endroid/qr-code kütüphanesi)

---

## 2. Genel Site Yapısı

### 2.1 Sayfalar

| Sayfa | URL | Açıklama |
|-------|-----|----------|
| Anasayfa | `/` | Hero, öne çıkan ürünler, hakkında özeti |
| Menü | `/menu` | Tüm ürünler, porsiyon filtresi, sepet |
| Şubemiz | `/subemiz` | Adres, harita, çalışma saatleri |
| İletişim | `/iletisim` | İletişim formu, telefon, sosyal medya |
| Admin Paneli | `/admin` | Ürün yönetimi (şifreli giriş) |
| QR Menü | `/qr-menu` | QR kod okutulunca açılan sade menü sayfası |

---

## 3. Tasarım Sistemi

### 3.1 Renk Paleti
*(BiMola referansından uyarlanan sıcak, iştah açıcı ton)*

| Değişken | Renk | Kullanım |
|----------|------|----------|
| `--color-primary` | `#D94F2B` | Butonlar, vurgu, aktif linkler |
| `--color-primary-dark` | `#B03A1E` | Hover durumları |
| `--color-accent` | `#F5A623` | Fiyatlar, rozetler (Popüler, Yeni) |
| `--color-bg` | `#F7F3EE` | Sayfa arka planı (krem/bej) |
| `--color-surface` | `#FFFFFF` | Kartlar, paneller |
| `--color-text` | `#1A1A1A` | Ana metin |
| `--color-text-muted` | `#6B6B6B` | İkincil metin, açıklamalar |
| `--color-border` | `#E8E0D8` | Kenarlıklar |

### 3.2 Tipografi
- **Başlıklar:** `'Playfair Display'` (Google Fonts) — zarif, premium his
- **Gövde Metni:** `'Inter'` (Google Fonts) — okunabilir, modern
- **Font Boyutları:** Rem tabanlı (base 16px)

### 3.3 Genel Tasarım Anlayışı
- Referans sitedeki gibi açık krem (`#F7F3EE`) arka plan
- Kırmızı-turuncu tonlarında primary renk
- Daire içinde yemek görselleri (hero bölümünde)
- Yuvarlak köşeli kartlar ve butonlar (`border-radius: 12px`)
- İnce çizgi ayraçlar ve `— BAŞLIK —` formatında section etiketleri
- Mobil öncelikli (mobile-first) responsive tasarım

---

## 4. Sayfa Detayları

### 4.1 Anasayfa (`/`)

**Hero Bölümü:**
- Sol: Başlık ("Gaziantep'in En Lezzetli Kanadı"), alt başlık, 2 CTA butonu ("Menüyü Gör", "Bizi Bul")
- Sağ: Daire içinde kanat görseli + fiyat etiketi (günün önerisi)
- Alt kısım: 2 özellik rozeti (örn. "Taze Tavuk", "Hızlı Teslimat")

**Öne Çıkan Ürünler Bölümü:**
- `— ÖZEL SEÇKİMİZ —` etiketi
- 3–4 adet "Popüler" ürün kartı (admin'den işaretlenenler)
- "Tüm Menüyü Gör" butonu

**Hakkımızda Özeti:**
- Kısa metin + yan yana 2–3 istatistik (yıl, müşteri sayısı vb.)

**Şubemiz Önizlemesi:**
- Küçük harita + adres bilgisi + "Yol Tarifi Al" butonu

**Footer:**
- Logo, kısa açıklama
- Hızlı linkler
- İletişim bilgileri
- Sosyal medya ikonları
- Telif hakkı

---

### 4.2 Menü Sayfası (`/menu`)

**Başlık Bölümü:**
- `— HER BİRİ ÖZENLE HAZIRLANDI —`
- "Lezzet Dolu Menümüz" başlığı

**Filtre Sekmeleri (porsiyon boyutuna göre):**
- Tümü | 6'lı | 12'li | 18'li | 24'lü | Ekstralar (sos, içecek vb.)
- Admin panelinden yönetilebilir dinamik kategoriler

**Ürün Kartları (grid, 4 sütun → mobilde 1–2 sütun):**
- Ürün fotoğrafı (üstte rozet: "Popüler ⭐", "Yeni 🔥", "Acılı 🌶️")
- Ürün adı
- Kısa açıklama
- Fiyat (kırmızı, belirgin)
- "Sepete Ekle" butonu

**Sepet (sağ sabit panel veya alt sticky bar — mobilde):**
- Ürün listesi + adetler
- Toplam tutar
- "Sipariş Ver" butonu → sipariş formuna yönlendirir

**Sipariş Formu (modal veya ayrı bölüm):**
- Ad Soyad
- Telefon Numarası
- Adres (teslimat için)
- Not (isteğe bağlı)
- Sipariş özeti
- "Siparişi Onayla" butonu
> ⚠️ Sipariş iletim yöntemi (WhatsApp/telefon/email) sonradan netleştirilecek. Şimdilik siparişler SQLite'a kaydedilsin, admin panelinden görüntülensin.

---

### 4.3 Şubemiz (`/subemiz`)

- Bölüm başlığı: `— NEREDE BİZ? —` / "Şubemiz ve Ulaşım"
- Sol: Adres kartı (adres, telefon, çalışma saatleri, "Ara" butonu)
- Sağ: Leaflet.js haritası (OpenStreetMap, pin ile konum)
- Adres, telefon ve koordinatlar admin panelinden düzenlenebilir

---

### 4.4 İletişim (`/iletisim`)

- Ad, E-posta, Mesaj alanları içeren form
- Mesajlar SQLite'a kaydedilir, admin panelinden okunur
- Telefon ve sosyal medya linkleri

---

### 4.5 QR Menü (`/qr-menu`)

- Navbar ve footer olmayan sade, tam ekran menü sayfası
- Aynı ürün verilerini gösterir (SQLite'dan çekilir)
- Porsiyon filtresi çalışır
- Yalnızca görüntüleme amaçlı (sepet yok)
- Mobil optimizasyonlu

**QR Kod Üretimi:**
- Admin panelinde "QR Kodu İndir" butonu
- `/qr-menu` URL'ini işaret eden PNG/SVG QR kod
- PHP ile sunucu tarafında üretilir (phpqrcode kütüphanesi)

---

## 5. Admin Paneli (`/admin`)

### 5.1 Giriş
- URL: `/admin/login`
- Tek kullanıcı: kullanıcı adı + şifre (PHP `password_hash` ile hashlenir)
- Oturum: PHP Session
- Başarısız girişte hata mesajı

### 5.2 Panel Bölümleri

#### 📦 Ürün Yönetimi
- Tüm ürünleri listele (tablo görünümü)
- Yeni ürün ekle:
  - Ürün adı
  - Kategori (porsiyon boyutu: 6'lı, 12'li, 18'li, 24'lü, Ekstralar)
  - Açıklama
  - Fiyat (₺)
  - Fotoğraf yükleme (sunucuya upload)
  - Rozet: Popüler / Yeni / Acılı / Yok
  - Aktif/Pasif durumu
- Ürün düzenle (aynı form, mevcut verilerle dolu)
- Ürün sil (onay dialogu ile)
- Sıralama (drag-drop veya sıra numarası)

#### 🛒 Sipariş Yönetimi
- Gelen siparişlerin listesi (tarih, müşteri adı, telefon, tutar, durum)
- Sipariş detayı görüntüleme
- Durum güncelleme: Yeni / Hazırlanıyor / Tamamlandı / İptal

#### 💬 İletişim Mesajları
- Gelen mesajlar listesi
- Okundu/Okunmadı işaretleme

#### ⚙️ Site Ayarları
- Restoran adı, slogan
- Adres, telefon, çalışma saatleri
- Google Maps / koordinat girişi (harita pini için)
- Sosyal medya linkleri
- "QR Kodu İndir" butonu

---

## 6. Veritabanı Şeması (SQLite)

```sql
-- Kategoriler
CREATE TABLE categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,          -- "6'lı", "12'li", vb.
    sort_order INTEGER DEFAULT 0
);

-- Ürünler
CREATE TABLE products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    category_id INTEGER,
    name TEXT NOT NULL,
    description TEXT,
    price REAL NOT NULL,
    image_path TEXT,
    badge TEXT,                  -- 'popular', 'new', 'spicy', NULL
    is_active INTEGER DEFAULT 1,
    sort_order INTEGER DEFAULT 0,
    created_at TEXT DEFAULT (datetime('now')),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Siparişler
CREATE TABLE orders (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    customer_name TEXT NOT NULL,
    customer_phone TEXT NOT NULL,
    customer_address TEXT NOT NULL,
    note TEXT,
    total_price REAL NOT NULL,
    status TEXT DEFAULT 'new',   -- 'new', 'preparing', 'done', 'cancelled'
    created_at TEXT DEFAULT (datetime('now'))
);

-- Sipariş kalemleri
CREATE TABLE order_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    order_id INTEGER,
    product_id INTEGER,
    product_name TEXT,
    quantity INTEGER NOT NULL,
    unit_price REAL NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- İletişim mesajları
CREATE TABLE messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT,
    message TEXT NOT NULL,
    is_read INTEGER DEFAULT 0,
    created_at TEXT DEFAULT (datetime('now'))
);

-- Site ayarları (key-value)
CREATE TABLE settings (
    key TEXT PRIMARY KEY,
    value TEXT
);
```

---

## 7. MVC Dosya Yapısı

```
kanatci-nihat/
├── public/                  # Web root (buraya işaret edilecek)
│   ├── index.php            # Front controller
│   ├── assets/
│   │   ├── css/
│   │   │   ├── main.css
│   │   │   ├── menu.css
│   │   │   └── admin.css
│   │   ├── js/
│   │   │   ├── main.js
│   │   │   ├── cart.js
│   │   │   └── admin.js
│   │   ├── images/
│   │   └── uploads/         # Ürün fotoğrafları buraya yüklenir
│
├── app/
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── MenuController.php
│   │   ├── OrderController.php
│   │   ├── BranchController.php
│   │   ├── ContactController.php
│   │   ├── QrMenuController.php
│   │   └── Admin/
│   │       ├── AuthController.php
│   │       ├── ProductController.php
│   │       ├── OrderAdminController.php
│   │       ├── MessageController.php
│   │       └── SettingsController.php
│   │
│   ├── Models/
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Message.php
│   │   └── Setting.php
│   │
│   ├── Views/
│   │   ├── layouts/
│   │   │   ├── main.php     # Ana layout (navbar + footer)
│   │   │   ├── qr.php       # QR menü layout (minimal)
│   │   │   └── admin.php    # Admin layout
│   │   ├── home/
│   │   │   └── index.php
│   │   ├── menu/
│   │   │   └── index.php
│   │   ├── branch/
│   │   │   └── index.php
│   │   ├── contact/
│   │   │   └── index.php
│   │   ├── qr-menu/
│   │   │   └── index.php
│   │   └── admin/
│   │       ├── login.php
│   │       ├── dashboard.php
│   │       ├── products/
│   │       │   ├── index.php
│   │       │   ├── create.php
│   │       │   └── edit.php
│   │       ├── orders/
│   │       │   ├── index.php
│   │       │   └── show.php
│   │       ├── messages/
│   │       │   └── index.php
│   │       └── settings/
│   │           └── index.php
│   │
│   └── Core/
│       ├── Router.php
│       ├── Database.php      # SQLite PDO bağlantısı
│       ├── Controller.php    # Base controller
│       ├── Model.php         # Base model
│       └── Session.php
│
├── database/
│   ├── kanatci.sqlite        # Veritabanı dosyası
│   └── seed.php              # Örnek veriler
│
├── config/
│   └── config.php            # DB yolu, site URL, admin şifresi vb.
│
└── .htaccess                 # URL yönlendirme (mod_rewrite)
```

---

## 8. Routing Tablosu

| Method | URL | Controller@Method | Açıklama |
|--------|-----|-------------------|----------|
| GET | `/` | HomeController@index | Anasayfa |
| GET | `/menu` | MenuController@index | Menü sayfası |
| POST | `/siparis` | OrderController@store | Sipariş kaydet |
| GET | `/subemiz` | BranchController@index | Şube sayfası |
| GET | `/iletisim` | ContactController@index | İletişim sayfası |
| POST | `/iletisim` | ContactController@send | Mesaj gönder |
| GET | `/qr-menu` | QrMenuController@index | QR menü |
| GET | `/admin` | Admin\AuthController@dashboard | Admin yönlendirme |
| GET | `/admin/login` | Admin\AuthController@loginForm | Giriş formu |
| POST | `/admin/login` | Admin\AuthController@login | Giriş işlemi |
| GET | `/admin/logout` | Admin\AuthController@logout | Çıkış |
| GET | `/admin/urunler` | Admin\ProductController@index | Ürün listesi |
| GET | `/admin/urunler/ekle` | Admin\ProductController@create | Ürün ekle formu |
| POST | `/admin/urunler/ekle` | Admin\ProductController@store | Ürün kaydet |
| GET | `/admin/urunler/{id}/duzenle` | Admin\ProductController@edit | Düzenle formu |
| POST | `/admin/urunler/{id}/duzenle` | Admin\ProductController@update | Güncelle |
| POST | `/admin/urunler/{id}/sil` | Admin\ProductController@destroy | Sil |
| GET | `/admin/siparisler` | Admin\OrderAdminController@index | Sipariş listesi |
| GET | `/admin/siparisler/{id}` | Admin\OrderAdminController@show | Sipariş detayı |
| POST | `/admin/siparisler/{id}/durum` | Admin\OrderAdminController@updateStatus | Durum güncelle |
| GET | `/admin/mesajlar` | Admin\MessageController@index | Mesajlar |
| GET | `/admin/ayarlar` | Admin\SettingsController@index | Ayarlar |
| POST | `/admin/ayarlar` | Admin\SettingsController@update | Ayarları kaydet |
| GET | `/admin/qr-kod` | Admin\SettingsController@qrCode | QR kod indir |

---

## 9. JavaScript Modülleri

### cart.js
- Sepet state yönetimi (localStorage)
- Ürün ekleme / çıkarma / adet güncelleme
- Toplam fiyat hesaplama
- Sipariş formunu tetikleme
- Sipariş POST isteği (`/siparis`)

### main.js
- Navbar scroll efekti
- Menü filtre sekmeleri
- Smooth scroll
- Mobil hamburger menü

### admin.js
- Ürün silme onay dialogu
- Fotoğraf önizleme (upload öncesi)
- Sipariş durum güncelleme (AJAX)
- Mesaj okundu işaretleme (AJAX)

---

## 10. QR Kod Detayı

- **Kütüphane:** `phpqrcode` (composer veya manuel dahil)
- **Hedef URL:** `https://[site-domain]/qr-menu`
- **Çıktı:** PNG olarak tarayıcıya gönderilir (indirilebilir)
- **Admin endpoint:** `GET /admin/qr-kod`
- **QR menü sayfası:** Navbar/footer olmayan minimal tasarım, sadece ürün grid'i + porsiyon filtresi

---

## 11. Güvenlik Kontrol Listesi

- [ ] Admin şifresi `password_hash()` / `password_verify()` ile saklanır
- [ ] Tüm kullanıcı girdileri `htmlspecialchars()` ile sanitize edilir
- [ ] SQL sorgularında PDO prepared statements kullanılır
- [ ] Admin rotaları session kontrolü ile korunur (`/admin/*`)
- [ ] Dosya yükleme: sadece `jpg/jpeg/png/webp` uzantısı, max 2MB, rastgele isim
- [ ] CSRF token: admin formlarında
- [ ] `.htaccess` ile `database/` ve `config/` klasörlerine dışarıdan erişim engeli

---

## 12. Örnek Başlangıç Verileri (Seed)

**Kategoriler:**
- 6'lı Kanat
- 12'li Kanat
- 18'li Kanat
- 24'lü Kanat
- Ekstralar (sos, içecek, kızarmış patates vb.)

**Örnek Ürünler:**
| Ürün | Kategori | Fiyat | Rozet |
|------|----------|-------|-------|
| Klasik 6'lı Kanat | 6'lı | ₺120 | — |
| Acılı 6'lı Kanat | 6'lı | ₺130 | Acılı 🌶️ |
| BBQ 12'li Kanat | 12'li | ₺220 | Popüler ⭐ |
| Sarımsaklı 12'li Kanat | 12'li | ₺230 | Yeni 🔥 |
| Karışık 18'li Kanat | 18'li | ₺310 | Popüler ⭐ |
| Mega 24'lü Kanat | 24'lü | ₺390 | — |
| Ekstra Sos | Ekstralar | ₺15 | — |
| Kızarmış Patates | Ekstralar | ₺45 | — |




---

## 13. Açık Kalan Kararlar

> Aşağıdaki konular proje sahibi ile sonradan netleştirilecektir:

1. **Sipariş iletim yöntemi:** Siparişler WhatsApp'a mı, telefon aramasına mı, yoksa sadece admin paneline mi düşsün?
2. **Hosting / domain:** Deploy ortamı netleşince `.htaccess` ve config yolları buna göre ayarlanacak
3. **Sosyal medya hesapları:** Instagram, Facebook vb. linkleri
4. **Gerçek ürün fotoğrafları ve fiyatları:** Seed verileri placeholder; gerçek içerik admin panelinden girilecek
5. **Restoran adresi ve koordinatları:** Harita pini için gerekli
6. **Çalışma saatleri:** Footer ve Şubemiz sayfası için