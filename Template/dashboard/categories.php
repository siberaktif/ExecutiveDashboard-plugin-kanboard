<div class="bilgiyapar-mcc-section">
    <div class="bilgiyapar-mcc-section-title"><i class="fa fa-tags"></i> <?= t('Tüm Proje Kategorileri') ?></div>
    <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; overflow-x:auto;">
        <table class="table-striped table-scrolling" style="width:100%; text-align:left; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #ddd;">
                    <th style="padding:10px;">ID</th>
                    <th style="padding:10px;">Kategori Adı</th>
                    <th style="padding:10px;">Proje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $cat): ?>
                <tr style="border-bottom:1px solid #f1f1f1;">
                    <td style="padding:10px;"><?= $cat['id'] ?></td>
                    <td style="padding:10px; font-weight:bold;"><?= htmlspecialchars($cat['name']) ?></td>
                    <td style="padding:10px;">
                        <a href="<?= $this->url->href('ProjectViewController', 'show', ['project_id' => $cat['project_id']]) ?>" target="_blank" style="text-decoration:none; color:#0366d6;">
                            <?= htmlspecialchars($cat['project_name']) ?>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($categories)): ?>
                <tr><td colspan="3" style="padding:20px; text-align:center; color:#6a737d;"><?= t('Sistemde henüz hiç kategori bulunmuyor.') ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>