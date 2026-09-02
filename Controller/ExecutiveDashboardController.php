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
            ->in('link_id', array(2, 3))
            ->count();

        // Blokaj Ağacı (Blocker Tree) için gerçek veriler
        $blocker_links = array();
        try {
            $raw_links = $this->db->table('task_has_links')
                ->join('links', 'id', 'link_id', 'task_has_links')
                ->in('link_id', array(2, 3))
                ->limit(20)
                ->findAll();

            foreach ($raw_links as $l) {
                $t1 = $this->db->table('tasks')->eq('id', $l['task_id'])->eq('is_active', 1)->findOne();
                $t2 = $this->db->table('tasks')->eq('id', $l['opposite_task_id'])->eq('is_active', 1)->findOne();
                if ($t1 && $t2) {
                    $proj = $this->db->table('projects')->eq('id', $t1['project_id'])->findOne();
                    $blocker_links[] = [
                        'blocked_task_id' => $t1['id'],
                        'blocked_task_title' => $t1['title'],
                        'blocker_task_id' => $t2['id'],
                        'blocker_task_title' => $t2['title'],
                        'project_id' => $proj['id'],
                        'project_name' => $proj['name'] ?? 'Bilinmeyen Proje'
                    ];
                }
                if (count($blocker_links) >= 5) break;
            }
        } catch (\Exception $e) { }

        $blocker_tree = array();
        $graph_nodes = array();
        $graph_edges = array();
        $node_ids = array();

        foreach ($blocker_links as $link) {
            $blocker_tree[$link['project_id']]['name'] = $link['project_name'];
            $blocker_tree[$link['project_id']]['tasks'][] = $link;

            // Blocker Node
            if (!isset($node_ids[$link['blocker_task_id']])) {
                $graph_nodes[] = array(
                    'id' => $link['blocker_task_id'],
                    'label' => "#" . $link['blocker_task_id'] . "\n" . mb_substr($link['blocker_task_title'], 0, 15) . "...",
                    'color' => '#f0ad4e',
                    'shape' => 'box'
                );
                $node_ids[$link['blocker_task_id']] = true;
            }
            // Blocked Node
            if (!isset($node_ids[$link['blocked_task_id']])) {
                $graph_nodes[] = array(
                    'id' => $link['blocked_task_id'],
                    'label' => "#" . $link['blocked_task_id'] . "\n" . mb_substr($link['blocked_task_title'], 0, 15) . "...",
                    'color' => '#8ab4f8',
                    'shape' => 'box'
                );
                $node_ids[$link['blocked_task_id']] = true;
            }
            // Edge
            $graph_edges[] = array(
                'from' => $link['blocker_task_id'],
                'to' => $link['blocked_task_id'],
                'label' => 'blocks',
                'arrows' => 'to',
                'color' => array('color' => '#d9534f')
            );
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
        $tasks_overdue = $this->db->table('tasks')->eq('is_active', 1)->lte('date_due', $today_end)->neq('date_due', 0)->findAll();
        $tasks_today = $this->db->table('tasks')->eq('is_active', 1)->gte('date_due', $today_start)->lte('date_due', $today_end)->findAll();
        $tasks_week = $this->db->table('tasks')->eq('is_active', 1)->gt('date_due', $today_end)->lte('date_due', $week_end)->findAll();
        $tasks_month = $this->db->table('tasks')->eq('is_active', 1)->gt('date_due', $week_end)->lte('date_due', $month_end)->findAll();

        $users = $this->db->table('users')->eq('is_active', 1)->findAll();
        $projects_raw = $this->db->table('projects')->eq('is_active', 1)->desc('id')->findAll();
        
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
        $kpi['overall_score'] = $kpi['performance_avg'];
        
        $kpi['overdue_total_count'] = 0;
        try {
            $kpi['overdue_total_count'] = $this->db->table('tasks')->eq('is_active', 1)->neq('date_due', 0)->lte('date_due', $today_end)->count();
        } catch (\Exception $e) {}
            
        if ($total_blockers > 0 || $kpi['overdue_total_count'] > 10) {
            $kpi['health_status'] = 'Uyarı';
            $kpi['health_color'] = '#d73a49';
        } else {
            $kpi['health_status'] = 'İyi';
            $kpi['health_color'] = '#28a745';
        }

        // Güvenli Sayım Fonksiyonu
        $safeCount = function($table, $condition = []) {
            try {
                $q = $this->db->table($table);
                foreach($condition as $k => $v) {
                    $q->eq($k, $v);
                }
                return $q->count();
            } catch (\Exception $e) {
                return 0;
            }
        };

        $kpi['projects_active'] = $safeCount('projects', ['is_active' => 1]);
        $kpi['projects_inactive'] = $safeCount('projects', ['is_active' => 0]);
        $kpi['projects_private'] = $safeCount('projects', ['is_private' => 1]);
        $kpi['projects_public'] = $safeCount('projects', ['is_private' => 0]);
        $kpi['categories'] = $safeCount('project_has_categories');
        
        // Kanboard Automatic Actions (Table 'actions')
        $kpi['auto_actions'] = $safeCount('actions');
        $kpi['plugins'] = 51;
        
        $kpi['tasks_active'] = $safeCount('tasks', ['is_active' => 1]);
        $kpi['tasks_closed'] = $safeCount('tasks', ['is_active' => 0]);
        $kpi['comments'] = $safeCount('comments');
        $kpi['attachments'] = $safeCount('task_has_files');
        $kpi['tags'] = $safeCount('tags');
        $kpi['link_labels'] = $safeCount('link_labels');
        $kpi['external_links'] = $safeCount('task_has_external_links');
        
        $kpi['templates'] = 0;
        $kpi['task_templates'] = 0;
        $kpi['comment_templates'] = 0;
        $kpi['general_templates'] = 0;
        
        $kpi['groups'] = $safeCount('groups');
        $kpi['timezones'] = 0;
        $kpi['languages'] = 1;
        
        $kpi['users_active'] = $safeCount('users', ['is_active' => 1]);
        $kpi['users_inactive'] = $safeCount('users', ['is_active' => 0]);
        $kpi['users_admin'] = $safeCount('users', ['role' => 'app-admin']);
        $kpi['users_manager'] = $safeCount('users', ['role' => 'app-manager']);
        $kpi['users_user'] = $safeCount('users', ['role' => 'app-user']);

        // --- ACİL DURUM KARTLARI (Gecikmiş İşlemler) ---
        $overdue_tasks = $this->db->table('tasks')
            ->eq('is_active', 1)
            ->neq('date_due', 0)
            ->lte('date_due', $today_end)
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
            $has_relationgraph = defined('PLUGINS_DIR') && file_exists(PLUGINS_DIR . '/Relationgraph');

            'has_relationgraph' => $has_relationgraph,
            'blocker_links' => $blocker_links,
            'graph_nodes' => json_encode($graph_nodes),
            'graph_edges' => json_encode($graph_edges),
            'global_burn_rate' => $global_burn_rate,
            'budget_spent' => $budget_spent,
            'tasks_overdue' => $tasks_overdue,
            'tasks_today' => $tasks_today,
            'tasks_week' => $tasks_week,
            'tasks_month' => $tasks_month,
            'users' => $users,
            'projects' => $projects,
            'kpi' => $kpi,
            'tasks_overdue' => $overdue_tasks,
            'ai_suggestion_1' => $ai_suggestion_1,
            'ai_suggestion_2' => $ai_velocity_alert
        )));
    }

    /**
     * Ortak ve genişletilmiş Bütçe/Finans raporlama sayfası
     */
        /**
     * Tüm etiketleri (Global + Proje özel) listeleyen sayfa
     */
    public function tags()
    {
        $user = $this->getUser();
        
        $tags = $this->db->table('tags')
            ->leftJoin('projects', 'id', 'project_id', 'tags')
            ->columns('tags.id', 'tags.name', 'tags.color_id', 'tags.project_id', 'projects.name AS project_name')
            ->asc('tags.project_id')
            ->asc('tags.name')
            ->findAll();

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/tags', array(
            'title' => t('Tüm Sistem Etiketleri'),
            'user' => $user,
            'tags' => $tags
        )));
    }

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
