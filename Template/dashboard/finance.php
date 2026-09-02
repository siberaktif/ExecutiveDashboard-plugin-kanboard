<div class="bilgiyapar-mcc-section">
    <div class="bilgiyapar-mcc-section-title"><i class="fa fa-money"></i> <?= t('Küresel Finans ve Bütçe Kırılımları') ?></div>
    
    <!-- Üst KPI Kartları -->
    <div style="display:flex; gap:20px; margin-bottom:20px; flex-wrap:wrap;">
        <div style="flex:1; min-width:200px; background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; text-align:center; border-left:4px solid #1a73e8;">
            <div style="font-size:12px; color:#666; font-weight:bold;"><?= t('Tahsis Edilen Toplam Bütçe') ?></div>
            <div style="font-size:24px; font-weight:bold; color:#1a73e8;"><?= number_format($global_budget, 2, ',', '.') ?> TL</div>
            <div style="font-size:11px; color:#888; margin-top:5px;"><?= t('Projelerin Toplam Bütçe Havuzu') ?></div>
        </div>

        <div style="flex:1; min-width:200px; background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; text-align:center; border-left:4px solid #d73a49;">
            <div style="font-size:12px; color:#666; font-weight:bold;"><?= t('Gerçekleşen Harcama (Maliyetler)') ?></div>
            <div style="font-size:24px; font-weight:bold; color:#d73a49;"><?= number_format($budget_spent, 2, ',', '.') ?> TL</div>
            <div style="font-size:11px; color:#888; margin-top:5px;"><?= t('Zaman Takibi ve Alt Görev Maliyeti') ?></div>
        </div>

        <?php 
            $remaining = $global_budget - $budget_spent; 
            $rem_color = $remaining >= 0 ? '#28a745' : '#d73a49';
        ?>
        <div style="flex:1; min-width:200px; background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; text-align:center; border-left:4px solid <?= $rem_color ?>;">
            <div style="font-size:12px; color:#666; font-weight:bold;"><?= t('Kalan Kullanılabilir Bakiye') ?></div>
            <div style="font-size:24px; font-weight:bold; color:<?= $rem_color ?>;"><?= number_format($remaining, 2, ',', '.') ?> TL</div>
            <div style="font-size:11px; color:#888; margin-top:5px;"><?= t('Net Kalan Bütçe') ?></div>
        </div>
    </div>

    <!-- Tanımlı Bütçe Kalemleri Tablosu -->
    <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; overflow-x:auto;">
        <div style="font-weight:bold; font-size:14px; margin-bottom:15px; color:#333;"><?= t('Projeler Bazında Tahsis Edilen Bütçeler (budget_lines)') ?></div>
        <table class="table-striped table-scrolling" style="width:100%; text-align:left; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #ddd;">
                    <th style="padding:10px;">ID</th>
                    <th style="padding:10px;">Tarih</th>
                    <th style="padding:10px;">Proje (Bütçe Sayfası)</th>
                    <th style="padding:10px;">Açıklama / Fonlama Kalemi</th>
                    <th style="padding:10px; text-align:right;">Bütçe Tutarı</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($budget_lines as $bl): ?>
                <tr style="border-bottom:1px solid #f1f1f1;">
                    <td style="padding:10px; color:#888;">#<?= $bl['id'] ?></td>
                    <td style="padding:10px; font-weight:bold;"><?= htmlspecialchars($bl['date']) ?></td>
                    <td style="padding:10px;">
                        <!-- Doğrudan ilgili projenin bütçe sayfasına yönlendirir -->
                        <a href="<?= $this->url->dir() ?>project/<?= $bl['project_id'] ?>/budget" target="_blank" style="text-decoration:none; color:#1a73e8; font-weight:bold;">
                            <i class="fa fa-money"></i> <?= htmlspecialchars($bl['project_name']) ?>
                        </a>
                    </td>
                    <td style="padding:10px; color:#555;"><?= htmlspecialchars($bl['comment'] ?? 'Açıklama yok') ?></td>
                    <td style="padding:10px; text-align:right; font-weight:bold; color:#28a745;">
                        +<?= number_format($bl['amount'], 2, ',', '.') ?> TL
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php if(empty($budget_lines)): ?>
                <tr><td colspan="5" style="padding:20px; text-align:center; color:#6a737d;"><?= t('Sistemde kayıtlı bütçe kalemi bulunmuyor.') ?></td></tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr style="border-top:2px solid #333; background:#fafafa;">
                    <td colspan="4" style="padding:10px; text-align:right; font-weight:bold;"><?= t('TOPLAM TAHSİS EDİLEN BÜTÇE:') ?></td>
                    <td style="padding:10px; text-align:right; font-weight:bold; color:#28a745; font-size:16px;">
                        <?= number_format($global_budget, 2, ',', '.') ?> TL
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>