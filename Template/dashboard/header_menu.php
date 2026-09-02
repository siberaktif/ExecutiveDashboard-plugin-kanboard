<li class="mcc-menu-item" <?= $this->app->checkMenuSelection('ExecutiveDashboardController', 'index', 'ExecutiveDashboard') ? 'class="active"' : '' ?>>
    <?= $this->url->icon('briefcase', '<span style="font-weight: normal !important;">' . t('Yönetici Kontrol Merkezi') . '</span>', 'ExecutiveDashboardController', 'index', ['plugin' => 'ExecutiveDashboard']) ?>
</li>
<script>
(function() {
    try {
        var mccs = document.querySelectorAll('.mcc-menu-item');
        mccs.forEach(function(mcc) {
            var ul = mcc.parentNode;
            if (ul) {
                var agile = null, todo = null;
                var lis = ul.children;
                for (var i = 0; i < lis.length; i++) {
                    var txt = lis[i].textContent || lis[i].innerText;
                    if (txt.indexOf('AgileIndicators') !== -1 || txt.indexOf('Agile') === 0) agile = lis[i];
                    if (txt.indexOf('Notlarım') !== -1 || txt.indexOf('TodoNotes') !== -1) todo = lis[i];
                }
                
                // If it's the sidebar, lock MCC under the 4 core items
                if (ul.parentNode && (ul.parentNode.classList.contains('sidebar') || ul.classList.contains('sidebar'))) {
                    if (lis.length >= 5) {
                        ul.insertBefore(mcc, ul.children[4]);
                    }
                }
                
                // Relative Sorting for Dropdowns/Headers: MCC -> TodoNotes -> AgileIndicators
                if (todo) { ul.insertBefore(mcc, todo); }
                if (agile) {
                    if (todo) { ul.insertBefore(agile, todo.nextSibling); }
                    else { ul.insertBefore(agile, mcc.nextSibling); }
                }
            }
        });
    } catch(e) {}
})();
</script>