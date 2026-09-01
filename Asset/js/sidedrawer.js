document.addEventListener("DOMContentLoaded", function() {
    var cards = document.querySelectorAll('.bilgiyapar-mcc-card');
    var drawer = document.getElementById('bilgiyapar-mcc-sidedrawer');
    var closeBtn = document.querySelector('.bilgiyapar-mcc-sidedrawer-close');
    var contentArea = document.querySelector('.bilgiyapar-mcc-sidedrawer-content');

    cards.forEach(function(card) {
        card.addEventListener('click', function() {
            var url = card.getAttribute('data-url');
            if(url && url !== '#') {
                // Show drawer
                drawer.classList.add('bilgiyapar-mcc-sidedrawer-open');
                contentArea.innerHTML = '<div class="bilgiyapar-mcc-loading">Yükleniyor...</div>';

                // Fetch data
                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    contentArea.innerHTML = data.html ? data.html : JSON.stringify(data);
                })
                .catch(error => {
                    contentArea.innerHTML = '<div class="bilgiyapar-mcc-text-danger" style="padding: 20px;">Veri alınırken hata oluştu! Controller metodunu kontrol edin.</div>';
                });
            }
        });
    });

    if(closeBtn) {
        closeBtn.addEventListener('click', function() {
            drawer.classList.remove('bilgiyapar-mcc-sidedrawer-open');
        });
    }
});
