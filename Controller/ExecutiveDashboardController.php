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

        // ZAMAN SINIRLI EYLEM PLANI (Time Bound Action Plan) data
        $now = time();
        $today_start = strtotime('today', $now);
        $today_end = strtotime('tomorrow', $now) - 1;
        $week_start = strtotime('monday this week', $now);
        $week_end = strtotime('sunday this week', $now) + 86399;
        $month_start = strtotime('first day of this month', $now);
        $month_end = strtotime('last day of this month', $now) + 86399;

        // Fetch tasks
        $tasks_today = $this->db->table('tasks')->eq('is_active', 1)->eq('priority', 1)->gte('date_due', $today_start)->lte('date_due', $today_end)->findAll();
        $tasks_week = $this->db->table('tasks')->eq('is_active', 1)->gt('date_due', $today_end)->lte('date_due', $week_end)->findAll();
        $tasks_month = $this->db->table('tasks')->eq('is_active', 1)->gt('date_due', $week_end)->lte('date_due', $month_end)->findAll();

        // Get all active users for the action plan
        $users = $this->db->table('users')->eq('is_active', 1)->findAll();

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/overview', array(
            'title' => t('Manager Control Center'),
            'user' => $user,
            'total_projects' => $total_projects,
            'total_p1' => $total_p1,
            'total_blockers' => $total_blockers,
            'global_burn_rate' => $global_burn_rate,
            'budget_spent' => $budget_spent,
            'tasks_today' => $tasks_today,
            'tasks_week' => $tasks_week,
            'tasks_month' => $tasks_month,
            'users' => $users
        )));
    }

    // --- HTML ENDPOINTS FOR NEW TABS ---

    private function renderStandalone($title, $content) {
        $html = '<!DOCTYPE html><html><head><title>' . htmlspecialchars($title) . '</title>';
        $html .= '<style>body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; padding: 40px; color: #333; background: #f4f5f7; } .card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: 1px solid #e1e4e8; }</style>';
        $html .= '</head><body>';
        $html .= '<div class="card">';
        $html .= '<h2>' . htmlspecialchars($title) . '</h2>';
        $html .= $content;
        $html .= '</div></body></html>';
        $this->response->html($html);
    }

    public function getFinanceDetails() {
        $this->renderStandalone(t('Küresel Nakit Yakım Hızı'), '<p>Finans detayları yapım aşamasında...</p>');
    }

    public function getMetrics() {
        $this->renderStandalone(t('Kritik Metrikler'), '<p>Metrik detayları hesaplanıyor...</p>');
    }

    public function getFunding() {
        $this->renderStandalone(t('Fonlama'), '<p>Fonlama detayları hazırlanıyor...</p>');
    }

    public function getBlockersList() {
        $tasks = $this->db->table('task_has_links')
            ->join('links', 'id', 'link_id', 'task_has_links')
            ->join('tasks', 'id', 'task_id', 'task_has_links')
            ->eq('tasks.is_active', 1)
            ->in('links.label', array('is blocked by', 'blocks', 'is_blocked_by'))
            ->findAll();

        $content = "<ul>";
        if (empty($tasks)) {
            $content .= "<li>Bloke olmuş görev bulunamadı (Tüm yollar açık).</li>";
        } else {
            foreach ($tasks as $t) {
                $content .= "<li>Görev #" . $t['task_id'] . " - " . htmlspecialchars($t['title']) . "</li>";
            }
        }
        $content .= "</ul>";
        $this->renderStandalone(t('Critical Blockers'), $content);
    }

    public function getCriticalPath() {
        $this->renderStandalone(t('Critical Path'), '<p>Kritik yol analizi (Relationgraph verileri) yükleniyor...</p>');
    }

    public function getActionPlan() {
        $this->renderStandalone(t('Action Plan'), '<p>Geciken görevler ve kişi bazlı sprint hedefleri listesi...</p>');
    }

    public function getProjectMatrix() {
        $projects = $this->projectModel->getAll();
        
        $content = "<ul>";
        if (empty($projects)) {
             $content .= "<li>Aktif proje bulunamadı.</li>";
        } else {
            foreach ($projects as $p) {
                if ($p['is_active']) {
                    $content .= "<li>" . htmlspecialchars($p['name']) . "</li>";
                }
            }
        }
        $content .= "</ul>";
        $this->renderStandalone(t('Active Projects'), $content);
    }

    public function getAiRecommendations() {
        $this->renderStandalone(t('AI Recommendations'), '<p>Sistem, darboğazları çözmek için Proje B\'den Proje A\'ya 2 kaynak aktarılmasını öneriyor.</p>');
    }
}
