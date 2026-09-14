<?php

namespace Kanboard\Plugin\ExecutiveDashboard;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize()
    {
        $this->db->getConnection()->exec("SET SESSION sql_mode = ''");
        // 1. CLEAR URL: Çirkin linkleri temiz ve kısa bir rotaya bağlar
        $this->route->addRoute('/mcc', 'ExecutiveDashboardController', 'index', 'ExecutiveDashboard');
        $this->route->addRoute('/mcc/finance', 'ExecutiveDashboardController', 'finance', 'ExecutiveDashboard');

        // 2. CSP OVERRIDE: Kanboard'un satır içi JS kodlarını engellemesini durdurur
        $this->setContentSecurityPolicy(array('script-src' => "'self' 'unsafe-inline' 'unsafe-eval'"));

        // Add CSS hooks
        $this->hook->on('template:layout:css', array('template' => 'plugins/ExecutiveDashboard/Asset/css/dashboard.css'));

        // Register Helper
        $this->helper->register('dashboardFormat', '\Kanboard\Plugin\ExecutiveDashboard\Helper\DashboardFormatHelper');

        // DOĞRU YAKLAŞIM: Orijinal sidebar'ı ezmek yerine kanca (hook) ile ekliyoruz
        $this->template->hook->attach('template:dashboard:sidebar', 'ExecutiveDashboard:dashboard/sidebar');

        // Yönetici Kontrol Merkezi'ni üst açılır menüye (Header Dropdown) ekler
        $this->template->hook->attach('template:header:dropdown', 'ExecutiveDashboard:dashboard/header_menu');
        $this->template->hook->attach('template:dashboard:page-header:menu', 'ExecutiveDashboard:dashboard/header_menu');
    }

    public function onStartup()
    {
        \Kanboard\Core\Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        return 'ExecutiveDashboard';
    }

    public function getPluginDescription()
    {
        return 'Kanboard CEO Operasyon ve Yönetici Kontrol Merkezi.';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/sencarto/ExecutiveDashboard-plugin-kanboard';
    }

    public function getPluginAuthor()
    {
        return 'DediTeknoloji.com Bilgiyapar.com Sencar Tosun';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }
}
