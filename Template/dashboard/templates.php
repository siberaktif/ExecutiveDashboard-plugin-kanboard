<div class="bilgiyapar-mcc-section">
    <div class="bilgiyapar-mcc-section-title"><i class="fa fa-file-text-o"></i> <?= t('Sistem Şablonları & Özel Filtreler') ?></div>
    <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; overflow-x:auto;">
        <table class="table-striped table-scrolling" style="width:100%; text-align:left; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #ddd;">
                    <th style="padding:10px;">Tür</th>
                    <th style="padding:10px;">Şablon / Filtre Adı</th>
                    <th style="padding:10px;">İlgili Proje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($templates as $tpl): ?>
                <tr style="border-bottom:1px solid #f1f1f1;">
                    <td style="padding:10px; color:#17a2b8; font-weight:bold;"><i class="fa fa-tag"></i> <?= htmlspecialchars($tpl['type']) ?></td>
                    <td style="padding:10px; font-weight:bold;"><?= htmlspecialchars($tpl['name']) ?></td>
                    <td style="padding:10px;">
                        <?php if($tpl['project_id'] > 0): ?>
                            <a href="<?= $this->url->href('ProjectViewController', 'show', ['project_id' => $tpl['project_id']]) ?>" target="_blank" style="text-decoration:none; color:#0366d6;">
                                <i class="fa fa-folder"></i> <?= t('Proje') ?> #<?= $tpl['project_id'] ?>
                            </a>
                        <?php else: ?>
                            <span style="color:#28a745; font-weight:bold;"><?= t('Genel (Global)') ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($templates)): ?>
                <tr><td colspan="3" style="padding:20px; text-align:center; color:#6a737d;"><?= t('Sistemde henüz kayıtlı şablon bulunmuyor.') ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->render('ExecutiveDashboard:dashboard/back_button') ?>
