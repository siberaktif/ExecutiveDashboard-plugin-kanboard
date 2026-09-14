# Değişim Günlüğü (Changelog)

Bu dosyada Kanboard Executive Dashboard eklentisindeki tüm önemli değişiklikler belgelenmektedir.

## [Unreleased] - Sürüm Adayı (v1.0.0)

### Eklenenler
- "Yönetici Kontrol Merkezi" ana panosu oluşturuldu.
- Kanboard sol menüsüne (sidebar) CSS order mimarisiyle en üste özel menü linki eklendi (TodoNotes çakışması çözüldü).
- CSS Grid yapıları ile 6 ana bölüm (Finans, Blokaj, Relationgraph, Eylem Planı, Projeler, AI) eklendi.
- Küresel Nakit Yakım Hızı için dinamik CSS tabanlı Donut Chart tasarımı geliştirildi.
- "Zaman Sınırlı Eylem Planı"na gerçek zamanlı Kanboard veritabanı kullanıcı eşleşmesi sağlandı; görevler `date_due` (bitiş tarihi) filtrelerine göre (Bugün, Bu Hafta, Bu Ay) kartlara yansıtıldı.
- AI Destekli Operasyonel Öneriler modülüne "Pano'ya Prompt Kopyalama" özelliği getirildi.
- Eklentinin sağ sekme (side-drawer) karmaşası iptal edilip doğrudan hızlı, yeni sekmeli HTML (standalone) kart raporlama yapısı kuruldu.
- PHP `sprintf` kaynaklı `Translator.php:68 ArgumentCountError (500)` hatası çözüldü ve çeviriler aktifleştirildi.

### Düzenlenenler ve İyileştirmeler (Son Güncellemeler)
- **Güvenlik (CSP):** Kanboard'ın katı CSP kısıtlamalarına takılan harici CDN (unpkg) kullanımı kaldırılarak, `Relationgraph` eklentisindeki yerel Vis.js kütüphanesine doğrudan referans verildi.
- **Navigasyon:** 14 alt sayfanın tamamı için evrensel ve yüzer (floating) bir "Kontrol Merkezine Dön" butonu (`back_button.php`) oluşturuldu. Çift (kopya) geri dön butonları temizlendi.
- **Grafik Motoru (Relationgraph):** Kapsayıcı `height` hatası düzeltildi (grafiğin 0px'e çökme problemi). Düğüm yazılarının okunabilirliğini artırmak için font rengi beyaza (`#ffffff`) yerine koyu gri/siyaha (`#333333`) çevrildi.
- **UI/UX Geliştirmeleri:** Değeri "0" olan KPI kartlarının tıklanabilir URL özellikleri devre dışı bırakıldı. Yönetici kartlarındaki yanıltıcı URL bağlantıları temizlendi.
- **Uyarı Sistemi:** `CostControl`, `KPI` ve `Relationgraph` gibi zorunlu eklentiler sunucuda yoksa veya eksikse, panoda ilgili blokların tam üzerine dinamik sarı uyarı mesajları (banner) yerleştirildi.
- **Çoklu Dil Desteği:** `overview.php` içindeki 37'den fazla sabit Türkçe metin `t()` fonksiyonu ile çoklu dil yapısına sarmalandı. Hem `tr_TR` hem de `en_EN` dil dosyalarındaki eksik çeviriler tamamlandı.
- **Dokümantasyon:** `README.md` dosyasındaki yanıltıcı/hatalı Kanboard çekirdek kod entegrasyonu bölümü tamamen silindi ve KPI kartlarının detaylı işlev açıklamaları eklendi.
