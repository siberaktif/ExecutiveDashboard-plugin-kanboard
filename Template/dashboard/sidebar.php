<style>
/* CSS Order kuralı ile MCC'yi zorla 5. sıraya (Altgörevlerimin hemen altina) aliyoruz */
.sidebar > ul {
    display: flex !important;
    flex-direction: column !important;
}
/* Tum ogeleri varsayilan olarak asagi (order 10) itiyoruz */
.sidebar > ul > li {
    order: 10;
}
/* Ilk 4 Kanboard core ogesini (Özet, Projelerim, Görevlerim, Altgörevlerim) en uste (order 1) aliyoruz */
.sidebar > ul > li:nth-child(1),
.sidebar > ul > li:nth-child(2),
.sidebar > ul > li:nth-child(3),
.sidebar > ul > li:nth-child(4) {
    order: 1 !important;
}
/* MCC butonumuzu kesin olarak core ogelerin hemen altina (order 5) kilitliyoruz */
#mcc-sidebar-item {
    order: 5 !important;
}
</style>
<li id="mcc-sidebar-item" <?= $this->app->checkMenuSelection('ExecutiveDashboardController', 'index', 'ExecutiveDashboard') ? 'class="active"' : '' ?>>
    <?= $this->url->link('<i class="fa fa-briefcase fa-fw" aria-hidden="true"></i> <strong>' . t('Yönetici Kontrol Merkezi') . '</strong>', 'ExecutiveDashboardController', 'index', ['plugin' => 'ExecutiveDashboard']) ?>
</li>