<div class="bilgiyapar-mcc-dashboard-container">
    <div class="bilgiyapar-mcc-dashboard-header"><?= t('YÖNETİCİ KONTROL MERKEZİ') ?></div>

    <!-- 1. YÖNETİCİ FİNANS & STRATEJİ PANELİ -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('YÖNETİCİ FİNANS & STRATEJİ PANELİ') ?></div>
        <div class="bilgiyapar-mcc-grid-4">
            <!-- Finans Kartı (Donut Chart) -->
            <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('DashboardController', 'projects', array('user_id' => $this->user->getId())) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-money bilgiyapar-mcc-text-success"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Küresel Nakit Yakım Hızı') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content bilgiyapar-mcc-donut-wrapper">
                    <div class="bilgiyapar-mcc-donut" style="width:60px; height:60px; border-radius:50%; background: conic-gradient(#d9534f 0% 60%, #5cb85c 60% 100%); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:bold; font-size:12px;">
                        <span>%60</span>
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
            
            <!-- Ek Metrik Kartı -->
            <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('DashboardController', 'tasks', array('user_id' => $this->user->getId())) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-line-chart bilgiyapar-mcc-text-primary"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Performans Metrikleri') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    <div class="card-value">Verimli</div>
                    <div class="card-sub">Aktif Proje: <?= isset($total_projects) ? $total_projects : 0 ?></div>
                    <div class="card-sub">Açık Görev: <?= isset($open_tasks) ? $open_tasks : 0 ?></div>
                </div>
            </a>
        </div>
    </div>

    <!-- 2. ACİL DURUM & KRİTİK BLOKAJLAR -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('ACİL DURUM & KRİTİK BLOKAJLAR') ?></div>
        <div class="bilgiyapar-mcc-grid-2">
            <!-- Blokaj Özet -->
            <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('SearchController', 'index', array('search' => 'status:open')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-warning bilgiyapar-mcc-text-danger"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Toplam Kritik Blokaj') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content bilgiyapar-mcc-text-danger" style="font-size:24px; font-weight:bold;">
                    <?= isset($total_blockers) ? $total_blockers : 3 ?> <?= t('Görev') ?>
                </div>
            </a>
            
            <!-- Hiyerarşik Ağaç -->
            <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('SearchController', 'index', array('search' => 'status:open')) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-sitemap bilgiyapar-mcc-text-warning"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Blokaj Ağacı') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content">
                    <div class="bilgiyapar-mcc-tree" style="font-family:monospace; line-height:1.5; font-size:13px; color:#333;">
<span style="font-weight:bold; color:#000;">A.Ş. Resmi İşlemler (Ana Proje)</span><br>
|-- <span style="color:#d9534f; font-weight:bold;">Vergi Yapılandırması</span> (P1 - Bloke)<br>
|   └─ Evrak Teslimi (Gecikmeli)<br>
|<br>
|-- İK İşe Alım Modülü<br>
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
            <a target="_blank" style="text-decoration:none; display:block; color:inherit;" class="bilgiyapar-mcc-card" href="<?= $this->url->href('DashboardController', 'projects', array('user_id' => $this->user->getId())) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-road bilgiyapar-mcc-text-primary"></i>
                    <div class="bilgiyapar-mcc-card-title"><?= t('Kritik Yol (Critical Path)') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content" style="display:flex; align-items:center; flex-wrap:wrap; gap:10px; padding:20px 0;">
                    <div style="background:#e8f0fe; color:#1a73e8; border-radius:20px; padding:8px 15px; font-weight:bold; border:1px solid #d2e3fc;">
                        <i class="fa fa-building"></i> [A.Ş. Resmi İşlemler]
                    </div>
                    <div style="font-size:12px; font-weight:bold; color:#d9534f; display:flex; flex-direction:column; align-items:center;">
                        <span style="background:#fce8e6; padding:2px 8px; border-radius:10px; border:1px dashed #d9534f;">%100 Engeller</span>
                        <span style="font-size:18px;">➔</span>
                    </div>
                    <div style="background:#e8f0fe; color:#1a73e8; border-radius:20px; padding:8px 15px; font-weight:bold; border:1px solid #d2e3fc;">
                        <i class="fa fa-mobile"></i> [ISAMA Play Store Yayını]
                    </div>
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
