# 🏢 Eva Home - Toplu/Kurumsal Sipariş Sistemi

## ✨ Sistem Özeti

Eva Home artık **toplu ve kurumsal sipariş** alabilecek şekilde geliştirildi!

### 🎯 Hedef Kitle

1. **🏨 Butik Oteller** - Otel odaları için mum ve koku setleri
2. **💆 SPA & Wellness Merkezleri** - Aromaterapi ve relaxation ürünleri  
3. **🏢 Kurumsal Firmalar** - Yılbaşı, özel gün hediyeleri
4. **🏪 Butik Mağazalar** - Perakende satış için toplu alım

---

## 📦 Ürün Paketleri

### 1. 8 Renk Koleksiyon Refil Seti
- **Min. Sipariş:** 50 adet
- **Birim Fiyat:** ₺280
- **İçerik:** Tüm koleksiyonlardan birer refil mumu
- **Özel Etiket:** ✅ Uygulanabilir

### 2. Mini Mum Hediye Seti (4'lü)
- **Min. Sipariş:** 100 adet
- **Birim Fiyat:** ₺180
- **İçerik:** 4 mini silindir mum + hediye kutusu
- **Özel Etiket:** ✅ Uygulanabilir

### 3. Lux Koleksiyon Seti (3'lü)
- **Min. Sipariş:** 30 adet
- **Birim Fiyat:** ₺650
- **İçerik:** 3 büyük silindir mum + premium alçı kaplar
- **Özel Etiket:** ✅ Uygulanabilir

### 4. Room Diffuser Toplu Paket
- **Min. Sipariş:** 50 adet
- **Birim Fiyat:** ₺320
- **İçerik:** Room diffuser 200ml + refill + çubuklar
- **Özel Etiket:** ✅ Uygulanabilir

### 5. Butik Mağaza Başlangıç Paketi
- **Min. Sipariş:** 20 adet
- **Birim Fiyat:** ₺450
- **İçerik:** Karışık 20 mum + stand + broşürler
- **Özel Etiket:** ❌ Standart

---

## 🏷️ Özel Etiket Seçenekleri

### 3 Farklı Etiket Türü

#### 1. Markasız Etiket
- Sadece ürün bilgisi
- Eva Home logosu yok
- Genel ürün açıklaması

#### 2. Kendi Markanız
- Müşterinin kendi logosu
- Özel metin/slogan
- Tamamen özelleştirilmiş

#### 3. Eva Home Standart
- Eva Home logosu
- Standart etiket tasarımı
- Hızlı teslimat

### Logo Yükleme
- **Desteklenen Formatlar:** PNG, JPG, PDF, AI, EPS
- **Max Boyut:** 5MB
- **Kullanım:** Etiket üzerinde basılacak

---

## 📝 Sipariş Süreci

### Müşteri Tarafı

1. **Ana Sayfada** "Kurumsal & Toplu Sipariş" bölümünü görür
2. **"Talep Oluştur"** butonuna tıklar
3. **Toplu Sipariş Formunu** doldurur:
   - Firma bilgileri
   - Ürün seçimi ve adet
   - Özel etiket tercihi
   - Logo yükleme (opsiyonel)
   - Özel talepler
4. **Form gönderilir** → Sipariş numarası alır
5. Eva Home'dan **teklif bekler**

### Admin Tarafı

1. **Admin Panel** → Toplu Siparişler menüsü
2. **Yeni talep** geldiğinde bildirim görür
3. **Sipariş detayını** inceler:
   - Firma bilgileri
   - Ürün ve adet
   - Özel etiket talebi
   - Yüklenen logo
4. **Teklif hazırlar** ve gönderir
5. **Sipariş durumunu** takip eder:
   - New → Reviewing → Quoted → Confirmed → Production → Shipped → Delivered

---

## 🗄️ Veritabanı Tabloları

### 1. `wholesale_orders` Tablosu

| Alan | Tip | Açıklama |
|------|-----|----------|
| order_number | VARCHAR(50) | Sipariş numarası (WSL-20241007-XXXX) |
| company_name | VARCHAR(255) | Firma adı |
| contact_person | VARCHAR(255) | Yetkili kişi |
| email | VARCHAR(255) | E-posta |
| phone | VARCHAR(20) | Telefon |
| company_type | ENUM | hotel, spa, corporate, boutique, other |
| product_type | VARCHAR(255) | Seçilen paket |
| quantity | INT | Sipariş adedi |
| custom_label | BOOLEAN | Özel etiket var mı? |
| label_type | ENUM | markasiz, kendi_markasi, eva_home |
| custom_text | TEXT | Etiket metni |
| logo_file | VARCHAR(255) | Yüklenen logo |
| status | ENUM | new, reviewing, quoted, confirmed, production, shipped, delivered, cancelled |
| quote_amount | DECIMAL | Teklif tutarı |

