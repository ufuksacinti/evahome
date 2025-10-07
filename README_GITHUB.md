# 🕯️ Eva Home - El Yapımı Mum E-Ticaret Sistemi

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange.svg)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

> Butik oteller, SPA merkezleri ve kurumsal müşteriler için el yapımı soya mumları ve aromaterapi ürünleri satan tam özellikli e-ticaret platformu.

![Eva Home](https://img.shields.io/badge/Status-Production%20Ready-success)

## ✨ Öne Çıkan Özellikler

### 🛍️ E-Ticaret
- **196+ Ürün** - 8 koleksiyon, renk kodlarıyla
- **Dinamik Kategori Sistemi** - Ana ve alt kategoriler
- **Ürün Detay Sayfaları** - Zengin ürün bilgileri
- **Stok Yönetimi** - Otomatik düşük stok uyarıları

### 🏢 Kurumsal Özellikler
- **Toplu Sipariş Sistemi** - Min 50 adet
- **Özel Etiket Servisi** - Logo baskı ve özel metin
- **B2B Portal** - Oteller, SPA, butik mağazalar için
- **Teklif Yönetimi** - Admin panelinde teklif hazırlama

### 📊 Analitik & Raporlama
- **Ürün İstatistikleri** - Sepet, favori takibi
- **Chart.js Grafikleri** - Görsel raporlar
- **Popülerlik Skoru** - Otomatik hesaplama
- **Excel Export** - Raporları dışa aktarma

### 📝 İçerik Yönetimi
- **TinyMCE Blog Editörü** - Profesyonel yazım
- **15+ Blog Yazısı** - Aromaterapi ve mum bakımı
- **SEO Optimizasyonu** - Meta tag'ler
- **Medya Kütüphanesi** - Görsel yönetimi

### 🎨 Tasarım
- **Eva Home Altın Teması** - Tutarlı renk paleti
- **Google Fonts** - Inter + Playfair Display
- **Responsive** - Tüm cihazlarda mükemmel
- **Modern UI/UX** - Smooth animasyonlar

## 📸 Ekran Görüntüleri

### Ana Sayfa
- Modern hero section
- Kategori kartları
- Öne çıkan ürünler
- Blog yazıları
- Toplu sipariş bölümü

### Admin Panel
- Dashboard istatistikleri
- Ürün yönetimi
- Toplu sipariş yönetimi
- TinyMCE blog editörü
- Grafik ve raporlar

## 🚀 Hızlı Başlangıç

### Gereksinimler

```bash
PHP >= 7.4
MySQL >= 5.7
Apache Web Server
```

**Önerilen:** XAMPP veya WAMP

### Kurulum

#### 1. Projeyi Klonlayın

```bash
git clone https://github.com/KULLANICI_ADI/evahome.git
cd evahome
```

#### 2. Veritabanı Konfigürasyonu

```bash
# Örnek dosyayı kopyalayın
cp config/database.example.php config/database.php

# Kendi ayarlarınızı girin
nano config/database.php
```

#### 3. Veritabanını Oluşturun

**Yöntem A: Otomatik Kurulum** (Önerilen)
```
http://localhost/evahome/install.php
```

**Yöntem B: phpMyAdmin**
1. `evahome_db` veritabanı oluşturun
2. `database.sql` dosyasını import edin

#### 4. Veri Yükleyin

```
http://localhost/evahome/load_massive_data.php
```

Bu komut:
- ✅ 196+ ürün ekler
- ✅ 15+ blog yazısı ekler
- ✅ Kategorileri oluşturur

#### 5. İsteğe Bağlı: Ek Özellikler

**Analitik Sistemi:**
```
http://localhost/evahome/add_analytics_tables.php
```

**Toplu Sipariş Sistemi:**
```
http://localhost/evahome/create_wholesale_tables.php
```

### Varsayılan Giriş

```
URL: http://localhost/evahome/admin/login.php
Kullanıcı: admin
Şifre: password
```

⚠️ **Güvenlik:** İlk girişten sonra şifrenizi değiştirin!

## 📁 Proje Yapısı

```
evahome/
├── 📁 admin/                    # Admin paneli
│   ├── 📁 ajax/                 # AJAX işlemleri
│   ├── 📁 assets/               # CSS, JS
│   ├── 📁 includes/             # Header, Sidebar
│   ├── 📄 dashboard.php         # Dashboard
│   ├── 📄 products.php          # Ürün yönetimi
│   ├── 📄 wholesale_orders.php  # Toplu sipariş yönetimi
│   ├── 📄 blog_add.php          # TinyMCE editör
│   ├── 📄 product_analytics.php # İstatistikler
│   └── ...
├── 📁 assets/                   # Frontend varlıklar
│   ├── 📁 css/                  # Stil dosyaları
│   └── 📁 images/               # Resimler
├── 📁 config/                   # Konfigürasyon
│   ├── 📄 database.php          # DB ayarları (gitignore'da)
│   └── 📄 database.example.php  # Örnek dosya
├── 📁 uploads/                  # Yüklenen dosyalar
├── 📄 index.php                 # Ana sayfa
├── 📄 urunler.php               # Ürün listesi
├── 📄 toplu-siparis.php         # Toplu sipariş formu
├── 📄 blog.php                  # Blog listesi
├── 📄 database.sql              # Veritabanı şeması
├── 📄 .gitignore                # Git ignore
└── 📄 README.md                 # Bu dosya
```

## 🗄️ Veritabanı

### Ana Tablolar (17)

| Tablo | Açıklama | Kayıt |
|-------|----------|-------|
| `products` | Ürünler (renk kodlarıyla) | 196+ |
| `categories` | Kategoriler ve koleksiyonlar | 20+ |
| `blog_posts` | Blog yazıları | 15+ |
| `wholesale_orders` | Toplu siparişler | - |
| `cart_analytics` | Sepet analitik | - |
| `favorites` | Favori takibi | - |
| `orders` | Siparişler | - |
| `customers` | Müşteriler | - |
| ... | ... | ... |

## 🎨 Eva Home Koleksiyonları

| Koleksiyon | Renk | Hex | Enerji |
|-----------|------|-----|--------|
| Golden Jasmine | Altın | #FFD700 | Şans |
| Velvet Rose | Bordo | #8B0A50 | Aşk |
| Citrus Harmony | Turuncu | #FF8C42 | Neşe |
| Luminous Bloom | Pembe | #FFB6C1 | Yenilenme |
| Sacred Oud | Koyu Yeşil | #2F4F4F | Huzur |
| Earth Harmony | Kahve | #8B4513 | Bolluk |
| Royal Spice | Gri | #808080 | Arınma |
| Lavender Peace | Lila | #E6E6FA | Rahatlama |

## 🏢 Toplu Sipariş Paketleri

1. **8 Renk Koleksiyon Refil Seti** - Min: 50 adet, ₺280/adet
2. **Mini Mum Hediye Seti (4'lü)** - Min: 100 adet, ₺180/adet
3. **Lux Koleksiyon Seti (3'lü)** - Min: 30 adet, ₺650/adet
4. **Room Diffuser Toplu Paket** - Min: 50 adet, ₺320/adet
5. **Butik Mağaza Başlangıç** - Min: 20 adet, ₺450/adet

### Özel Etiket Seçenekleri
- ✅ Markasız etiket
- ✅ Kendi markanız (logo + metin)
- ✅ Eva Home standart etiket

## 🛠️ Teknoloji Stack

### Backend
- **PHP 7.4+** - Server-side scripting
- **MySQL** - İlişkisel veritabanı
- **PDO** - Veritabanı abstraction
- **Sessions** - Kullanıcı yönetimi

### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Modern styling
- **Bootstrap 5.3** - UI framework
- **JavaScript** - Client-side logic
- **FontAwesome 6.0** - Icon library
- **Google Fonts** - Inter + Playfair Display

### Özel Kütüphaneler
- **TinyMCE 6** - WYSIWYG blog editörü
- **Chart.js** - Grafik ve istatistikler

## 📊 Admin Panel Özellikleri

### Dashboard
- ✅ Genel istatistikler
- ✅ Son siparişler
- ✅ Son mesajlar
- ✅ Düşük stok uyarıları
- ✅ Hızlı erişim kartları

### Ürün Yönetimi
- ✅ Ürün CRUD işlemleri
- ✅ Kategori yönetimi
- ✅ Renk kodu ekleme
- ✅ Toplu işlemler
- ✅ Stok takibi

### İçerik Yönetimi
- ✅ TinyMCE blog editörü
- ✅ Medya kütüphanesi
- ✅ SEO ayarları
- ✅ Taslak/Yayın durumları

### Sipariş Yönetimi
- ✅ Perakende siparişler
- ✅ Toplu/Kurumsal siparişler
- ✅ Durum takibi
- ✅ Teklif gönderme

### Analitik
- ✅ Ürün istatistikleri
- ✅ Sepet analizi
- ✅ Favori takibi
- ✅ Popülerlik skorları
- ✅ Chart.js grafikleri

## 🔒 Güvenlik

- ✅ CSRF token koruması
- ✅ SQL injection koruması (PDO prepared statements)
- ✅ XSS koruması (htmlspecialchars)
- ✅ Session yönetimi
- ✅ Admin giriş kontrolü
- ✅ Güvenli dosya yükleme

## 🌍 Demo

Canlı demo: [Demo Link Eklenecek]

## 📖 Dokümantasyon

Detaylı dokümantasyon için:
- `PROJE_TAMAMLANDI.md` - Tam özellik listesi
- `TOPLU_SİPARİŞ_REHBERİ.md` - Toplu sipariş rehberi
- `VERİTABANI_GÜNCELLEME.md` - DB güncelleme
- `ADMIN_LAYOUT_DÜZELTMELERİ.md` - Layout rehberi

## 🤝 Katkıda Bulunma

1. Fork edin
2. Feature branch oluşturun (`git checkout -b feature/YeniOzellik`)
3. Commit edin (`git commit -m 'Yeni özellik: XYZ'`)
4. Push edin (`git push origin feature/YeniOzellik`)
5. Pull Request açın

## 📝 Değişiklik Günlüğü

### v1.0.0 (2024-10-07)
- ✅ İlk sürüm
- ✅ 196+ ürün
- ✅ Toplu sipariş sistemi
- ✅ TinyMCE blog editörü
- ✅ Ürün analitik sistemi
- ✅ Responsive tasarım

## 📄 Lisans

Bu proje MIT lisansı altında lisanslanmıştır.

## 👨‍💻 Geliştirici

**Eva Home Development Team**

## 🙏 Teşekkürler

- [Bootstrap](https://getbootstrap.com/)
- [FontAwesome](https://fontawesome.com/)
- [TinyMCE](https://www.tiny.cloud/)
- [Chart.js](https://www.chartjs.org/)
- [Google Fonts](https://fonts.google.com/)

---

**Eva Home** - El yapımı soya mumları ve kurumsal aromaterapi çözümleri! 🕯️✨

**Star ⭐ vermeyi unutmayın!**

