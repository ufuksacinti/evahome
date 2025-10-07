# 🎉 Eva Home - Yeni Özellikler

## ✅ Tamamlanan Özellikler

### 1. 📊 Ürün İstatistikleri Sistemi

#### Yeni Tablolar
- **`favorites`** - Favoriye ekleme takibi
- **`cart_analytics`** - Sepete ekleme takibi

#### Takip Edilen Metrikler
- ✅ Sepete kaç kez eklendiği
- ✅ Kaç benzersiz kullanıcı sepete ekledi
- ✅ Favoriye kaç kez eklendiği
- ✅ Kaç benzersiz kullanıcı favoriledi
- ✅ Kaç adet satıldı
- ✅ Popülerlik skoru (otomatik hesaplanan)

#### Erişim
```
Admin Panel → Ürün İstatistikleri
http://localhost/evahome/admin/product_analytics.php
```

#### Özellikler
- 📈 Grafik görselleştirme (Chart.js)
- 📊 Detaylı tablo görünümü
- 🔍 Ürün arama
- 📥 Excel'e aktarma
- 🎯 Popülerlik skoru

---

### 2. ✍️ Gelişmiş Blog Editörü (TinyMCE)

#### Özellikler
- ✅ **WYSIWYG Editör** - Ne görüyorsan onu alırsın
- ✅ **Görsel ekleme** - Drag & drop
- ✅ **Medya ekleme** - Video, ses
- ✅ **Kod görünümü** - HTML düzenleme
- ✅ **Tam ekran modu** - Dikkat dağıtmadan yazma
- ✅ **Otomatik kaydetme** - 30 saniyede bir
- ✅ **Kelime sayacı** - Anlık kelime sayısı
- ✅ **Türkçe arayüz** - Türkçe menüler

#### Özel Şablonlar
1. Mum Bakımı Şablonu
2. Koleksiyon Tanıtım Şablonu

#### Toolbar Özellikleri
```
Geri Al/İleri Al | Başlıklar | Kalın/İtalik/Renk | Hizalama
Liste (Numaralı/Madde İmli) | Girinti | Link/Görsel/Medya
Kod Görünümü | Önizleme | Tam Ekran | Yardım
```

#### Erişim
```
Admin Panel → Blog Yazıları → Yeni Yazı
http://localhost/evahome/admin/blog_add.php
```

---

### 3. 🎨 Yeni Admin Panel Layout

#### Özellikler
- ✅ **Sabit Sidebar** - Sol tarafa sabitlenmiş, scroll'u var
- ✅ **Eva Home Altın Teması** - #c9a24a gradient
- ✅ **Top Bar** - Sayfa başlığı ve kullanıcı menüsü
- ✅ **Responsive** - Mobilde sidebar gizlenir
- ✅ **Smooth Animations** - Yumuşak geçişler

#### Layout Yapısı
```
Desktop:
┌─────────────────────────────────────────────────┐
│ [Sidebar]  │ [Top Bar: Başlık | User Menu]      │
│  260px     ├──────────────────────────────────── │
│  Sabit     │                                     │
│  Scroll    │  [Main Content Area]                │
│            │   Dinamik İçerik                    │
│            │   Scroll                            │
└────────────┴──────────────────────────────────── ┘
```

#### Sidebar Bölümleri
- 🏠 **Dashboard**
- 📦 **Ürün Yönetimi** (Ürünler, Kategoriler, Siparişler)
- 📝 **İçerik Yönetimi** (Blog, Mesajlar, Medya)
- 📊 **Raporlar & İstatistikler** (Ürün İstatistikleri - YENİ!)
- 👥 **Müşteriler**

---

### 4. 🔗 Dinamik Sayfa Linkleri

#### Ürünler Sayfası
- ✅ Veritabanından ürün çekiyor
- ✅ Her ürün için detay linki var
- ✅ Renk kodları gösteriliyor
- ✅ Stok uyarıları var

#### Blog Sayfası
- ✅ Veritabanından blog çekiyor
- ✅ Her blog için detay linki var
- ✅ Görüntülenme sayısı gösteriliyor
- ✅ Yazar bilgisi gösteriliyor

#### Blog Detay Sayfası (YENİ!)
```
http://localhost/evahome/blog_detay.php?id=1
```
- ✅ Tam blog içeriği
- ✅ Breadcrumb navigasyon
- ✅ İlgili blog yazıları
- ✅ Paylaşım butonları
- ✅ Etiketler
- ✅ Görüntülenme sayısı otomatik artar

---

## 🚀 Kurulum

### Adım 1: Analitik Tablolarını Oluştur
```
http://localhost/evahome/add_analytics_tables.php
```
Veya:
```
ANALİTİK_KUR.bat dosyasına çift tıklayın
```

### Adım 2: Admin Paneline Giriş
```
http://localhost/evahome/admin/login.php
Kullanıcı: admin
Şifre: password
```

