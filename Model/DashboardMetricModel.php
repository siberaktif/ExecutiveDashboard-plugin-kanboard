<?php

namespace Kanboard\Plugin\ExecutiveDashboard\Model;

use Kanboard\Core\Base;

class DashboardMetricModel extends Base
{
    /**
     * Get Total Active Projects
     * @return int
     */
    public function getTotalActiveProjects()
    {
        return $this->projectModel->getActiveProjectCount();
    }

    /**
     * Get Total Open Tasks
     * @return int
     */
    public function getTotalOpenTasks()
    {
        return $this->db->table('tasks')
            ->eq('is_active', 1)
            ->count();
    }

    /**
     * Get Total Priority P1 Tasks
     * Assuming P1 maps to priority 1
     * @return int
     */
    public function getTotalP1Tasks()
    {
        return $this->db->table('tasks')
            ->eq('is_active', 1)
            ->eq('priority', 1)
            ->count();
    }

    /**
     * Get Blocked Tasks Count (Uses Relationgraph task_has_links)
     * @return int
     */
    public function getBlockedTasksCount()
    {
        return $this->db->table('task_has_links')
            ->join('links', 'id', 'link_id', 'task_has_links')
            ->join('tasks', 'id', 'task_id', 'task_has_links')
            ->eq('tasks.is_active', 1)
            ->in('links.label', array('is blocked by', 'is_blocked_by'))
            ->count();
    }
}
