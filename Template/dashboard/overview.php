<div class="sencar-mcc-dashboard-container">
    <h2>Yönetici Kontrol Merkezi</h2>
    
    <div class="sencar-mcc-dashboard-grid">
        <div class="sencar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getCriticalTasks', array('plugin' => 'ExecutiveDashboard')) ?>">
            <div class="sencar-mcc-card-title">Acil Durum (P1) Görevleri</div>
            <div class="sencar-mcc-card-value sencar-mcc-text-danger">Yükleniyor...</div>
        </div>

        <div class="sencar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getBlockers', array('plugin' => 'ExecutiveDashboard')) ?>">
            <div class="sencar-mcc-card-title">Blokajlar</div>
            <div class="sencar-mcc-card-value sencar-mcc-text-warning">Yükleniyor...</div>
        </div>
    </div>
</div>

<!-- Side Drawer HTML -->
<div id="sencar-mcc-sidedrawer" class="sencar-mcc-sidedrawer">
    <div class="sencar-mcc-sidedrawer-header">
        <h3 class="sencar-mcc-sidedrawer-title">Detaylar</h3>
        <button class="sencar-mcc-sidedrawer-close">&times;</button>
    </div>
    <div class="sencar-mcc-sidedrawer-content">
        <!-- AJAX Content will load here -->
    </div>
</div>
