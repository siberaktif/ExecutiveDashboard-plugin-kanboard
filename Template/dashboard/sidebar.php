<li <?= $this->app->checkMenuSelection('ExecutiveDashboardController') ?>>
    <?= $this->url->link(t('Yönetici Kontrol Merkezi'), 'ExecutiveDashboardController', 'index', array('plugin' => 'ExecutiveDashboard')) ?>
</li>
