<?php

// Girdi verilerini temizleme (çıktı için kullanılır)
function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Veritabanına kaydetmeden önce temizleme (HTML etiketlerini korumaz)
function sanitize_for_db($data) {
    if (is_array($data)) {
        return array_map('sanitize_for_db', $data);
    }
    return trim(stripslashes($data));
}

// CSRF Token işlemleri
function generate_csrf_token() {
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
}

function csrf_field() {
    return '<input type="hidden" name="_csrf_token" value="' . generate_csrf_token() . '">';
}

function verify_csrf_token($token) {
    if (empty($_SESSION['_csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['_csrf_token'], $token);
}

function validate_csrf() {
    $token = $_POST['_csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        set_flash_message('error', 'Güvenlik doğrulaması başarısız. Lütfen sayfayı yenileyip tekrar deneyin.');
        redirect($_SERVER['HTTP_REFERER'] ?? '/');
    }
    // Token'ı yenile (her istekte yeni token)
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
}

// Şifre hashleme
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Şifre doğrulama
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

// Yönlendirme fonksiyonu
function redirect($url) {
    header("Location: " . $url);
    exit();
}

// Flash mesaj fonksiyonları
function set_flash_message($name, $message, $type = 'info') {
    $_SESSION['flash_' . $name] = ['message' => $message, 'type' => $type];
}

function get_flash_message($name) {
    if (isset($_SESSION['flash_' . $name])) {
        $message = $_SESSION['flash_' . $name];
        unset($_SESSION['flash_' . $name]);
        return $message;
    }
    return null;
}

// ========== Ürün Yönetimi Fonksiyonları ==========

function get_products($category_id = null, $only_active = false) {
    $pdo = get_db_connection();
    $sql = "SELECT p.*, c.name as category_name FROM products p
            LEFT JOIN categories c ON p.category_id = c.id";
    $params = [];

    if ($only_active) {
        $sql .= " WHERE p.is_active = 1";
    }

    if ($category_id !== null) {
        $sql .= ($only_active ? " AND" : " WHERE") . " p.category_id = :category_id";
        $params[':category_id'] = $category_id;
    }

    $sql .= " ORDER BY p.sort_order ASC, p.name ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_product($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function create_product($data) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("INSERT INTO products (category_id, name, description, price, image_path, badge, is_active, sort_order)
                           VALUES (:category_id, :name, :description, :price, :image_path, :badge, :is_active, :sort_order)");
    return $stmt->execute([
        ':category_id' => $data['category_id'],
        ':name' => $data['name'],
        ':description' => $data['description'],
        ':price' => $data['price'],
        ':image_path' => $data['image_path'],
        ':badge' => $data['badge'],
        ':is_active' => $data['is_active'],
        ':sort_order' => $data['sort_order']
    ]);
}

function update_product($id, $data) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("UPDATE products SET
                           category_id = :category_id,
                           name = :name,
                           description = :description,
                           price = :price,
                           image_path = :image_path,
                           badge = :badge,
                           is_active = :is_active,
                           sort_order = :sort_order
                           WHERE id = :id");
    return $stmt->execute([
        ':category_id' => $data['category_id'],
        ':name' => $data['name'],
        ':description' => $data['description'],
        ':price' => $data['price'],
        ':image_path' => $data['image_path'],
        ':badge' => $data['badge'],
        ':is_active' => $data['is_active'],
        ':sort_order' => $data['sort_order'],
        ':id' => $id
    ]);
}

function delete_product($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}

function get_product_count() {
    $pdo = get_db_connection();
    $stmt = $pdo->query("SELECT COUNT(*) FROM products");
    return $stmt->fetchColumn();
}

// ========== Kategori Fonksiyonları ==========

function get_categories() {
    $pdo = get_db_connection();
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY sort_order ASC, name ASC");
    return $stmt->fetchAll();
}

function get_category($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function create_category($name, $sort_order = 0) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("INSERT INTO categories (name, sort_order) VALUES (:name, :sort_order)");
    return $stmt->execute([':name' => $name, ':sort_order' => $sort_order]);
}

// ========== Sipariş Fonksiyonları ==========

function get_orders($status = null) {
    $pdo = get_db_connection();
    $sql = "SELECT * FROM orders";
    $params = [];
    if ($status) {
        $sql .= " WHERE status = :status";
        $params[':status'] = $status;
    }
    $sql .= " ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_order($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function get_order_items($order_id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
    $stmt->execute([':order_id' => $order_id]);
    return $stmt->fetchAll();
}

function get_order_count($status = null) {
    $pdo = get_db_connection();
    $sql = "SELECT COUNT(*) FROM orders";
    $params = [];
    if ($status) {
        $sql .= " WHERE status = :status";
        $params[':status'] = $status;
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn();
}

function create_order($data) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_phone, customer_address, note, total_price, status)
                           VALUES (:customer_name, :customer_phone, :customer_address, :note, :total_price, :status)");
    $stmt->execute([
        ':customer_name' => $data['customer_name'],
        ':customer_phone' => $data['customer_phone'],
        ':customer_address' => $data['customer_address'],
        ':note' => $data['note'],
        ':total_price' => $data['total_price'],
        ':status' => 'new'
    ]);
    return $pdo->lastInsertId();
}

function update_order_status($id, $status) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("UPDATE orders SET status = :status WHERE id = :id");
    return $stmt->execute([':status' => $status, ':id' => $id]);
}

// ========== Mesaj Fonksiyonları ==========

function get_messages($unread_only = false) {
    $pdo = get_db_connection();
    $sql = "SELECT * FROM messages";
    if ($unread_only) {
        $sql .= " WHERE is_read = 0";
    }
    $sql .= " ORDER BY created_at DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function get_unread_message_count() {
    $pdo = get_db_connection();
    $stmt = $pdo->query("SELECT COUNT(*) FROM messages WHERE is_read = 0");
    return $stmt->fetchColumn();
}

function create_message($name, $email, $message) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (:name, :email, :message)");
    return $stmt->execute([':name' => $name, ':email' => $email, ':message' => $message]);
}

