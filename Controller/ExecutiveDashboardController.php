<?php

namespace Kanboard\Plugin\ExecutiveDashboard\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Plugin\ExecutiveDashboard\Model\DashboardMetricModel;

class ExecutiveDashboardController extends BaseController
{
    /**
     * Ana Dashboard Görünümü
     */
    public function index()
    {
        $user = $this->getUser();
        $metricModel = new DashboardMetricModel($this->container);

        $total_projects = $metricModel->getTotalActiveProjects() ?? 0;
        $total_p1 = $this->db->table('tasks')->eq('is_active', 1)->eq('priority', 1)->count();

        // Blokajları güvenli çekelim
        try {
            $total_blockers = $this->db->table('task_has_links')
                ->join('tasks', 'id', 'task_id', 'task_has_links')
                ->eq('tasks.is_active', 1)
                ->in('link_id', [2, 3]) // Genellikle 2 ve 3 numaralı ID'ler 'blocks' ve 'is blocked by' içindir
                ->count();
        } catch (\Exception $e) {
            $total_blockers = 0;
        }

        // Bütçe - CostControl Eklentisi varsa veriyi çeker, yoksa 0 döner
        try {
            $budget_total = $this->db->table('budget_lines')->sum('amount') ?: 0;
        } catch (\Exception $e) {
            $budget_total = 0;
        }

        // ZAMAN SINIRLI EYLEM PLANI
        $now = time();
        $today_start = strtotime('today', $now);
        $today_end = strtotime('tomorrow', $now) - 1;
        $week_end = strtotime('sunday this week', $now) + 86399;
        $month_end = strtotime('last day of this month', $now) + 86399;

        // BUGÜN (P1 Acil)
        $tasks_today = $this->db->table('tasks')
            ->eq('is_active', 1)->eq('priority', 1)
            ->gte('date_due', $today_start)->lte('date_due', $today_end)
            ->findAll();

        // BU HAFTA
        $tasks_week = $this->db->table('tasks')
            ->eq('is_active', 1)
            ->gt('date_due', $today_end)->lte('date_due', $week_end)
            ->findAll();

        // BU AY
        $tasks_month = $this->db->table('tasks')
            ->eq('is_active', 1)
            ->gt('date_due', $week_end)->lte('date_due', $month_end)
            ->findAll();

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/overview', array(
            'title' => t('Yönetici Kontrol Merkezi'),
            'user' => $user,
            'total_projects' => $total_projects,
            'total_p1' => $total_p1,
            'total_blockers' => $total_blockers,
            'global_burn_rate' => $budget_total,
            'tasks_today' => $tasks_today,
            'tasks_week' => $tasks_week,
            'tasks_month' => $tasks_month
        )));
    }

    /**
     * PROJELER (Yan Sekme) - Gerçek Kanboard Proje Linkleri
     */
    public function getProjectMatrix()
    {
        $projects = $this->projectModel->getActive();

        $html = "<h4 style='border-bottom:1px solid #eee; padding-bottom:10px;'>" . t('Aktif Şirket Projeleri') . "</h4><ul style='list-style:none; padding:0;'>";
        foreach ($projects as $p) {
            // Kanboard'un orijinal proje panosuna giden link
            $url = $this->helper->url->to('BoardViewController', 'show', ['project_id' => $p['id']]);
            $html .= "<li style='margin-bottom:10px; padding:10px; background:#f9f9f9; border-radius:4px;'>";
            $html .= "<a href='{$url}' target='_blank' style='text-decoration:none; color:#0366d6; font-weight:bold;'><i class='fa fa-columns'></i> " . htmlspecialchars($p['name']) . "</a>";
            $html .= "</li>";
        }
        $html .= "</ul>";

        $this->response->json(['html' => $html]);
    }

    /**
     * BLOKAJLAR (Yan Sekme) - Gerçek Kanboard Görev Linkleri
     */
    public function getBlockersList()
    {
        try {
            $tasks = $this->db->table('task_has_links')
                ->join('tasks', 'id', 'task_id', 'task_has_links')
                ->eq('tasks.is_active', 1)
                ->findAll();
        } catch (\Exception $e) {
            $tasks = [];
        }

        $html = "<h4 style='border-bottom:1px solid #eee; padding-bottom:10px; color:#d9534f;'><i class='fa fa-ban'></i> " . t('Kritik Blokajlar') . "</h4><ul style='list-style:none; padding:0;'>";

        if (empty($tasks)) {
            $html .= "<li>" . t('Bloke olmuş görev bulunmuyor. Harika!') . "</li>";
        } else {
            foreach ($tasks as $t) {
                // Kanboard'un orijinal görev detay sayfasına giden link
                $url = $this->helper->url->to('TaskViewController', 'show', ['task_id' => $t['task_id'], 'project_id' => $t['project_id']]);
                $html .= "<li style='margin-bottom:10px; padding:10px; border-left:3px solid #d9534f; background:#fff;'>";
                $html .= "<a href='{$url}' target='_blank' style='text-decoration:none; color:#333;'><strong>Görev #" . $t['task_id'] . "</strong><br>" . htmlspecialchars($t['title']) . "</a>";
                $html .= "</li>";
            }
        }
        $html .= "</ul>";

        $this->response->json(['html' => $html]);
    }

    /**
     * ZAMAN SINIRLI EYLEM PLANI (Yan Sekme) - Geciken Görevler
     */
    public function getActionPlan()
    {
        $now = time();
        $delayed_tasks = $this->db->table('tasks')
            ->eq('is_active', 1)
            ->neq('date_due', 0)
            ->lt('date_due', $now)
            ->findAll();

        $html = "<h4 style='border-bottom:1px solid #eee; padding-bottom:10px;'><i class='fa fa-clock-o'></i> " . t('Geciken Görevler (Acil Eylem)') . "</h4><ul style='list-style:none; padding:0;'>";

        if (empty($delayed_tasks)) {
            $html .= "<li><i class='fa fa-check-circle' style='color:#5cb85c;'></i> " . t('Geciken görev yok.') . "</li>";
        } else {
            foreach ($delayed_tasks as $t) {
                $url = $this->helper->url->to('TaskViewController', 'show', ['task_id' => $t['id'], 'project_id' => $t['project_id']]);
                $html .= "<li style='margin-bottom:10px; padding:10px; background:#fff8e5; border-radius:4px;'>";
                $html .= "<a href='{$url}' target='_blank' style='text-decoration:none; color:#d9534f; font-weight:bold;'>#" . $t['id'] . " - " . htmlspecialchars($t['title']) . "</a>";
                $html .= "</li>";
            }
        }
        $html .= "</ul>";

        $this->response->json(['html' => $html]);
    }

    /**
     * FİNANS & METRİKLER (Diğer yan sekmeler)
     */
    public function getFinanceDetails() {
        $this->response->json(['html' => '<h4><i class="fa fa-money"></i> ' . t('Finansal Kırılımlar') . '</h4><p>' . t('Bütçe eklentisi (CostControl) ile entegrasyon sağlandığında harcama kırılımları burada listelenecektir.') . '</p>']);
    }

    public function getMetrics() {
        $this->response->json(['html' => '<h4><i class="fa fa-pie-chart"></i> ' . t('Kritik Metrikler') . '</h4><p>' . t('Tüm projelerinizdeki genel durum özetidir. Detaylar için Projeler sekmesini kullanın.') . '</p>']);
    }

    public function getFunding() {
        $this->response->json(['html' => '<h4><i class="fa fa-rocket"></i> ' . t('Fonlama ve Gelir') . '</h4><p>' . t('Kitlesel fonlama kampanya detayları ve hedef/gerçekleşen tutarlar.') . '</p>']);
    }

    public function getCriticalPath() {
        return $this->getBlockersList();
    }

    public function getAiRecommendations() {
        $html = "<h4><i class='fa fa-magic'></i> " . t('AI Operasyonel Öneriler') . "</h4>";
        $html .= "<p style='padding:10px; background:#e1f0fa; border-radius:4px;'>" . t('Otonom ajan (Hermes) sistem analizi sonucunda, A.Ş. kuruluş sürecinin hızlandırılmasını önermektedir. Bu işlem ISAMA mobil uygulamasının yayınlanmasını doğrudan etkilemektedir.') . "</p>";
        $this->response->json(['html' => $html]);
    }
}
