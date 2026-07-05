<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/');
}

try {
    validate_csrf();

    $customer_name = sanitize_input($_POST['customer_name'] ?? '');
    $customer_phone = sanitize_input($_POST['customer_phone'] ?? '');
    $customer_address = sanitize_input($_POST['customer_address'] ?? '');
    $note = sanitize_input($_POST['note'] ?? '');
    $items = isset($_POST['items']) ? json_decode($_POST['items'], true) : [];

    if (empty($customer_name) || empty($customer_phone) || empty($customer_address) || empty($items)) {
        set_flash_message('error', 'Lütfen tüm zorunlu alanları doldurun.');
        redirect('/menu');
    }

    $total_price = 0;
    foreach ($items as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }

    $order_id = create_order([
        'customer_name' => $customer_name,
        'customer_phone' => $customer_phone,
        'customer_address' => $customer_address,
        'note' => $note,
        'total_price' => $total_price
    ]);

    if ($order_id) {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, unit_price)
                               VALUES (:order_id, :product_id, :product_name, :quantity, :unit_price)");
        foreach ($items as $item) {
            $stmt->execute([
                ':order_id' => $order_id,
                ':product_id' => $item['product_id'],
                ':product_name' => $item['name'],
                ':quantity' => $item['quantity'],
                ':unit_price' => $item['price']
            ]);
        }

        set_flash_message('success', 'Siparişiniz başarıyla alındı!');
    } else {
        set_flash_message('error', 'Sipariş kaydedilirken bir hata oluştu.');
    }
} catch (Exception $e) {
    set_flash_message('error', 'Bir hata oluştu: ' . $e->getMessage());
}

redirect('/menu');
