<div class="sidebar">
    <ul class="no-bullets" style="display:flex; flex-direction:column;">
        <!-- 1. En üstte Yönetici Kontrol Merkezi -->
        <li style="order: 1;" <?= $this->app->checkMenuSelection('ExecutiveDashboardController', 'index', 'ExecutiveDashboard') ? 'class="active"' : '' ?>>
            <?= $this->url->link('<i class="fa fa-briefcase fa-fw" aria-hidden="true"></i> <strong>' . t('Yönetici Kontrol Merkezi') . '</strong>', 'ExecutiveDashboardController', 'index', ['plugin' => 'ExecutiveDashboard']) ?>
        </li>
        
        <!-- 2. TodoNotes (Notlarım) Sekmesi (Çökme Korumalı Güvenli $user Kapsamı) -->
        <?php $safe_user_id = isset($user) ? $user['id'] : $this->user->getId(); ?>
        <li style="order: 2;" <?= $this->app->checkMenuSelection('TodoNotesController', 'ShowDashboard', 'TodoNotes') ? 'class="active"' : '' ?>>
            <?= $this->url->link('<i class="fa fa-wpforms fa-fw" aria-hidden="true"></i> ' . t('Notlarım'), 'TodoNotesController', 'ShowDashboard', ['plugin' => 'TodoNotes', 'user_id' => $safe_user_id]) ?>
        </li>

        <!-- 3. Orijinal Kanboard Menüleri -->
        <li style="order: 3;" <?= $this->app->checkMenuSelection('DashboardController', 'show') ? 'class="active"' : '' ?>>
            <?= $this->url->link(t('Overview'), 'DashboardController', 'show', ['user_id' => $safe_user_id]) ?>
        </li>
        <li style="order: 4;" <?= $this->app->checkMenuSelection('DashboardController', 'projects') ? 'class="active"' : '' ?>>
            <?= $this->url->link(t('My projects'), 'DashboardController', 'projects', ['user_id' => $safe_user_id]) ?>
        </li>
        <li style="order: 5;" <?= $this->app->checkMenuSelection('DashboardController', 'tasks') ? 'class="active"' : '' ?>>
            <?= $this->url->link(t('My tasks'), 'DashboardController', 'tasks', ['user_id' => $safe_user_id]) ?>
        </li>
        <li style="order: 6;" <?= $this->app->checkMenuSelection('DashboardController', 'subtasks') ? 'class="active"' : '' ?>>
            <?= $this->url->link(t('My subtasks'), 'DashboardController', 'subtasks', ['user_id' => $safe_user_id]) ?>
        </li>

        <!-- 4. Diğer Eklentilerin Kancaları (En Alta Gider) -->
        <div style="order: 7; display:contents;">
            <?= $this->hook->render('template:dashboard:sidebar', array('user' => isset($user) ? $user : array('id' => $safe_user_id))) ?>
        </div>
    </ul>
</div>
