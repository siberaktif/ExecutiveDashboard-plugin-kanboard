<div class="sidebar">
    <ul class="no-bullets" style="display:flex; flex-direction:column;">
        <!-- 1. Yönetici Kontrol Merkezi -->
        <li style="order: 1;" <?= $this->app->checkMenuSelection('ExecutiveDashboardController', 'index', 'ExecutiveDashboard') ? 'class="active"' : '' ?>>
            <?= $this->url->link('<i class="fa fa-briefcase fa-fw" aria-hidden="true"></i> <strong>' . t('Yönetici Kontrol Merkezi') . '</strong>', 'ExecutiveDashboardController', 'index', ['plugin' => 'ExecutiveDashboard']) ?>
        </li>

        <?php $safe_user_id = isset($user) ? $user['id'] : $this->user->getId(); ?>
        
        <!-- 2. Özet Görünüm -->
        <li style="order: 2;" <?= $this->app->checkMenuSelection('DashboardController', 'show') ? 'class="active"' : '' ?>>
            <?= $this->url->link('<i class="fa fa-tachometer fa-fw" aria-hidden="true"></i> ' . t('Overview'), 'DashboardController', 'show', ['user_id' => $safe_user_id]) ?>
        </li>
        
        <!-- 3. Projelerim -->
        <li style="order: 3;" <?= $this->app->checkMenuSelection('DashboardController', 'projects') ? 'class="active"' : '' ?>>
            <?= $this->url->link('<i class="fa fa-folder fa-fw" aria-hidden="true"></i> ' . t('My projects'), 'DashboardController', 'projects', ['user_id' => $safe_user_id]) ?>
        </li>
        
        <!-- 4. Görevlerim -->
        <li style="order: 4;" <?= $this->app->checkMenuSelection('DashboardController', 'tasks') ? 'class="active"' : '' ?>>
            <?= $this->url->link('<i class="fa fa-tasks fa-fw" aria-hidden="true"></i> ' . t('My tasks'), 'DashboardController', 'tasks', ['user_id' => $safe_user_id]) ?>
        </li>
        
        <!-- 5. Altgörevlerim -->
        <li style="order: 5;" <?= $this->app->checkMenuSelection('DashboardController', 'subtasks') ? 'class="active"' : '' ?>>
            <?= $this->url->link('<i class="fa fa-sitemap fa-fw" aria-hidden="true"></i> ' . t('My subtasks'), 'DashboardController', 'subtasks', ['user_id' => $safe_user_id]) ?>
        </li>

        <!-- 6. TodoNotes (Notlarım) -->
        <li style="order: 6;" <?= $this->app->checkMenuSelection('TodoNotesController', 'ShowDashboard', 'TodoNotes') ? 'class="active"' : '' ?>>
            <?= $this->url->link('<i class="fa fa-wpforms fa-fw" aria-hidden="true"></i> ' . t('Notlarım'), 'TodoNotesController', 'ShowDashboard', ['plugin' => 'TodoNotes', 'user_id' => $safe_user_id]) ?>
        </li>

        <!-- 7. Diğer Eklentilerin Kancaları (En Alta Gider) -->
        <div style="order: 7; display:contents;">
            <?= $this->hook->render('template:dashboard:sidebar', array('user' => isset($user) ? $user : array('id' => $safe_user_id))) ?>
        </div>
    </ul>
</div>
