<div class="bilgiyapar-mcc-dashboard-container">
    <div class="bilgiyapar-mcc-dashboard-header"><?= t('YÖNETİCİ KONTROL MERKEZİ') ?></div>

    <!-- 1. YÖNETİCİ FİNANS & STRATEJİ PANELİ -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><i class="fa fa-money"></i> <?= t('YÖNETİCİ FİNANS & STRATEJİ PANELİ (Finans Zirvesi)') ?></div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <!-- 1. Bar Chart Kartı -->
            <a target="_blank" style="text-decoration:none; display:flex; flex-direction:column; color:inherit; background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:15px;" href="<?= $this->url->href('ExecutiveDashboardController', 'finance', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div style="font-weight:bold; font-size:14px; margin-bottom:15px;"><?= t('Küresel Nakit Yakım Hızı') ?></div>
                <div style="display:flex; align-items:flex-end; gap:8px; height:80px; margin-bottom:15px; border-bottom:1px solid #eee; padding-bottom:5px;">
                    <div style="width:20px; height:50%; background:#4dd0e1; border-radius:3px 3px 0 0;"></div>
                    <div style="width:20px; height:70%; background:#4dd0e1; border-radius:3px 3px 0 0;"></div>
                    <div style="width:20px; height:40%; background:#4dd0e1; border-radius:3px 3px 0 0;"></div>
                    <div style="width:20px; height:90%; background:#4dd0e1; border-radius:3px 3px 0 0;"></div>
                    <div style="width:20px; height:60%; background:#4dd0e1; border-radius:3px 3px 0 0;"></div>
                    <div style="width:20px; height:30%; background:#b39ddb; border-radius:3px 3px 0 0;"></div>
                </div>
                <div style="font-weight:bold; font-size:16px;">15,000 TL <span style="font-size:12px; font-weight:normal; color:#888;">/mo</span></div>
                <div style="font-size:12px; color:#555;"><?= t('Kalan:') ?> 250.000 TL</div>
            </a>

            <!-- 2. Donut Chart Kartı -->
            <?php 
                $spent_ratio = $global_burn_rate > 0 ? round(($budget_spent / $global_burn_rate) * 100) : 0;
                $rem_ratio = 100 - $spent_ratio;
                if ($spent_ratio > 100) { $spent_ratio = 100; $rem_ratio = 0; }
            ?>
            <a target="_blank" style="text-decoration:none; display:flex; flex-direction:column; color:inherit; background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:15px;" href="<?= $this->url->href('ExecutiveDashboardController', 'finance', array('plugin' => 'ExecutiveDashboard')) ?>">
                <div style="font-weight:bold; font-size:14px; margin-bottom:15px; text-align:center;"><?= t('Küresel Bütçe Durumu') ?></div>
                <div style="display:flex; justify-content:center; align-items:center; flex:1;">
                    <div style="position:relative; width:100px; height:100px; border-radius:50%; background: conic-gradient(#4a90e2 0% <?= $rem_ratio ?>%, #4dd0e1 <?= $rem_ratio ?>% 100%); display:flex; align-items:center; justify-content:center;">
                        <div style="width:70px; height:70px; border-radius:50%; background:#fff;"></div>
                    </div>
                </div>
                <div style="display:flex; justify-content:space-between; margin-top:15px; font-size:12px; font-weight:bold;">
                    <div><span style="color:#4dd0e1;">%<?= $spent_ratio ?></span> Harcanan</div>
                    <div><span style="color:#4a90e2;">%<?= $rem_ratio ?></span> Kalan</div>
                </div>
            </a>

            <!-- 3. Kritik Metrikler & Fonlama -->
            <div style="display:flex; flex-direction:column; gap:15px;">
                <!-- Kritik Metrikler -->
                <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:10px;">
                    <div style="font-weight:bold; font-size:13px; margin-bottom:10px;"><?= t('Kritik Metrikler') ?></div>
                    <div style="display:flex; gap:10px; text-align:center;">
                        <a href="<?= $this->url->href('DashboardController', 'projects', array('user_id' => $user['id'])) ?>" target="_blank" style="flex:1; border:1px solid #eee; border-radius:4px; padding:10px; text-decoration:none; color:inherit;">
                            <div style="font-size:24px; font-weight:bold; color:#333;"><?= isset($total_projects) ? $total_projects : 0 ?></div>
                            <div style="font-size:11px; color:#666;">Aktif<br>Proje</div>
                        </a>
                        <a href="<?= $this->url->href('SearchController', 'index', array('search' => 'status:open')) ?>" target="_blank" style="flex:1; border:1px solid #eee; border-radius:4px; padding:10px; text-decoration:none; color:inherit;">
                            <div style="font-size:24px; font-weight:bold; color:#333;"><?= isset($open_tasks) ? $open_tasks : 0 ?></div>
                            <div style="font-size:11px; color:#666;">Açık<br>Görev</div>
                        </a>
                        <a href="<?= $this->url->href('UserListController', 'show') ?>" target="_blank" style="flex:1; border:1px solid #eee; border-radius:4px; padding:10px; text-decoration:none; color:inherit;">
                            <div style="font-size:24px; font-weight:bold; color:#333;"><?= count($users) ?></div>
                            <div style="font-size:11px; color:#666;"><br>Kullanıcı</div>
                        </a>
                    </div>
                </div>
                <!-- Genişletilmiş Fonlama -->
                <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:15px;">
                    <div style="font-weight:bold; font-size:13px; margin-bottom:5px;"><?= t('Genişletilmiş Fonlama & Gelir') ?></div>
                    <div style="font-size:13px; color:#444; margin-bottom:5px;">Kitlesel Fonlama Lansmanı: <b>14 Gün Kaldı</b></div>
                    <div style="font-size:13px; color:#444;">Hedef: <b>500.000 TL</b></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. ACİL DURUM & KRİTİK BLOKAJLAR -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('ACİL DURUM & KRİTİK BLOKAJLAR') ?></div>
        <div class="bilgiyapar-mcc-grid-2">
            <!-- Blokaj Özet -->
            <a target="_blank" style="text-decoration:none; display:flex; flex-direction:column; justify-content:center; align-items:center; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('SearchController', 'index', array('search' => 'status:open')) ?>">
                <div style="font-size:14px; font-weight:bold; color:#586069; margin-bottom:10px;"><i class="fa fa-warning bilgiyapar-mcc-text-danger"></i> <?= t('Toplam Kritik Blokaj') ?></div>
                <div style="font-size:36px; font-weight:bold; color:#d9534f;"><?= isset($total_blockers) ? $total_blockers : 3 ?></div>
                <div style="font-size:12px; color:#999; margin-top:5px;"><?= t('Görev birbirini bekliyor') ?></div>
            </a>
            
            <!-- Hiyerarşik Ağaç -->
            <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('SearchController', 'index', array('search' => 'status:open')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-sitemap bilgiyapar-mcc-text-warning"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Blokaj Ağacı') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    <div class="bilgiyapar-mcc-tree" style="font-family:'Courier New', Courier, monospace; white-space:pre-wrap; line-height:1.6; font-size:13px; color:#333; background:#f9f9f9; padding:15px; border-radius:6px; border:1px solid #e1e4e8;">
<span style="font-weight:bold; color:#1a73e8; font-size:14px;">A.Ş. Resmi İşlemler (Ana Proje)</span>
|-- <span style="color:#d9534f; font-weight:bold;">Vergi Yapılandırması</span> <span style="color:#888;">(P1 - Bloke)</span>
|   └─ <span style="color:#d9534f;">Evrak Teslimi (Gecikmeli)</span>
|
|-- <span style="font-weight:bold; color:#333;">İK İşe Alım Modülü</span>
    └─ <span style="color:#f0ad4e;">Bütçe Onayı Bekleniyor</span>
</div>
                </div>
            </a>
        </div>
    </div>

    <!-- 3. GÖREV BAĞIMLILIKLARI & KRİTİK YOL (RELATIONGRAPH) -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><i class="fa fa-link"></i> <?= t('GÖREV BAĞIMLILIKLARI & KRİTİK YOL (Relationgraph)') ?></div>
        <div class="bilgiyapar-mcc-card" style="background: #fdfdfd;">
            <div class="bilgiyapar-mcc-card-content" style="display:flex; justify-content:center; align-items:center; padding:30px 10px;">
                <div style="display: flex; justify-content: space-around; align-items: center; width: 100%; max-width: 800px; position:relative;">
                    
                    <!-- Sol Sütun -->
                    <div style="display: flex; flex-direction: column; gap: 40px; z-index:2;">
                        <div style="background:#fff; color:#3b5998; border-radius:20px; padding:10px 20px; font-weight:bold; border:2px solid #aebcda; box-shadow:0 2px 5px rgba(0,0,0,0.05); display:flex; align-items:center; gap:8px;">
                            <i class="fa fa-building-o"></i> [A.Ş. Resmi İşlemler] <i class="fa fa-flag" style="color:#d9534f;"></i>
                        </div>
                        <div style="background:#fff; color:#333; border-radius:20px; padding:10px 20px; font-weight:bold; border:2px solid #f0ad4e; box-shadow:0 2px 5px rgba(0,0,0,0.05); display:flex; align-items:center; gap:8px;">
                            <i class="fa fa-cube" style="color:#f0ad4e;"></i> [FMHSCS v2.6] <i class="fa fa-refresh" style="color:#f0ad4e;"></i>
                        </div>
                    </div>

                    <!-- Orta Sütun (Bağlantılar) -->
                    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 20px; z-index:2;">
                        <div style="display:flex; align-items:center; gap:5px;">
                            <div style="background:#fce8e6; color:#d9534f; border:1px dashed #d9534f; padding:4px 10px; border-radius:12px; font-size:11px; font-weight:bold;">%100 Engeller ➔</div>
                        </div>
                        <div style="display:flex; align-items:center; gap:5px;">
                            <div style="background:#fcf8e3; color:#8a6d3b; border:1px dashed #f0ad4e; padding:4px 10px; border-radius:12px; font-size:11px; font-weight:bold;">relates to ➔</div>
                        </div>
                    </div>

                    <!-- Sağ Sütun -->
                    <div style="display: flex; flex-direction: column; gap: 40px; z-index:2;">
                        <div style="background:#e8f0fe; color:#1a73e8; border-radius:20px; padding:10px 20px; font-weight:bold; border:2px solid #8ab4f8; box-shadow:0 2px 5px rgba(0,0,0,0.05); display:flex; align-items:center; gap:8px;">
                            <i class="fa fa-android"></i> [ISAMA Play Store Yayını] <i class="fa fa-lock" style="color:#8ab4f8;"></i>
                        </div>
                        <div style="background:#e8f0fe; color:#1a73e8; border-radius:20px; padding:10px 20px; font-weight:bold; border:2px solid #8ab4f8; box-shadow:0 2px 5px rgba(0,0,0,0.05); display:flex; align-items:center; gap:8px;">
                            <i class="fa fa-user-o"></i> [ISAMA Web] <i class="fa fa-credit-card" style="color:#8ab4f8;"></i>
                        </div>
                    </div>

                    <!-- Arka Plan Ok Çizgileri (Görsel Zenginlik) -->
                    <svg style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:1;" preserveAspectRatio="none">
                        <line x1="25%" y1="25%" x2="75%" y2="25%" stroke="#d9534f" stroke-width="2" stroke-dasharray="5,5" />
                        <line x1="25%" y1="25%" x2="75%" y2="75%" stroke="#333" stroke-width="2" />
                        <line x1="25%" y1="75%" x2="75%" y2="25%" stroke="#333" stroke-width="2" />
                        <line x1="25%" y1="75%" x2="75%" y2="75%" stroke="#f0ad4e" stroke-width="2" stroke-dasharray="5,5" />
                    </svg>
                </div>
            </div>
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
                    <div class="bilgiyapar-mcc-action-col" style="display:flex; align-items:center; border-bottom:1px solid #eee;">
                        <div class="bilgiyapar-mcc-role-item" style="font-weight:bold; padding:10px;"><i class="fa fa-user" style="margin-right:8px; color:#007bff;"></i> <?= htmlspecialchars($u['name'] ?: $u['username']) ?></div>
                    </div>
                    
                    <!-- BUGÜN -->
                    <div class="bilgiyapar-mcc-action-col" style="border-bottom:1px solid #eee; padding:10px;">
                        <?php 
                        $hasToday = false;
                        if(isset($tasks_today)) {
                            foreach($tasks_today as $t) {
                                if($t['owner_id'] == $u['id']) {
                                    $hasToday = true;
                                    echo '<a target="_blank" style="text-decoration:none; display:flex; flex-direction:column; color:inherit; border:1px solid #e1e4e8; border-radius:4px; padding:8px; margin-bottom:5px; background:#fff;" class="bilgiyapar-mcc-mini-card" href="'.$this->url->href('TaskViewController', 'show', array('task_id' => $t['id'])).'"><div style="display:flex; justify-content:space-between; align-items:center; font-size:12px; font-weight:600;"><span class="bilgiyapar-mcc-mini-card-title">'.htmlspecialchars($t['title']).'</span><i class="fa fa-warning" style="color:#d9534f;"></i></div><div class="bilgiyapar-mcc-progress-bg" style="height:4px; background:#e1e4e8; border-radius:2px; margin-top:5px;"><div class="bilgiyapar-mcc-progress-bar" style="width: 25%; background-color:#d9534f; height:100%; border-radius:2px;"></div></div></a>';
                                }
                            }
                        }
                        if(!$hasToday) echo '<div style="font-size:12px; color:#aaa; text-align:center; font-style:italic;">Hedef Bulunmuyor</div>';
                        ?>
                    </div>

                    <!-- BU HAFTA -->
                    <div class="bilgiyapar-mcc-action-col" style="border-bottom:1px solid #eee; padding:10px;">
                        <?php 
                        $hasWeek = false;
                        if(isset($tasks_week)) {
                            foreach($tasks_week as $t) {
                                if($t['owner_id'] == $u['id']) {
                                    $hasWeek = true;
                                    echo '<a target="_blank" style="text-decoration:none; display:flex; flex-direction:column; color:inherit; border:1px solid #e1e4e8; border-radius:4px; padding:8px; margin-bottom:5px; background:#fff;" class="bilgiyapar-mcc-mini-card" href="'.$this->url->href('TaskViewController', 'show', array('task_id' => $t['id'])).'"><div style="display:flex; justify-content:space-between; align-items:center; font-size:12px; font-weight:600;"><span class="bilgiyapar-mcc-mini-card-title">'.htmlspecialchars($t['title']).'</span><i class="fa fa-check-circle" style="color:#5cb85c;"></i></div><div class="bilgiyapar-mcc-progress-bg" style="height:4px; background:#e1e4e8; border-radius:2px; margin-top:5px;"><div class="bilgiyapar-mcc-progress-bar" style="width: 50%; background-color:#5cb85c; height:100%; border-radius:2px;"></div></div></a>';
                                }
                            }
                        }
                        if(!$hasWeek) echo '<div style="font-size:12px; color:#aaa; text-align:center; font-style:italic;">Hedef Bulunmuyor</div>';
                        ?>
                    </div>

                    <!-- BU AY -->
                    <div class="bilgiyapar-mcc-action-col" style="border-bottom:1px solid #eee; padding:10px;">
                        <?php 
                        $hasMonth = false;
                        if(isset($tasks_month)) {
                            foreach($tasks_month as $t) {
                                if($t['owner_id'] == $u['id']) {
                                    $hasMonth = true;
                                    echo '<a target="_blank" style="text-decoration:none; display:flex; flex-direction:column; color:inherit; border:1px solid #e1e4e8; border-radius:4px; padding:8px; margin-bottom:5px; background:#fff;" class="bilgiyapar-mcc-mini-card" href="'.$this->url->href('TaskViewController', 'show', array('task_id' => $t['id'])).'"><div style="display:flex; justify-content:space-between; align-items:center; font-size:12px; font-weight:600;"><span class="bilgiyapar-mcc-mini-card-title">'.htmlspecialchars($t['title']).'</span><i class="fa fa-clock-o" style="color:#007bff;"></i></div><div class="bilgiyapar-mcc-progress-bg" style="height:4px; background:#e1e4e8; border-radius:2px; margin-top:5px;"><div class="bilgiyapar-mcc-progress-bar" style="width: 10%; background-color:#007bff; height:100%; border-radius:2px;"></div></div></a>';
                                }
                            }
                        }
                        if(!$hasMonth) echo '<div style="font-size:12px; color:#aaa; text-align:center; font-style:italic;">Hedef Bulunmuyor</div>';
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
            <?php if(isset($projects) && !empty($projects)): ?>
                <?php $p_count = 0; foreach($projects as $p): if($p_count++ >= 4) break; ?>
                    <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('BoardViewController', 'show', array('project_id' => $p['id'])) ?>">
                        <div class="bilgiyapar-mcc-card-header">
                            <i class="fa fa-cubes"></i>
                            <div class="bilgiyapar-mcc-card-title"><?= htmlspecialchars($p['name']) ?></div>
                        </div>
                        <div class="bilgiyapar-mcc-card-content" style="font-size:14px; font-weight:normal;">
                            <div class="bilgiyapar-mcc-velocity-badge" style="background:#f0f0f0; color:#333; padding:2px 6px; border-radius:4px; font-size:12px; display:inline-block; margin-bottom:8px;">Velocity C35</div>
                            
                            <div class="bilgiyapar-mcc-progress-bg" style="height:8px; margin-top:10px; background:#e1e4e8; border-radius:4px; overflow:hidden;">
                                <div class="bilgiyapar-mcc-progress-bar" style="width: <?= rand(30,80) ?>%; background-color:#5cb85c; height:100%;"></div>
                            </div>
                            
                            <div class="bilgiyapar-mcc-wip-alert" style="margin-top:10px; border:1px dashed #d9534f; color:#d9534f; padding:5px; border-radius:4px; font-size:12px; font-weight:bold;">
                                <i class="fa fa-exclamation-triangle"></i> WIP Limit Aşımı (Tasarım)
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- 6. AI DESTEKLİ OPERASYONEL ÖNERİLER -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('AI DESTEKLİ OPERASYONEL ÖNERİLER') ?></div>
        <div class="bilgiyapar-mcc-ai-grid">
            <!-- Öneri 1 -->
            <div class="bilgiyapar-mcc-card bilgiyapar-mcc-ai-prompt" style="display:block; cursor:pointer;" data-prompt="<?= htmlspecialchars("Lütfen 'Olympos Projesi' için tasarım ekibinden 1 kişiyi bu projeye atamak üzere bir görev oluştur. Darboğazı çözmek için acil durum belirt.", ENT_QUOTES) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-magic bilgiyapar-mcc-text-primary"></i>
                    <div class="bilgiyapar-mcc-card-title">Kapasite Dengeleme</div>
                </div>
                <div class="bilgiyapar-mcc-card-content" style="font-size:14px; font-weight:normal;">
                    Projede darboğaz var. Tasarım ekibinden 1 kişiyi buraya kaydırabilirsiniz.
                    <br><br>
                    <button class="bilgiyapar-mcc-btn bilgiyapar-mcc-copy-btn" onclick="return false;" style="background:#007bff; color:#fff; border:none; padding:5px 10px; border-radius:3px; cursor:pointer;"><i class="fa fa-copy"></i> PROMPT KOPYALA</button>
                </div>
            </div>
            
            <!-- Öneri 2 -->
            <div class="bilgiyapar-mcc-card bilgiyapar-mcc-ai-prompt" style="display:block; cursor:pointer;" data-prompt="<?= htmlspecialchars("Geçen ayki sunucu maliyetleri ve bütçe planlamasının %15 üzerindeki harcama oranları için detaylı bir analiz oluştur, optimizasyon önerilerini listele.", ENT_QUOTES) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-magic bilgiyapar-mcc-text-primary"></i>
                    <div class="bilgiyapar-mcc-card-title">Bütçe Optimizasyonu</div>
                </div>
                <div class="bilgiyapar-mcc-card-content" style="font-size:14px; font-weight:normal;">
                    Harcanan bütçe planlananın %15 üzerinde seyrediyor. Sunucu maliyetlerini gözden geçirin.
                    <br><br>
                    <button class="bilgiyapar-mcc-btn bilgiyapar-mcc-copy-btn" onclick="return false;" style="background:#007bff; color:#fff; border:none; padding:5px 10px; border-radius:3px; cursor:pointer;"><i class="fa fa-copy"></i> PROMPT KOPYALA</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var promptCards = document.querySelectorAll('.bilgiyapar-mcc-ai-prompt');
    promptCards.forEach(function(card) {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            var promptText = this.getAttribute('data-prompt');
            var btn = this.querySelector('.bilgiyapar-mcc-copy-btn');
            
            navigator.clipboard.writeText(promptText).then(function() {
                var originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fa fa-check"></i> KOPYALANDI!';
                btn.style.backgroundColor = '#28a745';
                
                setTimeout(function() {
                    btn.innerHTML = originalText;
                    btn.style.backgroundColor = '#007bff';
                }, 2000);
            }).catch(function(err) {
                console.error('Kopyalama başarısız: ', err);
            });
        });
    });
});
</script>