### Adım 3: Yeni Özellikleri Test Et

#### Ürün İstatistikleri
```
Admin Panel → Ürün İstatistikleri
```
Görüntüle:
- Sepete eklenme sayıları
- Favoriye eklenme sayıları
- Popülerlik grafikleri
- Detaylı raporlar

#### Blog Editörü
```
Admin Panel → Blog Yazıları → Yeni Yazı
```
Test et:
- TinyMCE zengin metin editörü
- Görsel ekleme
- Şablonlar
- Önizleme

---

## 📊 Ürün İstatistikleri Detayları

### Hesaplanan Metrikler

#### Popülerlik Skoru
```
Skor = (Sepete Eklenme × 0.4) + (Favoriye Eklenme × 0.3) + (Satılan × 0.3)
```

**Skor Renkleri:**
- 🟢 Yeşil (>50): Çok popüler
- 🟡 Sarı (20-50): Orta popülerlik
- ⚫ Gri (<20): Düşük popülerlik

### Tablo Sütunları

| Sütun | Açıklama |
|-------|----------|
| ID | Ürün ID'si |
| Ürün Adı | SKU, Renk bilgisi ile |
| Kategori | Ürün kategorisi |
| Fiyat | Normal/İndirimli fiyat |
| Stok | Renk kodlu stok durumu |
| 🛒 Sepet | Sepete eklenme sayısı |
| 👥 Kullanıcı (Sepet) | Benzersiz kullanıcı |
| ❤️ Favori | Favoriye eklenme |
| 👥 Kullanıcı (Favori) | Benzersiz kullanıcı |
| ✅ Satılan | Sipariş edilen adet |
| Popülerlik | 0-100 arası skor |

### Grafikler

1. **Bar Chart** - En popüler 10 ürün (sepet)
2. **Doughnut Chart** - En çok favorilenen 10 ürün

---

## ✍️ TinyMCE Blog Editörü Özellikleri

### Toolbar Komutları

#### Temel Düzenleme
- Geri Al / İleri Al
- Biçim (Başlık 1-6, Paragraf)
- Kalın / İtalik / Altı Çizili
- Renk (Metin / Arka Plan)

#### Hizalama & Liste
- Sol / Orta / Sağ / İki Yana Yaslı
- Numaralı Liste
- Madde İmli Liste
- Girinti Azalt / Artır

#### Medya & Link
- Link Ekle / Düzenle
- Görsel Ekle
- Medya Ekle (Video/Ses)
- Tablo Ekle

#### Araçlar
- Biçimlendirmeyi Kaldır
- Kod Görünümü
- Önizleme
- Tam Ekran
- Kelime Sayacı
- Yardım

### Otomatik Özellikler
- ✅ **30 saniyelik otomatik kaydetme**
- ✅ **Taslak kurtarma** (tarayıcı kapansa bile)
- ✅ **Görsel yükleme** (drag & drop)
- ✅ **Türkçe arayüz**
- ✅ **Responsive tasarım**

### İçerik Stili
```css
H2 başlıklar → Eva Home altın renk (#c9a24a)
H3 başlıklar → Koyu gri (#334155)
Paragraflar → 1.8 satır aralığı
Linkler → Altın renk
```

---

## 🎨 Admin Panel Renk Paleti

| Element | Renk | Kullanım |
|---------|------|----------|
| Sidebar | #c9a24a → #a0883d | Gradient |
| Active Link | White + 20% opacity | Seçili menü |
| Hover | White + 15% opacity | Hover efekti |
| Top Bar | White | Üst bar |
| Content Area | #f8f9fa | Ana içerik |
| Primary Button | #c9a24a | CTA butonları |

---

## 📱 Responsive Davranış

### Desktop (>991px)
```
- Sidebar: 260px sabit, sol kenarda
- Content: Sidebar'ın sağında, dinamik genişlik
- Top Bar: Sidebar genişliği kadar boşluk bırakır
```

### Mobil (<991px)
```
- Sidebar: Gizli, hamburger menü ile açılır
- Content: Tam genişlikte
- Top Bar: Tam genişlikte
- Mobile Toggle: Görünür
```

---

## 🔧 Kullanım Rehberi

### Ürün İstatistiklerini Görüntüle

1. Admin paneline giriş yapın
2. Sol menüden **"Ürün İstatistikleri"** tıklayın
3. Tabloda her ürün için:
   - Sepete eklenme sayısını görün
   - Favoriye eklenme sayısını görün
   - Popülerlik skorunu görün
4. Grafiklerle en popüler ürünleri analiz edin
5. Excel'e aktararak raporlayın

### Blog Yazısı Oluştur (TinyMCE ile)

1. Admin paneline giriş yapın
2. Sol menüden **"Blog Yazıları"** tıklayın
3. **"Yeni Yazı"** butonuna tıklayın
4. TinyMCE editörde:
   - Başlık ve özet girin
   - İçeriği zengin metin editörü ile yazın
   - Görsel ekleyin (drag & drop)
   - Şablon seçebilirsiniz
   - Önizleme yapabilirsiniz
