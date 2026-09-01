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
        
        // Gerçek veritabanından çekilen genel metrikler
        $total_projects = $this->db->table('projects')->eq('is_active', 1)->count();
        $open_tasks = $this->db->table('tasks')->eq('is_active', 1)->count();
        
        $total_blockers = $this->db->table('task_has_links')
            ->join('links', 'id', 'link_id', 'task_has_links')
            ->join('tasks', 'id', 'task_id', 'task_has_links')
            ->eq('tasks.is_active', 1)
            ->in('links.label', array('is blocked by', 'blocks', 'is_blocked_by'))
            ->count();

        // Kanboard çekirdeğinde finans olmadığı için arayüz mock verisi (sabit)
        $global_burn_rate = 150000; 
        $budget_spent = 90000; 

        // Zaman sınırları (Unix Timestamp)
        $now = time();
        $today_start = strtotime('today', $now);
        $today_end = strtotime('tomorrow', $now) - 1;
        $week_start = strtotime('monday this week', $now);
        $week_end = strtotime('sunday this week', $now) + 86399;
        $month_start = strtotime('first day of this month', $now);
        $month_end = strtotime('last day of this month', $now) + 86399;

        // Gerçek görevlerin date_due filtrelemesiyle çekilmesi
        $tasks_today = $this->db->table('tasks')->eq('is_active', 1)->gte('date_due', $today_start)->lte('date_due', $today_end)->findAll();
        $tasks_week = $this->db->table('tasks')->eq('is_active', 1)->gt('date_due', $today_end)->lte('date_due', $week_end)->findAll();
        $tasks_month = $this->db->table('tasks')->eq('is_active', 1)->gt('date_due', $week_end)->lte('date_due', $month_end)->findAll();

        $users = $this->db->table('users')->eq('is_active', 1)->findAll();
        $projects = $this->db->table('projects')->eq('is_active', 1)->findAll();

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/overview', array(
            'title' => t('Manager Control Center'),
            'user' => $user,
            'total_projects' => $total_projects,
            'open_tasks' => $open_tasks,
            'total_blockers' => $total_blockers,
            'global_burn_rate' => $global_burn_rate,
            'budget_spent' => $budget_spent,
            'tasks_today' => $tasks_today,
            'tasks_week' => $tasks_week,
            'tasks_month' => $tasks_month,
            'users' => $users,
            'projects' => $projects
        )));
    }
}
