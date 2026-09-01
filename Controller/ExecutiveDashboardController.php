<?php

namespace Kanboard\Plugin\ExecutiveDashboard\Controller;

use Kanboard\Controller\BaseController;

class ExecutiveDashboardController extends BaseController
{
    /**
     * Priority P1 and active tasks count
     */
    public function getCriticalTasks()
    {
        // priority=P1 implies priority=1 or maybe 3 depending on settings, but we will use the string or int representation standard in the user's setup. 
        // Typically Kanboard uses integers. Assuming 1 for P1 or 'P1'. I will query based on priority = 1.
        $count = $this->db->table('tasks')
            ->eq('is_active', 1)
            ->eq('priority', 1) // Assuming P1 maps to priority 1 in Kanboard
            ->count();
            
        $this->response->json(array('count' => $count));
    }

    /**
     * Fetch active tasks that have 'is_blocked_by' or 'blocks' relations
     */
    public function getBlockers()
    {
        // Find tasks that are blocked or are blocking
        // 'is_blocked_by' is relation_id 3 usually, 'blocks' is relation_id 2.
        // We will just join the link table to get tasks that are in these relations.
        $tasks = $this->db->table('task_has_links')
            ->join('links', 'id', 'link_id', 'task_has_links')
            ->join('tasks', 'id', 'task_id', 'task_has_links')
            ->eq('tasks.is_active', 1)
            ->in('links.label', array('is blocked by', 'blocks', 'is_blocked_by'))
            ->findAll();

        $this->response->json(array('tasks' => $tasks));
    }
}
