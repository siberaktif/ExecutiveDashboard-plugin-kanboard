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
        
        $total_projects = $metricModel->getTotalActiveProjects();
        $total_p1 = $metricModel->getTotalP1Tasks();
        $total_blockers = $metricModel->getBlockedTasksCount();
        $budget_total = 150000; // Mock total budget
        $budget_spent = 90000;  // Mock spent (60%)

        // ZAMAN SINIRLI EYLEM PLANI (Time Bound Action Plan) data
        $now = time();
        $today_start = strtotime('today', $now);
        $today_end = strtotime('tomorrow', $now) - 1;
        
        // Bu Hafta (Next 7 days or until end of week)
        $week_start = strtotime('monday this week', $now);
        $week_end = strtotime('sunday this week', $now) + 86399;
        
        // Bu Ay
        $month_start = strtotime('first day of this month', $now);
        $month_end = strtotime('last day of this month', $now) + 86399;

        // BUGÜN (P1 Acil) - Today & Priority 1
        $tasks_today = $this->db->table('tasks')
            ->eq('is_active', 1)
            ->eq('priority', 1)
            ->gte('date_due', $today_start)
            ->lte('date_due', $today_end)
            ->findAll();

        // BU HAFTA (Sprint Hedefi)
        $tasks_week = $this->db->table('tasks')
            ->eq('is_active', 1)
            ->gt('date_due', $today_end)
            ->lte('date_due', $week_end)
            ->findAll();

        // BU AY (Stratejik)
        $tasks_month = $this->db->table('tasks')
            ->eq('is_active', 1)
            ->gt('date_due', $week_end)
            ->lte('date_due', $month_end)
            ->findAll();

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/overview', array(
            'title' => t('Manager Control Center'),
            'user' => $user,
            'total_projects' => $total_projects,
            'total_p1' => $total_p1,
            'total_blockers' => $total_blockers,
            'budget_total' => $budget_total,
            'budget_spent' => $budget_spent,
            'tasks_today' => $tasks_today,
            'tasks_week' => $tasks_week,
            'tasks_month' => $tasks_month
        )));
    }

    /**
     * Project Details for Side Drawer
     */
    public function projectDetails()
    {
        $projects = $this->projectModel->getAll();
        
        $html = "<h4>" . t('Active Projects') . "</h4><ul>";
        foreach ($projects as $p) {
            if ($p['is_active']) {
                $html .= "<li>" . htmlspecialchars($p['name']) . "</li>";
            }
        }
        $html .= "</ul>";
        
        $this->response->json(array('html' => $html));
    }

    /**
     * Blocker Details for Side Drawer
     */
    public function blockerDetails()
    {
        $tasks = $this->db->table('task_has_links')
            ->join('links', 'id', 'link_id', 'task_has_links')
            ->join('tasks', 'id', 'task_id', 'task_has_links')
            ->eq('tasks.is_active', 1)
            ->in('links.label', array('is blocked by', 'blocks', 'is_blocked_by'))
            ->findAll();

        $html = "<h4>" . t('Critical Blockers') . "</h4><ul>";
        if (empty($tasks)) {
            $html .= "<li>" . t('No blocked tasks found.') . "</li>";
        } else {
            foreach ($tasks as $t) {
                $html .= "<li>Task #" . $t['task_id'] . " - " . htmlspecialchars($t['title']) . "</li>";
            }
        }
        $html .= "</ul>";

        $this->response->json(array('html' => $html));
    }

    /**
     * AI Recommendations for Side Drawer
     */
    public function aiRecommendations()
    {
        $html = "<h4>" . t('AI Recommendations') . "</h4>";
        $html .= "<p>" . t('System suggests moving 2 resources from Project B to Project A to resolve current blockers.') . "</p>";
        
        $this->response->json(array('html' => $html));
    }

    // Dummy endpoints for other cards to prevent 404s
    public function getFinanceDetails() { $this->response->json(array('html' => '<h4>' . t('Global Burn Rate') . '</h4><p>' . t('Finance details are under construction.') . '</p>')); }
    public function getBlockersList() { return $this->blockerDetails(); }
    public function getCriticalPath() { $this->response->json(array('html' => '<h4>' . t('Critical Path') . '</h4><p>' . t('Critical path analysis under construction.') . '</p>')); }
    public function getActionPlan() { $this->response->json(array('html' => '<h4>' . t('Action Plan') . '</h4><p>' . t('Action plan under construction.') . '</p>')); }
    public function getProjectMatrix() { return $this->projectDetails(); }
    public function getAiRecommendations() { return $this->aiRecommendations(); }
    
    // Legacy fallback endpoints from previous designs
    public function getMetrics() { $this->response->json(['html' => '<h3>Kritik Metrikler</h3><p>Aktif Proje: 5, Açık Görev: 54</p>']); }
    public function getFunding() { $this->response->json(['html' => '<h3>Fonlama</h3><p>Fonlama detayları hazırlanıyor...</p>']); }
}
