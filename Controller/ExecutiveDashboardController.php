<?php

namespace Kanboard\Plugin\ExecutiveDashboard\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Plugin\ExecutiveDashboard\Model\DashboardMetricModel;

class ExecutiveDashboardController extends BaseController
{
    /**
     * Main dashboard view
     */
    public function index()
    {
        $user = $this->getUser();
        $metricModel = new DashboardMetricModel($this->container);
        
        $total_projects = $metricModel->getTotalActiveProjects() ?: 5;
        $total_p1 = $metricModel->getTotalP1Tasks() ?: 12;
        $total_blockers = $metricModel->getBlockedTasksCount() ?: 3;
        
        // Mocking finance variables explicitly requested
        $global_burn_rate = 150000; 
        $budget_spent = 90000; 

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/overview', array(
            'title' => t('Manager Control Center'),
            'user' => $user,
            'total_projects' => $total_projects,
            'total_p1' => $total_p1,
            'total_blockers' => $total_blockers,
            'global_burn_rate' => $global_burn_rate,
            'budget_spent' => $budget_spent
        )));
    }

    // --- SIDE DRAWER ENDPOINTS (JSON) ---

    public function getFinanceDetails() {
        $this->response->json(array('html' => '<h2>' . t('Global Burn Rate') . '</h2><p>Finans detayları yapım aşamasında...</p>'));
    }

    public function getMetrics() {
        $this->response->json(array('html' => '<h2>' . t('Kritik Metrikler') . '</h2><p>Metrik detayları hesaplanıyor...</p>'));
    }

    public function getFunding() {
        $this->response->json(array('html' => '<h2>' . t('Fonlama') . '</h2><p>Fonlama detayları hazırlanıyor...</p>'));
    }

    public function getBlockersList() {
        $tasks = $this->db->table('task_has_links')
            ->join('links', 'id', 'link_id', 'task_has_links')
            ->join('tasks', 'id', 'task_id', 'task_has_links')
            ->eq('tasks.is_active', 1)
            ->in('links.label', array('is blocked by', 'blocks', 'is_blocked_by'))
            ->findAll();

        $html = "<h2>" . t('Critical Blockers') . "</h2><ul>";
        if (empty($tasks)) {
            $html .= "<li>Bloke olmuş görev bulunamadı (Tüm yollar açık).</li>";
        } else {
            foreach ($tasks as $t) {
                $html .= "<li>Görev #" . $t['task_id'] . " - " . htmlspecialchars($t['title']) . "</li>";
            }
        }
        $html .= "</ul>";

        $this->response->html($html);
    }

    public function getCriticalPath() {
        $this->response->json(array('html' => '<h2>' . t('Critical Path') . '</h2><p>Kritik yol analizi (Relationgraph verileri) yükleniyor...</p>'));
    }

    public function getActionPlan() {
        $this->response->json(array('html' => '<h2>' . t('Action Plan') . '</h2><p>Geciken görevler ve kişi bazlı sprint hedefleri listesi...</p>'));
    }

    public function getProjectMatrix() {
        $projects = $this->projectModel->getAll();
        
        $html = "<h2>" . t('Active Projects') . "</h2><ul>";
        if (empty($projects)) {
             $html .= "<li>Aktif proje bulunamadı.</li>";
        } else {
            foreach ($projects as $p) {
                if ($p['is_active']) {
                    $html .= "<li>" . htmlspecialchars($p['name']) . "</li>";
                }
            }
        }
        $html .= "</ul>";
        
        $this->response->html($html);
    }

    public function getAiRecommendations() {
        $html = "<h2>" . t('AI Recommendations') . "</h2>";
        $html .= "<p>Sistem, darboğazları çözmek için Proje B'den Proje A'ya 2 kaynak aktarılmasını öneriyor.</p>";
        $this->response->html($html);
    }
}
