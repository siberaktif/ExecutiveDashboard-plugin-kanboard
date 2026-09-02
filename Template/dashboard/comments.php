<div class="bilgiyapar-mcc-section">
    <div class="bilgiyapar-mcc-section-title"><i class="fa fa-comments"></i> <?= t('Tüm Sistem Yorumları') ?></div>
    
    <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; overflow-x:auto;">
        <table class="table-striped table-scrolling" style="width:100%; text-align:left; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #ddd;">
                    <th style="padding:10px;">ID</th>
                    <th style="padding:10px;">Yorum</th>
                    <th style="padding:10px;">Görev</th>
                    <th style="padding:10px;">Kullanıcı</th>
                    <th style="padding:10px;">Tarih</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($comments as $c): ?>
                <tr style="border-bottom:1px solid #f1f1f1;">
                    <td style="padding:10px;"><?= $c['id'] ?></td>
                    <td style="padding:10px; max-width:400px; word-break:break-word;"><?= htmlspecialchars(mb_substr($c['comment'], 0, 150)) ?>...</td>
                    <td style="padding:10px;">
                        <a href="<?= $this->url->href('TaskViewController', 'show', ['task_id' => $c['task_id']]) ?>" target="_blank" style="text-decoration:none; color:#0366d6;">
                            #<?= $c['task_id'] ?> - <?= htmlspecialchars($c['task_title']) ?>
                        </a>
                    </td>
                    <td style="padding:10px;"><?= htmlspecialchars($c['user_name'] ?: $c['username']) ?></td>
                    <td style="padding:10px;"><?= date('Y-m-d H:i', $c['date_creation']) ?></td>
                </tr>
                <?php endforeach; ?>
                
                <?php if(empty($comments)): ?>
                <tr>
                    <td colspan="5" style="padding:20px; text-align:center; color:#6a737d;"><?= t('Sistemde henüz hiç yorum bulunmuyor.') ?></td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>