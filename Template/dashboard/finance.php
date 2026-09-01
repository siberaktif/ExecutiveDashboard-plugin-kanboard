<div class="bilgiyapar-mcc-dashboard-container">
    <div class="bilgiyapar-mcc-dashboard-header"><i class="fa fa-money"></i> <?= t('Küresel Finans ve Bütçe Kırılımları') ?></div>
    
    <div class="bilgiyapar-mcc-section">
        <div class="bilgiyapar-mcc-section-title"><?= t('Tüm Projelerin Bütçe Kalemleri') ?></div>
        
        <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:20px; overflow-x:auto;">
            <table class="table-striped table-scrolling" style="width:100%; text-align:left; border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:2px solid #ddd;">
                        <th style="padding:10px;"><?= t('Proje') ?></th>
                        <th style="padding:10px;"><?= t('Başlık / Açıklama') ?></th>
                        <th style="padding:10px;"><?= t('Tarih') ?></th>
                        <th style="padding:10px;"><?= t('Miktar') ?></th>
                        <th style="padding:10px;"><?= t('Durum') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($budget_lines)): ?>
                        <?php $total = 0; foreach($budget_lines as $line): $total += $line['amount']; ?>
                        <tr style="border-bottom:1px solid #eee;">
                            <td style="padding:10px;"><a href="<?= $this->url->href('BudgetController', 'show', array('plugin' => 'CostControl', 'project_id' => $line['project_id'])) ?>" target="_blank"><strong><?= htmlspecialchars($line['project_name']) ?></strong></a></td>
                            <td style="padding:10px;"><?= htmlspecialchars($line['comment']) ?></td>
                            <td style="padding:10px;"><?= date('Y-m-d', $line['date'] ?? time()) ?></td>
                            <td style="padding:10px;"><strong><?= $this->helper->dashboardFormat->currency($line['amount']) ?></strong></td>
                            <td style="padding:10px;">
                                <span style="background:#fce8e6; color:#d9534f; padding:3px 8px; border-radius:10px; font-size:11px; font-weight:bold;">Gerçekleşen Harcama</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr style="background:#f9f9f9; border-top:2px solid #ddd;">
                            <td colspan="3" style="padding:15px; text-align:right;"><strong><?= t('Genel Toplam (Tüm Projeler):') ?></strong></td>
                            <td colspan="2" style="padding:15px; font-size:18px; color:#d9534f;"><strong><?= $this->helper->dashboardFormat->currency($total) ?></strong></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="padding:20px; text-align:center; color:#888;">
                                <i class="fa fa-info-circle fa-2x" style="margin-bottom:10px; display:block;"></i>
                                <?= t('Bütçe kaydı bulunamadı veya CostControl eklentisi aktif değil.') ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div style="margin-top:20px;">
        <a href="<?= $this->url->href('ExecutiveDashboardController', 'index', array('plugin' => 'ExecutiveDashboard')) ?>" class="btn btn-blue"><i class="fa fa-arrow-left"></i> <?= t('Kontrol Merkezine Dön') ?></a>
    </div>
</div>
