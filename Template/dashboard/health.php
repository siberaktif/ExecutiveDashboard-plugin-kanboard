<div class="bilgiyapar-mcc-section">
    <div class="bilgiyapar-mcc-section-title"><i class="fa fa-heartbeat"></i> <?= t('Proje Sağlığı & Tespit Edilen Riskler') ?></div>
    
    <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; overflow-x:auto;">
        
        <!-- JAVASCRIPT FİLTRE BUTONLARI -->
        <div style="display:flex; gap:15px; margin-bottom:20px; padding-bottom:15px; border-bottom:1px solid #eee;">
            <button onclick="filterRisk('all')" style="border:1px solid #1a73e8; background:#e8f0fe; color:#1a73e8; padding:8px 15px; border-radius:20px; cursor:pointer; font-weight:bold;">
                <i class="fa fa-stethoscope"></i> Tümü (<?= count($overdue_tasks) + count($blockers) ?>)
            </button>
            <button onclick="filterRisk('overdue')" style="border:1px solid #d73a49; background:#fff; color:#d73a49; padding:8px 15px; border-radius:20px; cursor:pointer; font-weight:bold;">
                <i class="fa fa-calendar-times-o"></i> Gecikenler (<?= count($overdue_tasks) ?>)
            </button>
            <button onclick="filterRisk('blocker')" style="border:1px solid #f0ad4e; background:#fff; color:#f0ad4e; padding:8px 15px; border-radius:20px; cursor:pointer; font-weight:bold;">
                <i class="fa fa-lock"></i> Blokajlar (<?= count($blockers) ?>)
            </button>
        </div>

        <table class="table-striped table-scrolling" style="width:100%; text-align:left; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #ddd;">
                    <th style="padding:10px;">Risk Türü</th>
                    <th style="padding:10px;">Görev</th>
                    <th style="padding:10px;">Proje</th>
                    <th style="padding:10px;">Etki (Öncelik x Puan)</th>
                    <th style="padding:10px;">Detay / Tarih</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($overdue_tasks as $ot): ?>
                <tr class="risk-row risk-overdue" style="border-bottom:1px solid #f1f1f1;">
                    <td style="padding:10px; color:#d73a49; font-weight:bold;"><i class="fa fa-calendar-times-o"></i> Gecikmiş</td>
                    <td style="padding:10px;">
                        <a href="<?= $this->url->href('TaskViewController', 'show', ['task_id' => $ot['id']]) ?>" target="_blank" style="text-decoration:none; color:#333; font-weight:bold;">
                            #<?= $ot['id'] ?> - <?= htmlspecialchars($ot['title']) ?>
                        </a>
                    </td>
                    <td style="padding:10px;">
                        <a href="<?= $this->url->href('ProjectViewController', 'show', ['project_id' => $ot['project_id']]) ?>" target="_blank" style="text-decoration:none; color:#0366d6;">
                            <?= htmlspecialchars($ot['project_name']) ?>
                        </a>
                    </td>
                    <td style="padding:10px; font-weight:bold; color:#6f42c1;">
                        Ö:<?= max(1, $ot['priority']) ?> × K:<?= max(1, $ot['score']) ?>
                    </td>
                    <td style="padding:10px; color:#d73a49; font-weight:bold;"><?= date('Y-m-d', $ot['date_due']) ?></td>
                </tr>
                <?php endforeach; ?>

                <?php foreach($blockers as $b): ?>
                <tr class="risk-row risk-blocker" style="border-bottom:1px solid #f1f1f1;">
                    <td style="padding:10px; color:#f0ad4e; font-weight:bold;"><i class="fa fa-lock"></i> Blokaj</td>
                    <td style="padding:10px;">
                        <a href="<?= $this->url->href('TaskViewController', 'show', ['task_id' => $b['id']]) ?>" target="_blank" style="text-decoration:none; color:#333; font-weight:bold;">
                            #<?= $b['id'] ?> - <?= htmlspecialchars($b['title']) ?>
                        </a>
                    </td>
                    <td style="padding:10px;">
                        <a href="<?= $this->url->href('ProjectViewController', 'show', ['project_id' => $b['project_id']]) ?>" target="_blank" style="text-decoration:none; color:#0366d6;">
                            <?= htmlspecialchars($b['project_name']) ?>
                        </a>
                    </td>
                    <td style="padding:10px; font-weight:bold; color:#6f42c1;">
                        Ö:<?= max(1, $b['priority']) ?> × K:<?= max(1, $b['score']) ?>
                    </td>
                    <td style="padding:10px; color:#888;">İşi durduran bağlantı</td>
                </tr>
                <?php endforeach; ?>

                <?php if(empty($overdue_tasks) && empty($blockers)): ?>
                <tr class="risk-row">
                    <td colspan="5" style="padding:20px; text-align:center; color:#28a745; font-weight:bold;"><?= t('Tüm projeler sağlıklı; risk bulunmuyor.') ?></td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function filterRisk(type) {
    var rows = document.querySelectorAll('.risk-row');
    rows.forEach(function(row) {
        if (type === 'all') {
            row.style.display = '';
        } else {
            if (row.classList.contains('risk-' + type)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}
</script>