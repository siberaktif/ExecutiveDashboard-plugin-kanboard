<div class="sidebar">
    <ul class="no-bullets">
        <!-- 1. Özel Yönetici Menünüz (En Üstte) -->
        <li <?= $this->app->checkMenuSelection('ExecutiveDashboardController', 'index', 'ExecutiveDashboard') ? 'class="active"' : '' ?>>
            <a href="<?= $this->url->href('ExecutiveDashboardController', 'index', ['plugin' => 'ExecutiveDashboard']) ?>">
                <i class="fa fa-briefcase fa-fw" aria-hidden="true"></i> <strong><?= t('Yönetici Kontrol Merkezi') ?></strong>
            </a>
        </li>

        <!-- 2. Orijinal Kanboard Menüleri -->
        <li <?= $this->app->checkMenuSelection('DashboardController', 'show') ? 'class="active"' : '' ?>>
            <?= $this->url->link(t('Overview'), 'DashboardController', 'show', ['user_id' => $user['id']]) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('DashboardController', 'projects') ? 'class="active"' : '' ?>>
            <?= $this->url->link(t('My projects'), 'DashboardController', 'projects', ['user_id' => $user['id']]) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('DashboardController', 'tasks') ? 'class="active"' : '' ?>>
            <?= $this->url->link(t('My tasks'), 'DashboardController', 'tasks', ['user_id' => $user['id']]) ?>
        </li>
        <li <?= $this->app->checkMenuSelection('DashboardController', 'subtasks') ? 'class="active"' : '' ?>>
            <?= $this->url->link(t('My subtasks'), 'DashboardController', 'subtasks', ['user_id' => $user['id']]) ?>
        </li>

        <!-- 3. KRİTİK KOD: Diğer Tüm Eklentilerin (P1-P5, TodoNotes) Menülerini Geri Getiren Hook -->
        <?= $this->hook->render('template:dashboard:sidebar') ?>
    </ul>
</div>
