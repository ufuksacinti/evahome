# 🕯️ Eva Home - Veritabanı Güncelleme Rehberi

## 🚀 Hızlı Başlangıç

Veritabanınızı eksiksiz hale getirmek için aşağıdaki adımları izleyin:

### 1. Otomatik Güncelleme (Önerilen)

Tarayıcınızda şu adresi açın:
```
http://localhost/evahome/complete_database.php
```

Bu dosya otomatik olarak şunları yapacaktır:
- ✅ Eksik sütunları ekleyecek
- ✅ Eva Home kategorilerini ve koleksiyonlarını ekleyecek
- ✅ Renk kodlarıyla birlikte ürünleri ekleyecek
- ✅ Veritabanı istatistiklerini gösterecek

### 2. Manuel Kontrol

Veritabanınızı manuel olarak kontrol etmek için:
```
http://localhost/phpmyadmin
```

## 📋 Eklenen Özellikler

### Yeni Sütunlar

#### Products Tablosu
- `color_name` - Ürün rengi (örn: Altın, Bordo, Pembe)
- `color_code` - Hex renk kodu (örn: #FFD700)

#### Contact Messages Tablosu
- `phone` - Telefon numarası alanı

### Yeni Kategoriler

**Ana Kategoriler:**
1. 🕯️ Candles - El yapımı soya mumları
2. 🌸 Room Fragrances - Oda kokuları
3. 🎨 Decor & Trays - Dekoratif ürünler
4. 🎁 Gift Sets - Hediye setleri
5. ♻️ Refill Collection - Yeniden dolum koleksiyonu
6. 🔧 Accessories - Aksesuar ürünler

**Koleksiyonlar (Alt Kategoriler):**
- Golden Jasmine (Altın) - Şans ve pozitif enerji
- Velvet Rose (Bordo) - Aşk ve sevgi
- Citrus Harmony (Turuncu) - Neşe ve canlılık
- Luminous Bloom (Pembe) - Yenilenme ve tazelik
- Sacred Oud (Koyu Yeşil) - Huzur ve bereket
- Earth Harmony (Kahve) - Bolluk ve topraklama
- Royal Spice (Gri) - Arınma enerjisi
- Lavender Peace (Lila) - Rahatlama enerjisi

### Yeni Ürünler

Toplam **20+ ürün** eklendi:
- Her koleksiyondan çeşitli mum boyutları
- Room diffuser ürünler
- Dekoratif tepsiler ve objeler
- Hediye setleri
- Mum bakım aksesuarları

## 📊 Veritabanı Yapısı

```
┌─────────────────────────────────────┐
│         EVA HOME DATABASE           │
├─────────────────────────────────────┤
│ ✅ 14 Ana Tablo                     │
│ ✅ 20+ Kategori/Koleksiyon          │
│ ✅ 30+ Ürün                         │
│ ✅ Blog Yazıları                    │
│ ✅ Sipariş Sistemi                  │
│ ✅ Mesaj Yönetimi                   │
└─────────────────────────────────────┘
```

## 🔧 Sorun Giderme

### Veritabanı Bağlantı Hatası
```bash
# XAMPP'ta MySQL servisini başlatın
# Control Panel > MySQL > Start
```

### Tablolar Oluşmadı
```
1. http://localhost/evahome/install.php adresini ziyaret edin
2. Veya setup.php dosyasını kullanın
3. Manuel olarak database.sql dosyasını import edin
```

### Ürünler Görünmüyor
```bash
# complete_database.php dosyasını tekrar çalıştırın
# Veya add_sample_data.php ile daha fazla örnek veri ekleyin
```

## 🎨 Renk Kodları

Eva Home koleksiyonlarının renk paleti:

| Koleksiyon | Renk | Hex Kod | Enerji |
|-----------|------|---------|---------|
| Golden Jasmine | Altın | #FFD700 | Şans |
| Velvet Rose | Bordo | #8B0A50 | Aşk |
| Citrus Harmony | Turuncu | #FF8C42 | Neşe |
| Luminous Bloom | Pembe | #FFB6C1 | Yenilenme |
| Sacred Oud | Koyu Yeşil | #2F4F4F | Huzur |
| Earth Harmony | Kahve | #8B4513 | Bolluk |
| Royal Spice | Gri | #808080 | Arınma |
| Lavender Peace | Lila | #E6E6FA | Rahatlama |

## 🔗 Hızlı Erişim Linkleri

- **Ana Sayfa:** http://localhost/evahome/
- **Admin Paneli:** http://localhost/evahome/admin/login.php
- **Kurulum:** http://localhost/evahome/setup.php
- **phpMyAdmin:** http://localhost/phpmyadmin

## 🔑 Varsayılan Giriş Bilgileri

**Admin Paneli:**
- Kullanıcı Adı: `admin`
- Şifre: `password`

⚠️ **Güvenlik:** İlk girişten sonra şifrenizi değiştirin!

## 📝 Notlar

- Tüm ürünler aktif durumda ve stokta
- Fiyatlar TRY (Türk Lirası) cinsindendir
- İndirimli fiyatlar mevcuttur
- Tüm mumlar el yapımı soya mumudur
- Alçı kaplar pastel renklerdedir

## 🎯 Sonraki Adımlar

1. ✅ Veritabanını güncelleyin: `complete_database.php`
2. ✅ Admin paneline giriş yapın
3. ✅ Ürünleri inceleyin ve gerekirse düzenleyin
4. ✅ Ürün resimlerini yükleyin
5. ✅ Site ayarlarını yapılandırın

## 💡 Ek Özellikler

- **Blog Sistemi** - Dekorasyon ipuçları için
- **Sipariş Yönetimi** - Müşteri siparişlerini takip edin
- **Mesaj Sistemi** - İletişim formundan gelen mesajlar
- **Kategori Yönetimi** - Dinamik kategori yapısı
- **Arama ve Filtreleme** - Ürünleri kolayca bulun

---

**Eva Home** - Ev dekorasyonunda kalite ve şıklığın buluştuğu yer! 🏠✨

