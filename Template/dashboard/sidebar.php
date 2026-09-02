<li id="mcc-sidebar-item" <?= $this->app->checkMenuSelection('ExecutiveDashboardController', 'index', 'ExecutiveDashboard') ? 'class="active"' : '' ?>>
    <?= $this->url->link('<i class="fa fa-briefcase fa-fw" aria-hidden="true"></i> ' . t('Yönetici Kontrol Merkezi'), 'ExecutiveDashboardController', 'index', ['plugin' => 'ExecutiveDashboard']) ?>
</li>
<script>
(function() {
    try {
        var mcc = document.getElementById('mcc-sidebar-item');
        if (mcc && mcc.parentNode) {
            var ul = mcc.parentNode;
            var lis = ul.querySelectorAll('li');
            // Kanboard core has exactly 4 items before plugins (Overview, My projects, My tasks, My subtasks)
            // If there are at least 5 items, we want mcc to be the 5th item (index 4).
            // This pushes AgileIndicators and others down.
            if (lis.length >= 5) {
                ul.insertBefore(mcc, lis[4]);
            }
        }
    } catch(e) {}
})();
</script>