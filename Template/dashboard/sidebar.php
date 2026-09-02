<li <?= $this->app->checkMenuSelection('ExecutiveDashboardController', 'index', 'ExecutiveDashboard') ? 'class="active"' : '' ?>>
    <?= $this->url->link('<i class="fa fa-briefcase fa-fw" aria-hidden="true"></i> <strong>' . t('Yönetici Kontrol Merkezi') . '</strong>', 'ExecutiveDashboardController', 'index', ['plugin' => 'ExecutiveDashboard']) ?>
</li>