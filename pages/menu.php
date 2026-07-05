<?php require_once __DIR__ . '/../includes/header.php'; ?>

<link rel="stylesheet" href="/assets/css/menu.css">

<div class="menu-page">
    <div class="menu-header">
        <span class="section-label">— HER BİRİ ÖZENLE HAZIRLANDI —</span>
        <h1>Lezzet Dolu Menümüz</h1>
    </div>

    <div class="filter-tabs">
        <button class="filter-btn active" data-filter="all">Tümü</button>
        <?php $categories = get_categories(); ?>
        <?php foreach ($categories as $cat): ?>
            <button class="filter-btn" data-filter="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></button>
        <?php endforeach; ?>
    </div>

    <div class="menu-layout">
        <div class="products-grid">
            <?php $products = get_products(null, true); ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card" data-category="<?php echo $product['category_id']; ?>">
                    <?php if ($product['badge']): ?>
                        <span class="product-badge badge-<?php echo $product['badge']; ?>">
                            <?php
                            $badges = ['popular' => 'Popüler ⭐', 'new' => 'Yeni 🔥', 'spicy' => 'Acılı 🌶️'];
                            echo $badges[$product['badge']] ?? $product['badge'];
                            ?>
                        </span>
                    <?php endif; ?>
                    <div class="product-image">
                        <?php if ($product['image_path']): ?>
                            <img src="/assets/uploads/<?php echo $product['image_path']; ?>" alt="<?php echo $product['name']; ?>">
                        <?php else: ?>
                            <div class="placeholder-image">🍗</div>
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <h3><?php echo $product['name']; ?></h3>
                        <p class="product-desc"><?php echo $product['description']; ?></p>
                        <p class="product-price">₺<?php echo number_format($product['price'], 2); ?></p>
                        <button class="btn btn-primary add-to-cart"
                                data-id="<?php echo $product['id']; ?>"
                                data-name="<?php echo $product['name']; ?>"
                                data-price="<?php echo $product['price']; ?>">Sepete Ekle</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Sepet Paneli -->
        <aside id="cart-panel" class="cart-panel">
            <div class="cart-header">
                <h3>Sepet</h3>
                <span class="cart-count">0</span>
                <button class="cart-toggle close-cart">×</button>
            </div>
            <ul class="cart-items">
                <li class="cart-empty">Sepetiniz boş.</li>
            </ul>
            <div class="cart-footer">
                <div class="cart-total-row">
                    <span>Toplam:</span>
                    <span class="cart-total">₺0.00</span>
                </div>
                <button class="btn btn-primary checkout-btn">Sipariş Ver</button>
                <button class="btn btn-secondary cart-clear-btn">Sepeti Temizle</button>
            </div>
        </aside>
    </div>
</div>

<!-- Mobil Sticky Sepet Butonu -->
<button class="cart-sticky-btn cart-toggle">
    🛒 Sepet (<span class="cart-sticky-count">0</span>)
</button>

<!-- Sipariş Modalı -->
<div id="order-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Sipariş Ver</h2>
            <button class="modal-close" onclick="closeOrderModal()">×</button>
        </div>
        <form id="order-form" action="/siparis" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="order-items-json" name="items" value="">

            <div class="form-group">
                <label for="customer_name">Ad Soyad</label>
                <input type="text" id="customer_name" name="customer_name" required>
            </div>
            <div class="form-group">
                <label for="customer_phone">Telefon</label>
                <input type="tel" id="customer_phone" name="customer_phone" required>
            </div>
            <div class="form-group">
                <label for="customer_address">Teslimat Adresi</label>
                <textarea id="customer_address" name="customer_address" rows="2" required></textarea>
            </div>
            <div class="form-group">
                <label for="customer_note">Not (isteğe bağlı)</label>
                <textarea id="customer_note" name="note" rows="2"></textarea>
            </div>

            <div class="order-summary">
                <h3>Sipariş Özeti</h3>
                <div class="order-summary-items"></div>
                <div class="order-summary-row order-summary-total-row">
                    <span>Toplam:</span>
                    <span class="order-summary-total">₺0.00</span>
                </div>
            </div>

            <button type="button" class="btn btn-primary" onclick="submitOrder()" style="width:100%;margin-top:1rem;">Siparişi Onayla</button>
        </form>
    </div>
</div>

<script src="/assets/js/cart.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
