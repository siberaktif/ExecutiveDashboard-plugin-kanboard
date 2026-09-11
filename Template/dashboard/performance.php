<div class="bilgiyapar-mcc-section">
    <div class="bilgiyapar-mcc-section-title"><i class="fa fa-line-chart"></i> <?= t('Genel Proje Performansı & Çevik (Agile) Metrik Hesaplama Paneli') ?></div>
    
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:15px; margin-bottom:20px;">
        <!-- Kart 1 -->
        <a target="_blank" href="<?= $this->url->href('ProjectListController', 'show') ?>" style="text-decoration:none; display:block; background:#fff; border:1px solid #e1e4e8; border-left:4px solid #1a73e8; border-radius:6px; padding:15px; transition: transform 0.2s;">
            <div style="font-size:12px; color:#666;"><?= t('Aritmetik Ortalama (Eşit Ağırlıklı)') ?></div>
            <div style="font-size:24px; font-weight:bold; color:#1a73e8;">%<?= $unweighted_avg ?></div>
            <div style="font-size:11px; color:#888; margin-top:5px;">Formül: Yüzdeler toplamı / <?= $project_count ?> Proje</div>
        </a>

        <!-- Kart 2 (Standartlaştırılmış Puan / Görev Görünümü) -->
        <a target="_blank" href="<?= $this->url->href('SearchController', 'index', ['search' => 'status:closed']) ?>" style="text-decoration:none; display:block; background:#fff; border:1px solid #e1e4e8; border-left:4px solid #28a745; border-radius:6px; padding:15px; transition: transform 0.2s;">
            <div style="font-size:12px; color:#666;"><?= t('Ağırlıklı İlerleme (Karmaşıklık Bazlı)') ?></div>
            <div style="font-size:24px; font-weight:bold; color:#28a745;">%<?= $weighted_avg ?></div>
            <div style="font-size:11px; color:#888; margin-top:5px; line-height:1.4;">
                <span style="color:#28a745; font-weight:bold;">Tamamlanan:</span> <?= $closed_complexity_all ?> Puan / <?= $total_closed_all ?> Görev<br>
                <span style="color:#555; font-weight:bold;">Toplam:</span> <?= $total_complexity_all ?> Puan / <?= $total_tasks_all ?> Görev
            </div>
        </a>

        <!-- Kart 3 -->
        <a target="_blank" href="<?= $this->url->href('ExecutiveDashboardController', 'score', ['plugin' => 'ExecutiveDashboard']) ?>" style="text-decoration:none; display:block; background:#fff; border:1px solid #e1e4e8; border-left:4px solid #f0ad4e; border-radius:6px; padding:15px; transition: transform 0.2s;">
            <div style="font-size:12px; color:#666;"><?= t('Genel Skor (Sağlık & Öncelik İndeksli)') ?></div>
            <div style="font-size:24px; font-weight:bold; color:#f0ad4e;">%<?= isset($score) ? $score : 0 ?></div>
            <div style="font-size:11px; color:#888; margin-top:5px; line-height:1.4;">
                İlerleme - (Gecikme Cezası) - (Blokaj Cezası)
            </div>
        </a>

        <!-- Kart 4 -->
        <a target="_blank" href="<?= $this->url->href('ExecutiveDashboardController', 'health', ['plugin' => 'ExecutiveDashboard']) ?>" style="text-decoration:none; display:block; background:#fff; border:1px solid #e1e4e8; border-left:4px solid #d73a49; border-radius:6px; padding:15px; transition: transform 0.2s;">
            <div style="font-size:12px; color:#666;"><?= t('Toplam Risk Havuzu') ?></div>
            <div style="font-size:24px; font-weight:bold; color:#d73a49;"><?= $overdue_count + $blocker_count ?> Sorun</div>
            <div style="font-size:11px; color:#888; margin-top:5px; line-height:1.4;">
                <span style="color:#d73a49; font-weight:bold;">Geciken:</span> <?= $overdue_count ?> Görev<br>
                <span style="color:#f0ad4e; font-weight:bold;">Blokaj:</span> <?= $blocker_count ?> Bağlantı
            </div>
        </a>
    </div>

    <!-- Tablo (Standartlaştırılmış Sütunlar) -->
    <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; overflow-x:auto;">
        <table class="table-striped table-scrolling" style="width:100%; text-align:left; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #ddd;">
                    <th style="padding:10px;">Proje Adı</th>
                    <th style="padding:10px;">Toplam (Puan / Görev)</th>
                    <th style="padding:10px;">Tamamlanan (Puan / Görev)</th>
                    <th style="padding:10px;">Açık (Puan / Görev)</th>
                    <th style="padding:10px;">Çevik İlerleme (Gantt)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($project_stats as $ps): ?>
                <tr style="border-bottom:1px solid #f1f1f1;">
                    <td style="padding:10px; font-weight:bold;">
                        <a href="<?= $this->url->href('ProjectViewController', 'show', ['project_id' => $ps['id']]) ?>" target="_blank" style="text-decoration:none; color:#1a73e8;">
                            <i class="fa fa-folder-open"></i> <?= htmlspecialchars($ps['name']) ?>
                        </a>
                    </td>
                    <td style="padding:10px;">
                        <a href="<?= $this->url->href('SearchController', 'index', ['search' => 'project:'.$ps['id']]) ?>" target="_blank" style="text-decoration:none; font-weight:bold; color:#333;">
                            <span style="color:#6f42c1;"><?= $ps['total_comp'] ?> Puan</span> / <?= $ps['total_tasks'] ?> Görev
                        </a>
                    </td>
                    <td style="padding:10px;">
                        <a href="<?= $this->url->href('SearchController', 'index', ['search' => 'project:'.$ps['id'].' status:closed']) ?>" target="_blank" style="text-decoration:none; color:#28a745; font-weight:bold;">
                            <?= $ps['closed_comp'] ?> Puan / <?= $ps['closed_tasks'] ?> Görev
                        </a>
                    </td>
                    <td style="padding:10px;">
                        <a href="<?= $this->url->href('SearchController', 'index', ['search' => 'project:'.$ps['id'].' status:open']) ?>" target="_blank" style="text-decoration:none; color:#d73a49; font-weight:bold;">
                            <?= $ps['total_comp'] - $ps['closed_comp'] ?> Puan / <?= $ps['open_tasks'] ?> Görev
                        </a>
                    </td>
                    <td style="padding:10px; width:220px;">
                        <a href="<?= $this->url->href('ProjectGanttController', 'show', ['project_id' => $ps['id'], 'plugin' => 'Gantt']) ?>" target="_blank" title="<?= t('Gantt Şemasını Aç') ?>" style="text-decoration:none; display:flex; align-items:center; gap:10px;">
                            <div style="flex:1; background:#e1e4e8; height:8px; border-radius:4px; overflow:hidden;">
                                <div style="width:<?= $ps['progress'] ?>%; background:#1a73e8; height:100%;"></div>
                            </div>
                            <span style="font-weight:bold; font-size:12px; color:#1a73e8;">%<?= $ps['progress'] ?> <i class="fa fa-sliders"></i></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="border-top:2px solid #333; font-weight:bold; background:#fafafa;">
                    <td style="padding:10px;">AĞIRLIKLI TOPLAM:</td>
                    <td style="padding:10px;"><span style="color:#6f42c1;"><?= $total_complexity_all ?> Puan</span> / <?= $total_tasks_all ?> Görev</td>
                    <td style="padding:10px; color:#28a745;"><?= $closed_complexity_all ?> Puan / <?= $total_closed_all ?> Görev</td>
                    <td style="padding:10px; color:#d73a49;"><?= $total_complexity_all - $closed_complexity_all ?> Puan / <?= $total_open_all ?> Görev</td>
                    <td style="padding:10px; color:#1a73e8;">%<?= $weighted_avg ?> (Genel İlerleme)</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?= $this->render('ExecutiveDashboard:dashboard/back_button') ?>
