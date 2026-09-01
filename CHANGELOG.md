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
