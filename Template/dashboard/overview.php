<div class="bilgiyapar-mcc-dashboard-container">
    <div class="bilgiyapar-mcc-dashboard-header"><?= t('Yönetici Kontrol Merkezi') ?></div>

    <!-- 1. YÖNETİCİ FİNANS & STRATEJİ PANELİ -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><i class="fa fa-money"></i> <?= t('YÖNETİCİ FİNANS & STRATEJİ PANELİ') ?></div>
        <div class="bilgiyapar-mcc-grid-4">
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getFinanceDetails', array('plugin' => 'ExecutiveDashboard')) ?>" onclick="MCC.openDrawer(this)">
                <div class="card-label"><?= t('Küresel Nakit Yakım Hızı') ?></div>
                <div class="card-value bilgiyapar-mcc-text-primary"><?= $this->helper->dashboardFormat->currency(isset($global_burn_rate) ? $global_burn_rate : 15000) ?> <small>/mo</small></div>
            </div>

            <!-- Donut Grafiği -->
            <div class="bilgiyapar-mcc-card" style="display:flex; align-items:center;">
                <div class="donut-chart" style="width: 60px; height: 60px; border-radius: 50%; background: conic-gradient(#5cb85c 0% 40%, #d9534f 40% 100%); margin-right:15px;"></div>
                <div>
                    <div style="font-weight:bold; color:#d9534f">%60 Harcanan</div>
                    <div style="font-weight:bold; color:#5cb85c">%40 Kalan</div>
                </div>
            </div>

            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getMetrics', array('plugin' => 'ExecutiveDashboard')) ?>" onclick="MCC.openDrawer(this)">
                <div class="card-label"><?= t('Kritik Metrikler') ?></div>
                <div class="card-stats">
                    <span><strong><?= $active_projects ?? 5 ?></strong> <?= t('Aktif Proje') ?></span>
                    <span><strong><?= $open_tasks ?? 54 ?></strong> <?= t('Açık Görev') ?></span>
                </div>
            </div>
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getFunding', array('plugin' => 'ExecutiveDashboard')) ?>" onclick="MCC.openDrawer(this)">
                <div class="card-label"><?= t('Genişletilmiş Fonlama & Gelir') ?></div>
                <div class="card-value">14 Gün Kaldı</div>
                <div class="card-sub">Hedef: 500.000 TL</div>
            </div>
        </div>
    </div>

    <!-- 2. ACİL DURUM & KRİTİK BLOKAJLAR -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><i class="fa fa-warning" style="color:#d9534f"></i> <?= t('ACİL DURUM & KRİTİK BLOKAJLAR') ?></div>
        <div class="bilgiyapar-mcc-grid-2">
            <div class="bilgiyapar-mcc-card alert-red" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getBlockerDetails', array('plugin' => 'ExecutiveDashboard')) ?>" onclick="MCC.openDrawer(this)">
                <i class="fa fa-ban"></i> <?= t('Toplam Kritik Blokaj') ?>: <strong><?= $total_blockers ?? 3 ?></strong>
            </div>
            <div class="bilgiyapar-mcc-card alert-red">
                <i class="fa fa-file-text"></i> <?= t('Gecikmiş Fatura') ?>: <strong>1</strong>
            </div>
        </div>

        <!-- Hiyerarşik Tree View (Monospaced) -->
        <div class="bilgiyapar-mcc-list-card">
            <div style="font-family: monospace; font-size: 13px; line-height: 1.6; color: #333;">
                <div>[A.Ş. Resmi İşlemler]</div>
                <div>|-- A.Ş. NACE Onayı (GÖREV)</div>
                <div>&nbsp;&nbsp;&nbsp;└─ <span style="color:#d9534f; font-weight:bold;">Mali Müşavir Bekleniyor (BLOKE)</span></div>
                <div style="margin-top:10px;">[ISAMA Play Store Yayını]</div>
                <div>|-- Apple Developer Hesabı</div>
                <div>&nbsp;&nbsp;&nbsp;└─ <span style="color:#d9534f; font-weight:bold;">DUNS Numarası Evrak Eksik (BLOKE)</span></div>
            </div>
        </div>
    </div>
</div>

<!-- Side Drawer HTML -->
<div id="bilgiyapar-mcc-sidedrawer" class="bilgiyapar-mcc-sidedrawer">
    <div class="bilgiyapar-mcc-sidedrawer-header">
        <h3 class="bilgiyapar-mcc-sidedrawer-title"><?= t('Detaylar') ?></h3>
        <button class="bilgiyapar-mcc-sidedrawer-close" onclick="document.getElementById('bilgiyapar-mcc-sidedrawer').classList.remove('bilgiyapar-mcc-sidedrawer-open');">&times;</button>
    </div>
    <div id="bilgiyapar-mcc-sidedrawer-content" class="bilgiyapar-mcc-sidedrawer-content">
        <!-- AJAX Content will load here -->
    </div>
</div>
