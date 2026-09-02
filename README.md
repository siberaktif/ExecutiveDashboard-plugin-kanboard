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

1. **[CostControl](https://github.com/aljawaid/CostControl/blob/master/README.md)**: Mandatory for the Global Finance Page (`/mcc/finance`), Burn Rate calculations, and realized expenditure data.
2. **[KPI](https://github.com/rmsbal/kpi/blob/main/README.md)**: Required for routing and displaying Global Project Performance, System Health, Overall Score, and Overdue Tasks modules.
3. **[Relationgraph](https://github.com/TimoStahl/kanboard_plugin_relationgraph) (Optional)**: Recommended for better visual mapping of task dependencies and Critical Path analysis.

**How to Install (Shortcut):**
- In Kanboard, go to the top right menu and select **Plugins > Plugin Directory**.
- Type the plugin names in the search box and click the **Install** button to load them with a single click.

### Compatibility
- Requires Kanboard version >= 1.2.20
- Compatible with all standard Kanboard themes (integrates seamlessly without overriding core CSS globally).

### Documentation & Repository Guidelines
- [CHANGELOG.md](CHANGELOG.md) - History of releases, new features, and bug fixes.
- [CONTRIBUTING.md](CONTRIBUTING.md) - Guidelines for developers.
- [SECURITY.md](SECURITY.md) - Security policies.
- [CODE_OF_CONDUCT.md](CODE_OF_CONDUCT.md) - Behavioral standards.

### Author & Credits
Created and maintained by:
- **Sencar Tosun**
- [DediTeknoloji.com](https://dediteknoloji.com)
- [Bilgiyapar.com](https://bilgiyapar.com)

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

1. **[CostControl](https://github.com/aljawaid/CostControl/blob/master/README.md)**: Küresel Finans Sayfası (`/mcc/finance`), Bütçe Kullanımı (Burn Rate) hesaplamaları ve gerçekleşen harcama verileri için zorunludur.
2. **[KPI](https://github.com/rmsbal/kpi/blob/main/README.md)**: Genel Proje Performansı, Sistem Sağlığı, Genel Skor ve Geciken İşler (Overdue Tasks) modüllerinin yönlendirmeleri için gereklidir.
3. **[Relationgraph](https://github.com/TimoStahl/kanboard_plugin_relationgraph) (Opsiyonel)**: Görev bağımlılıkları ve Kritik Yol analizlerinin görsel olarak daha iyi çizilebilmesi için tavsiye edilir.

**Nasıl Yüklenir? (Kısayol)**
- Kanboard sağ üst menüden **Eklentiler (Plugins) > Eklenti Dizini (Plugin Directory)** yolunu izleyin.
- Arama kutusuna eklenti isimlerini yazıp **Kur (Install)** butonuna basarak tek tıkla yükleyebilirsiniz.

### Uyumluluk
- Kanboard sürümü >= 1.2.20 gerektirir.
- Tüm standart Kanboard temalarıyla uyumludur (çekirdek CSS'i global olarak bozmadan entegre olur).

### Dökümantasyon ve Depo Kuralları
- [CHANGELOG.md](CHANGELOG.md) - Sürüm geçmişi, yeni özellikler ve hata düzeltmeleri.
- [CONTRIBUTING.md](CONTRIBUTING.md) - Geliştiriciler için katkıda bulunma rehberi.
- [SECURITY.md](SECURITY.md) - Güvenlik politikalarımız.
- [CODE_OF_CONDUCT.md](CODE_OF_CONDUCT.md) - Davranış kuralları.

### Yazar & Katkıda Bulunanlar
Oluşturan ve geliştiren:
- **Sencar Tosun**
- [DediTeknoloji.com](https://dediteknoloji.com)
- [Bilgiyapar.com](https://bilgiyapar.com)
