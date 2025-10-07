@echo off
chcp 65001 >nul
color 0D
cls
echo.
echo ════════════════════════════════════════════════════════════════
echo         📊 EVA HOME - ANALİTİK SİSTEMİ KURULUMU 📊
echo ════════════════════════════════════════════════════════════════
echo.
echo Bu script şunları yapacak:
echo.
echo   ✅ Favorites (Favoriler) tablosu oluştur
echo   ✅ Cart Analytics (Sepet İstatistikleri) tablosu oluştur
echo   ✅ Örnek analitik veri ekle
echo   ✅ Admin paneline istatistik sayfası ekle
echo.
echo Yeni Özellikler:
echo   📊 Ürün başına sepete eklenme sayısı
echo   ❤️ Ürün başına favoriye eklenme sayısı
echo   👥 Benzersiz kullanıcı sayıları
echo   📈 Popülerlik skorları
echo   📉 Grafikler ve raporlar
echo.
echo ════════════════════════════════════════════════════════════════
echo.
pause

echo.
echo 🚀 Analitik tabloları oluşturuluyor...
echo.
start http://localhost/evahome/add_analytics_tables.php

echo.
echo ⏳ Lütfen tarayıcıdaki işlemin tamamlanmasını bekleyin...
timeout /t 5 /nobreak >nul

echo.
echo ════════════════════════════════════════════════════════════════
echo              ✨ KURULUM TAMAMLANDI ✨
echo ════════════════════════════════════════════════════════════════
echo.
echo Yeni Özellikler Eklendi:
echo   ✅ Sepet ve Favori takip tabloları
echo   ✅ Ürün İstatistikleri sayfası
echo   ✅ TinyMCE Blog Editörü
echo   ✅ Grafikler ve raporlar
echo.
echo 🔗 Hızlı Erişim:
echo    📊 İstatistikler: http://localhost/evahome/admin/product_analytics.php
echo    📝 Blog Ekle: http://localhost/evahome/admin/blog_add.php
echo    ⚙️ Admin Panel: http://localhost/evahome/admin/dashboard.php
echo.
echo ════════════════════════════════════════════════════════════════
echo.
echo Admin paneline gitmek ister misiniz? (E/H)
set /p choice=Seçiminiz: 
if /i "%choice%"=="E" (
    start http://localhost/evahome/admin/login.php
    echo ✓ Admin paneli açılıyor...
    timeout /t 2 /nobreak >nul
    start http://localhost/evahome/admin/product_analytics.php
    echo ✓ Ürün İstatistikleri açılıyor...
)

echo.
pause

