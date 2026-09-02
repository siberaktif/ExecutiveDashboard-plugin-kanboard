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
        
        $total_projects = $this->db->table('projects')->eq('is_active', 1)->count();
        $open_tasks = $this->db->table('tasks')->eq('is_active', 1)->count();
        
        $total_blockers = $this->db->table('task_has_links')
            ->join('links', 'id', 'link_id', 'task_has_links')
            ->join('tasks', 'id', 'task_id', 'task_has_links')
            ->eq('tasks.is_active', 1)
            ->in('link_id', array(2, 3))
            ->count();

        // Blokaj Ağacı (Blocker Tree)
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
        foreach ($blocker_links as $link) {
            $blocker_tree[$link['project_id']]['name'] = $link['project_name'];
            $blocker_tree[$link['project_id']]['tasks'][] = $link;
        }

        // Relationgraph Düğüm & Kenarları
        $graph_nodes = array();
        $graph_edges = array();
        $node_ids = array();
        $task_cache = array();

        try {
            $all_links = $this->db->table('task_has_links')
                ->join('links', 'id', 'link_id', 'task_has_links')
                ->findAll();

            foreach ($all_links as $l) {
                if (!isset($task_cache[$l['task_id']])) {
                    $task_cache[$l['task_id']] = $this->db->table('tasks')->eq('id', $l['task_id'])->eq('is_active', 1)->findOne();
                }
                $t1 = $task_cache[$l['task_id']];

                if (!isset($task_cache[$l['opposite_task_id']])) {
                    $task_cache[$l['opposite_task_id']] = $this->db->table('tasks')->eq('id', $l['opposite_task_id'])->eq('is_active', 1)->findOne();
                }
                $t2 = $task_cache[$l['opposite_task_id']];

                if ($t1 && $t2) {
                    if (!isset($node_ids[$t1['id']])) {
                        $c = $this->colorModel->getColorProperties($t1['color_id']);
                        $graph_nodes[] = [
                            'id' => $t1['id'],
                            'label' => "#" . $t1['id'] . "\n" . mb_substr($t1['title'], 0, 20) . "...",
                            'color' => isset($c['background']) ? $c['background'] : '#f0ad4e',
                            'shape' => 'box'
                        ];
                        $node_ids[$t1['id']] = true;
                    }
                    if (!isset($node_ids[$t2['id']])) {
                        $c = $this->colorModel->getColorProperties($t2['color_id']);
                        $graph_nodes[] = [
                            'id' => $t2['id'],
                            'label' => "#" . $t2['id'] . "\n" . mb_substr($t2['title'], 0, 20) . "...",
                            'color' => isset($c['background']) ? $c['background'] : '#8ab4f8',
                            'shape' => 'box'
                        ];
                        $node_ids[$t2['id']] = true;
                    }
                    $edge_color = '#999999';
                    if ($l['link_id'] == 2 || $l['link_id'] == 3) {
                        $edge_color = '#d9534f'; 
                    } elseif ($l['link_id'] == 1) {
                        $edge_color = '#1a73e8';
                    }
                    $graph_edges[] = [
                        'from' => $t1['id'],
                        'to' => $t2['id'],
                        'label' => t($l['label']),
                        'arrows' => 'to',
                        'color' => ['color' => $edge_color]
                    ];
                }
            }
        } catch (\Exception $e) { }

        // --- GERÇEK FİNANS VE BÜTÇE HESAPLAMASI (DOĞRU MANTIK) ---
        $global_burn_rate = 0; // Toplam Tahsis Edilen Bütçe (Kasa)
        $budget_spent = 0;     // Gerçekleşen Fiili Harcama (Maliyetler)

        try {
            // 1. Tahsis Edilen Toplam Bütçe (budget_lines = Kasa Girişi)
            $global_burn_rate = (float) ($this->db->table('budget_lines')->sum('amount') ?: 0);

            // Eğer settings üzerinden manuel küresel bütçe tanımlıysa onu önceliklendir
            $db_budget = $this->db->table('settings')->eq('option', 'mcc_global_budget')->findOneColumn('value');
            if ($db_budget && (float)$db_budget > 0) {
                $global_burn_rate = (float) $db_budget;
            }

            // 2. Fiili Giderler: Kanboard alt görev zaman takibindeki maliyetler
            $subtask_costs = $this->db->table('subtask_time_tracking')
                ->join('users', 'id', 'user_id', 'subtask_time_tracking')
                ->findAll();

            foreach ($subtask_costs as $st) {
                $hours = (float)($st['time_spent'] ?? 0);
                $rate = (float)($st['cost_rate'] ?? 0);
                $budget_spent += ($hours * $rate);
            }
        } catch (\Exception $e) {
            $global_burn_rate = 0;
            $budget_spent = 0;
        }

        // Zaman sınırları
        $now = time();
        $today_start = strtotime('today', $now);
        $today_end = strtotime('tomorrow', $now) - 1;
        $week_start = strtotime('monday this week', $now);
        $week_end = strtotime('sunday this week', $now) + 86399;
        $month_start = strtotime('first day of this month', $now);
        $month_end = strtotime('last day of this month', $now) + 86399;

        // Görev Filtreleri
        $tasks_overdue = $this->db->table('tasks')->eq('is_active', 1)->lte('date_due', $today_end)->neq('date_due', 0)->findAll();
        $tasks_today = $this->db->table('tasks')->eq('is_active', 1)->gte('date_due', $today_start)->lte('date_due', $today_end)->findAll();
        $tasks_week = $this->db->table('tasks')->eq('is_active', 1)->gt('date_due', $today_end)->lte('date_due', $week_end)->findAll();
        $tasks_month = $this->db->table('tasks')->eq('is_active', 1)->gt('date_due', $week_end)->lte('date_due', $month_end)->findAll();

        $users = $this->db->table('users')->eq('is_active', 1)->findAll();
        $projects_raw = $this->db->table('projects')->eq('is_active', 1)->desc('id')->findAll();
        
        $projects = [];
        $ai_velocity_alert = null;
        
        // --- ANA SAYFA AGILE İLERLEME HESAPLAMASI ---
        $total_comp_all = 0;
        $closed_comp_all = 0;

        foreach ($projects_raw as $p) {
            $tasks = $this->db->table('tasks')->eq('project_id', $p['id'])->findAll();
            $open = 0;
            $total_comp = 0;
            $closed_comp = 0;

            foreach($tasks as $t) {
                $comp = (int)$t['score'] > 0 ? (int)$t['score'] : 1; 
                $total_comp += $comp;
                
                if ($t['is_active'] == 0) {
                    $closed_comp += $comp;
                } else {
                    $open++;
                }
            }
            
            $p['progress'] = $total_comp > 0 ? round(($closed_comp / $total_comp) * 100) : 0;
            
            $total_comp_all += $total_comp;
            $closed_comp_all += $closed_comp;
            
            // Velocity
            $week_ago = time() - 604800;
            $p['velocity'] = $this->db->table('tasks')->eq('project_id', $p['id'])->eq('is_active', 0)->gte('date_completed', $week_ago)->count();
            if ($p['velocity'] == 0 && $open > 0 && !$ai_velocity_alert) {
                $ai_velocity_alert = t('%s projesinde üretim hızı (Velocity) tamamen durmuş durumda. Ekipleri veya yeni süreçleri aktif edin.', $p['name']);
            }
            
            $p['wip_alert'] = $open > 5;
            
            // Proje bazlı bütçe kullanımı
            $p_budget = 0;
            try { 
                $p_budget = (float) $this->db->table('budget_lines')->eq('project_id', $p['id'])->sum('amount'); 
            } catch (\Exception $e) {}
            
            $p['burn_rate'] = $p_budget > 0 ? round(($budget_spent / $p_budget) * 100) : 0;
            if ($p['burn_rate'] > 100) $p['burn_rate'] = 100;
            
            $projects[] = $p;
        }

        // --- ANA SAYFA KPI VE SKOR HESAPLAMASI (AGILE) ---
        $kpi = [];
        
        $kpi['performance_avg'] = $total_comp_all > 0 ? round(($closed_comp_all / $total_comp_all) * 100) : 0;
        $kpi['overdue_total_count'] = count($tasks_overdue);
            
        if ($total_blockers > 0 || $kpi['overdue_total_count'] > 10) {
            $kpi['health_status'] = 'Uyarı';
            $kpi['health_color'] = '#d73a49';
        } else {
            $kpi['health_status'] = 'İyi';
            $kpi['health_color'] = '#28a745';
        }

        // Çevik Puanlama Cezası (Ana Sayfa İçin)
        $penalty_overdue = 0;
        foreach($tasks_overdue as $ot) {
            $pri = max(1, (int)($ot['priority'] ?? 1));
            $comp = max(1, (int)($ot['score'] ?? 1));
            $penalty_overdue += (1 * $pri * $comp);
        }

        $penalty_blocker = 0;
        $blockers_raw = $this->db->table('task_has_links')->join('tasks', 'id', 'task_id', 'task_has_links')->in('link_id', [2, 3])->eq('tasks.is_active', 1)->findAll();
        foreach($blockers_raw as $b) {
            $pri = max(1, (int)($b['priority'] ?? 1));
            $comp = max(1, (int)($b['score'] ?? 1));
            $penalty_blocker += (2 * $pri * $comp);
        }

        $kpi['overall_score'] = max(0, $kpi['performance_avg'] - $penalty_overdue - $penalty_blocker);

        $safeCount = function($table, $condition = []) {
            try {
                $q = $this->db->table($table);
                foreach($condition as $k => $v) $q->eq($k, $v);
                return $q->count();
            } catch (\Exception $e) { return 0; }
        };

        $kpi['projects_active'] = $safeCount('projects', ['is_active' => 1]);
        $kpi['projects_inactive'] = $safeCount('projects', ['is_active' => 0]);
        $kpi['projects_private'] = $safeCount('projects', ['is_private' => 1]);
        $kpi['projects_public'] = $safeCount('projects', ['is_private' => 0]);
        $kpi['categories'] = $safeCount('categories');
        
        $kpi['auto_actions'] = $safeCount('actions');
        $kpi['plugins'] = 51;
        
        $kpi['tasks_active'] = $safeCount('tasks', ['is_active' => 1]);
        $kpi['tasks_closed'] = $safeCount('tasks', ['is_active' => 0]);
        $kpi['comments'] = $safeCount('comments');
        $kpi['attachments'] = $safeCount('files');
        $kpi['tags'] = $safeCount('tags');
        $kpi['link_labels'] = $safeCount('link_labels') > 0 ? $safeCount('link_labels') : $safeCount('links');
        $kpi['external_links'] = $safeCount('task_has_external_links');
        
        $kpi['templates'] = $safeCount('templates');
        $kpi['task_templates'] = $safeCount('task_templates');
        $kpi['comment_templates'] = $safeCount('comment_templates');
        $kpi['general_templates'] = $safeCount('custom_filters');
        
        $kpi['groups'] = $safeCount('groups');
        $kpi['timezones'] = 1; 
        $kpi['languages'] = 1;
        
        $kpi['users_active'] = $safeCount('users', ['is_active' => 1]);
        $kpi['users_inactive'] = $safeCount('users', ['is_active' => 0]);
        $kpi['users_admin'] = $safeCount('users', ['role' => 'app-admin']);
        $kpi['users_manager'] = $safeCount('users', ['role' => 'app-manager']);
        $kpi['users_user'] = $safeCount('users', ['role' => 'app-user']);

        $ai_suggestion_1 = null;
        if (!empty($blocker_tree)) {
            $first_pid = array_key_first($blocker_tree);
            $ai_suggestion_1 = "[{$blocker_tree[$first_pid]['name']}] sürecinde ciddi bir darboğaz var. Ekip kaynaklarını acilen bu blokaja kaydırın.";
        }

        $relationgraph_dir = '';
        if (defined("PLUGINS_DIR")) {
            if (file_exists(PLUGINS_DIR . '/Relationgraph')) $relationgraph_dir = 'Relationgraph';
            elseif (file_exists(PLUGINS_DIR . '/kanboard_plugin_relationgraph')) $relationgraph_dir = 'kanboard_plugin_relationgraph';
        }
        $has_relationgraph = !empty($relationgraph_dir);

        // Fonlama Modülü
        $funding_task = $this->db->table('tasks')->like('title', '%Fonlama%')->eq('is_active', 1)->findOne() ?: $this->db->table('tasks')->like('title', '%Funding%')->eq('is_active', 1)->findOne();
        $funding_data = ['subtitle' => t('Hedef (Fonlama) Görevi Bulunamadı:'), 'days_left' => t('Tarih Yok'), 'target' => t('Belirtilmedi')];

        if (!empty($funding_task)) {
            $funding_data['subtitle'] = htmlspecialchars($funding_task['title']) . ':';
            if (!empty($funding_task['date_due'])) {
                $diff = $funding_task['date_due'] - time();
                $funding_data['days_left'] = $diff > 0 ? floor($diff / 86400) . ' ' . t('Gün Kaldı') : t('Süresi Doldu');
            }
            if (!empty($funding_task['score'])) $funding_data['target'] = number_format($funding_task['score'], 0, ',', '.') . ' TL';
        }

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/overview', [
            'title' => t('Manager Control Center'),
            'user' => $user,
            'total_projects' => $total_projects,
            'open_tasks' => $open_tasks,
            'total_blockers' => $total_blockers,
            'blocker_tree' => $blocker_tree,
            'has_relationgraph' => $has_relationgraph,
            'funding_data' => $funding_data,
            'relationgraph_dir' => $relationgraph_dir,
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
            'ai_suggestion_1' => $ai_suggestion_1,
            'ai_suggestion_2' => $ai_velocity_alert
        ]));
    }

    public function tags()
    {
        $user = $this->getUser();
        $tags = $this->db->table('tags')
            ->join('projects', 'id', 'project_id', 'tags')
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

    public function comments()
    {
        $user = $this->getUser();
        $comments = array();
        try {
            $comments = $this->db->table('comments')
                ->join('tasks', 'id', 'task_id', 'comments')
                ->join('users', 'id', 'user_id', 'comments')
                ->columns('comments.id', 'comments.comment', 'comments.date_creation', 'tasks.id AS task_id', 'tasks.title AS task_title', 'users.name AS user_name', 'users.username')
                ->desc('comments.date_creation')
                ->limit(100)
                ->findAll();
        } catch (\Exception $e) {}

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/comments', array(
            'title' => t('Tüm Sistem Yorumları'),
            'user' => $user,
            'comments' => $comments
        )));
    }

    public function attachments()
    {
        $user = $this->getUser();
        $files = array();
        try {
            $files = $this->db->table('files')
                ->join('tasks', 'id', 'task_id', 'files')
                ->columns('files.id', 'files.name', 'files.task_id', 'tasks.title AS task_title')
                ->desc('files.id')
                ->limit(100)
                ->findAll();
        } catch (\Exception $e) {}

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/attachments', array(
            'title' => t('Tüm Sistem Dosya Ekleri'),
            'user' => $user,
            'files' => $files
        )));
    }

    public function categories()
    {
        $user = $this->getUser();
        $categories = array();
        try {
            $categories = $this->db->table('categories')
                ->join('projects', 'id', 'project_id', 'categories')
                ->columns('categories.id', 'categories.name', 'categories.project_id', 'projects.name AS project_name')
                ->asc('categories.project_id')
                ->asc('categories.name')
                ->findAll();
        } catch (\Exception $e) {}

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/categories', array(
            'title' => t('Tüm Proje Kategorileri'),
            'user' => $user,
            'categories' => $categories
        )));
    }

    public function actions()
    {
        $user = $this->getUser();
        $actions = array();
        try {
            $actions = $this->db->table('actions')
                ->findAll();
            
            foreach ($actions as &$act) {
                if (!empty($act['project_id']) && $act['project_id'] > 0) {
                    $p = $this->db->table('projects')->eq('id', $act['project_id'])->findOne();
                    $act['project_name'] = $p['name'] ?? 'Proje #'.$act['project_id'];
                } else {
                    $act['project_name'] = 'Genel';
                }
            }
        } catch (\Exception $e) {}

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/actions', array(
            'title' => t('Tüm Otomatik Eylemler'),
            'user' => $user,
            'actions' => $actions
        )));
    }

    public function linkLabels()
    {
        $user = $this->getUser();
        $link_labels = array();
        try {
            $link_labels = $this->db->table('link_labels')->findAll();
            if (empty($link_labels)) {
                $link_labels = $this->db->table('links')->findAll();
            }
        } catch (\Exception $e) {}

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/link_labels', array(
            'title' => t('Bağlantı Etiketleri'),
            'user' => $user,
            'link_labels' => $link_labels
        )));
    }

    public function finance()
    {
        $user = $this->getUser();
        
        $global_budget = 0;
        $budget_spent = 0;
        $budget_lines = array();

        try {
            // 1. Proje Bütçe Kalemleri (Tanımlı Bütçeler)
            $global_budget = (float) ($this->db->table('budget_lines')->sum('amount') ?: 0);
            
            $db_budget = $this->db->table('settings')->eq('option', 'mcc_global_budget')->findOneColumn('value');
            if ($db_budget && (float)$db_budget > 0) {
                $global_budget = (float) $db_budget;
            }

            // Bütçe Kalemleri
            $budget_lines = $this->db->table('budget_lines')
                ->join('projects', 'id', 'project_id', 'budget_lines')
                ->eq('projects.is_active', 1)
                ->columns('budget_lines.id', 'budget_lines.amount', 'budget_lines.date', 'budget_lines.comment', 'projects.name AS project_name', 'projects.id AS project_id')
                ->desc('budget_lines.date')
                ->findAll();

            // 2. Harcanan Gerçek Maliyet
            $subtask_costs = $this->db->table('subtask_time_tracking')
                ->join('users', 'id', 'user_id', 'subtask_time_tracking')
                ->findAll();

            foreach ($subtask_costs as $st) {
                $budget_spent += ((float)($st['time_spent'] ?? 0) * (float)($st['cost_rate'] ?? 0));
            }
        } catch (\Exception $e) { }

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/finance', array(
            'title' => t('Küresel Finans ve Bütçe Kırılımları'),
            'user' => $user,
            'budget_lines' => $budget_lines,
            'budget_spent' => $budget_spent,
            'global_budget' => $global_budget
        )));
    }

    public function externalLinks()
    {
        $user = $this->getUser();
        $links = array();
        try {
            $links = $this->db->table('task_has_external_links')
                ->join('tasks', 'id', 'task_id', 'task_has_external_links')
                ->columns('task_has_external_links.*', 'tasks.title AS task_title')
                ->desc('task_has_external_links.id')
                ->limit(100)
                ->findAll();
        } catch (\Exception $e) {}

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/external_links', array(
            'title' => t('Tüm Dış Bağlantılar (External Links)'),
            'user' => $user,
            'links' => $links
        )));
    }

    public function templates()
    {
        $user = $this->getUser();
        $templates = array();
        
        try {
            if ($this->db->table('custom_filters')->exists()) {
                $filters = $this->db->table('custom_filters')->findAll();
                foreach($filters as $f) {
                    $templates[] = ['type' => 'Genel Şablon/Filtre', 'name' => $f['name'], 'project_id' => $f['project_id']];
                }
            }
            if ($this->db->table('task_has_templates')->exists()) {
                $tt = $this->db->table('task_has_templates')->findAll();
                foreach($tt as $t) {
                    $templates[] = ['type' => 'Task Template', 'name' => $t['title'] ?? 'İsimsiz Şablon', 'project_id' => $t['project_id'] ?? 0];
                }
            }
        } catch (\Exception $e) {}

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/templates', array(
            'title' => t('Sistem Şablonları ve Filtreler'),
            'user' => $user,
            'templates' => $templates
        )));
    }

    public function timezones()
    {
        $user = $this->getUser();
        $settings = array();
        try {
            $settings = $this->db->table('settings')
                ->in('option', ['application_timezone', 'timezone'])
                ->findAll();
            if (empty($settings)) {
                $settings = [['option' => 'application_timezone', 'value' => date_default_timezone_get()]];
            }
        } catch (\Exception $e) {
            $settings = [['option' => 'application_timezone', 'value' => date_default_timezone_get()]];
        }

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/timezones', array(
            'title' => t('Saat Dilimi Yapılandırması'),
            'user' => $user,
            'settings' => $settings
        )));
    }

    public function languages()
    {
        $user = $this->getUser();
        $settings = array();
        try {
            $settings = $this->db->table('settings')
                ->in('option', ['application_language', 'language'])
                ->findAll();
            if (empty($settings)) {
                $settings = [['option' => 'application_language', 'value' => 'tr_TR']];
            }
        } catch (\Exception $e) {
            $settings = [['option' => 'application_language', 'value' => 'tr_TR']];
        }

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/languages', array(
            'title' => t('Dil Yapılandırması'),
            'user' => $user,
            'settings' => $settings
        )));
    }

    public function performance()
    {
        $user = $this->getUser();
        $projects_raw = $this->db->table('projects')->eq('is_active', 1)->findAll();
        
        $project_stats = [];
        $total_tasks_all = 0;
        $total_closed_all = 0;
        $total_open_all = 0;
        $total_progress_sum = 0;

        $total_complexity_all = 0;
        $closed_complexity_all = 0;

        foreach ($projects_raw as $p) {
            $tasks = $this->db->table('tasks')->eq('project_id', $p['id'])->findAll();
            $total = count($tasks);
            $closed = 0;
            $open = 0;
            $total_comp = 0;
            $closed_comp = 0;

            foreach($tasks as $t) {
                $comp = (int)$t['score'] > 0 ? (int)$t['score'] : 1; 
                $total_comp += $comp;
                
                if ($t['is_active'] == 0) {
                    $closed++;
                    $closed_comp += $comp;
                } else {
                    $open++;
                }
            }
            
            $progress = $total_comp > 0 ? round(($closed_comp / $total_comp) * 100) : 0;
            
            $total_tasks_all += $total;
            $total_closed_all += $closed;
            $total_open_all += $open;
            $total_progress_sum += $progress;

            $total_complexity_all += $total_comp;
            $closed_complexity_all += $closed_comp;

            $project_stats[] = [
                'id' => $p['id'],
                'name' => $p['name'],
                'total_tasks' => $total,
                'closed_tasks' => $closed,
                'open_tasks' => $open,
                'progress' => $progress,
                'total_comp' => $total_comp,
                'closed_comp' => $closed_comp
            ];
        }

        $project_count = count($project_stats);
        $unweighted_avg = $project_count > 0 ? round($total_progress_sum / $project_count) : 0;
        $weighted_avg = $total_complexity_all > 0 ? round(($closed_complexity_all / $total_complexity_all) * 100) : 0;

        $today_end = strtotime('tomorrow', time()) - 1;
        $overdue_count = $this->db->table('tasks')->eq('is_active', 1)->neq('date_due', 0)->lte('date_due', $today_end)->count();
        $blocker_count = $this->db->table('task_has_links')->in('link_id', [2, 3])->count();

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/performance', [
            'title' => t('Genel Proje Performansı Raporu'),
            'user' => $user,
            'project_stats' => $project_stats,
            'project_count' => $project_count,
            'total_tasks_all' => $total_tasks_all,
            'total_closed_all' => $total_closed_all,
            'total_open_all' => $total_open_all,
            'unweighted_avg' => $unweighted_avg,
            'weighted_avg' => $weighted_avg,
            'overdue_count' => $overdue_count,
            'blocker_count' => $blocker_count,
            'total_complexity_all' => $total_complexity_all,
            'closed_complexity_all' => $closed_complexity_all
        ]));
    }

    public function score()
    {
        $user = $this->getUser();
        $projects_raw = $this->db->table('projects')->eq('is_active', 1)->findAll();
        
        $total_comp = 0;
        $closed_comp = 0;

        foreach ($projects_raw as $p) {
            $tasks = $this->db->table('tasks')->eq('project_id', $p['id'])->findAll();
            foreach($tasks as $t) {
                $c = (int)$t['score'] > 0 ? (int)$t['score'] : 1;
                $total_comp += $c;
                if ($t['is_active'] == 0) $closed_comp += $c;
            }
        }

        $base_score = $total_comp > 0 ? round(($closed_comp / $total_comp) * 100) : 0;
        $today_end = strtotime('tomorrow', time()) - 1;
        
        $overdue_tasks = $this->db->table('tasks')->eq('is_active', 1)->neq('date_due', 0)->lte('date_due', $today_end)->findAll();
        $overdue_count = count($overdue_tasks);
        
        $blockers_raw = $this->db->table('task_has_links')->join('tasks', 'id', 'task_id', 'task_has_links')->in('link_id', [2, 3])->eq('tasks.is_active', 1)->findAll();
        $blocker_count = count($blockers_raw);

        $penalty_overdue = 0;
        foreach($overdue_tasks as $ot) {
            $pri = max(1, (int)$ot['priority']);
            $comp = max(1, (int)$ot['score']);
            $penalty_overdue += (1 * $pri * $comp);
        }

        $penalty_blocker = 0;
        foreach($blockers_raw as $b) {
            $pri = max(1, (int)$b['priority']);
            $comp = max(1, (int)$b['score']);
            $penalty_blocker += (2 * $pri * $comp);
        }

        $total_penalty = $penalty_overdue + $penalty_blocker;
        $final_score = max(0, $base_score - $total_penalty);

        $score_color = '#28a745'; 
        if ($final_score < 50) $score_color = '#d73a49'; 
        elseif ($final_score < 75) $score_color = '#f0ad4e'; 

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/score', array(
            'title' => t('Genel Skor & Çevik (Agile) Sağlık İndeksi'),
            'user' => $user,
            'base_score' => $base_score,
            'overdue_count' => $overdue_count,
            'blocker_count' => $blocker_count,
            'penalty_overdue' => $penalty_overdue,
            'penalty_blocker' => $penalty_blocker,
            'total_penalty' => $total_penalty,
            'final_score' => $final_score,
            'score_color' => $score_color
        )));
    }

    public function health()
    {
        $user = $this->getUser();
        $today_end = strtotime('tomorrow', time()) - 1;
        
        $overdue_tasks = [];
        try {
            $overdue_tasks = $this->db->table('tasks')
                ->join('projects', 'id', 'project_id', 'tasks')
                ->eq('tasks.is_active', 1)
                ->neq('tasks.date_due', 0)
                ->lte('tasks.date_due', $today_end)
                ->columns('tasks.id', 'tasks.title', 'tasks.date_due', 'tasks.score', 'tasks.priority', 'projects.name AS project_name', 'projects.id AS project_id')
                ->findAll();
        } catch (\Exception $e) {}

        $blockers = [];
        try {
            $blockers = $this->db->table('task_has_links')
                ->join('tasks', 'id', 'task_id', 'task_has_links')
                ->join('projects', 'id', 'project_id', 'tasks')
                ->in('link_id', [2, 3])
                ->eq('tasks.is_active', 1)
                ->columns('tasks.id', 'tasks.title', 'tasks.score', 'tasks.priority', 'projects.name AS project_name', 'projects.id AS project_id')
                ->findAll();
        } catch (\Exception $e) {}

        $this->response->html($this->helper->layout->dashboard('ExecutiveDashboard:dashboard/health', [
            'title' => t('Proje Sağlığı & Risk Filtreleme Paneli'),
            'user' => $user,
            'overdue_tasks' => $overdue_tasks,
            'blockers' => $blockers
        ]));
    }
}