5. Kategori ve durum seçin
6. **"Yayınla"** butonuna tıklayın

---

## 📁 Yeni Dosyalar

| Dosya | Açıklama |
|-------|----------|
| `add_analytics_tables.php` | Analitik tabloları kurulum |
| `admin/product_analytics.php` | Ürün istatistikleri sayfası |
| `admin/blog_add.php` | TinyMCE editörlü blog ekleme |
| `blog_detay.php` | Blog içerik detay sayfası |
| `ANALİTİK_KUR.bat` | Tek tıkla kurulum |
| `YENİ_ÖZELLİKLER.md` | Bu dosya |

---

## 🎯 Sonraki Adımlar

### Hemen Yapabilirsiniz

1. ✅ **Analitik tablolarını kurun:**
   ```
   http://localhost/evahome/add_analytics_tables.php
   ```

2. ✅ **Ürün istatistiklerini görüntüleyin:**
   ```
   http://localhost/evahome/admin/product_analytics.php
   ```

3. ✅ **Blog yazısı oluşturun:**
   ```
   http://localhost/evahome/admin/blog_add.php
   ```

4. ✅ **Blog detayını test edin:**
   ```
   http://localhost/evahome/blog_detay.php?id=1
   ```

---

## 💡 İpuçları

### Ürün İstatistikleri
- Popülerlik skoru 0-100 arası
- Yüksek skor = Daha popüler ürün
- Düşük skora sahip ürünleri gözden geçirin
- Sepete eklenen ama satın alınmayan ürünleri analiz edin

### Blog Editörü
- **CTRL+Z** - Geri al
- **CTRL+Y** - İleri al
- **CTRL+K** - Link ekle
- **Tam Ekran** - Dikkat dağıtmadan yazın
- **Şablonlar** - Hızlı başlangıç için kullanın
- **Otomatik Kayıt** - 30 saniyede bir

### Layout
- Sidebar sol kenarda sabit
- Sidebar'ın kendi scroll'u var
- İçerik alanı sidebar'ın yanında
- Mobilde hamburger menü

---

## 🎨 Ekran Görüntüleri

### Ürün İstatistikleri Sayfası
```
╔════════════════════════════════════════════════╗
║ [Sidebar]  │ Ürün İstatistikleri               ║
║            │                                    ║
║ Dashboard  │ [📊 Sepet] [❤️ Favori] [✅ Satış] ║
║ Ürünler    │                                    ║
║ Blog       │ [Detaylı Tablo]                    ║
║ İstatistik ←  ID │ Ürün │ Sepet │ Favori │...  ║
║            │  1  │ xxx  │  45   │  23    │...  ║
║            │  2  │ yyy  │  38   │  19    │...  ║
║            │                                    ║
║            │ [Bar Chart] [Doughnut Chart]       ║
╚════════════════════════════════════════════════╝
```

### Blog Editörü
```
╔════════════════════════════════════════════════╗
║ [Sidebar]  │ Yeni Blog Yazısı                  ║
║            │                                    ║
║ Dashboard  │ Başlık: [________________]         ║
║ Blog ←     │                                    ║
║            │ [TinyMCE Zengin Metin Editörü]    ║
║            │  ┌──────────────────────────┐     ║
║            │  │ B I U | H2 H3 | 🎨 | 📷 │     ║
║            │  ├──────────────────────────┤     ║
║            │  │                          │     ║
║            │  │  Blog içeriğiniz...      │     ║
║            │  │                          │     ║
║            │  └──────────────────────────┘     ║
║            │                                    ║
║            │ [✅ Yayınla] [❌ İptal]           ║
╚════════════════════════════════════════════════╝
```

---

## 🔥 Hemen Test Edin!

### 1. Analitik Tablolarını Kurun
```bash
ANALİTİK_KUR.bat
```
Veya tarayıcıdan:
```
http://localhost/evahome/add_analytics_tables.php
```

### 2. Admin Paneline Giriş
```
http://localhost/evahome/admin/login.php
Kullanıcı: admin
Şifre: password
```

### 3. Özellikleri Test Edin
- Sol menüden **"Ürün İstatistikleri"** açın
- Sepet ve favori sayılarını görün
- **"Blog Yazıları → Yeni Yazı"** ile TinyMCE'yi test edin
- Blog yazısı oluşturun ve kaydedin
- Ana sitede blog detayını görüntüleyin

---

## 📝 Notlar

- **Örnek veri** otomatik eklendi (ilk 10 ürün için)
- Her ürün için **5-50 sepet ekleme**
- Her ürün için **3-30 favoriye ekleme**
- Gerçek kullanıcı verileri eklenene kadar test verisi kullanılıyor

---

**Eva Home Admin Panel** - Artık tam özellikli! 🕯️✨

