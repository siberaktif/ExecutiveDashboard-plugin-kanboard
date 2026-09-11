<div class="bilgiyapar-mcc-dashboard-container">
    <div class="bilgiyapar-mcc-dashboard-header"><?= t('YÖNETİCİ KONTROL MERKEZİ') ?></div>

    <!-- 1. YÖNETİCİ FİNANS & STRATEJİ PANELİ -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><i class="fa fa-money"></i> <?= t('YÖNETİCİ FİNANS & STRATEJİ PANELİ (Finans Zirvesi)') ?></div>
        
        <div class="bilgiyapar-mcc-grid-3-responsive">
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
                <div style="font-weight:bold; font-size:16px;"><?= number_format($budget_spent, 2, ',', '.') ?> TL <span style="font-size:12px; font-weight:normal; color:#888;">(Toplam)</span></div>
                <div style="font-size:12px; color:#555;"><?= t('Kalan Bütçe:') ?> <?= number_format(max(0, $global_burn_rate - $budget_spent), 2, ',', '.') ?> TL</div>
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
                            <div style="font-size:11px; color:#666;">Aktif<br>Kullanıcı</div>
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

    <!-- 2. KAPSAMLI SİSTEM & KÜRESEL KPI MATRİSİ -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('KAPSAMLI SİSTEM & KÜRESEL KPI MATRİSİ') ?></div>
        
        <?php
        $kpi_groups = [
            'Genel Durum' => [
                ['title' => 'Genel Proje Performansı', 'total' => '%'.$kpi['performance_avg'], 'sub' => '', 'color' => '#1a73e8', 'icon' => 'fa-line-chart', 'url' => $kpi['performance_avg'] > 0 ? $this->url->href('ExecutiveDashboardController', 'performance', ['plugin' => 'ExecutiveDashboard']) : ''],
                ['title' => 'Proje Sağlığı', 'total' => $kpi['health_status'], 'sub' => 'Durum', 'color' => $kpi['health_color'], 'icon' => 'fa-heartbeat', 'url' => $this->url->href('ExecutiveDashboardController', 'health', ['plugin' => 'ExecutiveDashboard'])],
                ['title' => 'Genel Skor', 'total' => '%'.$kpi['overall_score'], 'sub' => '', 'color' => '#f0ad4e', 'icon' => 'fa-trophy', 'url' => $kpi['overall_score'] > 0 ? $this->url->href('ExecutiveDashboardController', 'score', ['plugin' => 'ExecutiveDashboard']) : ''],
                ['title' => 'Geciken Görevler', 'total' => $kpi['overdue_total_count'], 'sub' => 'Dikkat Gerektiriyor', 'color' => '#d73a49', 'icon' => 'fa-calendar-times-o', 'url' => $this->url->href('SearchController', 'index', array('search' => 'status:open due:<=today'))],
            ],
            'Projeler' => [
                ['title' => 'Projeler', 'total' => $kpi['projects_active']+$kpi['projects_inactive'], 'sub' => 'A:'.$kpi['projects_active'].' P:'.$kpi['projects_inactive'], 'color' => '#0366d6', 'icon' => 'fa-folder-open-o', 'url' => $this->url->href('ProjectListController', 'show')],
                ['title' => 'Kişisel Projeler', 'total' => $kpi['projects_private'], 'sub' => 'Gizli', 'color' => '#0366d6', 'icon' => 'fa-lock', 'url' => $this->url->href('ProjectListController', 'show')],
                ['title' => 'Herkese Açık Projeler', 'total' => $kpi['projects_public'], 'sub' => 'Genel', 'color' => '#0366d6', 'icon' => 'fa-globe', 'url' => $this->url->href('ProjectListController', 'show')],
                ['title' => 'Görevler (Açık)', 'total' => $kpi['tasks_active'], 'sub' => 'Aktif', 'color' => '#e36209', 'icon' => 'fa-tasks', 'url' => $this->url->href('SearchController', 'index', array('search'=>'status:open'))],
                ['title' => 'Görevler (Kapalı)', 'total' => $kpi['tasks_closed'], 'sub' => 'Tamamlanan', 'color' => '#e36209', 'icon' => 'fa-check-square-o', 'url' => $this->url->href('SearchController', 'index', array('search'=>'status:closed'))],
            ],
            'Yapılandırma & Varlıklar' => [
                ['title' => 'Yorumlar', 'total' => $kpi['comments'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-comments', 'url' => $kpi['comments'] > 0 ? $this->url->href('ExecutiveDashboardController', 'comments', ['plugin' => 'ExecutiveDashboard']) : ''],
                ['title' => 'Ekler', 'total' => $kpi['attachments'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-paperclip', 'url' => $kpi['attachments'] > 0 ? $this->url->href('ExecutiveDashboardController', 'attachments', ['plugin' => 'ExecutiveDashboard']) : ''],
                ['title' => 'External Links', 'total' => $kpi['external_links'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-external-link', 'url' => $kpi['external_links'] > 0 ? $this->url->href('ExecutiveDashboardController', 'externalLinks', ['plugin' => 'ExecutiveDashboard']) : ''],
                ['title' => 'Etiketler', 'total' => $kpi['tags'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-tags', 'url' => $kpi['tags'] > 0 ? $this->url->href('ExecutiveDashboardController', 'tags', ['plugin' => 'ExecutiveDashboard']) : ''],
                ['title' => 'Bağlantı Etiketleri', 'total' => $kpi['link_labels'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-link', 'url' => $kpi['link_labels'] > 0 ? $this->url->href('ExecutiveDashboardController', 'linkLabels', ['plugin' => 'ExecutiveDashboard']) : ''],
                ['title' => 'Kategoriler', 'total' => $kpi['categories'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-tags', 'url' => $kpi['categories'] > 0 ? $this->url->href('ExecutiveDashboardController', 'categories', ['plugin' => 'ExecutiveDashboard']) : ''],
                ['title' => 'Otomatik Eylemler', 'total' => $kpi['auto_actions'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-cogs', 'url' => $kpi['auto_actions'] > 0 ? $this->url->href('ExecutiveDashboardController', 'actions', ['plugin' => 'ExecutiveDashboard']) : ''],
                ['title' => 'Templates', 'total' => $kpi['templates'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-file-text-o', 'url' => $kpi['templates'] > 0 ? $this->url->href('ExecutiveDashboardController', 'templates', ['plugin' => 'ExecutiveDashboard']) : ''],
                ['title' => 'Task Templates', 'total' => $kpi['task_templates'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-file-text-o', 'url' => $kpi['task_templates'] > 0 ? $this->url->href('ExecutiveDashboardController', 'templates', ['plugin' => 'ExecutiveDashboard']) : ''],
                ['title' => 'Yorum Şablonları', 'total' => $kpi['comment_templates'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-file-text-o', 'url' => $kpi['comment_templates'] > 0 ? $this->url->href('ExecutiveDashboardController', 'templates', ['plugin' => 'ExecutiveDashboard']) : ''],
                ['title' => 'Genel Şablonlar', 'total' => $kpi['general_templates'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-file-text-o', 'url' => $kpi['general_templates'] > 0 ? $this->url->href('ExecutiveDashboardController', 'templates', ['plugin' => 'ExecutiveDashboard']) : ''],
            ],
            'Sistem' => [
                ['title' => 'Eklentiler', 'total' => $kpi['plugins'], 'sub' => '', 'color' => '#28a745', 'icon' => 'fa-plug', 'url' => $this->url->href('PluginController', 'show')],
                ['title' => 'Saat Dilimleri', 'total' => $kpi['timezones'], 'sub' => '', 'color' => '#d73a49', 'icon' => 'fa-clock-o', 'url' => $kpi['timezones'] > 0 ? $this->url->href('ExecutiveDashboardController', 'timezones', ['plugin' => 'ExecutiveDashboard']) : ''],
                ['title' => 'Diller', 'total' => $kpi['languages'], 'sub' => '', 'color' => '#d73a49', 'icon' => 'fa-language', 'url' => $kpi['languages'] > 0 ? $this->url->href('ExecutiveDashboardController', 'languages', ['plugin' => 'ExecutiveDashboard']) : ''],
            ],
            'Kullanıcılar' => [
                ['title' => 'Kullanıcılar', 'total' => $kpi['users_active']+$kpi['users_inactive'], 'sub' => 'Aktif:'.$kpi['users_active'].' Pasif:'.$kpi['users_inactive'], 'color' => '#d73a49', 'icon' => 'fa-user', 'url' => $this->url->href('UserListController', 'show')],
                ['title' => 'Standart Kullanıcı', 'total' => $kpi['users_user'], 'sub' => 'Üye', 'color' => '#d73a49', 'icon' => 'fa-user-o', 'url' => ''],
                ['title' => 'Yöneticiler', 'total' => $kpi['users_manager'], 'sub' => 'PM', 'color' => '#d73a49', 'icon' => 'fa-user-circle-o', 'url' => ''],
                ['title' => 'Sistem Yöneticileri', 'total' => $kpi['users_admin'], 'sub' => 'Admin', 'color' => '#d73a49', 'icon' => 'fa-user-secret', 'url' => $this->url->href('UserListController', 'show')],
                ['title' => 'Kullanıcı Grupları', 'total' => $kpi['groups'], 'sub' => '', 'color' => '#d73a49', 'icon' => 'fa-users', 'url' => $this->url->href('GroupListController', 'index')],
            ],
        ];
        ?>
        <?php foreach($kpi_groups as $group_name => $kpi_cards): ?>
            <div style="font-size:14px; font-weight:600; color:#586069; margin: 15px 0 10px 0; border-bottom: 1px solid #e1e4e8; padding-bottom: 5px;"><?= $group_name ?></div>
            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap:12px; margin-bottom: 20px;">
                <?php foreach($kpi_cards as $c): ?>
                <?php 
                    $is_link = !empty($c['url']) && $c['url'] !== '#';
                    $tag_start = $is_link ? '<a href="'.$c['url'].'" target="_blank"' : '<div';
                    $tag_end = $is_link ? '</a>' : '</div>';
                    $bg_color = $is_link ? 'rgba(0, 173, 255, 0.03)' : '#ffffff';
                ?>
                <?= $tag_start ?> style="text-decoration:none; background:<?= $bg_color ?>; border:1px solid #e1e4e8; border-left:3px solid <?= $c['color'] ?>; border-radius:4px; padding:12px; color:#24292e; display:flex; flex-direction:column; justify-content:space-between; min-height:80px; box-shadow:0 1px 3px rgba(0,0,0,0.02); transition: box-shadow 0.2s;">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <div style="font-weight:600; font-size:12px; color:#586069; line-height:1.2; padding-right:5px; word-break:break-word;"><?= $c['title'] ?></div>
                        <div style="display:flex; gap:5px; align-items:center;">
                            <i class="fa <?= $c['icon'] ?>" style="color:<?= $c['color'] ?>; font-size:14px; opacity:0.8;"></i>
                            <?php if($is_link): ?>
                                <i class="fa fa-external-link" style="color:#00adff; font-size:10px; opacity:0.7;"></i>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-top:8px;">
                        <span style="font-size:22px; font-weight:bold; color:#24292e; line-height:1;"><?= $c['total'] ?></span>
                        <?php if($c['sub']): ?>
                        <span style="font-size:10px; color:#6a737d; font-weight:500; background:#f6f8fa; padding:2px 4px; border-radius:3px;"><?= $c['sub'] ?></span>
                        <?php endif; ?>
                    </div>
                <?= $tag_end ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- 3. ACİL DURUM & KRİTİK BLOKAJLAR -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('ACİL DURUM & KRİTİK BLOKAJLAR') ?></div>
        
        <div class="bilgiyapar-mcc-grid-2-responsive" style="margin-bottom:15px;">
            <!-- Kırmızı Uyarı Kartı 1: Blokajlar -->
            <a href="<?= $this->url->href('SearchController', 'index', array('search' => 'status:open')) ?>" target="_blank" style="text-decoration:none; background:#ffeef0; border-left:4px solid #d73a49; padding:15px; border-radius:4px; color:#24292e; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-weight:bold; font-size:14px; margin-bottom:5px;"><i class="fa fa-warning" style="color:#d73a49;"></i> <?= t('Sistem Blokajları') ?></div>
                    <div style="font-size:12px; color:#586069;"><?= t('Birbirini engelleyen kritik görevler') ?></div>
                </div>
                <div style="font-size:28px; font-weight:bold; color:#d73a49;"><?= isset($total_blockers) ? $total_blockers : 0 ?></div>
            </a>

            <!-- Kırmızı Uyarı Kartı 2: Gecikmiş Görevler -->
            <a href="<?= $this->url->href('SearchController', 'index', array('search' => 'status:open due:<=today')) ?>" target="_blank" style="text-decoration:none; background:#ffeef0; border-left:4px solid #d73a49; padding:15px; border-radius:4px; color:#24292e; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-weight:bold; font-size:14px; margin-bottom:5px;"><i class="fa fa-calendar-times-o" style="color:#d73a49;"></i> <?= t('Gecikmiş İşlemler') ?></div>
                    <div style="font-size:12px; color:#586069;"><?= t('Teslim tarihi geçmiş görevler') ?></div>
                </div>
                <div style="font-size:28px; font-weight:bold; color:#d73a49;"><?= isset($tasks_overdue) ? count($tasks_overdue) : 0 ?></div>
            </a>
        </div>

        <div class="bilgiyapar-mcc-grid-1">
            <!-- Hiyerarşik Ağaç -->
            <div class="bilgiyapar-mcc-card" style="border:1px solid #e1e4e8; border-radius:6px; background:#fff;">
                <div class="bilgiyapar-mcc-card-header" style="padding:15px; border-bottom:1px solid #eee;">
                    <i class="fa fa-sitemap bilgiyapar-mcc-text-warning"></i>
                    <div class="bilgiyapar-mcc-card-title" style="display:inline-block; margin-left:10px; font-weight:bold;"><?= t('Kök Neden Analizi (Root Cause Analysis)') ?></div>
                </div>
                <div class="bilgiyapar-mcc-card-content" style="padding:15px;">
                    <div class="bilgiyapar-mcc-tree" style="font-family:'Courier New', Courier, monospace; white-space:pre-wrap; line-height:1.6; font-size:13px; color:#333; background:#f9f9f9; padding:15px; border-radius:6px; border:1px solid #e1e4e8;">
<?php if(!empty($blocker_tree)): ?>
<?php foreach($blocker_tree as $pid => $project): ?>
<a href="<?= $this->url->href('BoardViewController', 'show', array('project_id' => $pid)) ?>" target="_blank" style="text-decoration:none;"><span style="font-weight:bold; color:#1a73e8; font-size:14px;"><?= htmlspecialchars($project['name']) ?> (Ana Proje)</span></a>
<?php foreach($project['tasks'] as $task): ?>
|-- <a href="<?= $this->url->href('TaskViewController', 'show', array('task_id' => $task['blocked_task_id'])) ?>" target="_blank" style="text-decoration:none;"><span style="color:#d9534f; font-weight:bold;"><?= htmlspecialchars($task['blocked_task_title']) ?></span> <span style="color:#888;">(P1 - Bloke)</span></a>
|   └─ <a href="<?= $this->url->href('TaskViewController', 'show', array('task_id' => $task['blocker_task_id'])) ?>" target="_blank" style="text-decoration:none;"><span style="color:#d9534f;"><?= htmlspecialchars($task['blocker_task_title']) ?> (Bekleniyor)</span></a>
|
<?php endforeach; ?>
<?php endforeach; ?>
<?php else: ?>
<span style="color:#5cb85c; font-weight:bold;"><?= t('Harika! Sistemde aktif bir blokaj (darboğaz) bulunmuyor.') ?></span>
<?php endif; ?>
</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. GÖREV BAĞIMLILIKLARI & KRİTİK YOL (RELATIONGRAPH) -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><i class="fa fa-link"></i> <?= t('GÖREV BAĞIMLILIKLARI & KRİTİK YOL (Relationgraph)') ?></div>
        <div class="bilgiyapar-mcc-card" style="background: #fdfdfd; padding:20px;">
            <?php if(!empty($graph_nodes) && $graph_nodes !== "[]" && $graph_nodes !== "null"): ?>
                <?php if(isset($has_relationgraph) && $has_relationgraph): ?>
                    <!-- VIS.JS Container -->
                    <div id="mcc-relationgraph-container" style="height: 350px; width: 100%; border: 1px solid #e1e4e8; border-radius: 6px; background: #ffffff;"></div>
                    
                    <script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
                    <script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function() {
                            var container = document.getElementById('mcc-relationgraph-container');
                            var data = {
                                nodes: new vis.DataSet(<?= $graph_nodes ?>),
                                edges: new vis.DataSet(<?= $graph_edges ?>)
                            };
                            var options = {
                                layout: { hierarchical: { direction: "UD", sortMethod: "directed" } },
                                physics: { hierarchicalRepulsion: { nodeDistance: 150 } },
                                edges: { font: { size: 12, align: 'middle' }, smooth: { type: 'cubicBezier' } },
                                nodes: { font: { color: '#ffffff', size: 14 } },
                                interaction: { hover: true, tooltipDelay: 200 }
                            };
                            var network = new vis.Network(container, data, options);
                            
                            // Open task on double click
                            network.on("doubleClick", function (params) {
                                if (params.nodes.length > 0) {
                                    var taskId = params.nodes[0];
                                    window.open('?controller=TaskViewController&action=show&task_id=' + taskId, '_blank');
                                }
                            });
                        });
                    </script>
                <?php else: ?>
                    <!-- Textual Fallback -->
                    <div style="display:flex; flex-direction:column; gap:25px; align-items:center;">
                        <?php foreach($blocker_links as $link): ?>
                            <div style="display:flex; align-items:center; gap:15px; justify-content:center; width:100%; max-width:800px; flex-wrap:wrap;">
                                <!-- Blocker Task (Neden Olan) -->
                                <a href="<?= $this->url->href('TaskViewController', 'show', array('task_id' => $link['blocker_task_id'])) ?>" target="_blank" style="text-decoration:none; background:#fff; color:#333; border-radius:20px; padding:10px 20px; font-weight:bold; border:2px solid #f0ad4e; box-shadow:0 2px 5px rgba(0,0,0,0.05); display:flex; align-items:center; gap:8px; transition: transform 0.2s;">
                                    <i class="fa fa-cube" style="color:#f0ad4e;"></i> [<?= htmlspecialchars($link['blocker_task_title']) ?>]
                                </a>
                                
                                <!-- Arrow & Relation -->
                                <div style="display:flex; align-items:center; gap:5px;">
                                    <div style="background:#fce8e6; color:#d9534f; border:1px dashed #d9534f; padding:5px 12px; border-radius:12px; font-size:11px; font-weight:bold; white-space:nowrap;">
                                        %100 Engeller (blocks) ➔
                                    </div>
                                </div>

                                <!-- Blocked Task (Mağdur) -->
                                <a href="<?= $this->url->href('TaskViewController', 'show', array('task_id' => $link['blocked_task_id'])) ?>" target="_blank" style="text-decoration:none; background:#e8f0fe; color:#1a73e8; border-radius:20px; padding:10px 20px; font-weight:bold; border:2px solid #8ab4f8; box-shadow:0 2px 5px rgba(0,0,0,0.05); display:flex; align-items:center; gap:8px; transition: transform 0.2s;">
                                    <i class="fa fa-lock" style="color:#8ab4f8;"></i> [<?= htmlspecialchars($link['blocked_task_title']) ?>]
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div style="text-align:center; padding:30px; color:#888;">
                    <i class="fa fa-check-circle fa-3x" style="color:#5cb85c; margin-bottom:15px; display:block;"></i>
                    <?= t('Şu anda birbirine bağımlı (blokaj) hiçbir görev bulunmuyor.') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- 4. ZAMAN SINIRLI EYLEM PLANI -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('ZAMAN SINIRLI EYLEM PLANI') ?></div>
        <div class="bilgiyapar-mcc-action-grid">
            <!-- Başlıklar -->
            <div class="bilgiyapar-mcc-action-header bilgiyapar-mcc-role-header"><?= t('Kişiler / Roller') ?></div>
            <div class="bilgiyapar-mcc-action-header"><?= t('GECİKENLER (Alarm)') ?></div>
            <div class="bilgiyapar-mcc-action-header"><?= t('BUGÜN (P1 Acil)') ?></div>
            <div class="bilgiyapar-mcc-action-header"><?= t('BU HAFTA (Sprint Hedefi)') ?></div>
            <div class="bilgiyapar-mcc-action-header"><?= t('BU AY (Stratejik)') ?></div>

            <?php if(isset($users) && !empty($users)): ?>
                <?php foreach($users as $u): ?>
                    <?php 
                        $uNameRaw = $u['name'] ?: $u['username'];
                    ?>
                    <div class="bilgiyapar-mcc-action-col" style="display:flex; align-items:center; border-bottom:1px solid #eee;">
                        <div class="bilgiyapar-mcc-role-item" style="font-weight:bold; padding:10px;">
                            <a href="<?= $this->url->href('DashboardController', 'show', array('user_id' => $u['id'])) ?>" target="_blank" style="text-decoration:none; color:#24292e;">
                                <i class="fa fa-user" style="margin-right:8px; color:#007bff;"></i> <?= htmlspecialchars($uNameRaw) ?>
                            </a>
                        </div>
                    </div>
                    
                    <!-- GECİKENLER -->
                    <div class="bilgiyapar-mcc-action-col" style="border-bottom:1px solid #eee; padding:10px; background:#fff5f5;">
                        <?php 
                        $hasOverdue = false; $count = 0;
                        if(isset($tasks_overdue)) {
                            foreach($tasks_overdue as $t) {
                                if($t['owner_id'] == $u['id']) {
                                    if($count >= 4) {
                                        echo '<a href="'.$this->url->href('SearchController', 'index', array('search' => 'assignee:"'.$u['username'].'" status:open due:<=today')).'" target="_blank" style="font-size:11px; color:#d9534f; text-align:center; display:block; text-decoration:none;">+ Diğer Görevler...</a>';
                                        break;
                                    }
                                    $hasOverdue = true; $count++;
                                    echo '<a target="_blank" style="text-decoration:none; display:flex; flex-direction:column; color:inherit; border:1px solid #e1e4e8; border-radius:4px; padding:8px; margin-bottom:5px; background:#fff; border-left:3px solid #d9534f;" class="bilgiyapar-mcc-mini-card" href="'.$this->url->href('TaskViewController', 'show', array('task_id' => $t['id'])).'"><div style="display:flex; justify-content:space-between; align-items:center; font-size:12px; font-weight:600;"><span class="bilgiyapar-mcc-mini-card-title">'.htmlspecialchars($t['title']).'</span><i class="fa fa-calendar-times-o" style="color:#d9534f;"></i></div></a>';
                                }
                            }
                        }
                        if(!$hasOverdue) echo '<div style="font-size:12px; color:#aaa; text-align:center; font-style:italic;">'.t('Temiz').'</div>';
                        ?>
                    </div>

                    <!-- BUGÜN -->
                    <div class="bilgiyapar-mcc-action-col" style="border-bottom:1px solid #eee; padding:10px;">
                        <?php 
                        $hasToday = false; $count = 0;
                        if(isset($tasks_today)) {
                            foreach($tasks_today as $t) {
                                if($t['owner_id'] == $u['id']) {
                                    if($count >= 4) {
                                        echo '<a href="'.$this->url->href('SearchController', 'index', array('search' => 'assignee:"'.$u['username'].'" status:open')).'" target="_blank" style="font-size:11px; color:#007bff; text-align:center; display:block; text-decoration:none;">+ Diğer Görevler...</a>';
                                        break;
                                    }
                                    $hasToday = true; $count++;
                                    echo '<a target="_blank" style="text-decoration:none; display:flex; flex-direction:column; color:inherit; border:1px solid #e1e4e8; border-radius:4px; padding:8px; margin-bottom:5px; background:#fff;" class="bilgiyapar-mcc-mini-card" href="'.$this->url->href('TaskViewController', 'show', array('task_id' => $t['id'])).'"><div style="display:flex; justify-content:space-between; align-items:center; font-size:12px; font-weight:600;"><span class="bilgiyapar-mcc-mini-card-title">'.htmlspecialchars($t['title']).'</span><i class="fa fa-warning" style="color:#d9534f;"></i></div><div class="bilgiyapar-mcc-progress-bg" style="height:4px; background:#e1e4e8; border-radius:2px; margin-top:5px;"><div class="bilgiyapar-mcc-progress-bar" style="width: 25%; background-color:#d9534f; height:100%; border-radius:2px;"></div></div></a>';
                                }
                            }
                        }
                        if(!$hasToday) echo '<div style="font-size:12px; color:#aaa; text-align:center; font-style:italic;">'.t('Hedef Bulunmuyor').'</div>';
                        ?>
                    </div>

                    <!-- BU HAFTA -->
                    <div class="bilgiyapar-mcc-action-col" style="border-bottom:1px solid #eee; padding:10px;">
                        <?php 
                        $hasWeek = false; $count = 0;
                        if(isset($tasks_week)) {
                            foreach($tasks_week as $t) {
                                if($t['owner_id'] == $u['id']) {
                                    if($count >= 4) {
                                        echo '<a href="'.$this->url->href('SearchController', 'index', array('search' => 'assignee:"'.$u['username'].'" status:open')).'" target="_blank" style="font-size:11px; color:#007bff; text-align:center; display:block; text-decoration:none;">+ Diğer Görevler...</a>';
                                        break;
                                    }
                                    $hasWeek = true; $count++;
                                    echo '<a target="_blank" style="text-decoration:none; display:flex; flex-direction:column; color:inherit; border:1px solid #e1e4e8; border-radius:4px; padding:8px; margin-bottom:5px; background:#fff;" class="bilgiyapar-mcc-mini-card" href="'.$this->url->href('TaskViewController', 'show', array('task_id' => $t['id'])).'"><div style="display:flex; justify-content:space-between; align-items:center; font-size:12px; font-weight:600;"><span class="bilgiyapar-mcc-mini-card-title">'.htmlspecialchars($t['title']).'</span><i class="fa fa-check-circle" style="color:#5cb85c;"></i></div><div class="bilgiyapar-mcc-progress-bg" style="height:4px; background:#e1e4e8; border-radius:2px; margin-top:5px;"><div class="bilgiyapar-mcc-progress-bar" style="width: 50%; background-color:#5cb85c; height:100%; border-radius:2px;"></div></div></a>';
                                }
                            }
                        }
                        if(!$hasWeek) echo '<div style="font-size:12px; color:#aaa; text-align:center; font-style:italic;">'.t('Hedef Bulunmuyor').'</div>';
                        ?>
                    </div>

                    <!-- BU AY -->
                    <div class="bilgiyapar-mcc-action-col" style="border-bottom:1px solid #eee; padding:10px;">
                        <?php 
                        $hasMonth = false; $count = 0;
                        if(isset($tasks_month)) {
                            foreach($tasks_month as $t) {
                                if($t['owner_id'] == $u['id']) {
                                    if($count >= 4) {
                                        echo '<a href="'.$this->url->href('SearchController', 'index', array('search' => 'assignee:"'.$u['username'].'" status:open')).'" target="_blank" style="font-size:11px; color:#007bff; text-align:center; display:block; text-decoration:none;">+ Diğer Görevler...</a>';
                                        break;
                                    }
                                    $hasMonth = true; $count++;
                                    echo '<a target="_blank" style="text-decoration:none; display:flex; flex-direction:column; color:inherit; border:1px solid #e1e4e8; border-radius:4px; padding:8px; margin-bottom:5px; background:#fff;" class="bilgiyapar-mcc-mini-card" href="'.$this->url->href('TaskViewController', 'show', array('task_id' => $t['id'])).'"><div style="display:flex; justify-content:space-between; align-items:center; font-size:12px; font-weight:600;"><span class="bilgiyapar-mcc-mini-card-title">'.htmlspecialchars($t['title']).'</span><i class="fa fa-clock-o" style="color:#007bff;"></i></div><div class="bilgiyapar-mcc-progress-bg" style="height:4px; background:#e1e4e8; border-radius:2px; margin-top:5px;"><div class="bilgiyapar-mcc-progress-bar" style="width: 10%; background-color:#007bff; height:100%; border-radius:2px;"></div></div></a>';
                                }
                            }
                        }
                        if(!$hasMonth) echo '<div style="font-size:12px; color:#aaa; text-align:center; font-style:italic;">'.t('Hedef Bulunmuyor').'</div>';
                        ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- 5. ŞİRKET PROJELERİ & ÇEVİK MATRİSLER -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('ŞİRKET PROJELERİ & ÇEVİK MATRİSLER (Halka şirket portföyü)') ?></div>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 15px;">
            <?php if(isset($projects) && !empty($projects)): ?>
                <?php foreach($projects as $p): ?>
                    <div style="background:#fff; border:1px solid #e1e4e8; border-radius:8px; display:flex; flex-direction:column; position:relative;">
                        <div style="padding:15px; border-bottom:1px solid #eee;">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <i class="fa fa-product-hunt" style="color:#1a73e8; font-size:16px;"></i>
                                    <div style="font-weight:bold; font-size:14px; line-height:1.2;"><?= htmlspecialchars($p['name']) ?></div>
                                </div>
                                <i class="fa fa-ellipsis-v" style="color:#aaa; cursor:pointer;"></i>
                            </div>
                            
                            <div style="display:flex; align-items:center; gap:5px; margin-top:10px; font-size:12px; color:#555;">
                                <?= $p['wip_alert'] ? '<div style="width:8px; height:8px; border-radius:50%; background:#d9534f;"></div> '.t('Riskli') : '<div style="width:8px; height:8px; border-radius:50%; background:#5cb85c;"></div> '.t('Sağlıklı') ?>
                            </div>

                            <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px; font-size:11px; font-weight:bold;">
                                <span><?= t('İlerleme') ?></span>
                            </div>
                            <div class="bilgiyapar-mcc-progress-bg" style="height:6px; background:#e1e4e8; border-radius:3px; overflow:hidden; margin-top:4px;">
                                <div class="bilgiyapar-mcc-progress-bar" style="width: <?= $p['progress'] ?>%; background-color:#1a73e8; height:100%;"></div>
                            </div>

                            <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px; font-size:11px; color:#555;">
                                <span><?= t('Bütçe Kullanımı') ?></span>
                                <span style="font-weight:bold;">%<?= $p['burn_rate'] ?></span>
                            </div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-top:5px; font-size:11px; color:#555;">
                                <span><?= t('Üretim Hızı') ?></span>
                                <span style="font-weight:bold;"><?= $p['velocity'] ?> <?= t('Görev') ?></span>
                            </div>

                            <?php if($p['wip_alert']): ?>
                            <div style="margin-top:10px; background:#fce8e6; color:#d9534f; padding:4px 8px; border-radius:4px; font-size:10px; font-weight:bold; display:inline-block;">
                                <?= t('Darboğaz (WIP)') ?>
                            </div>
                            <?php else: ?>
                            <div style="margin-top:10px; height:20px;"></div> <!-- Yer tutucu -->
                            <?php endif; ?>
                        </div>
                        <div style="display:flex; background:#f9f9f9; border-radius:0 0 8px 8px;">
                            <a href="<?= $this->url->href('ProjectViewController', 'show', array('project_id' => $p['id'])) ?>" target="_blank" style="flex:1; padding:10px; text-align:center; font-size:12px; font-weight:bold; color:#555; text-decoration:none; border-right:1px solid #e1e4e8;">
                                <i class="fa fa-pie-chart"></i> <?= t('Özet') ?>
                            </a>
                            <a href="<?= $this->url->href('BoardViewController', 'show', array('project_id' => $p['id'])) ?>" target="_blank" style="flex:1; padding:10px; text-align:center; font-size:12px; font-weight:bold; color:#555; text-decoration:none;">
                                <i class="fa fa-th"></i> <?= t('Tahta') ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- 6. AI DESTEKLİ OPERASYONEL ÖNERİLER -->
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title" style="display:flex; align-items:center; gap:10px;">
            <i class="fa fa-android fa-2x" style="color:#007bff;"></i> 
            <?= t('MCP ÖNERİLERİ | DANIŞMANLIK') ?>
        </div>
        <div class="bilgiyapar-mcc-ai-grid">
            
            <?php if(!empty($ai_suggestion_1)): ?>
            <!-- Öneri 1 (Dinamik Darboğaz) -->
            <div class="bilgiyapar-mcc-card bilgiyapar-mcc-ai-prompt" style="display:block; cursor:pointer;" data-prompt="<?= htmlspecialchars("Sistem Uyarısı: " . $ai_suggestion_1 . " Lütfen bu blokajı çözecek acil bir görev şablonu hazırla ve ekibe ata.", ENT_QUOTES) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-magic bilgiyapar-mcc-text-primary"></i>
                    <div class="bilgiyapar-mcc-card-title">Darboğaz Tespiti</div>
                </div>
                <div class="bilgiyapar-mcc-card-content" style="font-size:14px; font-weight:normal;">
                    <?= htmlspecialchars($ai_suggestion_1) ?>
                    <br><br>
                    <button class="bilgiyapar-mcc-btn bilgiyapar-mcc-copy-btn" onclick="return false;" style="background:#007bff; color:#fff; border:none; padding:5px 10px; border-radius:3px; cursor:pointer;"><i class="fa fa-copy"></i> GÖREV OLUŞTUR VE ATA</button>
                </div>
            </div>
            <?php else: ?>
            <div class="bilgiyapar-mcc-card" style="background:#f9f9f9; padding:20px; text-align:center; color:#5cb85c;">
                <i class="fa fa-check-circle fa-2x"></i><br>
                Sistemde kritik bir darboğaz tespit edilmedi. Operasyonlar sağlıklı.
            </div>
            <?php endif; ?>

            <?php if(!empty($ai_suggestion_2)): ?>
            <!-- Öneri 2 (Dinamik Optimizasyon) -->
            <div class="bilgiyapar-mcc-card bilgiyapar-mcc-ai-prompt" style="display:block; cursor:pointer;" data-prompt="<?= htmlspecialchars("Stratejik Veri: " . $ai_suggestion_2 . " Lütfen takımı tekrar aktif hale getirecek haftalık hedefleri belirle.", ENT_QUOTES) ?>">
                <div class="bilgiyapar-mcc-card-header">
                    <i class="fa fa-magic bilgiyapar-mcc-text-primary"></i>
                    <div class="bilgiyapar-mcc-card-title">Kapasite & Velocity Optimizasyonu</div>
                </div>
                <div class="bilgiyapar-mcc-card-content" style="font-size:14px; font-weight:normal;">
                    <?= htmlspecialchars($ai_suggestion_2) ?>
                    <br><br>
                    <button class="bilgiyapar-mcc-btn bilgiyapar-mcc-copy-btn" onclick="return false;" style="background:#007bff; color:#fff; border:none; padding:5px 10px; border-radius:3px; cursor:pointer;"><i class="fa fa-copy"></i> AJANLARI AKTİF ET</button>
                </div>
            </div>
            <?php else: ?>
            <div class="bilgiyapar-mcc-card" style="background:#f9f9f9; padding:20px; text-align:center; color:#5cb85c;">
                <i class="fa fa-dashboard fa-2x"></i><br>
                Tüm aktif projelerde iş kapatma hızı (Velocity) gayet verimli.
            </div>
            <?php endif; ?>
            
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
