<li class="mcc-menu-item" <?= $this->app->checkMenuSelection('ExecutiveDashboardController', 'index', 'ExecutiveDashboard') ? 'class="active"' : '' ?>>
    <?= $this->url->icon('briefcase', t('Yönetici Kontrol Merkezi'), 'ExecutiveDashboardController', 'index', ['plugin' => 'ExecutiveDashboard']) ?>
</li>
<script>
(function() {
    try {
        var mccs = document.querySelectorAll('.mcc-menu-item');
        for (var i = 0; i < mccs.length; i++) {
            var mcc = mccs[i];
            
            mcc.style.cssText += ' font-weight: normal !important;';
            var tags = mcc.querySelectorAll('a, span, i, strong, b');
            for(var k=0; k<tags.length; k++) {
                tags[k].style.cssText += ' font-weight: normal !important;';
            }

            var ul = mcc.parentNode;
            if (ul) {
                var agile = null, todo = null;
                var lis = ul.children;
                for (var j = 0; j < lis.length; j++) {
                    var html = lis[j].innerHTML || "";
                    if (html.indexOf('AgileIndicators') !== -1) { agile = lis[j]; }
                    if (html.indexOf('TodoNotes') !== -1) { todo = lis[j]; }
                }
                
                if (ul.parentNode && (ul.parentNode.className.indexOf('sidebar') !== -1 || ul.className.indexOf('sidebar') !== -1)) {
                    if (lis.length >= 5) {
                        ul.insertBefore(mcc, ul.children[4]);
                    }
                }
                
                if (todo) { ul.insertBefore(mcc, todo); }
                if (agile) {
                    if (todo) { ul.insertBefore(agile, todo.nextSibling); }
                    else { ul.insertBefore(agile, mcc.nextSibling); }
                }
            }
        }
    } catch(e) {}
})();
</script>