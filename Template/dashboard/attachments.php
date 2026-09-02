<div class="bilgiyapar-mcc-section">
    <div class="bilgiyapar-mcc-section-title"><i class="fa fa-paperclip"></i> <?= t('Tüm Sistem Dosya Ekleri') ?></div>
    <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; overflow-x:auto;">
        <table class="table-striped table-scrolling" style="width:100%; text-align:left; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #ddd;">
                    <th style="padding:10px;">ID</th>
                    <th style="padding:10px;">Dosya Adı</th>
                    <th style="padding:10px;">İlgili Görev</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($files as $f): ?>
                <tr style="border-bottom:1px solid #f1f1f1;">
                    <td style="padding:10px;"><?= $f['id'] ?></td>
                    <td style="padding:10px; font-weight:bold;"><?= htmlspecialchars($f['name']) ?></td>
                    <td style="padding:10px;">
                        <a href="<?= $this->url->href('TaskViewController', 'show', ['task_id' => $f['task_id']]) ?>" target="_blank" style="text-decoration:none; color:#0366d6;">
                            #<?= $f['task_id'] ?> - <?= htmlspecialchars($f['task_title']) ?>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($files)): ?>
                <tr><td colspan="3" style="padding:20px; text-align:center; color:#6a737d;"><?= t('Sistemde henüz hiç dosya eki bulunmuyor.') ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>