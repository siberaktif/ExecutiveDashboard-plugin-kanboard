<div class="sidebar">
    <ul class="no-bullets">
        <!-- 1. En üstte Yönetici Kontrol Merkezi -->
        <li <?= $this->app->checkMenuSelection('ExecutiveDashboardController', 'index', 'ExecutiveDashboard') ? 'class="active"' : '' ?>>
            <?= $this->url->link('<i class="fa fa-briefcase fa-fw" aria-hidden="true"></i> <strong>' . t('Yönetici Kontrol Merkezi') . '</strong>', 'ExecutiveDashboardController', 'index') ?>
        </li>
        
        <!-- 2. Orijinal Kanboard Menüleri (Şablon Helper ile Güvenli ID) -->
        <li <?= $this->app->checkMenuSelection('DashboardController', 'show') ? 'class="active"' : '' ?>>
            <?= $this->url->link(t('Overview'), 'DashboardController', 'show', ['user_id' => $this->user->getId()]) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('DashboardController', 'projects') ? 'class="active"' : '' ?>>
            <?= $this->url->link(t('My projects'), 'DashboardController', 'projects', ['user_id' => $this->user->getId()]) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('DashboardController', 'tasks') ? 'class="active"' : '' ?>>
            <?= $this->url->link(t('My tasks'), 'DashboardController', 'tasks', ['user_id' => $this->user->getId()]) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('DashboardController', 'subtasks') ? 'class="active"' : '' ?>>
            <?= $this->url->link(t('My subtasks'), 'DashboardController', 'subtasks', ['user_id' => $this->user->getId()]) ?>
        </li>

        <!-- 3. TodoNotes ve Diğerleri İçin $user Değişkenini Hook'a Dahil Ediyoruz -->
        <?= $this->hook->render('template:dashboard:sidebar', array('user' => isset($user) ? $user : array('id' => $this->user->getId()))) ?>
    </ul>
</div>
