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

        // Proje açıklamasını güncelle (Sadece çekirdek SQL ile)
        $desc = "# Executive Dashboard (Yönetici Kontrol Merkezi)\n\nBu proje, Executive Dashboard eklentisinin 1 Eylül 2026'dan itibaren geliştirilme sürecindeki tüm SDLC adımlarını, krizleri, mimari kararları ve otantik Git commit geçmişini barındıran bir \"Master Simülasyon\" projesidir.\n\n## Modül Hedefleri\n- **Finansal Kontrol (CostControl):** Bütçe ve harcama entegrasyonu.\n- **Çevik (Agile) Skor Motoru:** Geciken işleri ve blokajları analiz eden ağırlıklı skor hesaplamaları.\n- **Makro İlişki Ağı (Relationgraph):** Şirket genelindeki görev blokajlarının görselleştirilmesi.\n- **Tam Otonom SDLC:** Projenin kendisinin, kendi geliştirme sürecini belgelemesi.";
        $this->db->table('projects')->eq('id', $project_id)->update(['description' => $desc]);

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

        $history = [

            [
                'hash' => '416405e',
                'date' => 'Tue Sep 1 18:59:11 2026 +0300',
                'title' => 'Adım 1: first commit',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/416405e',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/416405e'
            ],

            [
                'hash' => '1ef2913',
                'date' => 'Tue Sep 1 19:36:33 2026 +0300',
                'title' => 'Adım 2: feat: eklenti iskeleti, metrik kontrolleri ve arayüz dosyaları eklendi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/1ef2913',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/1ef2913'
            ],

            [
                'hash' => '91b1495',
                'date' => 'Tue Sep 1 19:48:44 2026 +0300',
                'title' => 'Adım 3: chore: standart eklenti klasör hiyerarşisi, çeviri altyapısı ve temel konfigürasyon dosyaları (README, LICENSE, composer) eklendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/91b1495',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/91b1495'
            ],

            [
                'hash' => 'e4d9c83',
                'date' => 'Tue Sep 1 19:59:39 2026 +0300',
                'title' => 'Adım 4: feat: flat UI tasarımı, 6 kademeli arayüz, vanilla JS fetch API ve gerçek metrikli controller eklendi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/e4d9c83',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/e4d9c83'
            ],

            [
                'hash' => '3dbbb35',
                'date' => 'Tue Sep 1 20:07:37 2026 +0300',
                'title' => 'Adım 5: fix: gereksiz claude/dfmt klasörleri git\'ten çıkarıldı ve README linkleri eklendi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/3dbbb35',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/3dbbb35'
            ],

            [
                'hash' => '263ad6e',
                'date' => 'Tue Sep 1 20:10:47 2026 +0300',
                'title' => 'Adım 6: feat: veri modelleri, yardımcı (helper) formatlayıcılar,   AJAX side-drawer endpoint\'leri ve çoklu dil (Locale) entegrasyonu   tamamlandı',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/263ad6e',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/263ad6e'
            ],

            [
                'hash' => 'f681d0a',
                'date' => 'Tue Sep 1 20:39:35 2026 +0300',
                'title' => 'Adım 7: fix: 500 error on project count, sidebar menu order, and plugin homepage link',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/f681d0a',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/f681d0a'
            ],

            [
                'hash' => '00f8e83',
                'date' => 'Tue Sep 1 21:15:34 2026 +0300',
                'title' => 'Adım 8: fix: arayuz revizyonu ve menu kancasi onarildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/00f8e83',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/00f8e83'
            ],

            [
                'hash' => 'd33d2a6',
                'date' => 'Tue Sep 1 22:13:13 2026 +0300',
                'title' => 'Adım 9: fix: çeviriler aktif edildi, JSON ayrıştırma hatası   çözüldü ve eksik rotalar kapatıldı',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/d33d2a6',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/d33d2a6'
            ],

            [
                'hash' => 'd7a66a1',
                'date' => 'Tue Sep 1 22:14:15 2026 +0300',
                'title' => 'Adım 10: fix: controller endpoints replaced with real kanboard routing',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/d7a66a1',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/d7a66a1'
            ],

            [
                'hash' => '627b568',
                'date' => 'Tue Sep 1 22:24:34 2026 +0300',
                'title' => 'Adım 11: refactor: side-drawer yerine kartların yeni browser sekmesinde (target=_blank) açılması sağlandı',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 4,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/627b568',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/627b568'
            ],

            [
                'hash' => 'c4af0ae',
                'date' => 'Tue Sep 1 22:31:49 2026 +0300',
                'title' => 'Adım 12: fix: t() çeviri fonksiyonlarındaki % formatlayıcıları   dışarı çıkarılarak ArgumentCountError (500) hatası giderildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/c4af0ae',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/c4af0ae'
            ],

            [
                'hash' => '0d25a3e',
                'date' => 'Tue Sep 1 22:32:36 2026 +0300',
                'title' => 'Adım 13: fix: sidebar içindeki user_id atamaları userSession-   >getId() ile değiştirilerek TodoNotes çakışması ve Undefined Variable   hatası onarıldı',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/0d25a3e',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/0d25a3e'
            ],

            [
                'hash' => '4f05994',
                'date' => 'Tue Sep 1 22:36:32 2026 +0300',
                'title' => 'Adım 14: fix: sidebar userSession variable scope resolved for templates',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/4f05994',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/4f05994'
            ],

            [
                'hash' => '277b673',
                'date' => 'Tue Sep 1 22:49:58 2026 +0300',
                'title' => 'Adım 15: fix: tam HTML sekmeleri (renderStandalone) ve gerçek kullanıcı eylem planı',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/277b673',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/277b673'
            ],

            [
                'hash' => 'aa5f27d',
                'date' => 'Tue Sep 1 22:50:47 2026 +0300',
                'title' => 'Adım 16: feat: AI önerileri yeni sekme açmak yerine panoya prompt kopyalayacak şekilde güncellendi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/aa5f27d',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/aa5f27d'
            ],

            [
                'hash' => 'a7fb660',
                'date' => 'Tue Sep 1 22:53:41 2026 +0300',
                'title' => 'Adım 17: docs: README güncellendi, Changelog ve standart depo politikaları (Security, Contributing, Conduct) eklendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/a7fb660',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/a7fb660'
            ],

            [
                'hash' => '35e7442',
                'date' => 'Tue Sep 1 22:54:31 2026 +0300',
                'title' => 'Adım 18: docs: README ve SECURITY genel (jenerik) hale getirildi, Forgejo klasör birleşme sorunu (.gitkeep) çözüldü',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/35e7442',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/35e7442'
            ],

            [
                'hash' => '9071fae',
                'date' => 'Tue Sep 1 23:00:27 2026 +0300',
                'title' => 'Adım 19: docs: README.md dosyasına alt doküman linkleri ve yazar (Sencar Tosun, DediTeknoloji, Bilgiyapar) bilgileri eklendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/9071fae',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/9071fae'
            ],

            [
                'hash' => 'f19ddef',
                'date' => 'Tue Sep 1 23:02:19 2026 +0300',
                'title' => 'Adım 20: feat: Controller tamamen temizlendi, gerçek veri modellerine bağlandı. Template hedef tasarıma (Görsel 3) tam uyumlu, Clear URL linkleriyle baştan yazıldı.',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/f19ddef',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/f19ddef'
            ],

            [
                'hash' => '74a65d3',
                'date' => 'Tue Sep 1 23:10:10 2026 +0300',
                'title' => 'Adım 21: fix: template userSession fatal error and project model method corrected',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/74a65d3',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/74a65d3'
            ],

            [
                'hash' => '3bf53a6',
                'date' => 'Tue Sep 1 23:13:16 2026 +0300',
                'title' => 'Adım 22: fix: ProjectModel::getActive() undefined method hatası doğrudan QueryBuilder ile değiştirilerek çözüldü',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/3bf53a6',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/3bf53a6'
            ],

            [
                'hash' => '5d21c97',
                'date' => 'Tue Sep 1 23:25:44 2026 +0300',
                'title' => 'Adım 23: fix: clear url aktif edildi, csp hatasi cozuldu ve metrik kartlari orjinal tasarima sadik kalinarak ayrildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/5d21c97',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/5d21c97'
            ],

            [
                'hash' => '1077c6e',
                'date' => 'Tue Sep 1 23:32:20 2026 +0300',
                'title' => 'Adım 24: fix: sidebar Controller not found hatası çözüldü, BudgetController action güncellendi ve dinamik bütçe hesaplaması eklendi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/1077c6e',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/1077c6e'
            ],

            [
                'hash' => '511906d',
                'date' => 'Tue Sep 1 23:33:36 2026 +0300',
                'title' => 'Adım 25: fix: Blokaj Ağacı (Blocker Tree) tasarımı orijinal mockup\'a sadık kalınarak yeniden biçimlendirildi (whitespace sorunu çözüldü)',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/511906d',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/511906d'
            ],

            [
                'hash' => '6594f9e',
                'date' => 'Tue Sep 1 23:35:39 2026 +0300',
                'title' => 'Adım 26: feat: Finans Paneli genişletilmiş mockup tasarımına uyarlandı, Relationgraph (Kritik Yol) tasarımı SVG oklarla birebir aynı hale getirildi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/6594f9e',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/6594f9e'
            ],

            [
                'hash' => '90098ad',
                'date' => 'Tue Sep 1 23:42:12 2026 +0300',
                'title' => 'Adım 27: feat: Küresel Finans sayfası eklendi (tüm projelerin bütçe kırılımları tek ekranda toplanıyor)',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/90098ad',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/90098ad'
            ],

            [
                'hash' => '0807e47',
                'date' => 'Tue Sep 1 23:44:10 2026 +0300',
                'title' => 'Adım 28: fix: Kullanıcı sayısı kutusu tıklanabilir yapıldı ve Kullanıcılar sayfasına yönlendirildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/0807e47',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/0807e47'
            ],

            [
                'hash' => '983435c',
                'date' => 'Tue Sep 1 23:45:42 2026 +0300',
                'title' => 'Adım 29: feat: Blokaj Ağacı (Blocker Tree) artık Kanboard veritabanından dinamik olarak çekiliyor ve her satır tıklanarak detay sekmesi açılıyor',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/983435c',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/983435c'
            ],

            [
                'hash' => 'eec8fe5',
                'date' => 'Tue Sep 1 23:47:02 2026 +0300',
                'title' => 'Adım 30: feat: Relationgraph (Kritik Yol) alanı gerçek verilerle birbirine bağlandı ve tıklanabilir yapıldı',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/eec8fe5',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/eec8fe5'
            ],

            [
                'hash' => 'f18e6a1',
                'date' => 'Tue Sep 1 23:53:22 2026 +0300',
                'title' => 'Adım 31: fix: Eylem Planı (Action Plan) güncellendi: \'Yönetici / Tüm Projeler\' gizlendi ve görev sınırı max 4 olarak ayarlandı',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/f18e6a1',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/f18e6a1'
            ],

            [
                'hash' => 'b2797e6',
                'date' => 'Tue Sep 1 23:56:44 2026 +0300',
                'title' => 'Adım 32: feat: Şirket Projeleri & Çevik Matrisler alanı gerçek Progress, Velocity, WIP ve Bütçe (Burn Rate) metrikleriyle güncellenip tasarıma uygun hale getirildi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/b2797e6',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/b2797e6'
            ],

            [
                'hash' => 'dd43459',
                'date' => 'Wed Sep 2 00:45:28 2026 +0300',
                'title' => 'Adım 33: feat: Kapsamlı Yönetici Mimari Planı entegre edildi. Sistem KPI Matrisi, Gecikmiş Görev Uyarıları ve Dinamik AI Önerileri eklendi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/dd43459',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/dd43459'
            ],

            [
                'hash' => '6998b47',
                'date' => 'Wed Sep 2 00:47:59 2026 +0300',
                'title' => 'Adım 34: style: Kapsamlı Sistem & Küresel KPI Matrisi 23 kartlık nötr, sade ve minimalist tasarıma geçirildi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/6998b47',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/6998b47'
            ],

            [
                'hash' => '59bf2ee',
                'date' => 'Wed Sep 2 00:49:15 2026 +0300',
                'title' => 'Adım 35: feat: KPI Eklentisi uyumlu Genel Proje Performansı, Sağlık, Skor ve Geciken Görevler kartları eklendi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/59bf2ee',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/59bf2ee'
            ],

            [
                'hash' => 'ac1edd3',
                'date' => 'Wed Sep 2 00:51:57 2026 +0300',
                'title' => 'Adım 36: fix: SQL Error 42S02 (project_has_actions) çözüldü, tüm KPI sayımları try-catch bloğuna alındı',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/ac1edd3',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/ac1edd3'
            ],

            [
                'hash' => 'e167797',
                'date' => 'Wed Sep 2 01:26:42 2026 +0300',
                'title' => 'Adım 37: fix: Eylem planı linkleri eklendi, proje metrikleri Türkçeleştirildi, gecikmiş işler araması (due:<=yesterday) düzeltildi, sağlık bildirimleri eklendi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/e167797',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/e167797'
            ],

            [
                'hash' => 'a006c91',
                'date' => 'Wed Sep 2 01:39:56 2026 +0300',
                'title' => 'Adım 38: feat: Eylem Planına Gecikenler (Alarm) sütunu eklendi, Finans şablonu formatlayıcı hataları giderildi ve son dil çevirileri tamamlandı',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/a006c91',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/a006c91'
            ],

            [
                'hash' => 'e897393',
                'date' => 'Wed Sep 2 01:49:30 2026 +0300',
                'title' => 'Adım 39: feat: Projeler DESC sıralandı ve sarmalayıcı grid yapıldı; Tüm kullanıcılar aksiyon planına dahil edildi; Görev KPI kartı Açık/Kapalı olarak ikiye ayrıldı',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/e897393',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/e897393'
            ],

            [
                'hash' => '5462664',
                'date' => 'Wed Sep 2 01:50:10 2026 +0300',
                'title' => 'Adım 40: docs: README dosyasına gerekli eklentiler (CostControl, KPI, Relationgraph) ve yükleme talimatları eklendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/5462664',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/5462664'
            ],

            [
                'hash' => '0d66772',
                'date' => 'Wed Sep 2 02:14:46 2026 +0300',
                'title' => 'Adım 41: fix: finans sarmalayicisi, gecikmis isler filtresi, cift linkli projeler ve kpi gruplamasi tamamlandi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/0d66772',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/0d66772'
            ],

            [
                'hash' => '4c96d3b',
                'date' => 'Wed Sep 2 02:55:21 2026 +0300',
                'title' => 'Adım 42: refactor: Sidebar hiyerarşisi yeniden düzenlendi, TodoNotes kancası güvenli user id ile eklendi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 4,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/4c96d3b',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/4c96d3b'
            ],

            [
                'hash' => 'daf66eb',
                'date' => 'Wed Sep 2 02:58:06 2026 +0300',
                'title' => 'Adım 43: style: Yönetici Kontrol Merkezi mobil uyumluluk (dik, yatay, likit) sorunları giderildi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/daf66eb',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/daf66eb'
            ],

            [
                'hash' => '71de767',
                'date' => 'Wed Sep 2 03:11:20 2026 +0300',
                'title' => 'Adım 44: fix: Sidebar ikonlari eklendi, KPI Matrisi gruplandirildi, Finans Sayfasi layout\'a tam oturtuldu, Blokaj sorgusu guvenli hale getirildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/71de767',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/71de767'
            ],

            [
                'hash' => '398ca95',
                'date' => 'Wed Sep 2 03:11:36 2026 +0300',
                'title' => 'Adım 45: chore: Gecici yama dosyalari temizlendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/398ca95',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/398ca95'
            ],

            [
                'hash' => '740f4b7',
                'date' => 'Wed Sep 2 03:23:40 2026 +0300',
                'title' => 'Adım 46: fix: Finans sayfasindaki PHP 8 type fatal error (string date) cozumu',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/740f4b7',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/740f4b7'
            ],

            [
                'hash' => '42b8d42',
                'date' => 'Wed Sep 2 03:25:14 2026 +0300',
                'title' => 'Adım 47: docs: README.md cift dilli (Ingilizce & Turkce) olarak detaylandirildi ve Gerekli Eklentiler eklendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/42b8d42',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/42b8d42'
            ],

            [
                'hash' => '11b9d22',
                'date' => 'Wed Sep 2 03:27:54 2026 +0300',
                'title' => 'Adım 48: docs: README.md icin vurgulu Turkce kisayolu ve guvenli anchor baglantilari eklendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/11b9d22',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/11b9d22'
            ],

            [
                'hash' => '41bbb07',
                'date' => 'Wed Sep 2 03:28:51 2026 +0300',
                'title' => 'Adım 49: docs: README icindeki gerekli eklentilere GitHub linkleri eklendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/41bbb07',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/41bbb07'
            ],

            [
                'hash' => 'a62d1d5',
                'date' => 'Wed Sep 2 03:30:13 2026 +0300',
                'title' => 'Adım 50: chore: Eklenti anasayfa URL\'si localhost\'tan GitHub\'a guncellendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/a62d1d5',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/a62d1d5'
            ],

            [
                'hash' => '5d692d3',
                'date' => 'Wed Sep 2 03:31:24 2026 +0300',
                'title' => 'Adım 51: docs: README.md icindeki tum linklerin yeni sekmede (target=_blank) acilmasi saglandi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/5d692d3',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/5d692d3'
            ],

            [
                'hash' => '56774b9',
                'date' => 'Wed Sep 2 03:36:59 2026 +0300',
                'title' => 'Adım 52: fix: Sol menu siralamasi ve ikonlar istenilen hiyerarsiye gore duzeltildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/56774b9',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/56774b9'
            ],

            [
                'hash' => 'dc34e00',
                'date' => 'Wed Sep 2 03:39:01 2026 +0300',
                'title' => 'Adım 53: style: Aktif/tiklanabilir KPI kartlari icin mavi arkaplan vurgusu ve external-link ikonu eklendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/dc34e00',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/dc34e00'
            ],

            [
                'hash' => 'd24fa6e',
                'date' => 'Wed Sep 2 03:41:02 2026 +0300',
                'title' => 'Adım 54: fix: overview.php\'deki gecikenler sutununun bos gelmesine sebep olan degisken ismi uyusmazligi giderildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/d24fa6e',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/d24fa6e'
            ],

            [
                'hash' => '4eac550',
                'date' => 'Wed Sep 2 03:46:53 2026 +0300',
                'title' => 'Adım 55: feat: Etiketler karti icin projelere ozel 44 etiketi de kapsayan yeni detay sayfasi (tags.php) eklendi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/4eac550',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/4eac550'
            ],

            [
                'hash' => 'b3781c8',
                'date' => 'Wed Sep 2 03:50:10 2026 +0300',
                'title' => 'Adım 56: fix: Geciken gorevlerin kirmizi uyari kartinda 0 gorunmesi ve Kok Neden Analizi blokajlarinin boss kalmasi hatalari giderildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/b3781c8',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/b3781c8'
            ],

            [
                'hash' => 'd78b2d7',
                'date' => 'Wed Sep 2 03:58:25 2026 +0300',
                'title' => 'Adım 57: fix: Finans zirvesi kartlarindaki statik 15000 TL degerleri kaldirildi, veritabanindan okunan gercek budget_lines toplamlarina (budget_spent) baglandi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/d78b2d7',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/d78b2d7'
            ],

            [
                'hash' => '8e13f7b',
                'date' => 'Wed Sep 2 04:02:40 2026 +0300',
                'title' => 'Adım 58: feat: Relationgraph bileseni icin Vis.js/SVG entegrasyonu tamamlandi ve etkilesimli akis semasi (node/edge) render edildi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/8e13f7b',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/8e13f7b'
            ],

            [
                'hash' => '53461e5',
                'date' => 'Wed Sep 2 04:06:48 2026 +0300',
                'title' => 'Adım 59: style: Relationgraph Vis.js rendering islemine eklenti varligi guvenlik denetimi (fallback) ve CSS disaridan cagrimi eklendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/53461e5',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/53461e5'
            ],

            [
                'hash' => '2394fe9',
                'date' => 'Wed Sep 2 04:12:38 2026 +0300',
                'title' => 'Adım 60: fix: Controller icerisindeki array tanimi sirasinda yapilan soz dizimi hatasi (syntax error) giderildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/2394fe9',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/2394fe9'
            ],

            [
                'hash' => '1d58d41',
                'date' => 'Wed Sep 2 04:16:10 2026 +0300',
                'title' => 'Adım 61: fix: Etiketler sayfasinda (tags) 500 hatasina neden olan PicoDb leftJoin tanımsiz metod (undefined method) cagrisi, dogru olan join() metodu ile degistirildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/1d58d41',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/1d58d41'
            ],

            [
                'hash' => 'f7746fb',
                'date' => 'Wed Sep 2 04:20:18 2026 +0300',
                'title' => 'Adım 62: docs: Relationgraph ve Vis.js kullanim sartlari, veritabani baglantisi aciklamalari README.md dosyasina eklendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/f7746fb',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/f7746fb'
            ],

            [
                'hash' => 'a87187b',
                'date' => 'Wed Sep 2 04:39:35 2026 +0300',
                'title' => 'Adım 63: docs: Relationgraph görev bağlantıları kurulumu ve geliştirici kod entegrasyon (getExecutiveGraphData) rehberi eklendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/a87187b',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/a87187b'
            ],

            [
                'hash' => 'c134ed3',
                'date' => 'Wed Sep 2 04:48:02 2026 +0300',
                'title' => 'Adım 64: feat: Relationgraph ag semasi tek bir gorevle veya 5 limitli blokajlarla sinirlandirilmak yerine, sirket genelindeki tum aktif gorevleri tarayip (Makro Harita) birlestirecek sekilde guncellendi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/c134ed3',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/c134ed3'
            ],

            [
                'hash' => '1c00052',
                'date' => 'Wed Sep 2 04:54:35 2026 +0300',
                'title' => 'Adım 65: fix: Tarayici guvenlik (CSP) engeline takilan dis kaynakli Vis.js kutuphanesi projeye dahil edildi (Asset/js/vis-network.min.js) ve yerel olarak yuklenmesi saglandi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/1c00052',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/1c00052'
            ],

            [
                'hash' => '57a17c8',
                'date' => 'Wed Sep 2 04:55:35 2026 +0300',
                'title' => 'Adım 66: refactor: Vis.js kutuphanesi kopyalanmak yerine, dogrudan akilli klasor tespiti (Relationgraph vs kanboard_plugin_relationgraph) ile eklentiden referans alinarak yuklenmesi saglandi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 4,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/57a17c8',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/57a17c8'
            ],

            [
                'hash' => '62bd1a6',
                'date' => 'Wed Sep 2 04:58:19 2026 +0300',
                'title' => 'Adım 67: chore: test dosyasi kaldirildi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/62bd1a6',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/62bd1a6'
            ],

            [
                'hash' => 'e00dc86',
                'date' => 'Wed Sep 2 05:06:57 2026 +0300',
                'title' => 'Adım 68: feat: Makro ag semasi icin (Vis.js) ozel navigasyon kontrolleri (Zoom In, Zoom Out, Ekrana Sigdir) ve FontAwesome UI butonlari eklendi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/e00dc86',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/e00dc86'
            ],

            [
                'hash' => 'ff77e92',
                'date' => 'Wed Sep 2 05:14:03 2026 +0300',
                'title' => 'Adım 69: fix: Vis.js ag semasinda dugumlerdeki metinlerin (text render) bozuk cikmasini engellemek adina, eksik olan orijinal vis.css stil dosyasi projeye dahil edildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/ff77e92',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/ff77e92'
            ],

            [
                'hash' => 'e57e0e4',
                'date' => 'Wed Sep 2 05:16:05 2026 +0300',
                'title' => 'Adım 70: style: Vis.js grafik motoru (physics), dugum marginleri ve canvas boyutlari (500px) orijinal GraphBuilder standartlarina cekildi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/e57e0e4',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/e57e0e4'
            ],

            [
                'hash' => 'e466bbe',
                'date' => 'Wed Sep 2 05:19:16 2026 +0300',
                'title' => 'Adım 71: fix: Relationgraph icerisindeki eski surum Vis.js tarafindan desteklenmeyen margin ve font.multi ayarlarinin konsolda hata vermesi (Unknown option) giderildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/e466bbe',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/e466bbe'
            ],

            [
                'hash' => 'f2614db',
                'date' => 'Wed Sep 2 05:20:56 2026 +0300',
                'title' => 'Adım 72: feat: Eski surum vis.js yerine, modern ve bagimsiz (standalone) vis-network.min.js kütüphanesi yerel assetlere alinarak bagimlilik ortadan kaldirildi ve modern komutlar (margin, multi) aktif edildi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/f2614db',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/f2614db'
            ],

            [
                'hash' => '815999d',
                'date' => 'Wed Sep 2 05:21:58 2026 +0300',
                'title' => 'Adım 73: fix: Modern vis-network kütüphanesine geçişte silinen CSS dosyası, modern motorla uyumlu orijinal vis-network.min.css dosyası yerel olarak projeye dahil edilerek geri getirildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/815999d',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/815999d'
            ],

            [
                'hash' => 'b511c08',
                'date' => 'Wed Sep 2 05:27:08 2026 +0300',
                'title' => 'Adım 74: fix: Relationgraph eklentisinin global olarak yukledigi eski vis.js ile modern komutlarin cakismasini onlemek adina margin ve multi argumanlari kalici olarak temizlendi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/b511c08',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/b511c08'
            ],

            [
                'hash' => 'd8aa01b',
                'date' => 'Wed Sep 2 05:55:11 2026 +0300',
                'title' => 'Adım 75: i18n: Harita navigasyon araclari (Zoom In, vb.) icin dil (locale) cevirileri TR ve EN modullerine islendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/d8aa01b',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/d8aa01b'
            ],

            [
                'hash' => '614bc7f',
                'date' => 'Wed Sep 2 05:59:11 2026 +0300',
                'title' => 'Adım 76: i18n: Executive Dashboard genelindeki (Finans, Etiketler, KPI kartlari, AI Onerileri) tum sabit kodlu Turkce metinler coklu dil (t) fonksiyonu icine alindi ve tr_TR ile en_EN sozluklerine islendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/614bc7f',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/614bc7f'
            ],

            [
                'hash' => '17ebcc6',
                'date' => 'Wed Sep 2 06:03:36 2026 +0300',
                'title' => 'Adım 77: feat: Genisletilmis Fonlama & Gelir hucresindeki gorsel (mockup) statik veriler gercek veritabanina baglandi (tasks tablosu uzerinden dinamik veri cekiliyor)',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/17ebcc6',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/17ebcc6'
            ],

            [
                'hash' => '98ff85e',
                'date' => 'Wed Sep 2 06:04:36 2026 +0300',
                'title' => 'Adım 78: chore: Gecici test dosyalari silindi ve Vis.js kenar (edge) cizim motoru coklu baglantilarin (ayni gorevler arasindaki farkli iliskiler) ust uste binmemesi icin \'dynamic\' moduna alindi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/98ff85e',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/98ff85e'
            ],

            [
                'hash' => 'c86e0a4',
                'date' => 'Wed Sep 2 06:13:34 2026 +0300',
                'title' => 'Adım 79: fix: translations.php icerisindeki otomatik script kokenli fazladan virgul (Cannot use empty array elements in arrays) cozumuyle 500 hatasi giderildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/c86e0a4',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/c86e0a4'
            ],

            [
                'hash' => '459d43b',
                'date' => 'Wed Sep 2 06:19:03 2026 +0300',
                'title' => 'Adım 80: fix: Kanboard t() fonksiyonunun kendi icinde arguman (sprintf) yonetimi yapmasi nedeniyle olusan ArgumentCountError (500) hatasi giderildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/459d43b',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/459d43b'
            ],

            [
                'hash' => '3cf192e',
                'date' => 'Wed Sep 2 06:21:52 2026 +0300',
                'title' => 'Adım 81: fix: overview.php icerisindeki echo blogunda yanlis konumlandirilmis translation kisaltmasi (PHP Parse error: unexpected identifier) duzeltildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/3cf192e',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/3cf192e'
            ],

            [
                'hash' => '1cd9cf8',
                'date' => 'Wed Sep 2 06:25:04 2026 +0300',
                'title' => 'Adım 82: fix: tags.php icerisindeki PHP ternary operatoru icine yanlis enjekte edilen translation (PHP Parse error: unexpected identifier) duzeltildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/1cd9cf8',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/1cd9cf8'
            ],

            [
                'hash' => 'e598c9b',
                'date' => 'Wed Sep 2 15:51:06 2026 +0300',
                'title' => 'Adım 83: fix: vis.js kutuphanesi gec veya hatali yuklendiginde sayfa scriptlerinin cokmesini (vis is not defined) engellemek icin typeof kontrolu eklendi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/e598c9b',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/e598c9b'
            ],

            [
                'hash' => 'cb53e3b',
                'date' => 'Wed Sep 2 18:12:20 2026 +0300',
                'title' => 'Adım 84: feat: Yonetici Kontrol Merkezi (MCC) ust menu (page-header) kismina eklendi, sidebar yapisindaki agresif ezme (order:1) komutlari kaldirilarak Kanboard\'un dogal kanca (hook) hiyerarsisine birakildi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/cb53e3b',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/cb53e3b'
            ],

            [
                'hash' => 'a941b80',
                'date' => 'Wed Sep 2 18:22:48 2026 +0300',
                'title' => 'Adım 85: fix: AgileIndicators ve benzeri eklentilerin alfabetik sira yuzunden mcc\'nin ustune cikmasini engellemek amaciyla js order kilidi eklendi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/a941b80',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/a941b80'
            ],

            [
                'hash' => '037358f',
                'date' => 'Wed Sep 2 18:26:37 2026 +0300',
                'title' => 'Adım 86: fix: JS based sidebar ordering failed on some environments, replaced with robust CSS Flexbox ordering',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/037358f',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/037358f'
            ],

            [
                'hash' => '13575fc',
                'date' => 'Wed Sep 2 18:48:16 2026 +0300',
                'title' => 'Adım 87: fix: Sol menudeki bold vurgu (strong) iptal edildi ve tema/cache bagimsiz anlik isleyen Javascript (IIFE) ile AgileIndicators alt siraya dogal yoldan itildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/13575fc',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/13575fc'
            ],

            [
                'hash' => '3130943',
                'date' => 'Wed Sep 2 19:13:44 2026 +0300',
                'title' => 'Adım 88: fix: Ust acilir menu ve sol menudeki active bold (kalin) font stili ezildi, TodoNotes ve AgileIndicators eklentilerine karsi evrensel JS siralayici (MCC > Notlarim > AgileIndicators) eklendi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/3130943',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/3130943'
            ],

            [
                'hash' => 'eb94986',
                'date' => 'Wed Sep 2 19:35:23 2026 +0300',
                'title' => 'Adım 89: fix: Siralama scripti dil bagimsiz URL (innerHTML) taramasina gecirildi ve dropdown aktif font (bold) iptali icin agresif JS inline CSS eklendi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/eb94986',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/eb94986'
            ],

            [
                'hash' => '100ff58',
                'date' => 'Thu Sep 3 00:21:46 2026 +0300',
                'title' => 'Adım 90: feat(mcc): Executive Dashboard Executive Suite & Agile Metrics Upgrade',
                'desc' => '- Refactor ExecutiveDashboardController to support Agile (Complexity/Priority-based) scoring and weighted progress tracking.\n- Fix finance budget logic: separate allocated budget pools (budget_lines) from actual operational costs (subtask_time_tracking).\n- Fix project budget URL routing using clean paths (/project/{id}/budget) to resolve controller errors.\n- Add comprehensive sub-dashboard views (performance, health, score, finance, external_links, actions, etc.) with tabbed and filtered UI components.\n- Standardize all task count and point displays to uniform \'Points / Tasks\' format.',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/100ff58',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/100ff58'
            ],

            [
                'hash' => '75c19a4',
                'date' => 'Fri Sep 11 15:32:26 2026 +0300',
                'title' => 'Adım 91: fix: Baglanti Etiketleri (linkLabels) sayfasindaki bos liste hatasi (PicoDb PDOException) duzeltildi ve MCC panosuna URL baglantisi eklendi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/75c19a4',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/75c19a4'
            ],

            [
                'hash' => 'cc16b59',
                'date' => 'Fri Sep 11 15:35:02 2026 +0300',
                'title' => 'Adım 92: feat: Kontrol Merkezine Don (Back) yuzen butonu tum eklenti alt sayfalarina eklendi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/cc16b59',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/cc16b59'
            ],

            [
                'hash' => '025af64',
                'date' => 'Fri Sep 11 15:37:14 2026 +0300',
                'title' => 'Adım 93: style: Kritik Metrikler Kullanici karti etiketi \'Aktif Kullanici\' olarak guncellendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/025af64',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/025af64'
            ],

            [
                'hash' => 'cdda074',
                'date' => 'Fri Sep 11 15:40:57 2026 +0300',
                'title' => 'Adım 94: fix: Alt kullanici rol kartlarindaki yaniltici yonlendirme baglantilari (URL) kaldirildi ve sadece bilgi kutusuna donusturuldu',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/cdda074',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/cdda074'
            ],

            [
                'hash' => '80de9ae',
                'date' => 'Fri Sep 11 15:46:33 2026 +0300',
                'title' => 'Adım 95: feat: Sistem Yoneticileri kartina tiklanabilirlik (UserList) linki geri eklendi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/80de9ae',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/80de9ae'
            ],

            [
                'hash' => 'c836102',
                'date' => 'Fri Sep 11 15:57:37 2026 +0300',
                'title' => 'Adım 96: feat: Performans, Saglik ve Skor KPI kartlarina URL yonlendirmeleri geri eklendi; 0 degeri olanlarda link deaktif edildi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/c836102',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/c836102'
            ],

            [
                'hash' => '65ac994',
                'date' => 'Fri Sep 11 16:05:11 2026 +0300',
                'title' => 'Adım 97: feat: Yorumlar, Ekler, Kategoriler vb. tum ikincil KPI kartlari (degeri 0\'dan buyuk olma sartiyla) tekrar tiklanabilir hale getirildi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/65ac994',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/65ac994'
            ],

            [
                'hash' => '624e3ee',
                'date' => 'Fri Sep 11 16:14:44 2026 +0300',
                'title' => 'Adım 98: fix: Relationgraph gorunurluk sarti blocker_links yerine tekrar graph_nodes olarak duzeltilerek grafik geri getirildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/624e3ee',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/624e3ee'
            ],

            [
                'hash' => '0219f41',
                'date' => 'Fri Sep 11 16:25:40 2026 +0300',
                'title' => 'Adım 99: fix: Relationgraph konteynerinin yukseklik (height: 350px) stili geri eklendi, boylece grafik tekrar gorunur hale geldi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/0219f41',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/0219f41'
            ],

            [
                'hash' => 'eca84e1',
                'date' => 'Fri Sep 11 16:29:08 2026 +0300',
                'title' => 'Adım 100: fix: Relationgraph CSP hatasi duzeltildi, vis-network kütüphanesi yerel (local) Asset klasorunden yukleniyor',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/eca84e1',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/eca84e1'
            ],

            [
                'hash' => 'b4793db',
                'date' => 'Fri Sep 11 16:31:43 2026 +0300',
                'title' => 'Adım 101: fix: Relationgraph icin ozel zoom butonlari (navigasyon) ve renkleri saglayan vis-network CSS dosyasi geri eklendi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/b4793db',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/b4793db'
            ],

            [
                'hash' => '6ef3ecb',
                'date' => 'Fri Sep 11 16:35:28 2026 +0300',
                'title' => 'Adım 102: refactor: vis-network kutuphanesi kendi eklentimizden kaldirildi, README\'de tavsiye edilen kanboard_plugin_relationgraph icindeki orijinal dosyalara baglandi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 4,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/6ef3ecb',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/6ef3ecb'
            ],

            [
                'hash' => '7f177c6',
                'date' => 'Fri Sep 11 17:03:36 2026 +0300',
                'title' => 'Adım 103: docs/feat: README\'den hatali kod guncelleme bolumu cikarildi, KPI aciklamalari eklendi, overview.php\'deki tum KPI kartlari coklu dil (t()) uyumlu hale getirilip tr_TR ve en_EN cevirileri tamamlandi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/7f177c6',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/7f177c6'
            ],

            [
                'hash' => '57e1cac',
                'date' => 'Fri Sep 11 17:06:42 2026 +0300',
                'title' => 'Adım 104: feat: Gerekli eklentiler (CostControl, KPI, Relationgraph) eksik oldugunda ilgili bolumlerde uyari gosterilmesi saglandi; vis.js grafik yazilarinin okunabilirligi icin font rengi siyaha cevrildi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/57e1cac',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/57e1cac'
            ],

            [
                'hash' => 'c426586',
                'date' => 'Fri Sep 11 17:12:10 2026 +0300',
                'title' => 'Adım 105: style: score.php sayfasindaki cift olan eski statik \'Kontrol Merkezine Don\' butonu kaldirildi, yalnizca yeni yuzen(floating) buton birakildi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/c426586',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/c426586'
            ],

            [
                'hash' => 'f52b445',
                'date' => 'Mon Sep 14 14:20:01 2026 +0300',
                'title' => 'Adım 106: docs: son yapilan butun UI, CSP, Relationgraph ve coklu dil (t()) guncellemeleri CHANGELOG.md dosyasina eklendi',
                'desc' => '',
                'color' => 'green',
                'priority' => 1,
                'score' => 3,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/f52b445',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/f52b445'
            ],

            [
                'hash' => '4efaec8',
                'date' => 'Mon Sep 14 14:41:02 2026 +0300',
                'title' => 'Adım 107: feat: MCP api task_creation \'user_id\' hook bug\'ini asmak uzere guvenli / gizli Proje Canlandirma (DemoImport) controller\'i eklendi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/4efaec8',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/4efaec8'
            ],

            [
                'hash' => 'ac21695',
                'date' => 'Mon Sep 14 14:49:35 2026 +0300',
                'title' => 'Adım 108: fix: uzak sunucudaki \'user_id doesn\'t have a default value\' hatasini engellemek icin task ve subtask payloadlarina \'user_id\' eklendi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/ac21695',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/ac21695'
            ],

            [
                'hash' => '8196986',
                'date' => 'Mon Sep 14 14:51:43 2026 +0300',
                'title' => 'Adım 109: feat: DemoImportController her calistirildiginda eski/kopya gorevleri silip panoyu temizleyen (idempotent) ozellik eklendi',
                'desc' => '',
                'color' => 'blue',
                'priority' => 2,
                'score' => 5,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/8196986',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/8196986'
            ],

            [
                'hash' => 'c63546e',
                'date' => 'Mon Sep 14 14:54:19 2026 +0300',
                'title' => 'Adım 110: fix: tasks tablosunda user_id bulunmadigi icin \'unknown column\' hatasini cozmek amaciyla gorev olusturma kismindan user_id kaldirildi, yalnizca alt gorevlerde birakildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/c63546e',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/c63546e'
            ],

            [
                'hash' => 'f32a753',
                'date' => 'Mon Sep 14 14:58:29 2026 +0300',
                'title' => 'Adım 111: fix: uzak sunucudaki inatci \'user_id\' eklenti/veritabani kancalarini tamamen atlatmak amaciyla DemoImportController Kanboard Modelleri yerine dogrudan RAW SQL Insert (PDO) kullanacak sekilde guncellendi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/f32a753',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/f32a753'
            ],

            [
                'hash' => 'a158321',
                'date' => 'Mon Sep 14 15:05:01 2026 +0300',
                'title' => 'Adım 112: fix: swimlane_id default deger hatasini cozmek icin Kanboard\'un orijinal TaskCreationModel sinifina geri donuldu, user_id yalnizca subtasks modelinde birakilarak DB sorunlari kokten cozuldu',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/a158321',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/a158321'
            ],

            [
                'hash' => 'b7d1e70',
                'date' => 'Mon Sep 14 15:07:57 2026 +0300',
                'title' => 'Adım 113: fix: RAW SQL enjeksiyonunda MySQL strict modu asmak icin swimlane_id=0 ve category_id=0 varsayilan degerleri manuel olarak eklendi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/b7d1e70',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/b7d1e70'
            ],

            [
                'hash' => 'e049c6a',
                'date' => 'Mon Sep 14 15:11:30 2026 +0300',
                'title' => 'Adım 114: fix: uzak sunucudaki eklentilerin ekledigi (due_description vb.) tum alanlarin eksik varsayilan (default) hatalarini engellemek icin MySQL strict modu devredisi birakildi ve tekrar Kanboard Model yapisina donuldu',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/e049c6a',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/e049c6a'
            ],

            [
                'hash' => '7880b98',
                'date' => 'Mon Sep 14 15:32:08 2026 +0300',
                'title' => 'Adım 115: feat: Kanboard tarihsel simulasyonu, gercek efor/kriz metrikleri ve GitHub commit baglantilari iceren 21 adimlik \'%100 kapali\' SDLC (Master Simulation) formatina yukseltildi',
                'desc' => '',
                'color' => 'red',
                'priority' => 3,
                'score' => 8,
                'forgejo' => 'http://localhost:3010/sencarto/ExecutiveDashboard-plugin-kanboard/commit/7880b98',
                'github' => 'https://github.com/siberaktif/ExecutiveDashboard-plugin-kanboard/commit/7880b98'
            ]
        ];

        $previous_task_id = 0;
        $current_time = $base_time;
        $count = 0;

        foreach ($history as $index => $step) {
            $step_number = $index + 1;
            
            $task_start = $current_time;
            $task_end = $current_time + (4 * 3600);
            $current_time = $task_end + 86400;

            $full_desc = "**Otantik Forgejo Tarihçesi**\n\n" . $step['desc'] . "\n\n* Commit: " . $step['hash'] . "\n* Date: " . $step['date'];

            // Görev Oluştur
            $task_id = $this->taskCreationModel->create([
                'project_id' => $project_id,
                'title' => $step['title'],
                'description' => $full_desc,
                'column_id' => $done_column_id,
                'owner_id' => $user_id,
                'creator_id' => $user_id,
                'color_id' => $step['color'],
                'score' => $step['score'],
                'priority' => $step['priority'],
                'time_estimated' => 4,
                'time_spent' => 4,
                'date_creation' => $task_start,
                'date_started' => $task_start,
                'date_completed' => $task_end,
                'date_due' => $task_end
            ]);

            if ($task_id) {
                $count++;
                // Görevi Kapat (is_active = 0)
                $this->taskStatusModel->close($task_id);

                // Alt Görev Ekle
                $this->subtaskModel->create([
                    'task_id' => $task_id, 
                    'title' => 'Değişiklikler incelendi ve test edildi.', 
                    'status' => SubtaskModel::STATUS_DONE, 
                    'time_estimated'=> 4, 
                    'time_spent'=> 4, 
                    'user_id' => $user_id
                ]);

                // Harici GitHub/Forgejo Linki Ekle
                $this->taskExternalLinkModel->create([
                    'task_id' => $task_id,
                    'creator_id' => $user_id,
                    'link_type' => 'weblink',
                    'dependency' => 'related',
                    'title' => 'Forgejo: ' . $step['hash'],
                    'url' => $step['forgejo']
                ]);
                
                $this->taskExternalLinkModel->create([
                    'task_id' => $task_id,
                    'creator_id' => $user_id,
                    'link_type' => 'weblink',
                    'dependency' => 'related',
                    'title' => 'GitHub: ' . $step['hash'],
                    'url' => $step['github']
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
        echo "<p>Tam " . $count . " Adımlık geliştirme serüveni (krizler, çözümler, commitler) %100 kapalı, bitiş tarihli ve dış bağlantılı şekilde Kanboard'a aktarıldı.</p>";
        echo "<p><a href='/?controller=BoardViewController&action=show&project_id=".$project_id."' style='padding:10px 20px; background:#007bff; color:#fff; text-decoration:none; border-radius:5px;'>Otantik Proje Panosunu Görüntüle</a></p>";
        echo "</div>";
    }
}
