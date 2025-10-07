@echo off
chcp 65001 >nul
color 0E
cls
echo.
echo ════════════════════════════════════════════════════════════════
echo       🏢 EVA HOME - TOPLU SİPARİŞ SİSTEMİ KURULUMU 🏢
echo ════════════════════════════════════════════════════════════════
echo.
echo Bu sistem kurumsal müşteriler için tasarlanmıştır:
echo.
echo Hedef Kitle:
echo   🏨 Butik Oteller
echo   💆 SPA & Wellness Merkezleri
echo   🏢 Kurumsal Firmalar (Yılbaşı Hediyesi vb.)
echo   🏪 Butik Mağazalar (Perakende Satış)
echo.
echo Özellikler:
echo   ✅ Minimum 50 adet toplu sipariş
echo   ✅ Özel etiket seçenekleri (Markasız/Kendi Markanız)
echo   ✅ Logo yükleme ve özel metin
echo   ✅ 8 renk koleksiyon refil setleri
echo   ✅ Özel fiyatlandırma
echo   ✅ Admin panelinde sipariş yönetimi
echo.
echo ════════════════════════════════════════════════════════════════
echo.
pause

echo.
echo 🚀 Veritabanı tabloları oluşturuluyor...
echo.
start http://localhost/evahome/create_wholesale_tables.php

echo.
echo ⏳ Lütfen tarayıcıdaki işlemin tamamlanmasını bekleyin...
timeout /t 5 /nobreak >nul

echo.
echo ════════════════════════════════════════════════════════════════
echo              ✨ KURULUM TAMAMLANDI ✨
echo ════════════════════════════════════════════════════════════════
echo.
echo Oluşturulan Özellikler:
echo   ✅ wholesale_orders tablosu (Toplu siparişler)
echo   ✅ wholesale_packages tablosu (Ürün paketleri)
echo   ✅ 5 örnek paket eklendi
echo   ✅ Ana sayfada Toplu Sipariş bölümü
echo   ✅ Toplu sipariş formu sayfası
echo   ✅ Admin panelinde sipariş yönetimi
echo.
echo 🔗 Hızlı Erişim:
echo    🏠 Ana Sayfa: http://localhost/evahome/#wholesale
echo    📋 Sipariş Formu: http://localhost/evahome/toplu-siparis.php
echo    ⚙️ Admin Panel: http://localhost/evahome/admin/wholesale_orders.php
echo.
echo ════════════════════════════════════════════════════════════════
echo.
echo Toplu sipariş sayfasını açmak ister misiniz? (E/H)
set /p choice=Seçiminiz: 
if /i "%choice%"=="E" (
    start http://localhost/evahome/toplu-siparis.php
    echo ✓ Toplu sipariş formu açılıyor...
    timeout /t 2 /nobreak >nul
    echo.
    echo Admin panelini de açmak ister misiniz? (E/H)
    set /p choice2=Seçiminiz: 
    if /i "%choice2%"=="E" (
        start http://localhost/evahome/admin/wholesale_orders.php
        echo ✓ Admin panel açılıyor...
    )
)

echo.
pause

