<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/db.php';

create_tables();

$pdo = get_db_connection();

// Kategoriler
$categories = [
    ['name' => "6'lı Kanat", 'sort_order' => 1],
    ['name' => "12'li Kanat", 'sort_order' => 2],
    ['name' => "18'li Kanat", 'sort_order' => 3],
    ['name' => "24'lü Kanat", 'sort_order' => 4],
    ['name' => "Ekstralar", 'sort_order' => 5],
];

$stmt = $pdo->prepare("INSERT OR IGNORE INTO categories (id, name, sort_order) VALUES (:id, :name, :sort_order)");
foreach ($categories as $i => $cat) {
    $stmt->execute([':id' => $i + 1, ':name' => $cat['name'], ':sort_order' => $cat['sort_order']]);
}

// Ürünler
$products = [
    ['category_id' => 1, 'name' => 'Klasik 6\'lı Kanat', 'description' => 'Özel baharatlarla marine edilmiş klasik lezzet.', 'price' => 120, 'badge' => null, 'sort_order' => 1],
    ['category_id' => 1, 'name' => 'Acılı 6\'lı Kanat', 'description' => 'Ateş gibi acı sosla buluşan kanatlar.', 'price' => 130, 'badge' => 'spicy', 'sort_order' => 2],
    ['category_id' => 2, 'name' => 'BBQ 12\'li Kanat', 'description' => 'Barbekü soslu, dumanlı lezzet.', 'price' => 220, 'badge' => 'popular', 'sort_order' => 1],
    ['category_id' => 2, 'name' => 'Sarımsaklı 12\'li Kanat', 'description' => 'Bol sarımsaklı ve aromatik.', 'price' => 230, 'badge' => 'new', 'sort_order' => 2],
    ['category_id' => 3, 'name' => 'Karışık 18\'li Kanat', 'description' => 'Her damak tadına uygun karışık seçenek.', 'price' => 310, 'badge' => 'popular', 'sort_order' => 1],
    ['category_id' => 4, 'name' => 'Mega 24\'lü Kanat', 'description' => 'Büyük iştahlar için dev porsiyon.', 'price' => 390, 'badge' => null, 'sort_order' => 1],
    ['category_id' => 5, 'name' => 'Ekstra Sos', 'description' => 'Yanında ekstra sos.', 'price' => 15, 'badge' => null, 'sort_order' => 1],
    ['category_id' => 5, 'name' => 'Kızarmış Patates', 'description' => 'Altın sarısı çıtır patates.', 'price' => 45, 'badge' => null, 'sort_order' => 2],
];

$stmt = $pdo->prepare("INSERT OR IGNORE INTO products (id, category_id, name, description, price, badge, is_active, sort_order)
                       VALUES (:id, :category_id, :name, :description, :price, :badge, 1, :sort_order)");
foreach ($products as $i => $prod) {
    $stmt->execute([
        ':id' => $i + 1,
        ':category_id' => $prod['category_id'],
        ':name' => $prod['name'],
        ':description' => $prod['description'],
        ':price' => $prod['price'],
        ':badge' => $prod['badge'],
        ':sort_order' => $prod['sort_order']
    ]);
}

// Varsayılan site ayarları
$default_settings = [
    ['site_title', 'Kanatçı Nihat'],
    ['site_slogan', "Gaziantep'in En Lezzetli Kanadı"],
    ['address', 'Şahinbey, Gaziantep'],
    ['phone', '+90 555 123 45 67'],
    ['email', 'info@kanatcinihat.com'],
    ['latitude', '37.0662'],
    ['longitude', '37.3833'],
    ['working_hours', '10:00 - 23:00'],
];

$stmt = $pdo->prepare("INSERT OR IGNORE INTO settings (key, value) VALUES (:key, :value)");
foreach ($default_settings as $setting) {
    $stmt->execute([':key' => $setting[0], ':value' => $setting[1]]);
}

echo "Örnek veriler başarıyla eklendi.\n";
