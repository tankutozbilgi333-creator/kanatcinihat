class Cart {
    constructor() {
        this.items = this.load();
        this.render();
        this.updateUI();
    }

    load() {
        try {
            return JSON.parse(localStorage.getItem('cart')) || [];
        } catch {
            return [];
        }
    }

    save() {
        localStorage.setItem('cart', JSON.stringify(this.items));
    }

    add(product) {
        var existing = this.items.find(function(i) { return i.id === product.id; });
        if (existing) {
            existing.quantity += 1;
        } else {
            this.items.push({ id: product.id, name: product.name, price: product.price, quantity: 1 });
        }
        this.save();
        this.render();
        this.updateUI();
        this.showNotification('"' + product.name + '" sepete eklendi.');
    }

    remove(productId) {
        this.items = this.items.filter(function(i) { return i.id !== productId; });
        this.save();
        this.render();
        this.updateUI();
    }

    updateQuantity(productId, delta) {
        var item = this.items.find(function(i) { return i.id === productId; });
        if (item) {
            item.quantity += delta;
            if (item.quantity <= 0) {
                this.remove(productId);
                return;
            }
            this.save();
            this.render();
            this.updateUI();
        }
    }

    getTotal() {
        var total = 0;
        this.items.forEach(function(i) { total += i.price * i.quantity; });
        return total;
    }

    getCount() {
        var count = 0;
        this.items.forEach(function(i) { count += i.quantity; });
        return count;
    }

    clear() {
        this.items = [];
        this.save();
        this.render();
        this.updateUI();
    }

    render() {
        var panel = document.getElementById('cart-panel');
        if (!panel) return;

        var list = panel.querySelector('.cart-items');
        var totalEl = panel.querySelector('.cart-total');
        var countEl = panel.querySelector('.cart-count');

        if (!list) return;

        if (this.items.length === 0) {
            list.innerHTML = '<li class="cart-empty">Sepetiniz boş.</li>';
            if (totalEl) totalEl.textContent = '₺0.00';
            if (countEl) countEl.textContent = '0';
            return;
        }

        var html = '';
        var self = this;
        this.items.forEach(function(item) {
            html += '<li class="cart-item">' +
                '<span class="cart-item-name">' + item.name + '</span>' +
                '<div class="cart-item-controls">' +
                    '<button class="cart-qty-btn" data-id="' + item.id + '" data-delta="-1">−</button>' +
                    '<span class="cart-item-qty">' + item.quantity + '</span>' +
                    '<button class="cart-qty-btn" data-id="' + item.id + '" data-delta="1">+</button>' +
                    '<span class="cart-item-price">₺' + (item.price * item.quantity).toFixed(2) + '</span>' +
                    '<button class="cart-remove-btn" data-id="' + item.id + '">×</button>' +
                '</div>' +
            '</li>';
        });
        list.innerHTML = html;
        if (totalEl) totalEl.textContent = '₺' + this.getTotal().toFixed(2);
        if (countEl) countEl.textContent = this.getCount();
    }

    updateUI() {
        var count = this.getCount();
        document.querySelectorAll('.cart-count').forEach(function(el) { el.textContent = count; });
        document.querySelectorAll('.cart-total').forEach(function(el) { el.textContent = '₺' + this.getTotal().toFixed(2); }.bind(this));

        var stickyBtn = document.querySelector('.cart-sticky-btn');
        if (stickyBtn) {
            stickyBtn.style.display = count > 0 ? 'flex' : 'none';
            stickyBtn.querySelector('.cart-sticky-count').textContent = count;
        }
    }

    showNotification(msg) {
        var n = document.createElement('div');
        n.className = 'cart-notification';
        n.textContent = msg;
        document.body.appendChild(n);
        setTimeout(function() { n.classList.add('show'); }, 10);
        setTimeout(function() { n.classList.remove('show'); setTimeout(function() { n.remove(); }, 300); }, 2000);
    }

    togglePanel() {
        var panel = document.getElementById('cart-panel');
        if (panel) {
            panel.classList.toggle('open');
        }
    }

    getOrderData() {
        return {
            items: this.items.map(function(i) {
                return { product_id: i.id, name: i.name, price: i.price, quantity: i.quantity };
            }),
            total: this.getTotal()
        };
    }
}

var cart;

document.addEventListener('DOMContentLoaded', function() {
    cart = new Cart();

    document.addEventListener('click', function(e) {
        // Sepete ekle butonu
        if (e.target.classList.contains('add-to-cart')) {
            var btn = e.target;
            cart.add({ id: parseInt(btn.dataset.id), name: btn.dataset.name, price: parseFloat(btn.dataset.price) });
        }

        // Miktar değiştirme
        if (e.target.classList.contains('cart-qty-btn')) {
            cart.updateQuantity(parseInt(e.target.dataset.id), parseInt(e.target.dataset.delta));
        }

        // Ürün sil
        if (e.target.classList.contains('cart-remove-btn')) {
            cart.remove(parseInt(e.target.dataset.id));
        }

        // Sepet paneli toggle
        if (e.target.classList.contains('cart-toggle')) {
            cart.togglePanel();
        }

        // Sepeti temizle
        if (e.target.classList.contains('cart-clear-btn')) {
            if (confirm('Sepeti temizlemek istediğinize emin misiniz?')) {
                cart.clear();
            }
        }

        // Sipariş ver butonu
        if (e.target.classList.contains('checkout-btn')) {
            if (cart.getCount() > 0) {
                openOrderModal();
            }
        }
    });
});

function openOrderModal() {
    var modal = document.getElementById('order-modal');
    if (!modal) return;

    var summary = modal.querySelector('.order-summary-items');
    if (summary) {
        var html = '';
        cart.items.forEach(function(item) {
            html += '<div class="order-summary-row">' +
                '<span>' + item.name + ' × ' + item.quantity + '</span>' +
                '<span>₺' + (item.price * item.quantity).toFixed(2) + '</span>' +
            '</div>';
        });
        summary.innerHTML = html;
    }
    var totalEl = modal.querySelector('.order-summary-total');
    if (totalEl) {
        totalEl.textContent = '₺' + cart.getTotal().toFixed(2);
    }

    modal.classList.add('open');
}

function closeOrderModal() {
    var modal = document.getElementById('order-modal');
    if (modal) modal.classList.remove('open');
}

function submitOrder() {
    var modal = document.getElementById('order-modal');
    var name = modal.querySelector('#customer_name').value.trim();
    var phone = modal.querySelector('#customer_phone').value.trim();
    var address = modal.querySelector('#customer_address').value.trim();
    var note = modal.querySelector('#customer_note').value.trim();

    if (!name || !phone || !address) {
        alert('Lütfen ad, telefon ve adres alanlarını doldurun.');
        return;
    }

    // Sipariş verilerini form'a ekle
    var itemsInput = document.getElementById('order-items-json');
    if (itemsInput) {
        itemsInput.value = JSON.stringify(cart.items.map(function(i) {
            return { product_id: i.id, name: i.name, price: i.price, quantity: i.quantity };
        }));
    }

    document.getElementById('order-form').submit();
}
