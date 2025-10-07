# 🏠 Eva Home - Ev Dekorasyon Web Sitesi

Eva Home, ev dekorasyonu ve mobilya satışı için geliştirilmiş modern bir web sitesi ve admin paneli sistemidir.

## ✨ Özellikler

### 🌐 Ana Web Sitesi
- **Modern ve Responsive Tasarım** - Tüm cihazlarda mükemmel görünüm
- **Ürün Kataloğu** - Kategorilere ayrılmış ürün listesi
- **Blog Sistemi** - Dekorasyon ipuçları ve trendler
- **İletişim Formu** - Müşteri geri bildirimleri
- **SEO Optimizasyonu** - Arama motorları için optimize edilmiş

### 🔧 Admin Paneli
- **Dashboard** - Genel istatistikler ve hızlı erişim
- **Ürün Yönetimi** - Ürün ekleme, düzenleme, silme
- **Sipariş Yönetimi** - Sipariş takibi ve durum güncelleme
- **Blog Yönetimi** - Blog yazıları ve kategoriler
- **Mesaj Yönetimi** - İletişim mesajları ve yanıtlama
- **Kullanıcı Yönetimi** - Admin kullanıcıları
- **Site Ayarları** - Genel site konfigürasyonu

### 📊 Veritabanı Yapısı
- **14 Ana Tablo** - Kapsamlı veri yönetimi
- **İlişkisel Veritabanı** - Foreign key ilişkileri
- **İndeksler** - Performans optimizasyonu
- **Örnek Veriler** - Hızlı başlangıç için hazır veriler

## 🚀 Kurulum

### Gereksinimler
- **XAMPP** (Apache + MySQL + PHP)
- **PHP 7.4+**
- **MySQL 5.7+**

### Kurulum Adımları

#### 1. XAMPP'ı Başlatın
```bash
# XAMPP Control Panel'den Apache ve MySQL servislerini başlatın
```

#### 2. Projeyi İndirin
```bash
# Proje dosyalarını C:\xampp\htdocs\evahome\ klasörüne kopyalayın
```

#### 3. Veritabanını Kurun

**Seçenek A: Otomatik Kurulum (Önerilen)**
```
http://localhost/evahome/install.php
```

**Seçenek B: Kurulum Sayfası**
```
http://localhost/evahome/setup.php
```

**Seçenek C: phpMyAdmin ile Manuel Kurulum**
```
http://localhost/phpmyadmin
```
1. Yeni veritabanı oluşturun: `evahome_db`
2. `database.sql` dosyasını import edin

#### 4. Veritabanı Eksikliklerini Tamamlayın

**🔥 YENİ: Tek Tıkla Veritabanı Güncelleme**
```
http://localhost/evahome/complete_database.php
```

Bu dosya otomatik olarak:
- ✅ Eksik sütunları ekler (color_name, color_code, phone)
- ✅ Eva Home kategorilerini ve koleksiyonlarını ekler
- ✅ 20+ ürün ekler (renk kodlarıyla birlikte)
- ✅ Veritabanı istatistiklerini gösterir

Detaylı bilgi için: `VERİTABANI_GÜNCELLEME.md` dosyasına bakın

#### 5. Admin Paneline Giriş
```
URL: http://localhost/evahome/admin/login.php
Kullanıcı: admin
Şifre: password
```

## 📁 Proje Yapısı

```
evahome/
├── 📁 admin/                    # Admin paneli
│   ├── 📁 ajax/                 # AJAX işlemleri
│   ├── 📁 assets/               # CSS, JS, resimler
│   ├── 📁 includes/             # Ortak dosyalar
│   ├── 📄 dashboard.php         # Ana panel
│   ├── 📄 products.php          # Ürün yönetimi
│   ├── 📄 orders.php            # Sipariş yönetimi
│   ├── 📄 blog_posts.php        # Blog yönetimi
│   ├── 📄 messages.php          # Mesaj yönetimi
│   └── 📄 login.php             # Admin girişi
├── 📁 config/                   # Konfigürasyon
│   └── 📄 database.php          # Veritabanı bağlantısı
├── 📁 uploads/                  # Yüklenen dosyalar
├── 📄 index.php                 # Ana sayfa
├── 📄 setup.php                 # Kurulum sayfası
├── 📄 install.php               # Hızlı kurulum
├── 📄 contact.php               # İletişim formu
└── 📄 database.sql              # Veritabanı yapısı
```

