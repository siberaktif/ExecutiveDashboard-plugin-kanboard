<div class="bilgiyapar-mcc-dashboard-container">
    <div class="bilgiyapar-mcc-dashboard-header">YÖNETİCİ KONTROL MERKEZİ</div>

    <!-- 1. YÖNETİCİ FİNANS & STRATEJİ PANELİ -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title">YÖNETİCİ FİNANS & STRATEJİ PANELİ</div>
        <div class="bilgiyapar-mcc-dashboard-grid">
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getFinanceDetails', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-money bilgiyapar-mcc-text-success"></i>
                    <div class="bilgiyapar-mcc-card-title">Küresel Nakit Yakım Hızı</div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    <?= isset($budget_total) ? number_format($budget_total, 2) . ' ₺' : '0.00 ₺' ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. ACİL DURUM & KRİTİK BLOKAJLAR -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title">ACİL DURUM & KRİTİK BLOKAJLAR</div>
        <div class="bilgiyapar-mcc-dashboard-grid">
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getBlockers', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-warning bilgiyapar-mcc-text-danger"></i>
                    <div class="bilgiyapar-mcc-card-title">Toplam Kritik Blokaj</div>
                </div>
                <div class="bilgiyapar-mcc-card-content bilgiyapar-mcc-text-danger">
                    <?= isset($total_blockers) ? $total_blockers : 0 ?> Adet
                </div>
            </div>
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getBlockersList', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-ban bilgiyapar-mcc-text-warning"></i>
                    <div class="bilgiyapar-mcc-card-title">Blokaj Özeti</div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    <ul>
                        <li><?= isset($total_p1) ? $total_p1 : 0 ?> acil (P1) görev beklemede.</li>
                        <li>Bağımlılık kilitlenmesi tespit edildi.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. GÖREV BAĞIMLILIKLARI & KRİTİK YOL -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title">GÖREV BAĞIMLILIKLARI & KRİTİK YOL</div>
        <div class="bilgiyapar-mcc-dashboard-grid">
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getCriticalPath', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-road"></i>
                    <div class="bilgiyapar-mcc-card-title">Kritik Yol Analizi</div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    Analizi Gör
                </div>
            </div>
        </div>
    </div>

    <!-- 4. ZAMAN SINIRLI EYLEM PLANI -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title">ZAMAN SINIRLI EYLEM PLANI</div>
        <div class="bilgiyapar-mcc-dashboard-grid">
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getActionPlan', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-clock-o"></i>
                    <div class="bilgiyapar-mcc-card-title">Geciken Görevler</div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    Detayları İncele
                </div>
            </div>
        </div>
    </div>

    <!-- 5. ŞİRKET PROJELERİ & ÇEVİK MATRİSLER -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title">ŞİRKET PROJELERİ & ÇEVİK MATRİSLER</div>
        <div class="bilgiyapar-mcc-dashboard-grid">
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getProjectMatrix', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-cubes"></i>
                    <div class="bilgiyapar-mcc-card-title">Aktif Projeler</div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    <?= isset($total_projects) ? $total_projects : 0 ?> Proje
                </div>
            </div>
        </div>
    </div>

    <!-- 6. AI DESTEKLİ OPERASYONEL ÖNERİLER -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title">AI DESTEKLİ OPERASYONEL ÖNERİLER</div>
        <div class="bilgiyapar-mcc-dashboard-grid">
            <div class="bilgiyapar-mcc-card" data-url="<?= $this->url->href('ExecutiveDashboardController', 'getAiRecommendations', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-magic"></i>
                    <div class="bilgiyapar-mcc-card-title">Sistem Önerileri</div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    Önerileri Göster
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Side Drawer HTML -->
<div id="bilgiyapar-mcc-sidedrawer" class="bilgiyapar-mcc-sidedrawer">
    <div class="bilgiyapar-mcc-sidedrawer-header">
        <h3 class="bilgiyapar-mcc-sidedrawer-title">Detaylar</h3>
        <button class="bilgiyapar-mcc-sidedrawer-close">&times;</button>
    </div>
    <div class="bilgiyapar-mcc-sidedrawer-content">
        <!-- AJAX Content will load here -->
    </div>
</div>
