<a href="<?= $this->url->href('ExecutiveDashboardController', 'index', ['plugin' => 'ExecutiveDashboard']) ?>" 
   class="mcc-back-btn"
   style="position: fixed; bottom: 30px; right: 30px; z-index: 9999; background-color: #007bff; color: white; padding: 10px 20px; border-radius: 50px; text-decoration: none; box-shadow: 0 4px 8px rgba(0,0,0,0.2); font-weight: bold; font-size: 14px; transition: background-color 0.3s;">
    <i class="fa fa-arrow-left"></i> <?= t('Kontrol Merkezine Dön') ?>
</a>
<style>
.mcc-back-btn:hover { background-color: #0056b3; color: white !important; text-decoration: none; }
</style>