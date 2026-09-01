<div class="bilgiyapar-mcc-dashboard-container">
    <div class="bilgiyapar-mcc-dashboard-header"><?= t('Manager Control Center') ?></div>

    <!-- 1. YÖNETİCİ FİNANS & STRATEJİ PANELİ -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('EXECUTIVE FINANCE & STRATEGY PANEL') ?></div>
        <div class="bilgiyapar-mcc-dashboard-grid">
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getFinanceDetails', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-money bilgiyapar-mcc-text-success"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Global Burn Rate') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    <?= $this->helper->dashboardFormat->currency(isset($budget_total) ? $budget_total : 0) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. ACİL DURUM & KRİTİK BLOKAJLAR -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('EMERGENCY & CRITICAL BLOCKERS') ?></div>
        <div class="bilgiyapar-mcc-dashboard-grid">
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getBlockersList', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-warning bilgiyapar-mcc-text-danger"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Total Critical Blockers') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content bilgiyapar-mcc-text-danger">
                    <?= isset($total_blockers) ? $total_blockers : 0 ?> <?= t('Tasks') ?>
                </div>
            </div>
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getBlockersList', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-ban bilgiyapar-mcc-text-warning"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Blocker Summary') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    <ul>
                        <li><?= isset($total_p1) ? $total_p1 : 0 ?> <?= t('Emergency (P1) tasks pending.') ?></li>
                        <li><?= t('Dependency lock detected.') ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. GÖREV BAĞIMLILIKLARI & KRİTİK YOL -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('TASK DEPENDENCIES & CRITICAL PATH') ?></div>
        <div class="bilgiyapar-mcc-dashboard-grid">
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getCriticalPath', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-road"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Critical Path Analysis') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    <?= t('View Analysis') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. ZAMAN SINIRLI EYLEM PLANI -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('TIME BOUND ACTION PLAN') ?></div>
        <div class="bilgiyapar-mcc-dashboard-grid">
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getActionPlan', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-clock-o"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Delayed Tasks') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    <?= t('Examine Details') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. ŞİRKET PROJELERİ & ÇEVİK MATRİSLER -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('COMPANY PROJECTS & AGILE MATRIX') ?></div>
        <div class="bilgiyapar-mcc-dashboard-grid">
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getProjectMatrix', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-cubes"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Active Projects') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    <?= isset($total_projects) ? $total_projects : 0 ?> <?= t('Projects') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 6. AI DESTEKLİ OPERASYONEL ÖNERİLER -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('AI SUPPORTED OPERATIONAL RECOMMENDATIONS') ?></div>
        <div class="bilgiyapar-mcc-dashboard-grid">
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getAiRecommendations', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-magic"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('System Recommendations') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    <?= t('Show Recommendations') ?>
                </div>
            </div>
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
