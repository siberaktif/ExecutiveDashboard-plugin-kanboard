<div class="bilgiyapar-mcc-section">
    <div class="bilgiyapar-mcc-section-title"><i class="fa fa-cogs"></i> <?= t('Tüm Otomatik Eylemler (Automatic Actions)') ?></div>
    <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; overflow-x:auto;">
        <table class="table-striped table-scrolling" style="width:100%; text-align:left; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #ddd;">
                    <th style="padding:10px;">ID</th>
                    <th style="padding:10px;">Olay (Event)</th>
                    <th style="padding:10px;">Eylem (Action)</th>
                    <th style="padding:10px;">Proje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($actions as $act): ?>
                <tr style="border-bottom:1px x solid #f1f1f1;">
                    <td style="padding:10px;"><?= $act['id'] ?></td>
                    <td style="padding:10px; font-family:monospace; color:#d73a49;"><?= htmlspecialchars($act['event']) ?></td>
                    <td style="padding:10px; font-weight:bold; color:#0366d6;"><?= htmlspecialchars($act['action_name']) ?></td>
                    <td style="padding:10px;">
                        <?php if(!empty($act['project_id']) && $act['project_id'] > 0): ?>
                            <a href="<?= $this->url->href('ProjectViewController', 'show', ['project_id' => $act['project_id']]) ?>" target="_blank" style="text-decoration:none; color:#0366d6;">
                                <i class="fa fa-folder"></i> <?= htmlspecialchars($act['project_name'] ?? 'Proje #'.$act['project_id']) ?>
                            </a>
                        <?php else: ?>
                            <span style="color:#28a745; font-weight:bold;"><?= t('Genel (Global)') ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($actions)): ?>
                <tr><td colspan="4" style="padding:20px; text-align:center; color:#6a737d;"><?= t('Sistemde henüz hiç otomatik eylem tanımlanmamış.') ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->render('ExecutiveDashboard:dashboard/back_button') ?>
