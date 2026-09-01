# Katkıda Bulunma (Contributing)

Executive Dashboard eklentisine katkıda bulunmak istediğiniz için teşekkür ederiz!

## Geliştirme Adımları
1. Bu depoyu kendi çalışma alanınıza forklayın.
2. Yeni bir özellik dalı oluşturun (`git checkout -b feature/HarikaOzellik`).
3. Değişikliklerinizi standartlara (PSR-4) uygun olarak kodlayın. CSS yazarken `.bilgiyapar-mcc-` önekini (prefix) KESİNLİKLE kullanın.
4. Yaptığınız değişiklikleri commit edin (`git commit -m 'feat: harika özellik eklendi'`).
5. Dalınızı pushlayın (`git push origin feature/HarikaOzellik`).
6. Bir Pull Request (PR) açın.

## Kod Standartları
- Kanboard çekirdek (core) dosyalarını asla değiştirmeyin.
- Hataları önlemek için şablon içine iş mantığı (business logic) yazmaktan kaçının, Controller veya Model katmanlarını kullanın.
