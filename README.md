# Kanboard Executive Dashboard Plugin

**[🇹🇷 Türkçe Sürüm İçin Tıklayın (Click for Turkish Version)](#turkish)** | **[🇬🇧 English Version](#english)**

---

<a id="english"></a>
## 🇬🇧 English Version

This plugin transforms your Kanboard interface into a strategic, high-level executive dashboard. Designed specifically for C-level executives, project managers, and team leaders, it provides a bird's-eye view of all critical operations, financial metrics, and bottlenecks across your organization.

### Screenshot
<!-- Place your screenshot image in the repository as screenshot.jpg -->
![Executive Dashboard Screenshot](screenshot.jpg)

### Features
- **Finance & Strategy Panel:** Track global burn rates and overall performance metrics dynamically.
- **Critical Blockers:** Identify blocked tasks and visualize bottlenecks using a clear, hierarchical tree structure.
- **Dependencies & Critical Path:** Access structural node graphs mapping out cross-project dependencies.
- **Time-Boxed Action Plan:** A robust 4-column grid displaying tasks assigned to users for Today (P1), This Week, and This Month. Automatically pulls real data from active users.
- **Company Projects Matrix:** Monitor active project Velocity scores and Work-in-Progress (WIP) limit alerts.
- **AI-Assisted Operational Recommendations:** Actionable insights with one-click "Copy Prompt" functionality to easily delegate tasks or request detailed financial reports.

### Installation
1. Clone this repository or download the ZIP file.
2. Rename the extracted folder to `ExecutiveDashboard`.
3. Move the `ExecutiveDashboard` folder into your Kanboard `plugins/` directory.
4. Restart your server or refresh the Kanboard page. You will see the new **Manager Control Center** link in the sidebar.

### Required Plugins
To ensure the Executive Dashboard works flawlessly with all its features, the following Kanboard plugins must be installed:

1. **<a href="https://github.com/aljawaid/CostControl/blob/master/README.md" target="_blank">CostControl</a>**: Mandatory for the Global Finance Page (`/mcc/finance`), Burn Rate calculations, and realized expenditure data.
2. **<a href="https://github.com/rmsbal/kpi/blob/main/README.md" target="_blank">KPI</a>**: Required for routing and displaying Global Project Performance, System Health, Overall Score, and Overdue Tasks modules.
3. **<a href="https://github.com/TimoStahl/kanboard_plugin_relationgraph" target="_blank">Relationgraph</a> (Optional)**: Recommended for better visual mapping of task dependencies and Critical Path analysis.

**How to Install (Shortcut):**
- In Kanboard, go to the top right menu and select **Plugins > Plugin Directory**.
- Type the plugin names in the search box and click the **Install** button to load them with a single click.

### Relationgraph (Critical Path) Configuration & Requirements
For the interactive Vis.js SVG Network Graph to render on the Executive Dashboard, two operational requirements must be met. If they are not met, the system will safely fallback to a standard textual list view.

1. **Relationgraph Plugin (JavaScript Engine):**
   - **Status:** The UI container `<div id="mcc-relationgraph-container"></div>` relies on the Vis.js library. The official Relationgraph plugin provides these core libraries. If the plugin folder (`plugins/Relationgraph`) is not physically present, the graphical engine cannot be triggered.
2. **Active Task Links in Database (`task_has_links`):**
   - **Status:** If there are no `is blocked by` or `blocks` task relations defined across your projects, the map will not find any nodes to draw.
   - **Solution:** Navigate to any task, add an internal Kanboard link specifying that it "blocks" or "is blocked by" another task to test the rendering.

**Summary:** Ensure the Relationgraph plugin is installed and that you have at least one active blocker relation in your tasks. Once both conditions are met, the SVG network schema will automatically populate the container.

### Compatibility
- Requires Kanboard version >= 1.2.20
- Compatible with all standard Kanboard themes (integrates seamlessly without overriding core CSS globally).

### Documentation & Repository Guidelines
- <a href="CHANGELOG.md" target="_blank">CHANGELOG.md</a> - History of releases, new features, and bug fixes.
- <a href="CONTRIBUTING.md" target="_blank">CONTRIBUTING.md</a> - Guidelines for developers.
- <a href="SECURITY.md" target="_blank">SECURITY.md</a> - Security policies.
- <a href="CODE_OF_CONDUCT.md" target="_blank">CODE_OF_CONDUCT.md</a> - Behavioral standards.

### Author & Credits
Created and maintained by:
- **Sencar Tosun**
- <a href="https://dediteknoloji.com" target="_blank">DediTeknoloji.com</a>
- <a href="https://bilgiyapar.com" target="_blank">Bilgiyapar.com</a>

---

<a id="turkish"></a>
## 🇹🇷 Türkçe Sürüm

Bu eklenti, Kanboard arayüzünüzü stratejik, üst düzey bir yönetici kontrol merkezine dönüştürür. Özellikle C-Level yöneticiler, proje yöneticileri ve takım liderleri için tasarlanmış olup, kuruluşunuzdaki tüm kritik operasyonların, finansal metriklerin ve darboğazların kuş bakışı görünümünü sunar.

### Ekran Görüntüsü
<!-- Ekran görüntünüzü screenshot.jpg adıyla depoya yükleyin -->
![Yönetici Kontrol Merkezi Ekran Görüntüsü](screenshot.jpg)

### Özellikler
- **Finans ve Strateji Paneli:** Küresel bütçe kullanım hızlarını ve genel performans metriklerini dinamik olarak izleyin.
- **Kritik Blokajlar:** Bloke olmuş görevleri tespit edin ve darboğazları net, hiyerarşik bir ağaç yapısıyla görselleştirin.
- **Görev Bağımlılıkları ve Kritik Yol:** Projeler arası bağımlılıkları haritalayan yapısal düğüm (node) grafiklerine erişin.
- **Zaman Sınırlı Eylem Planı:** Bugün (P1), Bu Hafta ve Bu Ay için kullanıcılara atanan görevleri gösteren güçlü 4 sütunlu matris. Aktif kullanıcılardan gerçek verileri otomatik olarak çeker.
- **Şirket Projeleri Matrisi:** Aktif projelerin Üretim Hızı (Velocity) skorlarını ve Devam Eden İş (WIP) limiti uyarılarını izleyin.
- **Yapay Zeka Destekli Operasyonel Öneriler:** Tek tıkla "Kopyala" özelliğine sahip uygulanabilir içgörüler ile görevleri kolayca delege edin veya detaylı finansal raporlar talep edin.

### Kurulum
1. Bu depoyu (repository) klonlayın veya ZIP dosyası olarak indirin.
2. Çıkarılan klasörün adını `ExecutiveDashboard` olarak değiştirin.
3. `ExecutiveDashboard` klasörünü Kanboard `plugins/` dizininizin içine taşıyın.
4. Sunucunuzu yeniden başlatın veya Kanboard sayfasını yenileyin. Sol menüde yeni **Yönetici Kontrol Merkezi** bağlantısını göreceksiniz.

### Gerekli Eklentiler (Required Plugins)
Bu eklentinin (Executive Dashboard) tüm fonksiyonlarıyla kusursuz çalışabilmesi için aşağıdaki Kanboard eklentilerinin sistemde kurulu olması gerekmektedir:

1. **<a href="https://github.com/aljawaid/CostControl/blob/master/README.md" target="_blank">CostControl</a>**: Küresel Finans Sayfası (`/mcc/finance`), Bütçe Kullanımı (Burn Rate) hesaplamaları ve gerçekleşen harcama verileri için zorunludur.
2. **<a href="https://github.com/rmsbal/kpi/blob/main/README.md" target="_blank">KPI</a>**: Genel Proje Performansı, Sistem Sağlığı, Genel Skor ve Geciken İşler (Overdue Tasks) modüllerinin yönlendirmeleri için gereklidir.
3. **<a href="https://github.com/TimoStahl/kanboard_plugin_relationgraph" target="_blank">Relationgraph</a> (Opsiyonel)**: Görev bağımlılıkları ve Kritik Yol analizlerinin görsel olarak daha iyi çizilebilmesi için tavsiye edilir.

**Nasıl Yüklenir? (Kısayol)**
- Kanboard sağ üst menüden **Eklentiler (Plugins) > Eklenti Dizini (Plugin Directory)** yolunu izleyin.
- Arama kutusuna eklenti isimlerini yazıp **Kur (Install)** butonuna basarak tek tıkla yükleyebilirsiniz.

### Relationgraph (Kritik Yol) Yapılandırma ve Çalışma Şartları
Yönetici Kontrol Merkezi ana sayfasında Relationgraph (SVG Ağ Şeması) kutusunun etkileşimli (Vis.js) olarak çizilebilmesi için iki teknik şartın sağlanması gerekir. Eğer bu şartlar sağlanmazsa, sistem çökmez; ancak harita yerine eski tip metinsel liste görünümü aktif kalır.

1. **Relationgraph Eklentisi (JavaScript Motoru):**
   - **Durum:** Arayüzdeki `<div id="mcc-relationgraph-container"></div>` alanına grafiğin basılabilmesi için tarayıcının Vis.js kütüphanesini yüklemiş olması gerekir. Relationgraph eklentisi bu kütüphaneyi klasör yapısında barındırır. Eklenti sistemde klasör olarak (`plugins/Relationgraph`) bulunmuyorsa grafik motoru tetiklenemez.
2. **Veritabanında Aktif Görev Bağı (`task_has_links`) Olması:**
   - **Durum:** Eğer sistemdeki görevler arasında `is blocked by` veya `blocks` türünde bir ilişki tanımlanmamışsa, harita çizilecek düğüm bulamayacağı için alan boş kalır.
   - **Çözüm:** Herhangi bir görevin detayına girip başka bir görevi "Engelliyor" (blocks) veya "Tarafından engelleniyor" (is blocked by) şeklinde bağlayarak haritayı test edebilirsiniz.

**Özet Kontrol:** Yönetici Kontrol Merkezi ana sayfasında Relationgraph kutusunun görünmesi için öncelikle Relationgraph eklentisinin eklentiler sayfasından kurulu ve aktif olduğundan ve projelerinizde en az bir adet görev bağı (bağlantısı) bulunduğundan emin olun. Bu iki şart sağlandığında SVG ağ şeması otomatik olarak kutunun içine oturacaktır.

### Uyumluluk
- Kanboard sürümü >= 1.2.20 gerektirir.
- Tüm standart Kanboard temalarıyla uyumludur (çekirdek CSS'i global olarak bozmadan entegre olur).

### Dökümantasyon ve Depo Kuralları
- <a href="CHANGELOG.md" target="_blank">CHANGELOG.md</a> - Sürüm geçmişi, yeni özellikler ve hata düzeltmeleri.
- <a href="CONTRIBUTING.md" target="_blank">CONTRIBUTING.md</a> - Geliştiriciler için katkıda bulunma rehberi.
- <a href="SECURITY.md" target="_blank">SECURITY.md</a> - Güvenlik politikalarımız.
- <a href="CODE_OF_CONDUCT.md" target="_blank">CODE_OF_CONDUCT.md</a> - Davranış kuralları.

### Yazar & Katkıda Bulunanlar
Oluşturan ve geliştiren:
- **Sencar Tosun**
- <a href="https://dediteknoloji.com" target="_blank">DediTeknoloji.com</a>
- <a href="https://bilgiyapar.com" target="_blank">Bilgiyapar.com</a>
