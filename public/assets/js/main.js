document.addEventListener('DOMContentLoaded', function() {
    // Menü Filtre Sekmeleri
    var filterBtns = document.querySelectorAll('.filter-btn');
    filterBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            filterBtns.forEach(function(b) { b.classList.remove('active'); });
            this.classList.add('active');

            var filter = this.dataset.filter;
            var cards = document.querySelectorAll('.product-card');

            cards.forEach(function(card) {
                if (filter === 'all' || card.dataset.category === filter) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Navbar scroll efekti
    var header = document.querySelector('.site-header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }

    // Mobil hamburger menü
    var menuToggle = document.querySelector('.menu-toggle');
    var navMenu = document.querySelector('.main-nav ul');
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('open');
        });
    }
});
