<div class="bilgiyapar-mcc-dashboard-container">
    <div class="bilgiyapar-mcc-dashboard-header"><?= t('Manager Control Center') ?></div>

    <!-- 1. YÖNETİCİ FİNANS & STRATEJİ PANELİ -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><i class="fa fa-money"></i> <?= t('EXECUTIVE FINANCE & STRATEGY PANEL') ?></div>
        <div class="bilgiyapar-mcc-grid-4">
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getFinanceDetails', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="card-label"><?= t('Global Burn Rate') ?></div>
                <div class="card-value bilgiyapar-mcc-text-primary"><?= $this->helper->dashboardFormat->currency(isset($budget_total) ? $budget_total : 15000) ?> <small>/mo</small></div>
            </div>
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getMetrics', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="card-label"><?= t('Critical Metrics') ?></div>
                <div class="card-stats">
                    <span><strong>5</strong> <?= t('Active Projects') ?></span>
                    <span><strong>54</strong> <?= t('Open Tasks') ?></span>
                </div>
            </div>
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getFunding', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="card-label"><?= t('Funding & Revenue') ?></div>
                <div class="card-value">14 Gün Kaldı</div>
                <div class="card-sub">Hedef: 500.000 TL</div>
            </div>
        </div>
    </div>

    <!-- 2. ACİL DURUM & KRİTİK BLOKAJLAR -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><i class="fa fa-warning" style="color:#d9534f"></i> <?= t('EMERGENCY & CRITICAL BLOCKERS') ?></div>
        <div class="bilgiyapar-mcc-grid-2">
            <div class="bilgiyapar-mcc-card alert-red" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getBlockersList', array('plugin' => 'ExecutiveDashboard')) ?>">
                <i class="fa fa-ban"></i> <?= t('Total Critical Blockers') ?>: <strong>3</strong>
            </div>
            <div class="bilgiyapar-mcc-card alert-red">
                <i class="fa fa-file-text"></i> <?= t('Delayed Invoices') ?>: <strong>1</strong>
            </div>
        </div>
        <div class="bilgiyapar-mcc-list-card">
            <ul class="mcc-blocker-list">
                <li><strong>A.Ş. NACE Onayı: Mali Müşavir Bekleniyor</strong> (A.Ş. Kuruluşu Bloke) (3 Gün)</li>
                <li><strong>DUNS Numarası Evrak Eksik</strong> (ISAMA Bloke)</li>
            </ul>
        </div>
    </div>

    <!-- 5. ŞİRKET PROJELERİ & ÇEVİK MATRİSLER -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><i class="fa fa-cubes"></i> <?= t('COMPANY PROJECTS & AGILE MATRIX') ?></div>
        <div class="bilgiyapar-mcc-grid-5">
            <?php
            $mock_projects = ['ISAMA Hardware', 'FMHSCS SaaS', 'ISO 9001 Şablonu', '3D Pop-up Katalog', 'ISAMA Pazarlama'];
            foreach($mock_projects as $p): ?>
            <div class="bilgiyapar-mcc-card project-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getProjectMatrix', array('plugin' => 'ExecutiveDashboard')) ?>">
                <strong><?= $p ?></strong>
                <div class="project-health bilgiyapar-mcc-text-success"><i class="fa fa-circle"></i> Sağlıklı</div>
                <div class="project-burn" style="font-size:12px; margin-top:5px; color:#666;">Burn Rate: %5</div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Side Drawer HTML -->
<div id="bilgiyapar-mcc-sidedrawer" class="bilgiyapar-mcc-sidedrawer">
    <div class="bilgiyapar-mcc-sidedrawer-header">
        <h3 class="bilgiyapar-mcc-sidedrawer-title"><?= t('Details') ?></h3>
        <button class="bilgiyapar-mcc-sidedrawer-close">&times;</button>
    </div>
    <div class="bilgiyapar-mcc-sidedrawer-content">
        <!-- AJAX Content will load here -->
    </div>
</div>
