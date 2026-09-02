<?php
$content = file_get_contents('Controller/ExecutiveDashboardController.php');

$old_blockers = <<<EOT
        // Blokaj Ağacı (Blocker Tree) için gerçek veriler
        \$blocker_links = array();
        try {
            \$blocker_links = \$this->db->table('task_has_links')
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
        } catch (\Exception \$e) { }
EOT;

$new_blockers = <<<EOT
        // Blokaj Ağacı (Blocker Tree) için gerçek veriler
        \$blocker_links = array();
        try {
            \$raw_links = \$this->db->table('task_has_links')
                ->join('links', 'id', 'link_id', 'task_has_links')
                ->in('links.label', array('is blocked by', 'blocks', 'is_blocked_by'))
                ->limit(20)
                ->findAll();

            foreach (\$raw_links as \$l) {
                \$t1 = \$this->db->table('tasks')->eq('id', \$l['task_id'])->eq('is_active', 1)->findOne();
                \$t2 = \$this->db->table('tasks')->eq('id', \$l['opposite_task_id'])->eq('is_active', 1)->findOne();
                if (\$t1 && \$t2) {
                    \$proj = \$this->db->table('projects')->eq('id', \$t1['project_id'])->findOne();
                    \$blocker_links[] = [
                        'blocked_task_id' => \$t1['id'],
                        'blocked_task_title' => \$t1['title'],
                        'blocker_task_id' => \$t2['id'],
                        'blocker_task_title' => \$t2['title'],
                        'project_id' => \$proj['id'],
                        'project_name' => \$proj['name'] ?? 'Bilinmeyen Proje'
                    ];
                }
                if (count(\$blocker_links) >= 5) break;
            }
        } catch (\Exception \$e) { }
EOT;

if (strpos($content, trim(explode("\n", $old_blockers)[2])) !== false) {
    $content = str_replace($old_blockers, $new_blockers, $content);
    file_put_contents('Controller/ExecutiveDashboardController.php', $content);
    echo "Patched blockers successfully.";
} else {
    echo "Could not find old blockers block.";
}
?>
