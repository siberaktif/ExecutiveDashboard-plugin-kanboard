<?php

namespace Kanboard\Plugin\ExecutiveDashboard;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize()
    {
        // 1. CLEAR URL: Çirkin linkleri temiz ve kısa bir rotaya bağlar
        $this->route->addRoute('/mcc', 'ExecutiveDashboardController', 'index', 'ExecutiveDashboard');

        // 2. CSP OVERRIDE: Kanboard'un satır içi JS kodlarını (Prompt Kopyala) engellemesini durdurur
        $this->setContentSecurityPolicy(array('script-src' => "'self' 'unsafe-inline' 'unsafe-eval'"));

        // Add CSS and JS hooks
        $this->hook->on('template:layout:css', array('template' => 'plugins/ExecutiveDashboard/Asset/css/dashboard.css'));
        // $this->hook->on('template:layout:js', array('template' => 'plugins/ExecutiveDashboard/Asset/js/sidedrawer.js'));

        // Register Helper
        $this->helper->register('dashboardFormat', '\Kanboard\Plugin\ExecutiveDashboard\Helper\DashboardFormatHelper');

        // Add 'Yönetici Kontrol Merkezi' to the dashboard sidebar by overriding it
        $this->template->setTemplateOverride('dashboard/sidebar', 'ExecutiveDashboard:dashboard/sidebar');
    }

    public function onStartup()
    {
        // Çeviri dosyalarını sisteme yükler
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
        return 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard';
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
