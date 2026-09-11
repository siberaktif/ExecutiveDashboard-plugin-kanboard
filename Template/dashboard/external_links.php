<div class="bilgiyapar-mcc-section">
    <div class="bilgiyapar-mcc-section-title"><i class="fa fa-external-link"></i> <?= t('Tüm Dış Bağlantılar (External Links)') ?></div>
    <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; overflow-x:auto;">
        <table class="table-striped table-scrolling" style="width:100%; text-align:left; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #ddd;">
                    <th style="padding:10px;">ID</th>
                    <th style="padding:10px;">Başlık / URL</th>
                    <th style="padding:10px;">İlgili Görev</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($links as $l): ?>
                <tr style="border-bottom:1px solid #f1f1f1;">
                    <td style="padding:10px;"><?= $l['id'] ?></td>
                    <td style="padding:10px;">
                        <a href="<?= htmlspecialchars($l['url']) ?>" target="_blank" style="text-decoration:none; color:#0366d6; font-weight:bold;">
                            <i class="fa fa-external-link"></i> <?= htmlspecialchars($l['title'] ?? $l['url']) ?>
                        </a>
                    </td>
                    <td style="padding:10px;">
                        <a href="<?= $this->url->href('TaskViewController', 'show', ['task_id' => $l['task_id']]) ?>" target="_blank" style="text-decoration:none; color:#555;">
                            #<?= $l['task_id'] ?> - <?= htmlspecialchars($l['task_title'] ?? '') ?>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($links)): ?>
                <tr><td colspan="3" style="padding:20px; text-align:center; color:#6a737d;"><?= t('Sistemde henüz hiç dış bağlantı bulunmuyor.') ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->render('ExecutiveDashboard:dashboard/back_button') ?>