### 2. `wholesale_packages` Tablosu

| Alan | Tip | Açıklama |
|------|-----|----------|
| name | VARCHAR(255) | Paket adı |
| description | TEXT | Paket açıklaması |
| product_type | VARCHAR(100) | Ürün türü kodu |
| min_quantity | INT | Minimum sipariş adedi |
| unit_price | DECIMAL | Birim fiyat |
| includes | TEXT | Pakete dahil olanlar |
| custom_label_available | BOOLEAN | Özel etiket uygulanabilir mi? |

---

## 🎨 Kullanıcı Arayüzü

### Ana Sayfada Toplu Sipariş Bölümü

```
┌────────────────────────────────────────────────┐
│  🏢 Kurumsal & Toplu Sipariş                   │
│                                                 │
│  [🏨 Butik]  [💆 SPA]  [🏢 Kurumsal]  [🏪 Butik]│
│   Oteller    Wellness   Firmalar      Mağazalar│
│                                                 │
│  ✅ Min 50 adet                                │
│  ✅ Özel etiket                                │
│  ✅ Logo baskı                                 │
│  ✅ Özel fiyat                                 │
│                                                 │
│            [📋 Talep Oluştur]                  │
└────────────────────────────────────────────────┘
```

### Toplu Sipariş Formu Sayfası

```
┌────────────────────────────────────────────────┐
│  📦 Toplu Sipariş Paketleri                    │
│  ┌────────┐ ┌────────┐ ┌────────┐             │
│  │8 Renk  │ │Mini Set│ │Lux Set │             │
│  │Refil   │ │4'lü    │ │3'lü    │             │
│  │Min:50  │ │Min:100 │ │Min:30  │             │
│  │₺280    │ │₺180    │ │₺650    │             │
│  └────────┘ └────────┘ └────────┘             │
│                                                 │
│  📋 Sipariş Formu                              │
│  ┌──────────────────────────────────┐          │
│  │ Firma Bilgileri                  │          │
│  │ - Firma Adı, Yetkili, İletişim   │          │
│  │                                   │          │
│  │ Ürün Bilgileri                   │          │
│  │ - Paket Seçimi, Adet              │          │
│  │ - Tahmini Tutar (Otomatik)        │          │
│  │                                   │          │
│  │ Özel Etiket Seçenekleri           │          │
│  │ ☐ Özel Etiket İstiyorum           │          │
│  │   ○ Markasız                      │          │
│  │   ○ Kendi Markanız                │          │
│  │   ○ Eva Home                      │          │
│  │   [Logo Yükle]                    │          │
│  │   Etiket Metni: [_____________]   │          │
│  │                                   │          │
│  │ Özel Talepler                     │          │
│  │ [_____________________________]   │          │
│  │                                   │          │
│  │      [📤 Talep Gönder]           │          │
│  └──────────────────────────────────┘          │
└────────────────────────────────────────────────┘
```

### Admin Paneli - Toplu Siparişler

```
┌────────────────────────────────────────────────┐
│ 📊 İstatistikler                               │
│ [Yeni: 3] [İnceleniyor: 2] [Teklif: 1] [✓: 5] │
│                                                 │
│ 📋 Sipariş Listesi                             │
│ ┌──────────────────────────────────────────┐   │
│ │No  │Firma │Ürün │Adet│Etiket│Durum│İşlem│   │
│ ├──────────────────────────────────────────┤   │
│ │WSL-│Otel  │Refil│100 │✅Logo│Yeni │👁💰⚙│   │
│ │001 │      │8clr │    │      │     │     │   │
│ ├──────────────────────────────────────────┤   │
│ │WSL-│SPA   │Mini │200 │Marksz│İncl │👁💰⚙│   │
│ │002 │      │4'lü │    │      │     │     │   │
│ └──────────────────────────────────────────┘   │
│                                                 │
│ İşlemler:                                      │
│   👁 Detay Görüntüle                           │
│   💰 Teklif Gönder                             │
│   ⚙ Durum Değiştir                             │
└────────────────────────────────────────────────┘
```

---

## 🚀 Kurulum

### Yöntem 1: BAT Dosyası (Önerilen)
```
TOPLU_SİPARİŞ_KUR.bat dosyasına çift tıklayın
```

