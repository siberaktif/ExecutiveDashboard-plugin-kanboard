<div class="bilgiyapar-mcc-section">
    <div class="bilgiyapar-mcc-section-title"><i class="fa fa-language"></i> <?= t('Sistem Dil Yapılandırması') ?></div>
    <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; overflow-x:auto;">
        <table class="table-striped table-scrolling" style="width:100%; text-align:left; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #ddd;">
                    <th style="padding:10px;">Ayar Adı (Option)</th>
                    <th style="padding:10px;">Aktif Dil Kodu (Locale)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($settings as $s): ?>
                <tr style="border-bottom:1px solid #f1f1f1;">
                    <td style="padding:10px; font-family:monospace; font-weight:bold; color:#555;"><?= htmlspecialchars($s['option'] ?? 'language') ?></td>
                    <td style="padding:10px; font-weight:bold; color:#28a745;"><i class="fa fa-flag"></i> <?= htmlspecialchars($s['value'] ?? '') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>