<div class="bilgiyapar-mcc-dashboard-container">
    <div class="bilgiyapar-mcc-dashboard-header"><?= t('YÖNETİCİ KONTROL MERKEZİ') ?></div>

    <!-- 1. YÖNETİCİ FİNANS & STRATEJİ PANELİ -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('YÖNETİCİ FİNANS & STRATEJİ PANELİ') ?></div>
        <div class="bilgiyapar-mcc-grid-4">
            <!-- Finans Kartı -->
            <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('ExecutiveDashboardController', 'getFinanceDetails', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-money bilgiyapar-mcc-text-success"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Küresel Nakit Yakım Hızı') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content bilgiyapar-mcc-donut-wrapper">
                    <div class="bilgiyapar-mcc-donut">
                        <span class="bilgiyapar-mcc-donut-text">%60</span>
                    </div>
                    <div class="bilgiyapar-mcc-donut-legend">
                        <div class="card-value"><?= $this->helper->dashboardFormat->currency(isset($budget_spent) ? $budget_spent : 90000) ?></div>
                        <div class="card-sub"><?= t('Harcanan Bütçe') ?></div>
                        <div style="margin-top: 5px;">
                            <span style="background: #d9534f; display:inline-block; width:10px; height:10px; border-radius:50%;"></span> <?= t('Harcanan') ?> (%60)<br>
                            <span style="background: #5cb85c; display:inline-block; width:10px; height:10px; border-radius:50%;"></span> <?= t('Kalan') ?> (%40)
                        </div>
                    </div>
                </div>
            </a>
            
            <!-- Ek Metrik Kartı Mock -->
            <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('ExecutiveDashboardController', 'getMetrics', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-line-chart bilgiyapar-mcc-text-primary"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Performans Metrikleri') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    <div class="card-value">Verimli</div>
                    <div class="card-sub">Son 30 gün operasyon puanı: %85</div>
                </div>
            </a>
        </div>
    </div>

    <!-- 2. ACİL DURUM & KRİTİK BLOKAJLAR -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('ACİL DURUM & KRİTİK BLOKAJLAR') ?></div>
        <div class="bilgiyapar-mcc-grid-2">
            <!-- Blokaj Özet -->
            <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('ExecutiveDashboardController', 'getBlockersList', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-warning bilgiyapar-mcc-text-danger"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Toplam Kritik Blokaj') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content bilgiyapar-mcc-text-danger">
                    <?= isset($total_blockers) ? $total_blockers : 3 ?> <?= t('Görev') ?>
                </div>
            </a>
            
            <!-- Hiyerarşik Ağaç -->
            <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('ExecutiveDashboardController', 'getBlockersList', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-sitemap bilgiyapar-mcc-text-warning"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Blokaj Ağacı') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    <div class="bilgiyapar-mcc-tree" style="font-family:monospace">
<span class="highlight">A.Ş. Resmi İşlemler (Ana Proje)</span>
|-- <span class="highlight">Vergi Yapılandırması</span> (P1 - Bloke)
|   └─ Evrak Teslimi (Gecikmeli)
|
|-- İK İşe Alım Modülü
    └─ Bütçe Onayı Bekleniyor
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- 3. GÖREV BAĞIMLILIKLARI & KRİTİK YOL (RELATIONGRAPH) -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('GÖREV BAĞIMLILIKLARI & KRİTİK YOL') ?></div>
        <div class="bilgiyapar-mcc-grid-2">
            <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('ExecutiveDashboardController', 'getCriticalPath', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-road bilgiyapar-mcc-text-primary"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Kritik Yol (Critical Path)') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    <div class="card-sub">Ana süreçlerdeki darboğazların ağ analizi yüklenmeye hazır.</div>
                    <button class="bilgiyapar-mcc-btn" style="margin-top:10px;"><i class="fa fa-eye"></i> Haritayı Aç</button>
                </div>
            </a>
        </div>
    </div>

    <!-- 4. ZAMAN SINIRLI EYLEM PLANI -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('ZAMAN SINIRLI EYLEM PLANI') ?></div>
        <div class="bilgiyapar-mcc-action-grid">
            <!-- Başlıklar -->
            <div class="bilgiyapar-mcc-action-header bilgiyapar-mcc-role-header">Kişiler / Roller</div>
            <div class="bilgiyapar-mcc-action-header">BUGÜN (P1 Acil)</div>
            <div class="bilgiyapar-mcc-action-header">BU HAFTA (Sprint Hedefi)</div>
            <div class="bilgiyapar-mcc-action-header">BU AY (Stratejik)</div>

            <?php if(isset($users) && !empty($users)): ?>
                <?php foreach($users as $u): ?>
                    <div class="bilgiyapar-mcc-action-col">
                        <div class="bilgiyapar-mcc-role-item"><i class="fa fa-user" style="margin-right:8px; color:#007bff;"></i> <?= htmlspecialchars($u['name'] ?: $u['username']) ?></div>
                    </div>
                    
                    <!-- BUGÜN -->
                    <div class="bilgiyapar-mcc-action-col">
                        <?php 
                        $hasToday = false;
                        if(isset($tasks_today)) {
                            foreach($tasks_today as $t) {
                                if($t['owner_id'] == $u['id']) {
                                    $hasToday = true;
                                    echo '<a target="_blank" style="text-decoration:none; display:flex; color:inherit;" class="bilgiyapar-mcc-mini-card" href="'.$this->url->href('ExecutiveDashboardController', 'getActionPlan', array('plugin' => 'ExecutiveDashboard')).'"><div class="bilgiyapar-mcc-mini-card-top"><span class="bilgiyapar-mcc-mini-card-title">'.htmlspecialchars($t['title']).'</span><i class="fa fa-warning bilgiyapar-mcc-text-danger"></i></div><div class="bilgiyapar-mcc-progress-bg"><div class="bilgiyapar-mcc-progress-bar" style="width: 25%; background-color:#d9534f;"></div></div></a>';
                                }
                            }
                        }
                        if(!$hasToday) echo '<div style="font-size:12px; color:#999; text-align:center; padding:10px;">Hedef Bulunmuyor</div>';
                        ?>
                    </div>

                    <!-- BU HAFTA -->
                    <div class="bilgiyapar-mcc-action-col">
                        <?php 
                        $hasWeek = false;
                        if(isset($tasks_week)) {
                            foreach($tasks_week as $t) {
                                if($t['owner_id'] == $u['id']) {
                                    $hasWeek = true;
                                    echo '<a target="_blank" style="text-decoration:none; display:flex; color:inherit;" class="bilgiyapar-mcc-mini-card" href="'.$this->url->href('ExecutiveDashboardController', 'getActionPlan', array('plugin' => 'ExecutiveDashboard')).'"><div class="bilgiyapar-mcc-mini-card-top"><span class="bilgiyapar-mcc-mini-card-title">'.htmlspecialchars($t['title']).'</span><i class="fa fa-check-circle bilgiyapar-mcc-text-success"></i></div><div class="bilgiyapar-mcc-progress-bg"><div class="bilgiyapar-mcc-progress-bar" style="width: 50%; background-color:#5cb85c;"></div></div></a>';
                                }
                            }
                        }
                        if(!$hasWeek) echo '<div style="font-size:12px; color:#999; text-align:center; padding:10px;">Hedef Bulunmuyor</div>';
                        ?>
                    </div>

                    <!-- BU AY -->
                    <div class="bilgiyapar-mcc-action-col">
                        <?php 
                        $hasMonth = false;
                        if(isset($tasks_month)) {
                            foreach($tasks_month as $t) {
                                if($t['owner_id'] == $u['id']) {
                                    $hasMonth = true;
                                    echo '<a target="_blank" style="text-decoration:none; display:flex; color:inherit;" class="bilgiyapar-mcc-mini-card" href="'.$this->url->href('ExecutiveDashboardController', 'getActionPlan', array('plugin' => 'ExecutiveDashboard')).'"><div class="bilgiyapar-mcc-mini-card-top"><span class="bilgiyapar-mcc-mini-card-title">'.htmlspecialchars($t['title']).'</span><i class="fa fa-clock-o bilgiyapar-mcc-text-primary"></i></div><div class="bilgiyapar-mcc-progress-bg"><div class="bilgiyapar-mcc-progress-bar" style="width: 10%; background-color:#007bff;"></div></div></a>';
                                }
                            }
                        }
                        if(!$hasMonth) echo '<div style="font-size:12px; color:#999; text-align:center; padding:10px;">Hedef Bulunmuyor</div>';
                        ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- 5. ŞİRKET PROJELERİ & ÇEVİK MATRİSLER -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('ŞİRKET PROJELERİ & ÇEVİK MATRİSLER') ?></div>
        <div class="bilgiyapar-mcc-grid-4">
            <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('ExecutiveDashboardController', 'getProjectMatrix', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-cubes"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Olympos Projesi') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content" style="font-size:14px; font-weight:normal;">
                    <div class="bilgiyapar-mcc-velocity-badge">Velocity C35</div>
                    
                    <div class="bilgiyapar-mcc-progress-bg" style="height:8px; margin-top:10px;">
                        <div class="bilgiyapar-mcc-progress-bar" style="width: 75%; background-color:#f0ad4e;"></div>
                    </div>
                    
                    <div class="bilgiyapar-mcc-wip-alert">
                        <i class="fa fa-exclamation-triangle"></i> WIP Limit Aşımı (Tasarım)
                    </div>
                </div>
            </a>
            
            <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('ExecutiveDashboardController', 'getProjectMatrix', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-cubes"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Kurumsal Web V2') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content" style="font-size:14px; font-weight:normal;">
                    <div class="bilgiyapar-mcc-velocity-badge" style="background:#dff0d8; color:#3c763d;">Velocity C10</div>
                    
                    <div class="bilgiyapar-mcc-progress-bg" style="height:8px; margin-top:10px;">
                        <div class="bilgiyapar-mcc-progress-bar" style="width: 40%; background-color:#5cb85c;"></div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- 6. AI DESTEKLİ OPERASYONEL ÖNERİLER -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('AI DESTEKLİ OPERASYONEL ÖNERİLER') ?></div>
        <div class="bilgiyapar-mcc-ai-grid">
            <!-- Öneri 1 -->
            <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('ExecutiveDashboardController', 'getAiRecommendations', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-magic bilgiyapar-mcc-text-primary"></i>
                    <div class="bilgiyapar-mcc-card-title">Kapasite Dengeleme</div>
                </div>
                <div class="bilgiyapar-mcc-card-content" style="font-size:14px; font-weight:normal;">
                    "Olympos Projesi"nde darboğaz var. Tasarım ekibinden 1 kişiyi buraya kaydırabilirsiniz.
                    <br>
                    <button class="bilgiyapar-mcc-btn"><i class="fa fa-plus"></i> GÖREV OLUŞTUR VE ATA</button>
                </div>
            </a>
            
            <!-- Öneri 2 -->
            <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('ExecutiveDashboardController', 'getAiRecommendations', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-magic bilgiyapar-mcc-text-primary"></i>
                    <div class="bilgiyapar-mcc-card-title">Bütçe Optimizasyonu</div>
                </div>
                <div class="bilgiyapar-mcc-card-content" style="font-size:14px; font-weight:normal;">
                    Harcanan bütçe planlananın %15 üzerinde seyrediyor. Sunucu maliyetlerini gözden geçirin.
                    <br>
                    <button class="bilgiyapar-mcc-btn"><i class="fa fa-bar-chart"></i> RAPORU İNCELE</button>
                </div>
            </a>
        </div>
    </div>

</div>