function mark_message_read($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("UPDATE messages SET is_read = 1 WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}

function get_message($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

// ========== Site Ayarları Fonksiyonları ==========

function get_setting($key) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT value FROM settings WHERE key = :key");
    $stmt->execute([':key' => $key]);
    $row = $stmt->fetch();
    return $row ? $row['value'] : null;
}

function set_setting($key, $value) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("INSERT OR REPLACE INTO settings (key, value) VALUES (:key, :value)");
    return $stmt->execute([':key' => $key, ':value' => $value]);
}

function get_all_settings() {
    $pdo = get_db_connection();
    $stmt = $pdo->query("SELECT * FROM settings");
    $rows = $stmt->fetchAll();
    $settings = [];
    foreach ($rows as $row) {
        $settings[$row['key']] = $row['value'];
    }
    return $settings;
}

// ========== Dosya Yükleme ==========

function upload_image($file, $target_dir) {
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
    $max_size = 2 * 1024 * 1024; // 2MB

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Dosya yükleme hatası.'];
    }

    // Gerçek dosya türünü kontrol et (MIME type spoofing'i engelle)
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowed_mime = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($mime_type, $allowed_mime)) {
        return ['success' => false, 'error' => 'Sadece JPG, PNG ve WebP dosyalarına izin verilir.'];
    }

    // Dosyanın geçerli bir görsel olduğunu doğrula
    $image_info = getimagesize($file['tmp_name']);
    if ($image_info === false) {
        return ['success' => false, 'error' => 'Dosya geçerli bir görsel değil.'];
    }

    if ($file['size'] > $max_size) {
        return ['success' => false, 'error' => 'Dosya boyutu 2MB\'dan büyük olamaz.'];
    }

    // Uzantıyı MIME türüne göre belirle (güvenli)
    $ext_map = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $ext = $ext_map[$mime_type];

    // Rastgele dosya adı oluştur
    $new_name = bin2hex(random_bytes(16)) . '.' . $ext;
    $target_path = rtrim($target_dir, '/') . '/' . $new_name;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return ['success' => true, 'path' => $new_name];
    }

    return ['success' => false, 'error' => 'Dosya kaydedilemedi.'];
}

// ========== Masa (Tables) Fonksiyonları ==========

