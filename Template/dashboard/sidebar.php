<li id="mcc-sidebar-item" <?= $this->app->checkMenuSelection('ExecutiveDashboardController', 'index', 'ExecutiveDashboard') ? 'class="active"' : '' ?>>
    <?= $this->url->link('<i class="fa fa-briefcase fa-fw" aria-hidden="true"></i> <strong>' . t('Yönetici Kontrol Merkezi') . '</strong>', 'ExecutiveDashboardController', 'index', ['plugin' => 'ExecutiveDashboard']) ?>
</li>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var mccItem = document.getElementById("mcc-sidebar-item");
    if (mccItem) {
        var sidebarUl = mccItem.closest('.sidebar ul');
        if (sidebarUl && sidebarUl.children.length > 4) {
            sidebarUl.insertBefore(mccItem, sidebarUl.children[4]);
        }
    }
});
</script>