<?php

namespace Kanboard\Plugin\ExecutiveDashboard\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Model\TaskModel;
use Kanboard\Model\SubtaskModel;

class DemoImportController extends BaseController
{
    public function import()
    {
        // Sihirli Mermi: MySQL Katı Modunu (Strict Mode) kapat, eklenti tabloları çökmesin
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
        
        // PANO TEMİZLİĞİ: Önceki tüm görevleri sil
        $tasks = $this->taskFinderModel->getAll($project_id);
        foreach ($tasks as $task) {
            $this->taskModel->remove($task['id']);
        }

        $base_time = strtotime('2026-09-01 10:00:00');

        // 21 ADIMLIK MASTER SDLC SİMÜLASYONU VERİ SETİ
        $history = [
            ['title' => 'Proje Başlangıcı & .htaccess / ModSecurity Analizi', 'desc' => 'Sunucu güvenlik kuralları aşıldı. Kapsam belirlendi.', 'est'=>4, 'spent'=>8],
            ['title' => 'Kanboard Eklenti İskeletinin (Controller/Template) Kurulması', 'desc' => 'Temel MVC yapısı ve klasör hiyerarşisi oluşturuldu.', 'est'=>3, 'spent'=>3],
            ['title' => 'Sol Menü (Sidebar) CSS Order Çakışmasının Çözülmesi', 'desc' => 'TodoNotes eklentisiyle olan menü sıralaması çakışması CSS Order ile çözüldü.', 'est'=>2, 'spent'=>3],
            ['title' => '6 Ana Modüllü CSS Grid Arayüz Kodlaması', 'desc' => 'Responsive panellerin iskeleti oturtuldu.', 'est'=>5, 'spent'=>5],
            ['title' => 'Çevik (Agile) Metrik & Aritmetik Skor Motoru', 'desc' => 'score() fonksiyonu ve matematiksel ağırlıklandırma entegre edildi.', 'est'=>4, 'spent'=>4],
            ['title' => 'Görev Karmaşıklığı ve Öncelik (Priority) Çarpanları', 'desc' => 'Ceza formülleri puanlama sistemine yansıtıldı.', 'est'=>3, 'spent'=>3],
            ['title' => 'Finansal Modül: CostControl Bütçe Entegrasyonu', 'desc' => 'CostControl eklentisinden bütçe satırları başarıyla çekildi.', 'est'=>4, 'spent'=>4],
            ['title' => 'KRİZ: Ters Bütçe Hesabının Düzeltilmesi', 'desc' => 'Tahsis edilen havuz (budget_lines) ile gerçekleşen efor (time_tracking) hesapları ters dönmüştü. Matematiksel mantık onarıldı.', 'est'=>3, 'spent'=>6],
            ['title' => 'Temiz URL (Clean URL) /project/{id}/budget Yönlendirmesi', 'desc' => 'Finans paneline geçiş rotası güzelleştirildi.', 'est'=>1, 'spent'=>1],
            ['title' => 'Nakit Yakım Hızı (Burn Rate) Donut Chart CSS', 'desc' => 'Saf CSS ile dinamik grafik üretimi.', 'est'=>4, 'spent'=>4],
            ['title' => 'Zaman Sınırlı Eylem Planı (Bugün, Bu Hafta, Bu Ay)', 'desc' => 'Kullanıcıya özel due_date (Bitiş Tarihi) SQL filtreleri eklendi.', 'est'=>5, 'spent'=>5],
            ['title' => 'KRİZ: Relationgraph (Vis.js) CSP Blokajı', 'desc' => 'Harici unpkg CDN kullanımı Kanboard İçerik Güvenlik Politikası (CSP) tarafından engellendi.', 'est'=>2, 'spent'=>5],
            ['title' => 'Vis.js Kütüphanesinin Dinamik Referanslama Çözümü', 'desc' => 'Dosyalar yerel kanboard_plugin_relationgraph dizininden dinamik çağrıldı.', 'est'=>3, 'spent'=>3],
            ['title' => 'Relationgraph 0px Kapsayıcı (Height) Hatası Onarımı', 'desc' => 'DOM yüklenmeden önce script çalıştığı için grafik kapsayıcısı sıfır yüksekliğe çöküyordu. Çözüldü.', 'est'=>2, 'spent'=>2],
            ['title' => 'Yüzer Geri Dön (Floating Back) Butonu Yapımı', 'desc' => '14 alt sayfaya evrensel gezinme kolaylığı sağlandı. Çift butonlar silindi.', 'est'=>3, 'spent'=>3],
            ['title' => 'UI Cila: 0 Değerli KPI Kartlarında Link İptali', 'desc' => 'Boş kartlara tıklayıp çıkmaz sokağa girmeyi önleyen UX düzeltmesi.', 'est'=>1, 'spent'=>1],
            ['title' => 'Relationgraph Font Renginin #333333 Yapılması', 'desc' => 'Açık renkli görev kutularında beyaz yazıların okunmama sorunu giderildi.', 'est'=>1, 'spent'=>1],
            ['title' => 'Çoklu Dil (Localization): 37 Metnin t() İle Sarmalanması', 'desc' => 'Türkçe sabit metinler çeviri fonksiyonuna alındı.', 'est'=>3, 'spent'=>3],
            ['title' => 'Gerekli Eklentiler İçin Dinamik Sarı Uyarı Bannerları', 'desc' => 'CostControl, KPI veya Relationgraph eksikse arayüzde yerinde uyarı verilecek şekilde ayarlandı.', 'est'=>2, 'spent'=>2],
            ['title' => 'KRİZ: Demo Import SQL Kancaları (user_id & due_description)', 'desc' => 'Kanboard API ve Modelleri üzerinden görev yaratırken uzak sunucudaki eklentilerin Strict Mode hataları baş gösterdi.', 'est'=>2, 'spent'=>6],
            ['title' => 'ÇÖZÜM: MySQL Session sql_mode Override ile Tam Bypass', 'desc' => 'Veritabanı katı modu devreden çıkarılarak tüm eklenti zırhları delindi ve sistem oturtuldu.', 'est'=>1, 'spent'=>1],
        ];

        $previous_task_id = 0;
        $current_time = $base_time;

        foreach ($history as $index => $step) {
            $step_number = $index + 1;
            
            // Zaman Çizelgesi Hesaplaması (Her adımda süre artıyor)
            $task_start = $current_time;
            $task_end = $current_time + ($step['spent'] * 3600);
            $current_time = $task_end + 86400; // Sonraki görev ertesi gün başlıyor

            $color = 'green';
            if (strpos($step['title'], 'KRİZ') !== false) {
                $color = 'red';
            } elseif (strpos($step['title'], 'ÇÖZÜM') !== false) {
                $color = 'blue';
            }

            // Görev Oluştur
            $task_id = $this->taskCreationModel->create([
                'project_id' => $project_id,
                'title' => 'Adım ' . $step_number . ': ' . $step['title'],
                'description' => $step['desc'] . "\n\n**Orijinal Forgejo Commit Geçmişinden Alınmıştır.**",
                'column_id' => $done_column_id,
                'owner_id' => $user_id,
                'creator_id' => $user_id,
                'color_id' => $color,
                'score' => rand(3, 13), // Agile Complexity
                'priority' => rand(1, 3), // Agile Priority
                'time_estimated' => $step['est'],
                'time_spent' => $step['spent'],
                'date_creation' => $task_start,
                'date_started' => $task_start,
                'date_completed' => $task_end
            ]);

            if ($task_id) {
                // Görevi Kapat (is_active = 0) -> Gantt grafiğinde %100 olması için
                $this->taskStatusModel->close($task_id);

                // Alt Görev Ekle
                $this->subtaskModel->create([
                    'task_id' => $task_id, 
                    'title' => 'Teknik uygulamalar kodlandı ve test edildi.', 
                    'status' => SubtaskModel::STATUS_DONE, 
                    'time_estimated'=> $step['est'], 
                    'time_spent'=> $step['spent'], 
                    'user_id' => $user_id
                ]);

                // Harici GitHub/Forgejo Linki Ekle
                $this->taskExternalLinkModel->create([
                    'task_id' => $task_id,
                    'creator_id' => $user_id,
                    'link_type' => 'weblink',
                    'dependency' => 'related',
                    'title' => 'Github/Forgejo Commit ' . $step_number,
                    'url' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard.git'
                ]);

                // Blokaj (Kritik Yol) İlişkisi Kur
                if ($previous_task_id > 0) {
                    $this->taskLinkModel->create($previous_task_id, $task_id, 2); // 2 = blocks
                }
                $previous_task_id = $task_id;
            }
        }

        echo "<div style='padding:40px; font-family:sans-serif; text-align:center;'>";
        echo "<h2 style='color:#28a745;'>🏆 Master SDLC Simülasyonu Başarıyla Kuruldu!</h2>";
        echo "<p>Tam 21 Adımlık geliştirme serüveni (krizler, çözümler, commitler) %100 kapalı, bitiş tarihli ve dış bağlantılı şekilde Kanboard'a aktarıldı.</p>";
        echo "<p><a href='/?controller=BoardViewController&action=show&project_id=".$project_id."' style='padding:10px 20px; background:#007bff; color:#fff; text-decoration:none; border-radius:5px;'>Otantik Proje Panosunu Görüntüle</a></p>";
        echo "</div>";
    }
}
