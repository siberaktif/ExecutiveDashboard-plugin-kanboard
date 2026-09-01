<?php

namespace Kanboard\Plugin\ExecutiveDashboard\Controller;

use Kanboard\Controller\BaseController;

class ExecutiveDashboardController extends BaseController
{
    /**
     * Main dashboard view
     */
    public function index()
    {
        $user = $this->getUser();
        
        // 1. Total Active Projects
        $total_projects = $this->projectModel->getActiveProjectCount();

        // 2. Critical Blockers & P1 Tasks
        // Find active tasks that are P1 (assuming priority 1 or string 'P1')
        $total_p1 = $this->db->table('tasks')
            ->eq('is_active', 1)
            ->eq('priority', 1) 
            ->count();
            
        // Find blocking relations
        $total_blockers = $this->db->table('task_has_links')
            ->join('links', 'id', 'link_id', 'task_has_links')
            ->join('tasks', 'id', 'task_id', 'task_has_links')
            ->eq('tasks.is_active', 1)
            ->in('links.label', array('is blocked by', 'blocks', 'is_blocked_by'))
            ->count();
            
        // 3. Budget Data (Dummy if no plugin exists)
        $budget_total = 0; // Replace with Budget plugin query if needed

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/overview', array(
            'title' => t('Yönetici Kontrol Merkezi'),
            'user' => $user,
            'total_projects' => $total_projects,
            'total_p1' => $total_p1,
            'total_blockers' => $total_blockers,
            'budget_total' => $budget_total
        )));
    }

    /**
     * Fetch active tasks that have 'is_blocked_by' or 'blocks' relations
     */
    public function getBlockers()
    {
        $tasks = $this->db->table('task_has_links')
            ->join('links', 'id', 'link_id', 'task_has_links')
            ->join('tasks', 'id', 'task_id', 'task_has_links')
            ->eq('tasks.is_active', 1)
            ->in('links.label', array('is blocked by', 'blocks', 'is_blocked_by'))
            ->findAll();

        $this->response->json(array('tasks' => $tasks));
    }

    /**
     * Priority P1 and active tasks count API for Side drawer
     */
    public function getCriticalTasks()
    {
        $count = $this->db->table('tasks')
            ->eq('is_active', 1)
            ->eq('priority', 1)
            ->count();
            
        $this->response->json(array('count' => $count));
    }
    
    // Dummy endpoints for other cards to prevent 404s
    public function getFinanceDetails() { $this->response->json(array('message' => 'Finans detayları yapım aşamasında.')); }
    public function getBlockersList() { $this->response->json(array('message' => 'Blokaj özeti yapım aşamasında.')); }
    public function getCriticalPath() { $this->response->json(array('message' => 'Kritik yol analizi yapım aşamasında.')); }
    public function getActionPlan() { $this->response->json(array('message' => 'Eylem planı yapım aşamasında.')); }
    public function getProjectMatrix() { $this->response->json(array('message' => 'Proje matrisi yapım aşamasında.')); }
    public function getAiRecommendations() { $this->response->json(array('message' => 'AI önerileri yapım aşamasında.')); }
}
