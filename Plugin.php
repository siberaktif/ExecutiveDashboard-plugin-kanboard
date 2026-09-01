<?php

namespace Kanboard\Plugin\ExecutiveDashboard;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize()
    {
        // Add CSS and JS hooks
        $this->hook->on('template:layout:css', array('template' => 'plugins/ExecutiveDashboard/Asset/css/dashboard.css'));
        $this->hook->on('template:layout:js', array('template' => 'plugins/ExecutiveDashboard/Asset/js/sidedrawer.js'));

        // Add 'Yönetici Kontrol Merkezi' to the dashboard sidebar
        // Note: The prompt requested 'dashboard:sidebar' hook. In Kanboard, it's typically template:dashboard:sidebar.
        // We will create the sidebar template next to render the link.
        $this->template->hook->attach('template:dashboard:sidebar', 'ExecutiveDashboard:dashboard/sidebar');
    }

    public function getPluginName()
    {
        return 'ExecutiveDashboard';
    }

    public function getPluginDescription()
    {
        return 'Yönetici Kontrol Merkezi ve Metrik Paneli';
    }

    public function getPluginAuthor()
    {
        return 'Bilgiyapar Tosun';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }
}
