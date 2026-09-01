<?php
$content = file_get_contents('Template/dashboard/overview.php');
$content = str_replace('status:open due:<=yesterday', 'status:open due:<=today', $content);

$kpi_old = <<<EOT
            <?php
            \$kpi_cards = [
                ['title' => 'Genel Proje Performansı', 'total' => '%'.\$kpi['performance_avg'], 'sub' => '', 'color' => '#1a73e8', 'icon' => 'fa-line-chart', 'url' => '#'],
                ['title' => 'Proje Sağlığı', 'total' => \$kpi['health_status'], 'sub' => 'Uyarı', 'color' => \$kpi['health_color'], 'icon' => 'fa-heartbeat', 'url' => '#'],
                ['title' => 'Genel Skor', 'total' => '%'.\$kpi['overall_score'], 'sub' => '', 'color' => '#f0ad4e', 'icon' => 'fa-trophy', 'url' => '#'],
                ['title' => 'Geciken Görevler', 'total' => \$kpi['overdue_total_count'], 'sub' => 'Dikkat Gerektiriyor', 'color' => '#d73a49', 'icon' => 'fa-calendar-times-o', 'url' => \$this->url->href('TaskController', 'task_overdue', array('project_id'=>2, 'plugin'=>'KPI'))],
                
                ['title' => 'Projeler', 'total' => \$kpi['projects_active']+\$kpi['projects_inactive'], 'sub' => 'A:'.\$kpi['projects_active'].' P:'.\$kpi['projects_inactive'], 'color' => '#0366d6', 'icon' => 'fa-folder-open-o', 'url' => \$this->url->href('ProjectListController', 'show')],
                ['title' => 'Kişisel Projeler', 'total' => \$kpi['projects_private'], 'sub' => '', 'color' => '#0366d6', 'icon' => 'fa-lock', 'url' => \$this->url->href('ProjectListController', 'show')],
                ['title' => 'Herkese Açık Projeler', 'total' => \$kpi['projects_public'], 'sub' => '', 'color' => '#0366d6', 'icon' => 'fa-globe', 'url' => \$this->url->href('ProjectListController', 'show')],
                ['title' => 'Kategoriler', 'total' => \$kpi['categories'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-tags', 'url' => '#'],
                ['title' => 'Otomatik Eylemler', 'total' => \$kpi['auto_actions'], 'sub' => '', 'color' => '#005cc5', 'icon' => 'fa-cogs', 'url' => '#'],
                ['title' => 'Eklentiler', 'total' => \$kpi['plugins'], 'sub' => '', 'color' => '#28a745', 'icon' => 'fa-plug', 'url' => \$this->url->href('PluginController', 'show')],
                ['title' => 'Görevler (Açık)', 'total' => \$kpi['tasks_active'], 'sub' => '', 'color' => '#e36209', 'icon' => 'fa-tasks', 'url' => \$this->url->href('SearchController', 'index', array('search'=>'status:open'))],
                ['title' => 'Görevler (Kapalı)', 'total' => \$kpi['tasks_closed'], 'sub' => '', 'color' => '#e36209', 'icon' => 'fa-check-square-o', 'url' => \$this->url->href('SearchController', 'index', array('search'=>'status:closed'))],
                ['title' => 'Yorumlar', 'total' => \$kpi['comments'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-comments', 'url' => '#'],
                ['title' => 'Ekler', 'total' => \$kpi['attachments'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-paperclip', 'url' => '#'],
                ['title' => 'Etiketler', 'total' => \$kpi['tags'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-tags', 'url' => \$this->url->href('TagController', 'index')],
                ['title' => 'Bağlantı Etiketleri', 'total' => \$kpi['link_labels'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-link', 'url' => '#'],
                ['title' => 'External Links', 'total' => \$kpi['external_links'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-external-link', 'url' => '#'],
                ['title' => 'Templates', 'total' => \$kpi['templates'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-file-text-o', 'url' => '#'],
                ['title' => 'Task Templates', 'total' => \$kpi['task_templates'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-file-text-o', 'url' => '#'],
                ['title' => 'Yorum Şablonları', 'total' => \$kpi['comment_templates'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-file-text-o', 'url' => '#'],
                ['title' => 'Genel Şablonlar', 'total' => \$kpi['general_templates'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-file-text-o', 'url' => '#'],
                ['title' => 'Kullanıcı Grupları', 'total' => \$kpi['groups'], 'sub' => '', 'color' => '#d73a49', 'icon' => 'fa-users', 'url' => \$this->url->href('GroupListController', 'index')],
                ['title' => 'Saat Dilimleri', 'total' => \$kpi['timezones'], 'sub' => '', 'color' => '#d73a49', 'icon' => 'fa-clock-o', 'url' => '#'],
                ['title' => 'Diller', 'total' => \$kpi['languages'], 'sub' => '', 'color' => '#d73a49', 'icon' => 'fa-language', 'url' => '#'],
                ['title' => 'Kullanıcılar', 'total' => \$kpi['users_active']+\$kpi['users_inactive'], 'sub' => 'Aktif:'.\$kpi['users_active'].' Pasif:'.\$kpi['users_inactive'], 'color' => '#d73a49', 'icon' => 'fa-user', 'url' => \$this->url->href('UserListController', 'show')],
                ['title' => 'Üyeler', 'total' => \$kpi['users_user'], 'sub' => 'Standart', 'color' => '#d73a49', 'icon' => 'fa-user-o', 'url' => \$this->url->href('UserListController', 'show')],
                ['title' => 'Yöneticiler', 'total' => \$kpi['users_manager'], 'sub' => 'PM', 'color' => '#d73a49', 'icon' => 'fa-user-circle-o', 'url' => \$this->url->href('UserListController', 'show')],
                ['title' => 'Sistem Yöneticileri', 'total' => \$kpi['users_admin'], 'sub' => 'Admin', 'color' => '#d73a49', 'icon' => 'fa-user-secret', 'url' => \$this->url->href('UserListController', 'show')],
            ];
            ?>
            <?php foreach(\$kpi_cards as \$c): ?>
            <a href="<?= \$c['url'] ?>" target="_blank" style="text-decoration:none; background:#ffffff; border:1px solid #e1e4e8; border-left:3px solid <?= \$c['color'] ?>; border-radius:4px; padding:12px; color:#24292e; display:flex; flex-direction:column; justify-content:space-between; min-height:80px; box-shadow:0 1px 3px rgba(0,0,0,0.02); transition: box-shadow 0.2s;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div style="font-weight:600; font-size:12px; color:#586069; line-height:1.2; padding-right:5px; word-break:break-word;"><?= \$c['title'] ?></div>
                    <i class="fa <?= \$c['icon'] ?>" style="color:<?= \$c['color'] ?>; font-size:14px; opacity:0.8;"></i>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-top:8px;">
                    <span style="font-size:22px; font-weight:bold; color:#24292e; line-height:1;"><?= \$c['total'] ?></span>
                    <?php if(\$c['sub']): ?>
                    <span style="font-size:10px; color:#6a737d; font-weight:500; background:#f6f8fa; padding:2px 4px; border-radius:3px;"><?= \$c['sub'] ?></span>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
EOT;

$kpi_new = <<<EOT
            <?php
            \$kpi_cards = [
                // 1. GENEL METRİKLER
                ['title' => 'Genel Proje Performansı', 'total' => '%'.\$kpi['performance_avg'], 'sub' => '', 'color' => '#1a73e8', 'icon' => 'fa-line-chart', 'url' => ''],
                ['title' => 'Proje Sağlığı', 'total' => \$kpi['health_status'], 'sub' => 'Uyarı', 'color' => \$kpi['health_color'], 'icon' => 'fa-heartbeat', 'url' => ''],
                ['title' => 'Genel Skor', 'total' => '%'.\$kpi['overall_score'], 'sub' => '', 'color' => '#f0ad4e', 'icon' => 'fa-trophy', 'url' => ''],
                ['title' => 'Geciken Görevler', 'total' => \$kpi['overdue_total_count'], 'sub' => 'Dikkat Gerektiriyor', 'color' => '#d73a49', 'icon' => 'fa-calendar-times-o', 'url' => \$this->url->href('SearchController', 'index', array('search' => 'status:open due:<=today'))],
                
                // 2. PROJELER GRUBU
                ['title' => 'Projeler', 'total' => \$kpi['projects_active']+\$kpi['projects_inactive'], 'sub' => 'A:'.\$kpi['projects_active'].' P:'.\$kpi['projects_inactive'], 'color' => '#0366d6', 'icon' => 'fa-folder-open-o', 'url' => \$this->url->href('ProjectListController', 'show')],
                ['title' => 'Kişisel Projeler', 'total' => \$kpi['projects_private'], 'sub' => 'Gizli', 'color' => '#0366d6', 'icon' => 'fa-lock', 'url' => \$this->url->href('ProjectListController', 'show')],
                ['title' => 'Herkese Açık Projeler', 'total' => \$kpi['projects_public'], 'sub' => 'Genel', 'color' => '#0366d6', 'icon' => 'fa-globe', 'url' => \$this->url->href('ProjectListController', 'show')],
                
                // 3. GÖREVLER GRUBU
                ['title' => 'Görevler (Açık)', 'total' => \$kpi['tasks_active'], 'sub' => 'Aktif', 'color' => '#e36209', 'icon' => 'fa-tasks', 'url' => \$this->url->href('SearchController', 'index', array('search'=>'status:open'))],
                ['title' => 'Görevler (Kapalı)', 'total' => \$kpi['tasks_closed'], 'sub' => 'Tamamlanan', 'color' => '#e36209', 'icon' => 'fa-check-square-o', 'url' => \$this->url->href('SearchController', 'index', array('search'=>'status:closed'))],
                
                // 4. İLETİŞİM & VARLIKLAR
                ['title' => 'Yorumlar', 'total' => \$kpi['comments'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-comments', 'url' => ''],
                ['title' => 'Ekler', 'total' => \$kpi['attachments'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-paperclip', 'url' => ''],
                ['title' => 'External Links', 'total' => \$kpi['external_links'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-external-link', 'url' => ''],
                
                // 5. ETİKETLER GRUBU
                ['title' => 'Etiketler', 'total' => \$kpi['tags'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-tags', 'url' => \$this->url->href('TagController', 'index')],
                ['title' => 'Bağlantı Etiketleri', 'total' => \$kpi['link_labels'], 'sub' => '', 'color' => '#6f42c1', 'icon' => 'fa-link', 'url' => ''],
                
                // 6. SİSTEM YAPILARI
                ['title' => 'Kategoriler', 'total' => \$kpi['categories'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-tags', 'url' => ''],
                ['title' => 'Otomatik Eylemler', 'total' => \$kpi['auto_actions'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-cogs', 'url' => ''],
                ['title' => 'Eklentiler', 'total' => \$kpi['plugins'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-plug', 'url' => \$this->url->href('PluginController', 'show')],
                ['title' => 'Templates', 'total' => \$kpi['templates'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-file-text-o', 'url' => ''],
                ['title' => 'Task Templates', 'total' => \$kpi['task_templates'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-file-text-o', 'url' => ''],
                ['title' => 'Yorum Şablonları', 'total' => \$kpi['comment_templates'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-file-text-o', 'url' => ''],
                ['title' => 'Genel Şablonlar', 'total' => \$kpi['general_templates'], 'sub' => '', 'color' => '#17a2b8', 'icon' => 'fa-file-text-o', 'url' => ''],
                
                // 7. KULLANICI DEMOGRAFİSİ VE YETKİLER
                ['title' => 'Kullanıcı Grupları', 'total' => \$kpi['groups'], 'sub' => '', 'color' => '#d73a49', 'icon' => 'fa-users', 'url' => \$this->url->href('GroupListController', 'index')],
                ['title' => 'Saat Dilimleri', 'total' => \$kpi['timezones'], 'sub' => '', 'color' => '#d73a49', 'icon' => 'fa-clock-o', 'url' => ''],
                ['title' => 'Diller', 'total' => \$kpi['languages'], 'sub' => '', 'color' => '#d73a49', 'icon' => 'fa-language', 'url' => ''],
                ['title' => 'Kullanıcılar', 'total' => \$kpi['users_active']+\$kpi['users_inactive'], 'sub' => 'Aktif:'.\$kpi['users_active'].' Pasif:'.\$kpi['users_inactive'], 'color' => '#d73a49', 'icon' => 'fa-user', 'url' => \$this->url->href('UserListController', 'show')],
                ['title' => 'Üyeler', 'total' => \$kpi['users_user'], 'sub' => 'Standart', 'color' => '#d73a49', 'icon' => 'fa-user-o', 'url' => \$this->url->href('UserListController', 'show')],
                ['title' => 'Yöneticiler', 'total' => \$kpi['users_manager'], 'sub' => 'PM', 'color' => '#d73a49', 'icon' => 'fa-user-circle-o', 'url' => \$this->url->href('UserListController', 'show')],
                ['title' => 'Sistem Yöneticileri', 'total' => \$kpi['users_admin'], 'sub' => 'Admin', 'color' => '#d73a49', 'icon' => 'fa-user-secret', 'url' => \$this->url->href('UserListController', 'show')],
            ];
            ?>
            <?php foreach(\$kpi_cards as \$c): ?>
            <?php 
                \$is_link = !empty(\$c['url']) && \$c['url'] !== '#';
                \$tag_start = \$is_link ? '<a href="'.\$c['url'].'" target="_blank"' : '<div';
                \$tag_end = \$is_link ? '</a>' : '</div>';
            ?>
            <?= \$tag_start ?> style="text-decoration:none; background:#ffffff; border:1px solid #e1e4e8; border-left:3px solid <?= \$c['color'] ?>; border-radius:4px; padding:12px; color:#24292e; display:flex; flex-direction:column; justify-content:space-between; min-height:80px; box-shadow:0 1px 3px rgba(0,0,0,0.02); transition: box-shadow 0.2s;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div style="font-weight:600; font-size:12px; color:#586069; line-height:1.2; padding-right:5px; word-break:break-word;"><?= \$c['title'] ?></div>
                    <i class="fa <?= \$c['icon'] ?>" style="color:<?= \$c['color'] ?>; font-size:14px; opacity:0.8;"></i>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-top:8px;">
                    <span style="font-size:22px; font-weight:bold; color:#24292e; line-height:1;"><?= \$c['total'] ?></span>
                    <?php if(\$c['sub']): ?>
                    <span style="font-size:10px; color:#6a737d; font-weight:500; background:#f6f8fa; padding:2px 4px; border-radius:3px;"><?= \$c['sub'] ?></span>
                    <?php endif; ?>
                </div>
            <?= \$tag_end ?>
            <?php endforeach; ?>
EOT;

$content = str_replace($kpi_old, $kpi_new, $content);
file_put_contents('Template/dashboard/overview.php', $content);
echo "Patched overview.php successfully.";
?>
