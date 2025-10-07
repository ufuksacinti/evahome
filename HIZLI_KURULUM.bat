@echo off
chcp 65001 >nul
color 0B
cls
echo.
echo ════════════════════════════════════════════════════════════════
echo           🕯️ EVA HOME - HIZLI TAM KURULUM 🕯️
echo ════════════════════════════════════════════════════════════════
echo.
echo Bu script tam kurulum yapacak:
echo.
echo   ADIM 1: Eksik tabloları oluştur (customers, vb.)
echo   ADIM 2: Veritabanını güncelle (renk kodları, telefon)
echo   ADIM 3: 15 blog + 196+ ürün yükle
echo.
echo ════════════════════════════════════════════════════════════════
echo.
pause

echo.
echo ┌────────────────────────────────────────────────────────────┐
echo │ ADIM 1/3: Eksik Tabloları Düzelt                          │
echo └────────────────────────────────────────────────────────────┘
echo.
echo 🔧 Customers tablosu ve diğer eksikler oluşturuluyor...
timeout /t 2 /nobreak >nul
start http://localhost/evahome/fix_missing_tables.php
echo ✓ Tablo düzeltme sayfası açıldı
echo.
echo Lütfen tarayıcıdaki işlemin tamamlanmasını bekleyin...
timeout /t 8 /nobreak >nul

echo.
echo ┌────────────────────────────────────────────────────────────┐
echo │ ADIM 2/3: Veritabanını Güncelle                           │
echo └────────────────────────────────────────────────────────────┘
echo.
echo 🎨 Renk kodları, kategoriler ve sütunlar ekleniyor...
timeout /t 2 /nobreak >nul
start http://localhost/evahome/complete_database.php
echo ✓ Veritabanı güncelleme sayfası açıldı
echo.
echo Lütfen tarayıcıdaki işlemin tamamlanmasını bekleyin...
timeout /t 8 /nobreak >nul

echo.
echo ┌────────────────────────────────────────────────────────────┐
echo │ ADIM 3/3: Kapsamlı Veri Yükle                             │
echo └────────────────────────────────────────────────────────────┘
echo.
echo 📦 15 blog yazısı ve 196+ ürün yükleniyor...
timeout /t 2 /nobreak >nul
start http://localhost/evahome/load_massive_data.php
echo ✓ Veri yükleme sayfası açıldı
echo.
echo ⏳ Veri yükleme işlemi 10-30 saniye sürebilir...
echo    Lütfen tarayıcıdaki ilerleme çubuğunu takip edin.

echo.
echo ════════════════════════════════════════════════════════════════
echo              ✨ KURULUM TAMAMLANDI ✨
echo ════════════════════════════════════════════════════════════════
echo.
echo Veritabanınız artık tamamen hazır:
echo   ✅ 15 Tablo (users, products, customers, vb.)
echo   ✅ 20+ Kategori ve koleksiyon
echo   ✅ 15+ Blog yazısı
echo   ✅ 196+ Ürün (mumlar, room fragrances, dekor, aksesuar)
echo.
echo ════════════════════════════════════════════════════════════════
echo.
echo 🔗 Hızlı Erişim:
echo    🏠 Ana Sayfa: http://localhost/evahome/
echo    ⚙️ Admin Paneli: http://localhost/evahome/admin/login.php
echo    📦 Ürünler: http://localhost/evahome/admin/products.php
echo    📝 Blog: http://localhost/evahome/admin/blog_posts.php
echo.
echo 🔑 Admin Giriş:
echo    Kullanıcı: admin
echo    Şifre: password
echo.
echo ════════════════════════════════════════════════════════════════
echo.
echo Şimdi admin paneline gitmek ister misiniz? (E/H)
set /p choice=Seçiminiz: 
if /i "%choice%"=="E" (
    start http://localhost/evahome/admin/login.php
    echo ✓ Admin paneli açılıyor...
)

echo.
pause

