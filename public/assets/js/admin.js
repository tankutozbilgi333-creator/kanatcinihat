function getCsrfToken() {
    var meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

function confirmDelete(productName) {
    return confirm("'" + productName + "' adlı ürünü silmek istediğinize emin misiniz?");
}

document.addEventListener('DOMContentLoaded', function() {
    // Fotoğraf önizleme
    const imageInput = document.getElementById('image');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.querySelector('.image-preview');
                    if (preview) {
                        preview.innerHTML = '<img src="' + e.target.result + '" alt="Önizleme" width="100">';
                    } else {
                        const container = document.createElement('div');
                        container.className = 'image-preview';
                        container.innerHTML = '<img src="' + e.target.result + '" alt="Önizleme" width="100">';
                        imageInput.parentNode.appendChild(container);
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Sipariş durum güncelleme
    document.querySelectorAll('.order-status-select').forEach(function(select) {
        select.addEventListener('change', function() {
            const orderId = this.dataset.orderId;
            const status = this.value;
            const token = getCsrfToken();

            fetch('/admin/order_update_status', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + orderId + '&status=' + status + '&_csrf_token=' + encodeURIComponent(token)
            })
            .then(function(response) { return response.text(); })
            .then(function(data) {
                if (data === 'OK') {
                    var alert = document.createElement('div');
                    alert.className = 'alert alert-success';
                    alert.textContent = 'Sipariş durumu güncellendi.';
                    document.querySelector('main').insertBefore(alert, document.querySelector('main').firstChild);
                    setTimeout(function() { alert.remove(); }, 3000);
                }
            });
        });
    });

    // Rezervasyon onay/iptal
    document.querySelectorAll('.reservation-action').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const action = this.dataset.action;
            const token = getCsrfToken();
            const row = this.closest('tr');

            if (action === 'cancel' && !confirm('Rezervasyonu iptal etmek istediğinize emin misiniz?')) {
                return;
            }

            fetch('/admin/reservation_update_status', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + id + '&action=' + action + '&_csrf_token=' + encodeURIComponent(token)
            })
            .then(function(response) { return response.text(); })
            .then(function(data) {
                if (data === 'OK') {
                    location.reload();
                }
            });
        });
    });

    // Mesaj okundu işaretleme
    document.querySelectorAll('.mark-read-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const messageId = this.dataset.messageId;
            const row = this.closest('tr');
            const token = getCsrfToken();

            fetch('/admin/message_mark_read', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + messageId + '&_csrf_token=' + encodeURIComponent(token)
            })
            .then(function(response) { return response.text(); })
            .then(function(data) {
                if (data === 'OK') {
                    row.style.opacity = '0.5';
                    btn.disabled = true;
                    btn.textContent = 'Okundu';
                }
            });
        });
    });
});
