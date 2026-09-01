document.addEventListener("DOMContentLoaded", function() {
    var cards = document.querySelectorAll('.sencar-mcc-card');
    var drawer = document.getElementById('sencar-mcc-sidedrawer');
    var closeBtn = document.querySelector('.sencar-mcc-sidedrawer-close');
    var contentArea = document.querySelector('.sencar-mcc-sidedrawer-content');

    cards.forEach(function(card) {
        card.addEventListener('click', function() {
            var url = card.getAttribute('data-url');
            if(url) {
                // Show drawer
                drawer.classList.add('sencar-mcc-sidedrawer-open');
                contentArea.innerHTML = '<div class="sencar-mcc-loading">Yükleniyor...</div>';
                
                // Fetch data
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Very simple render just to show it's working
                    contentArea.innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                })
                .catch(error => {
                    contentArea.innerHTML = '<div class="sencar-mcc-text-danger">Hata oluştu!</div>';
                });
            }
        });
    });

    if(closeBtn) {
        closeBtn.addEventListener('click', function() {
            drawer.classList.remove('sencar-mcc-sidedrawer-open');
        });
    }
});
