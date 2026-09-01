# Kanboard Executive Dashboard Plugin

This plugin transforms your Kanboard interface into a strategic, high-level executive dashboard. Designed specifically for C-level executives, project managers, and team leaders, it provides a bird's-eye view of all critical operations, financial metrics, and bottlenecks across your organization.

## Screenshot
<!-- Place your screenshot image in the repository as screenshot.jpg -->
![Executive Dashboard Screenshot](screenshot.jpg)

## Features
- **Finance & Strategy Panel:** Track global burn rates and overall performance metrics dynamically.
- **Critical Blockers:** Identify blocked tasks and visualize bottlenecks using a clear, hierarchical tree structure.
- **Dependencies & Critical Path:** Access structural node graphs mapping out cross-project dependencies.
- **Time-Boxed Action Plan:** A robust 4-column grid displaying tasks assigned to users for Today (P1), This Week, and This Month. Automatically pulls real data from active users.
- **Company Projects Matrix:** Monitor active project Velocity scores and Work-in-Progress (WIP) limit alerts.
- **AI-Assisted Operational Recommendations:** Actionable insights with one-click "Copy Prompt" functionality to easily delegate tasks or request detailed financial reports.

## Installation
1. Clone this repository or download the ZIP file.
2. Rename the extracted folder to `ExecutiveDashboard`.
3. Move the `ExecutiveDashboard` folder into your Kanboard `plugins/` directory.
4. Restart your server or refresh the Kanboard page. You will see the new **Manager Control Center** link in the sidebar.

### Required Plugins (Gerekli Eklentiler)
Bu eklentinin (Executive Dashboard) tüm fonksiyonlarıyla kusursuz çalışabilmesi için aşağıdaki Kanboard eklentilerinin sistemde kurulu olması gerekmektedir:

1. **CostControl**: Küresel Finans Sayfası (/mcc/finance), Bütçe Kullanımı (Burn Rate) hesaplamaları ve gerçekleşen harcama verileri için zorunludur.
2. **KPI**: Genel Proje Performansı, Sistem Sağlığı, Genel Skor ve Geciken İşler (Overdue Tasks) modüllerinin yönlendirmeleri için gereklidir.
3. **Relationgraph (Opsiyonel)**: Görev bağımlılıkları ve Kritik Yol analizlerinin görsel olarak daha iyi çizilebilmesi için tavsiye edilir.

**Nasıl Yüklenir? (Kısayol)**
- Kanboard sağ üst menüden **Eklentiler (Plugins) > Eklenti Dizini (Plugin Directory)** yolunu izleyin.
- Arama kutusuna eklenti isimlerini yazıp **Kur (Install)** butonuna basarak tek tıkla yükleyebilirsiniz.

## Compatibility
- Requires Kanboard version >= 1.2.20
- Compatible with all standard Kanboard themes (integrates seamlessly without overriding core CSS globally).

## Documentation & Repository Guidelines
Please refer to the following documents for more details on project standards and contributions:
- [CHANGELOG.md](CHANGELOG.md) - History of releases, new features, and bug fixes.
- [CONTRIBUTING.md](CONTRIBUTING.md) - Guidelines and instructions for developers who want to contribute to the codebase.
- [SECURITY.md](SECURITY.md) - Our security policies and instructions on how to report vulnerabilities.
- [CODE_OF_CONDUCT.md](CODE_OF_CONDUCT.md) - Behavioral standards expected from all contributors.

## Author & Credits
Created and maintained by:
- **Sencar Tosun**
- [DediTeknoloji.com](https://dediteknoloji.com)
- [Bilgiyapar.com](https://bilgiyapar.com)
