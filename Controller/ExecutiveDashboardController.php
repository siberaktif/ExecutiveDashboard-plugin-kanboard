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
        $budget_total = 0; // Replace with Budget plugin query if needed

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/overview', array(
            'title' => t('Manager Control Center'),
            'user' => $user,
            'total_projects' => $total_projects,
            'total_p1' => $total_p1,
            'total_blockers' => $total_blockers,
            'budget_total' => $budget_total
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
}
