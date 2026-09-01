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
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(function(htmlOrJson) {
                    // Try parsing as JSON first
                    try {
                        var data = JSON.parse(htmlOrJson);
                        contentArea.innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                    } catch (e) {
                        // If it's HTML, just inject it
                        contentArea.innerHTML = htmlOrJson;
                    }
                })
                .catch(function(error) {
                    contentArea.innerHTML = '<div class="bilgiyapar-mcc-text-danger" style="padding: 20px;">Veri alınırken hata oluştu! Detay: ' + error.message + '</div>';
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
