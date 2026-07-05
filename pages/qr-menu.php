<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menü - Kanatçı Nihat</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body { padding: 1rem; }
        .menu-header { text-align: center; margin-bottom: 2rem; padding-top: 1rem; }
        .filter-tabs { display: flex; flex-wrap: wrap; justify-content: center; gap: 0.5rem; margin-bottom: 2rem; }
        .filter-btn { padding: 0.5rem 1rem; border: 1px solid var(--color-border); border-radius: 8px; background: var(--color-surface); cursor: pointer; font-family: var(--font-body); }
        .filter-btn.active { background: var(--color-primary); color: #fff; border-color: var(--color-primary); }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem; max-width: 1000px; margin: 0 auto; }
        .product-card { background: var(--color-surface); border-radius: var(--radius); padding: 1rem; box-shadow: var(--shadow); position: relative; }
        .product-badge { position: absolute; top: 0.5rem; right: 0.5rem; background: var(--color-accent); padding: 0.25rem 0.5rem; border-radius: 6px; font-size: 0.8rem; }
        .placeholder-image { font-size: 3rem; text-align: center; padding: 1rem; }
        .product-info h3 { font-size: 1.1rem; margin-bottom: 0.25rem; }
        .product-desc { color: var(--color-text-muted); font-size: 0.875rem; margin-bottom: 0.5rem; }
        .product-price { font-size: 1.25rem; font-weight: 700; color: var(--color-primary); }
    </style>
</head>
<body>
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

    <div class="products-grid">
        <?php $products = get_products(null, true); ?>
        <?php foreach ($products as $product): ?>
            <div class="product-card" data-category="<?php echo $product['category_id']; ?>">
                <?php if ($product['badge']): ?>
                    <span class="product-badge">
                        <?php $badges = ['popular' => 'Popüler ⭐', 'new' => 'Yeni 🔥', 'spicy' => 'Acılı 🌶️']; echo $badges[$product['badge']] ?? $product['badge']; ?>
                    </span>
                <?php endif; ?>
                <div class="placeholder-image">🍗</div>
                <div class="product-info">
                    <h3><?php echo $product['name']; ?></h3>
                    <p class="product-desc"><?php echo $product['description']; ?></p>
                    <p class="product-price">₺<?php echo number_format($product['price'], 2); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="/assets/js/main.js"></script>
</body>
</html>