### Yöntem 2: Manuel
```
http://localhost/evahome/create_wholesale_tables.php
```

Kurulum sonrası:
- ✅ 2 tablo oluşturulur
- ✅ 5 örnek paket eklenir
- ✅ Sistem kullanıma hazır

---

## 📊 Sipariş Durumları

| Durum | Açıklama | Renk |
|-------|----------|------|
| **new** | Yeni talep geldi | 🔴 Kırmızı |
| **reviewing** | İnceleniyor | 🟡 Sarı |
| **quoted** | Teklif gönderildi | 🔵 Mavi |
| **confirmed** | Müşteri onayladı | 🟢 Yeşil |
| **production** | Üretim aşamasında | 🟣 Mor |
| **shipped** | Kargoya verildi | 🟢 Yeşil |
| **delivered** | Teslim edildi | 🟢 Yeşil |
| **cancelled** | İptal edildi | ⚫ Gri |

---

## 🎯 Özellikler

### Müşteri Özellikleri
- ✅ Online toplu sipariş formu
- ✅ Ürün paketlerini görüntüleme
- ✅ Minimum sipariş adedi kontrolü
- ✅ Tahmini tutar hesaplama
- ✅ Özel etiket seçenekleri
- ✅ Logo yükleme
- ✅ Özel talep notu
- ✅ Sipariş numarası ile takip

### Admin Özellikleri
- ✅ Tüm toplu siparişleri görüntüleme
- ✅ Durum bazlı istatistikler
- ✅ Sipariş detayları
- ✅ Logo ve etiket bilgileri
- ✅ Teklif gönderme sistemi
- ✅ Durum güncelleme
- ✅ Filtreleme ve arama
- ✅ Bildirim sistemi (Yeni sipariş sayısı)

---

## 🔗 Sayfalar

### Müşteri Tarafı

#### 1. Ana Sayfa - Toplu Sipariş Bölümü
```
http://localhost/evahome/#wholesale
```
- Hedef kitle gösterimi
- Özel etiket seçenekleri
- "Talep Oluştur" butonu

#### 2. Toplu Sipariş Formu
```
http://localhost/evahome/toplu-siparis.php
```
**Form Bölümleri:**
1. Firma Bilgileri
   - Firma adı, yetkili, e-posta, telefon
   - Firma türü, adres, şehir
   
2. Ürün Bilgileri
   - Paket seçimi
   - Adet (min validation)
   - Otomatik tutar hesaplama
   
3. Özel Etiket
   - Checkbox ile aktif/pasif
   - 3 etiket türü (radio)
   - Özel metin (textarea)
   - Logo yükleme (file input)
   
4. Özel Talepler
   - Serbest not alanı

### Admin Tarafı

#### 1. Toplu Sipariş Yönetimi
```
Admin Panel → Toplu Siparişler
http://localhost/evahome/admin/wholesale_orders.php
```

**Özellikler:**
- İstatistik kartları (Durum bazlı)
- Detaylı sipariş tablosu
- Detay görüntüleme modal
- Teklif gönderme modal
- Durum güncelleme dropdown

---

## 💻 Teknik Detaylar

### Form Validation

**JavaScript:**
```javascript
- Min. sipariş adedi kontrolü (50+)
- Otomatik tutar hesaplama
- Logo önizleme
- Özel etiket toggle
```

**PHP:**
```php
- Zorunlu alan kontrolü
- E-posta validasyonu
- Dosya yükleme güvenliği
- SQL injection koruması
```

### Dosya Yükleme

**Konum:** `uploads/logos/`

**Güvenlik:**
- Dosya uzantısı kontrolü
- Dosya boyutu limiti (5MB)
- Benzersiz dosya adı (uniqid)
- Güvenli klasör izinleri

### Sipariş Numarası Formatı

```
WSL-YYYYMMDD-XXXX

WSL = Wholesale (Toplu Sipariş)
YYYYMMDD = Tarih
XXXX = Benzersiz 4 karakter
```

**Örnek:** `WSL-20241007-A3F9`

---

## 📱 Responsive Tasarım

### Desktop
- 4 sütunlu paket gösterimi
- Geniş form alanları
- Yan yana input'lar

### Tablet
- 2 sütunlu paket gösterimi
- Orta genişlik form

### Mobil
- 1 sütunlu paket gösterimi
- Tam genişlik input'lar
- Stack butonlar

---

## 🎨 Tasarım Özellikleri

