<div class="bilgiyapar-mcc-section">
    <div class="bilgiyapar-mcc-section-title"><i class="fa fa-tags"></i> <?= t('Tüm Sistem Etiketleri (Global & Projeler)') ?></div>
    
    <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; overflow-x:auto;">
        <table class="table-striped table-scrolling" style="width:100%; text-align:left; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #ddd;">
                    <th style="padding:10px;">ID</th>
                    <th style="padding:10px;">Etiket Adı</th>
                    <th style="padding:10px;">Proje</th>
                    <th style="padding:10px;">Renk Kodu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tags as $tag): ?>
                <tr style="border-bottom:1px solid #f1f1f1;">
                    <td style="padding:10px;"><?= $tag['id'] ?></td>
                    <td style="padding:10px;">
                        <?php 
                            // Try to map kanboard color id to actual color
                            $color_css = "#ccc";
                            if (!empty($tag['color_id'])) {
                                $color_css = "var(--color-".$tag['color_id'].")"; 
                            }
                        ?>
                        <span style="background:<?= $color_css ?>; padding:3px 8px; border-radius:4px; border:1px solid #ccc; font-weight:bold;">
                            <?= htmlspecialchars($tag['name']) ?>
                        </span>
                    </td>
                    <td style="padding:10px;">
                        <?php if($tag['project_id'] == 0): ?>
                            <span style="color:#28a745; font-weight:bold;"><?= t('Genel (Global)') ?></span>
                        <?php else: ?>
                            <a href="<?= $this->url->href('ProjectViewController', 'show', ['project_id' => $tag['project_id']]) ?>" target="_blank" style="text-decoration:none; color:#0366d6;">
                                <i class="fa fa-folder"></i> <?= htmlspecialchars($tag['project_name']) ?>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td style="padding:10px;">
                        <span style="color:#6a737d; font-family:monospace;"><?= $tag['color_id'] ? $tag['color_id'] : t('Varsayılan') ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php if(empty($tags)): ?>
                <tr>
                    <td colspan="4" style="padding:20px; text-align:center; color:#6a737d;"><?= t('Sistemde henüz hiçbir etiket bulunmuyor.') ?></td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
