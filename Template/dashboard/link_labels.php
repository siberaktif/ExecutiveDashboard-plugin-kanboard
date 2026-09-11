<div class="bilgiyapar-mcc-section">
    <div class="bilgiyapar-mcc-section-title"><i class="fa fa-link"></i> <?= t('Bağlantı Etiketleri (Link Labels)') ?></div>
    <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; overflow-x:auto;">
        <table class="table-striped table-scrolling" style="width:100%; text-align:left; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #ddd;">
                    <th style="padding:10px;">ID</th>
                    <th style="padding:10px;">Bağlantı Türü / Etiket</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($link_labels as $ll): ?>
                <tr style="border-bottom:1px solid #f1f1f1;">
                    <td style="padding:10px;"><?= isset($ll['id']) ? $ll['id'] : '-' ?></td>
                    <td style="padding:10px; font-weight:bold;"><?= htmlspecialchars($ll['name'] ?? $ll['label'] ?? '') ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($link_labels)): ?>
                <tr><td colspan="2" style="padding:20px; text-align:center; color:#6a737d;"><?= t('Sistemde tanımlı bağlantı etiketi bulunmuyor.') ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->render('ExecutiveDashboard:dashboard/back_button') ?>