### Renk Paleti
- **Primary:** #c9a24a (Eva Home Altın)
- **Gradient:** #c9a24a → #a0883d
- **Badge Background:** rgba(201, 162, 74, 0.15)
- **Success:** #28a745
- **Warning:** #ffc107
- **Danger:** #dc3545

### Icon'lar
- 🏨 Hotel → `fa-hotel`
- 💆 SPA → `fa-spa`
- 🏢 Corporate → `fa-building`
- 🏪 Boutique → `fa-store`
- 📦 Package → `fa-box`
- 🏷️ Label → `fa-tag`
- 📤 Submit → `fa-paper-plane`

---

## 🧪 Test Senaryoları

### ✅ Müşteri Akışı Testi

1. Ana sayfaya git: `http://localhost/evahome/`
2. Aşağı scroll yap → "Kurumsal & Toplu Sipariş" bölümünü gör
3. "Talep Oluştur" butonuna tıkla
4. Formu doldur:
   - Firma: Test Otel
   - Yetkili: Ahmet Yılmaz
   - E-posta: test@hotel.com
   - Telefon: 05551234567
   - Firma Türü: Butik Otel
   - Paket: 8 Renk Koleksiyon Refil Seti
   - Adet: 100
   - Özel Etiket: ☑ İstiyorum
   - Etiket Türü: Kendi Markanız
   - Logo: [Test logo yükle]
5. "Sipariş Talebini Gönder" tıkla
6. Başarı mesajı ve sipariş numarası gör

### ✅ Admin Akışı Testi

1. Admin paneline giriş: `http://localhost/evahome/admin/login.php`
2. Sol menüden "Toplu Siparişler" tıkla
3. İstatistiklerde "Yeni: 1" gör
4. Tabloda siparişi gör
5. 👁 butonuna tıkla → Detayları görüntüle
6. 💰 butonuna tıkla → Teklif gönder
7. ⚙ menüsünden durumu değiştir

---

## 📈 İstatistikler

Admin panelinde gösterilen metrikler:

- **Yeni Talepler:** new durumundaki sipariş sayısı
- **İnceleniyor:** reviewing durumundaki
- **Teklif Verildi:** quoted durumundaki
- **Onaylandı:** confirmed durumundaki
- **Üretimde:** production durumundaki
- **Toplam:** Tüm toplu siparişler

---

## 💡 Kullanım İpuçları

### Müşteriler İçin
- Minimum 50 adet siparişlerde özel fiyat avantajı
- Özel etiket için logo dosyanızı hazırlayın (PNG, AI)
- Teslimat tarihi tercihlerinizi "Özel Talepler" alanına yazın
- Renk tercihi varsa belirtin

### Adminler İçin
- Yeni siparişleri hızlıca "İnceleniyor" durumuna alın
- Teklif gönderirken teslimat süresini belirtin
- Logo kalitesini kontrol edin
- Özel talepleri not edin
- Onaylandıktan sonra hemen üretime başlayın

---

## 🔔 Bildirimler

### Sidebar'da Otomatik Bildirim
```
Toplu Siparişler [YENİ] [3]
                  ↑     ↑
                Badge  Yeni sipariş sayısı
```

---

## 🎉 Kurulum Özeti

### Oluşturulan Dosyalar (5 Yeni)
1. `create_wholesale_tables.php` - Tablo kurulumu
2. `toplu-siparis.php` - Müşteri sipariş formu
3. `admin/wholesale_orders.php` - Admin yönetim sayfası
4. `TOPLU_SİPARİŞ_KUR.bat` - Hızlı kurulum
5. `TOPLU_SİPARİŞ_REHBERİ.md` - Bu dosya

### Güncellenen Dosyalar (2)
1. `admin/includes/header.php` - Sidebar'a menü eklendi
2. `index.php` - Toplu sipariş bölümü eklendi

---

## ✅ Kontrol Listesi

Kurulum sonrası kontrol edin:

- [ ] Tablolar oluşturuldu mu? (`wholesale_orders`, `wholesale_packages`)
- [ ] Örnek paketler eklendi mi? (5 adet)
- [ ] Ana sayfada toplu sipariş bölümü görünüyor mu?
- [ ] Toplu sipariş formu çalışıyor mu?
- [ ] Logo yükleme çalışıyor mu?
- [ ] Admin panelinde menü görünüyor mu?
- [ ] Sipariş yönetim sayfası açılıyor mu?
- [ ] Durum güncelleme çalışıyor mu?

---

**Eva Home** - Artık kurumsal müşterilere de hizmet vermeye hazır! 🏢✨

**Min. Sipariş:** 50 adet | **Özel Etiket:** ✅ | **Logo Baskı:** ✅

