<li <?= $this->app->checkMenuSelection('ExecutiveDashboardController', 'index', 'ExecutiveDashboard') ? 'class="active"' : '' ?>>
    <?= $this->url->icon('briefcase', t('Yönetici Kontrol Merkezi'), 'ExecutiveDashboardController', 'index', ['plugin' => 'ExecutiveDashboard']) ?>
</li>
