<div class="bilgiyapar-mcc-section">
    <div class="bilgiyapar-mcc-section-title"><i class="fa fa-trophy"></i> <?= t('Genel Skor & Kurumsal Sağlık İndeksi Analizi') ?></div>
    
    <div style="background:#fff; border:1px solid #e1e4e8; border-radius:6px; padding:30px; margin-bottom:20px;">
        <div style="text-align:center; margin-bottom:40px;">
            <div style="font-size:16px; color:#555; text-transform:uppercase; letter-spacing:2px; margin-bottom:10px;"><?= t('Şirket Net Sağlık Skoru') ?></div>
            
            <div style="display:inline-block; position:relative;">
                <div style="width:150px; height:150px; border-radius:50%; border:10px solid <?= $score_color ?>; display:flex; align-items:center; justify-content:center; box-shadow:0 0 20px rgba(0,0,0,0.1);">
                    <span style="font-size:48px; font-weight:900; color:<?= $score_color ?>;">%<?= $final_score ?></span>
                </div>
            </div>
            <p style="margin-top:20px; font-size:14px; color:#666; max-width:600px; margin-left:auto; margin-right:auto;">
                <?= t('Bu skor, takımların sadece kapattığı kolay görevleri değil, aynı zamanda geciktirdikleri işleri ve çözmedikleri blokajları (darboğazları) ceza puanı olarak yansıtarak hesaplanan <b>acımasız bir yönetici metriğidir.</b>') ?>
            </p>
        </div>

        <!-- Matematiksel Kırılım (Breakdown) -->
        <div style="display:flex; justify-content:center; align-items:center; flex-wrap:wrap; gap:20px; background:#f9f9f9; padding:20px; border-radius:8px; border:1px dashed #ccc;">
            
            <!-- Taban Puan -->
            <div style="text-align:center; flex:1; min-width:150px;">
                <div style="font-size:12px; color:#666; font-weight:bold;"><?= t('Taban Puan (Ağırlıklı İlerleme)') ?></div>
                <div style="font-size:28px; font-weight:bold; color:#1a73e8;">%<?= $base_score ?></div>
                <div style="font-size:11px; color:#888; margin-top:5px;"><?= t('Kapanan / Toplam Görev') ?></div>
            </div>

            <div style="font-size:32px; color:#ccc; font-weight:bold;">-</div>

            <!-- score.php de Matematiksel Kırılım Bölümünü Güncelleyin -->
            <!-- Gecikme Cezası -->
            <div style="text-align:center; flex:1; min-width:150px;">
                <div style="font-size:12px; color:#666; font-weight:bold;"><?= t('Gecikme Cezası (Çevik)') ?></div>
                <div style="font-size:28px; font-weight:bold; color:#d73a49;">-<?= $penalty_overdue ?></div>
                <div style="font-size:11px; color:#888; margin-top:5px;">∑ (1 × Öncelik × Puan)</div>
            </div>

            <div style="font-size:32px; color:#ccc; font-weight:bold;">-</div>

            <!-- Blokaj Cezası -->
            <div style="text-align:center; flex:1; min-width:150px;">
                <div style="font-size:12px; color:#666; font-weight:bold;"><?= t('Blokaj Cezası (Çevik)') ?></div>
                <div style="font-size:28px; font-weight:bold; color:#d73a49;">-<?= $penalty_blocker ?></div>
                <div style="font-size:11px; color:#888; margin-top:5px;">∑ (2 × Öncelik × Puan)</div>
            </div>

            <div style="font-size:32px; color:#333; font-weight:bold;">=</div>

            <!-- NET SKOR -->
            <div style="text-align:center; flex:1; min-width:150px; background:#fff; padding:15px; border-radius:6px; border:2px solid <?= $score_color ?>; box-shadow:0 4px 6px rgba(0,0,0,0.05);">
                <div style="font-size:12px; color:#333; font-weight:bold;"><?= t('NET SKOR') ?></div>
                <div style="font-size:32px; font-weight:900; color:<?= $score_color ?>;">%<?= $final_score ?></div>
            </div>

        </div>

    </div>

</div>
<?= $this->render('ExecutiveDashboard:dashboard/back_button') ?>