function get_tables($only_active = false) {
    $pdo = get_db_connection();
    $sql = "SELECT * FROM tables";
    $params = [];
    if ($only_active) {
        $sql .= " WHERE status = 'active'";
    }
    $sql .= " ORDER BY table_number ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_table($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM tables WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function create_table($data) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("INSERT INTO tables (table_number, capacity, status)
                           VALUES (:table_number, :capacity, :status)");
    return $stmt->execute([
        ':table_number' => $data['table_number'],
        ':capacity' => $data['capacity'],
        ':status' => $data['status'] ?? 'active'
    ]);
}

function update_table($id, $data) {
    $pdo = get_db_connection();
    $fields = [];
    $params = [':id' => $id];
    foreach (['table_number', 'capacity', 'status'] as $field) {
        if (array_key_exists($field, $data)) {
            $fields[] = "$field = :$field";
            $params[":$field"] = $data[$field];
        }
    }
    if (empty($fields)) return false;
    $sql = "UPDATE tables SET " . implode(', ', $fields) . " WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}

function delete_table($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("DELETE FROM tables WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}

function get_table_count() {
    $pdo = get_db_connection();
    $stmt = $pdo->query("SELECT COUNT(*) FROM tables");
    return $stmt->fetchColumn();
}

// ========== Rezervasyon (Reservations) Fonksiyonları ==========

function get_reservations($status = null, $date = null) {
    $pdo = get_db_connection();
    $sql = "SELECT r.*, t.table_number FROM reservations r
            LEFT JOIN tables t ON r.table_id = t.id";
    $params = [];
    $conditions = [];

    if ($status !== null) {
        $conditions[] = "r.status = :status";
        $params[':status'] = $status;
    }
    if ($date !== null) {
        $conditions[] = "r.reservation_date = :date";
        $params[':date'] = $date;
    }
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    $sql .= " ORDER BY r.reservation_date DESC, r.reservation_time ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_reservation($id) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT r.*, t.table_number FROM reservations r
                           LEFT JOIN tables t ON r.table_id = t.id
                           WHERE r.id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

function create_reservation($data) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("INSERT INTO reservations (name, phone, guest_count, reservation_date, reservation_time, table_id, note, status)
                           VALUES (:name, :phone, :guest_count, :reservation_date, :reservation_time, :table_id, :note, :status)");
    $stmt->execute([
        ':name' => $data['name'],
        ':phone' => $data['phone'],
        ':guest_count' => $data['guest_count'],
        ':reservation_date' => $data['reservation_date'],
        ':reservation_time' => $data['reservation_time'],
        ':table_id' => $data['table_id'],
        ':note' => $data['note'] ?? null,
        ':status' => $data['status'] ?? 'pending'
    ]);
    return $pdo->lastInsertId();
}

function update_reservation_status($id, $status) {
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("UPDATE reservations SET status = :status WHERE id = :id");
    return $stmt->execute([':status' => $status, ':id' => $id]);
}

function get_reservation_count($status = null) {
    $pdo = get_db_connection();
    $sql = "SELECT COUNT(*) FROM reservations";
    $params = [];
    if ($status !== null) {
        $sql .= " WHERE status = :status";
        $params[':status'] = $status;
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn();
}

// ========== Müsaitlik Sorgusu (Availability) ==========

function get_available_tables($date, $time, $guest_count) {
    $pdo = get_db_connection();
    $sql = "SELECT * FROM tables
            WHERE status = 'active'
              AND capacity >= :guest_count
              AND id NOT IN (
                  SELECT table_id FROM reservations
                  WHERE reservation_date = :date
                    AND status IN ('pending', 'confirmed')
                    AND reservation_time < time(:requested_time, '+2 hours')
                    AND time(:requested_time) < time(reservation_time, '+2 hours')
              )
            ORDER BY table_number ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':guest_count' => $guest_count,
        ':date' => $date,
        ':requested_time' => $time
    ]);
    return $stmt->fetchAll();
}

function is_table_available($table_id, $date, $time) {
    $pdo = get_db_connection();
    $sql = "SELECT COUNT(*) FROM reservations
            WHERE table_id = :table_id
              AND reservation_date = :date
              AND status IN ('pending', 'confirmed')
              AND reservation_time < time(:requested_time, '+2 hours')
              AND time(:requested_time) < time(reservation_time, '+2 hours')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':table_id' => $table_id,
        ':date' => $date,
        ':requested_time' => $time
    ]);
    return $stmt->fetchColumn() == 0;
}