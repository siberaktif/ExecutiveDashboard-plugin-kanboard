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

        // Blokaj Ağacı (Blocker Tree) için gerçek veriler
        $blocker_links = array();
        try {
            $blocker_links = $this->db->table('task_has_links')
                ->join('links', 'links.id', 'task_has_links.link_id')
                ->join('tasks AS t1', 't1.id', 'task_has_links.task_id')
                ->join('tasks AS t2', 't2.id', 'task_has_links.opposite_task_id')
                ->join('projects', 'projects.id', 't1.project_id')
                ->eq('t1.is_active', 1)
                ->eq('t2.is_active', 1)
                ->in('links.label', array('is blocked by', 'is_blocked_by'))
                ->columns(
                    't1.id AS blocked_task_id',
                    't1.title AS blocked_task_title',
                    't2.id AS blocker_task_id',
                    't2.title AS blocker_task_title',
                    'projects.id AS project_id',
                    'projects.name AS project_name'
                )
                ->limit(5)
                ->findAll();
        } catch (\Exception $e) { }

        $blocker_tree = array();
        foreach ($blocker_links as $link) {
            $blocker_tree[$link['project_id']]['name'] = $link['project_name'];
            $blocker_tree[$link['project_id']]['tasks'][] = $link;
        }

        // Gerçek Finans/Bütçe Verilerinin CostControl Eklentisinden Çekilmesi
        $global_burn_rate = 150000; // Varsayılan Şirket Hedef Bütçesi
        $budget_spent = 0;
        try {
            // Tüm projelerdeki harcama kalemlerini (budget_lines) topla
            $budget_spent = $this->db->table('budget_lines')->sum('amount') ?: 0;
        } catch (\Exception $e) {
            // CostControl kurulu değilse veya tablo yoksa varsayılan mock veri
            $budget_spent = 90000;
        }

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
        $projects_raw = $this->db->table('projects')->eq('is_active', 1)->findAll();
        
        $projects = array();
        $ai_velocity_alert = null;
        foreach ($projects_raw as $p) {
            $total = $this->db->table('tasks')->eq('project_id', $p['id'])->count();
            $closed = $this->db->table('tasks')->eq('project_id', $p['id'])->eq('is_active', 0)->count();
            $open = $this->db->table('tasks')->eq('project_id', $p['id'])->eq('is_active', 1)->count();
            
            // 1. Progress Hesaplaması
            $p['progress'] = $total > 0 ? round(($closed / $total) * 100) : 0;
            
            // 2. Velocity (Son 7 günde kapanan görevler)
            $week_ago = time() - 604800;
            $p['velocity'] = $this->db->table('tasks')->eq('project_id', $p['id'])->eq('is_active', 0)->gte('date_completed', $week_ago)->count();
            if ($p['velocity'] == 0 && $open > 0 && !$ai_velocity_alert) {
                $ai_velocity_alert = "{$p['name']} projesinde üretim hızı (Velocity) tamamen durmuş durumda. Ekipleri veya yeni süreçleri aktif edin.";
            }
            
            // 3. WIP Alert (Eğer 5'ten fazla açık görev varsa uyarı ver)
            $p['wip_alert'] = $open > 5;
            
            // 4. Burn Rate (Harcanan Bütçe Oranı)
            $spent = 0;
            try {
                $spent = $this->db->table('budget_lines')->eq('project_id', $p['id'])->sum('amount');
            } catch (\Exception $e) {}
            // Varsayılan hedef bütçeyi 50000 varsayarak % hesapla
            $p['burn_rate'] = $spent > 0 ? round(($spent / 50000) * 100) : 0;
            if($p['burn_rate'] > 100) $p['burn_rate'] = 100;
            
            $projects[] = $p;
        }

        // --- SİSTEM & KÜRESEL KPI MATRİSİ (System Metrics) ---
        $kpi = array();
        
        // 1. Yeni Genel Metrikler (KPI)
        $total_project_count_for_avg = count($projects);
        $total_progress_sum = 0;
        foreach ($projects as $p) {
            $total_progress_sum += $p['progress'];
        }
        $kpi['performance_avg'] = $total_project_count_for_avg > 0 ? round($total_progress_sum / $total_project_count_for_avg) : 0;
        $kpi['overall_score'] = $kpi['performance_avg']; // Şimdilik performans ile eşdeğer
        
        $kpi['overdue_total_count'] = $this->db->table('tasks')
            ->eq('is_active', 1)
            ->neq('date_due', 0)
            ->lt('date_due', $now)
            ->count();
            
        if ($total_blockers > 0 || $kpi['overdue_total_count'] > 10) {
            $kpi['health_status'] = 'Uyarı';
            $kpi['health_color'] = '#d73a49';
        } else {
            $kpi['health_status'] = 'İyi';
            $kpi['health_color'] = '#28a745';
        }

        $kpi['projects_active'] = $this->db->table('projects')->eq('is_active', 1)->count();
        $kpi['projects_inactive'] = $this->db->table('projects')->eq('is_active', 0)->count();
        $kpi['projects_private'] = $this->db->table('projects')->eq('is_private', 1)->count();
        $kpi['projects_public'] = $this->db->table('projects')->eq('is_private', 0)->count();
        $kpi['categories'] = $this->db->table('project_has_categories')->count();
        $kpi['auto_actions'] = $this->db->table('project_has_actions')->count();
        $kpi['plugins'] = 51; // Statik veya plugin loader
        
        $kpi['tasks_active'] = $this->db->table('tasks')->eq('is_active', 1)->count();
        $kpi['tasks_closed'] = $this->db->table('tasks')->eq('is_active', 0)->count();
        $kpi['comments'] = $this->db->table('comments')->count();
        $kpi['attachments'] = $this->db->table('task_has_files')->count();
        $kpi['tags'] = $this->db->table('tags')->count();
        $kpi['link_labels'] = $this->db->table('link_labels')->count();
        $kpi['external_links'] = $this->db->table('task_has_external_links')->count();
        
        $kpi['templates'] = 0;
        $kpi['task_templates'] = 0;
        $kpi['comment_templates'] = 0;
        $kpi['general_templates'] = 0;
        
        $kpi['groups'] = $this->db->table('groups')->count();
        $kpi['timezones'] = 0;
        $kpi['languages'] = 1;
        
        $kpi['users_active'] = $this->db->table('users')->eq('is_active', 1)->count();
        $kpi['users_inactive'] = $this->db->table('users')->eq('is_active', 0)->count();
        $kpi['users_admin'] = $this->db->table('users')->eq('role', 'app-admin')->count();
        $kpi['users_manager'] = $this->db->table('users')->eq('role', 'app-manager')->count();
        $kpi['users_user'] = $this->db->table('users')->eq('role', 'app-user')->count();

        // --- ACİL DURUM KARTLARI (Gecikmiş İşlemler) ---
        $overdue_tasks = $this->db->table('tasks')
            ->eq('is_active', 1)
            ->neq('date_due', 0)
            ->lt('date_due', $now)
            ->limit(5)
            ->findAll();

        // --- AI ÖNERİSİ OLUŞTUR (Dynamic AI Logic) ---
        $ai_suggestion_1 = null;
        if (!empty($blocker_tree)) {
            $first_pid = array_key_first($blocker_tree);
            $ai_suggestion_1 = "[{$blocker_tree[$first_pid]['name']}] sürecinde ciddi bir darboğaz var. Ekip kaynaklarını acilen bu blokaja kaydırın.";
        }

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/overview', array(
            'title' => t('Manager Control Center'),
            'user' => $user,
            'total_projects' => $total_projects,
            'open_tasks' => $open_tasks,
            'total_blockers' => $total_blockers,
            'blocker_tree' => $blocker_tree,
            'blocker_links' => $blocker_links,
            'global_burn_rate' => $global_burn_rate,
            'budget_spent' => $budget_spent,
            'tasks_today' => $tasks_today,
            'tasks_week' => $tasks_week,
            'tasks_month' => $tasks_month,
            'users' => $users,
            'projects' => $projects,
            'kpi' => $kpi,
            'overdue_tasks' => $overdue_tasks,
            'ai_suggestion_1' => $ai_suggestion_1,
            'ai_suggestion_2' => $ai_velocity_alert
        )));
    }

    /**
     * Ortak ve genişletilmiş Bütçe/Finans raporlama sayfası
     */
    public function finance()
    {
        $user = $this->getUser();
        $projects = $this->db->table('projects')->eq('is_active', 1)->findAll();
        
        $budget_lines = array();
        try {
            // CostControl kuruluysa tüm projelerin budget_lines tablosundan detayları çeker
            $budget_lines = $this->db->table('budget_lines')
                ->join('projects', 'id', 'project_id', 'budget_lines')
                ->eq('projects.is_active', 1)
                ->columns('budget_lines.*', 'projects.name AS project_name')
                ->desc('budget_lines.date')
                ->findAll();
        } catch (\Exception $e) {
            // Tablo bulunamazsa boş döner
        }

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/finance', array(
            'title' => t('Küresel Finans ve Bütçe Kırılımları'),
            'user' => $user,
            'budget_lines' => $budget_lines
        )));
    }
}