## 🗄️ Veritabanı Tabloları

| Tablo | Açıklama | Varsayılan Kayıt |
|-------|----------|------------------|
| `users` | Kullanıcılar (admin, editor) | 1 |
| `categories` | Ürün kategorileri ve koleksiyonlar | 20+ |
| `products` | Ürünler (renk kodlarıyla) | 30+ |
| `orders` | Siparişler | 1 |
| `order_items` | Sipariş öğeleri | 1 |
| `blog_posts` | Blog yazıları | 3+ |
| `contact_messages` | İletişim mesajları (telefon ile) | 1 |
| `job_applications` | İş başvuruları | 1 |
| `coupons` | Kuponlar | 0 |
| `product_reviews` | Ürün yorumları | 0 |
| `newsletter_subscribers` | Haber bülteni | 0 |
| `site_settings` | Site ayarları | 9 |
| `file_uploads` | Dosya yüklemeleri | 0 |
| `activity_logs` | Aktivite logları | 0 |

### 🆕 Yeni Özellikler
- **Products Tablosu:** `color_name` ve `color_code` sütunları eklendi
- **Contact Messages Tablosu:** `phone` sütunu eklendi
- **Eva Home Koleksiyonları:** 8 özel koleksiyon kategorisi
- **Renk Kodları:** Her ürün için hex renk kodları (#FFD700, #8B0A50, vb.)

## 🔑 Varsayılan Giriş Bilgileri

### Admin Paneli
- **URL:** `http://localhost/evahome/admin/login.php`
- **Kullanıcı:** `admin`
- **Şifre:** `password`

### Veritabanı
- **Host:** `localhost`
- **Veritabanı:** `evahome_db`
- **Kullanıcı:** `root`
- **Şifre:** (boş)

## 🛠️ Geliştirme

### Yeni Özellik Ekleme
1. Veritabanı tablosu oluşturun
2. Admin paneli sayfası ekleyin
3. AJAX işlemleri ekleyin
4. Ana sayfada gösterim ekleyin

### Dosya Yükleme
- **Konum:** `uploads/` klasörü
- **Desteklenen Formatlar:** JPG, PNG, GIF, WebP
- **Maksimum Boyut:** 5MB

### Güvenlik
- **CSRF Token** koruması
- **SQL Injection** koruması
- **XSS** koruması
- **Session** yönetimi

## 📞 Destek

### Sorun Giderme
1. **XAMPP servisleri çalışıyor mu?**
2. **Veritabanı bağlantısı var mı?**
3. **Dosya izinleri doğru mu?**
4. **PHP hata loglarını kontrol edin**

### Yaygın Hatalar
- **"Table doesn't exist"** → Veritabanı kurulumu yapın
- **"Connection refused"** → MySQL servisini başlatın
- **"Permission denied"** → Dosya izinlerini kontrol edin

## 📄 Lisans

Bu proje MIT lisansı altında lisanslanmıştır.

## 🤝 Katkıda Bulunma

1. Projeyi fork edin
2. Feature branch oluşturun (`git checkout -b feature/AmazingFeature`)
3. Değişikliklerinizi commit edin (`git commit -m 'Add some AmazingFeature'`)
4. Branch'inizi push edin (`git push origin feature/AmazingFeature`)
5. Pull Request oluşturun

## 📈 Gelecek Özellikler

- [ ] E-ticaret entegrasyonu
- [ ] Çoklu dil desteği
- [ ] Mobil uygulama
- [ ] API geliştirme
- [ ] Ödeme sistemi entegrasyonu
- [ ] Kargo takip sistemi

---

**Eva Home** - Ev dekorasyonunda kalite ve şıklığın buluştuğu yer! 🏠✨
