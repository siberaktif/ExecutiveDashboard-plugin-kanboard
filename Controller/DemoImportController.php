<?php

namespace Kanboard\Plugin\ExecutiveDashboard\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Model\TaskModel;
use Kanboard\Model\SubtaskModel;

class DemoImportController extends BaseController
{
    public function import()
    {
        // MySQL Strict modunu bu oturum için kapat, böylece eksik eklenti sütunlarına (due_description vb.) 
        // MySQL otomatik olarak boş değer (default) atar ve sistemi çökertmez.
        $this->db->getConnection()->exec("SET SESSION sql_mode = ''");

        $project_id = $this->request->getIntegerParam('project_id');
        
        if (empty($project_id)) {
            echo "Lütfen URL'ye &project_id=7 parametresini ekleyin.";
            return;
        }

        $columns = $this->columnModel->getAll($project_id);
        $done_column_id = 0;
        foreach ($columns as $col) {
            if (stripos($col['title'], 'Bitti') !== false || stripos($col['title'], 'Tamamland') !== false) {
                $done_column_id = $col['id'];
            }
        }
        if ($done_column_id === 0 && !empty($columns)) {
            $done_column_id = $columns[count($columns)-1]['id'];
        }

        $user_id = $this->userSession->getId();
        
        // Önceki tüm kopya görevleri temizle
        $tasks = $this->taskFinderModel->getAll($project_id);
        foreach ($tasks as $task) {
            $this->taskModel->remove($task['id']);
        }

        $base_time = strtotime('2026-09-01 18:59:00');

        // GÖREV 1
        $t1 = $this->taskCreationModel->create([
            'project_id' => $project_id,
            'title' => 'Ön Analiz & Altyapı Hazırlığı',
            'description' => "**Aşama 1: Hazırlık & Kapsam Belirleme**\n\nExecutive Dashboard için çoklu proje verilerini tek ekranda toplayan, Çevik (Agile) metrikleri barındıran kurumsal bir yönetim paneli tasarlanması kararlaştırıldı. Apache `.htaccess` ve ModSecurity kısıtlamaları aşıldı. Forgejo yerel entegrasyonu kuruldu.",
            'column_id' => $done_column_id,
            'owner_id' => $user_id,
            'creator_id' => $user_id,
            'color_id' => 'yellow',
            'score' => 5,
            'priority' => 3,
            'time_estimated' => 16,
            'time_spent' => 16,
            'date_creation' => $base_time,
            'date_started' => $base_time + 3600,
            'date_completed' => $base_time + (24 * 3600)
        ]);
        if ($t1) {
            $this->subtaskModel->create(['task_id' => $t1, 'title' => 'Apache .htaccess ve ModSecurity rewrite kurallarının incelenmesi', 'status' => SubtaskModel::STATUS_DONE, 'time_estimated'=>12, 'time_spent'=>12, 'user_id' => $user_id]);
            $this->subtaskModel->create(['task_id' => $t1, 'title' => 'Forgejo yerel entegrasyonu ve pnpm monorepo yapısının kurulması', 'status' => SubtaskModel::STATUS_DONE, 'time_estimated'=>4, 'time_spent'=>4, 'user_id' => $user_id]);
        }

        // GÖREV 2
        $t2 = $this->taskCreationModel->create([
            'project_id' => $project_id,
            'title' => 'Çevik (Agile) Metrik & Aritmetik Skor Motoru',
            'description' => "**Aşama 2: Çekirdek Geliştirme**\n\nExecutiveDashboardController.php içinde score() ve performance() metotları yazıldı. Görev karmaşıklığı (score) ve öncelik çarpanları ceza formüllerine entegre edildi.",
            'column_id' => $done_column_id,
            'owner_id' => $user_id,
            'creator_id' => $user_id,
            'color_id' => 'blue',
            'score' => 8,
            'priority' => 2,
            'time_estimated' => 6,
            'time_spent' => 6,
            'date_creation' => $base_time + (2 * 86400),
            'date_started' => $base_time + (2 * 86400) + 3600,
            'date_completed' => $base_time + (3 * 86400)
        ]);
        if ($t2) {
            $this->subtaskModel->create(['task_id' => $t2, 'title' => 'ExecutiveDashboardController.php içinde score() ve performance() metotlarının yazılması', 'status' => SubtaskModel::STATUS_DONE, 'time_estimated'=>3, 'time_spent'=>3, 'user_id' => $user_id]);
            $this->subtaskModel->create(['task_id' => $t2, 'title' => 'Görev karmaşıklığı (score) ve öncelik çarpanlarının (priority) ceza formüllerine entegre edilmesi', 'status' => SubtaskModel::STATUS_DONE, 'time_estimated'=>3, 'time_spent'=>3, 'user_id' => $user_id]);
        }

        // GÖREV 3
        $t3 = $this->taskCreationModel->create([
            'project_id' => $project_id,
            'title' => 'Finansal Modül & Bütçe Kırılımları (Ters Hesap Krizi)',
            'description' => "**Aşama 3: Veri Entegrasyonları**\n\nTers hesap krizinin düzeltilmesi. budget_lines ile zaman takibi maliyetlerinin ayrıştırılması sağlandı. Temiz URL yönlendirmeleri kusursuz hale getirildi.",
            'column_id' => $done_column_id,
            'owner_id' => $user_id,
            'creator_id' => $user_id,
            'color_id' => 'green',
            'score' => 13,
            'priority' => 3,
            'time_estimated' => 4,
            'time_spent' => 4,
            'date_creation' => $base_time + (4 * 86400),
            'date_started' => $base_time + (4 * 86400) + 3600,
            'date_completed' => $base_time + (5 * 86400)
        ]);
        if ($t3) {
            $this->subtaskModel->create(['task_id' => $t3, 'title' => 'budget_lines (Tahsis edilen bütçe havuzu) ile zaman takibi maliyetlerinin ayrıştırılması', 'status' => SubtaskModel::STATUS_DONE, 'time_spent'=>2, 'user_id' => $user_id]);
            $this->subtaskModel->create(['task_id' => $t3, 'title' => '/project/{id}/budget temiz URL (clean URL) yönlendirmelerinin kusursuz hale getirilmesi', 'status' => SubtaskModel::STATUS_DONE, 'time_spent'=>2, 'user_id' => $user_id]);
        }

        // GÖREV 4
        $t4 = $this->taskCreationModel->create([
            'project_id' => $project_id,
            'title' => 'Risk Yönetimi & Dinamik Filtreleme Paneli',
            'description' => "**Aşama 4: UI Optimizasyonu**\n\nGeciken görevler ve kritik blokajlar için JS filtreleme butonlarının eklenmesi sağlandı. health.php şablonu modern glassmorphism estetiğine uyarlandı.",
            'column_id' => $done_column_id,
            'owner_id' => $user_id,
            'creator_id' => $user_id,
            'color_id' => 'red',
            'score' => 3,
            'priority' => 1,
            'time_estimated' => 3,
            'time_spent' => 3,
            'date_creation' => $base_time + (6 * 86400),
            'date_started' => $base_time + (6 * 86400) + 3600,
            'date_completed' => $base_time + (7 * 86400)
        ]);
        if ($t4) {
            $this->subtaskModel->create(['task_id' => $t4, 'title' => 'Geciken görevler ve kritik blokajlar için JS filtreleme butonlarının eklenmesi', 'status' => SubtaskModel::STATUS_DONE, 'time_spent'=>1.5, 'user_id' => $user_id]);
            $this->subtaskModel->create(['task_id' => $t4, 'title' => 'health.php şablonunun modern glassmorphism/minimalist estetiğe uyarlanması', 'status' => SubtaskModel::STATUS_DONE, 'time_spent'=>1.5, 'user_id' => $user_id]);
        }

        if ($t1 && $t2 && $t3 && $t4) {
            // YORUMLAR
            $this->commentModel->create([
                'task_id' => $t1,
                'user_id' => $user_id,
                'comment' => "# ExecutiveDashboard Plugin - CHANGELOG & README Özet Notu\n- v1.0.0: İlk sürüm ve temel arayüz bileşenleri.\n- v1.2.0: Çevik (Agile) skor matrisi ve ağırlıklı ilerleme oranları eklendi.\n- v1.3.0: Finans modülü düzeltildi, tahsis edilen bütçe ile fiili maliyetler ayrıldı. Temiz URL yönlendirmeleri tamamlandı."
            ]);

            // BAĞLANTILAR (Kritik Yol)
            $this->taskLinkModel->create($t1, $t2, 2); 
            $this->taskLinkModel->create($t2, $t3, 2); 
            $this->taskLinkModel->create($t3, $t4, 2); 

            echo "<div style='padding:40px; font-family:sans-serif; text-align:center;'>";
            echo "<h2 style='color:#28a745;'>Tebrikler! Executive Dashboard Canlandırma Projesi Başarıyla Yüklendi.</h2>";
            echo "<p>MySQL Strict Mode başarıyla bypass edildi. Pano verileriniz artık kusursuz.</p>";
            echo "<p><a href='/?controller=BoardViewController&action=show&project_id=".$project_id."' style='padding:10px 20px; background:#007bff; color:#fff; text-decoration:none; border-radius:5px;'>Panoya Gitmek İçin Tıklayın</a></p>";
            echo "</div>";
        } else {
            echo "<div style='padding:40px; font-family:sans-serif; text-align:center;'>";
            echo "<h2 style='color:#dc3545;'>Görevler oluşturulurken beklenmeyen bir hata meydana geldi.</h2>";
            echo "</div>";
        }
    }
}
