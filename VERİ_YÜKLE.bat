@echo off
chcp 65001 >nul
color 0E
echo.
echo ================================================================
echo     🕯️ EVA HOME - KAPSAMLI VERİ YÜKLEME 🕯️
echo ================================================================
echo.
echo Bu script veritabanınıza kapsamlı veri yükleyecek:
echo.
echo   ✅ EN AZ 10 BLOG YAZISI
echo   ✅ EN AZ 100 ÜRÜN
echo.
echo Yüklenecek içerikler:
echo   📝 15 Blog yazısı (mum bakımı, aromaterapi, koleksiyonlar)
echo   🕯️ 120+ Mum çeşidi (her koleksiyondan 15 farklı tip)
echo   🌸 32 Room fragrance ürünü
echo   🎨 32 Dekoratif ürün
echo   🔧 12 Aksesuar ürünü
echo.
echo   TOPLAM: 196+ ÜRÜN!
echo.
echo ================================================================
echo.
pause

echo.
echo 🚀 Veri yükleme başlıyor...
echo 📊 İlerleme tarayıcıda görüntülenecek
echo.

start http://localhost/evahome/load_massive_data.php

echo.
echo ================================================================
echo Tarayıcınızda veri yükleme işlemi başlatıldı.
echo Lütfen sayfanın yüklenmesini bekleyin.
echo.
echo Bu işlem 10-30 saniye sürebilir.
echo.
echo İşlem tamamlandıktan sonra:
echo   🏠 Ana Sayfa: http://localhost/evahome/
echo   ⚙️ Admin Paneli: http://localhost/evahome/admin/
echo   📦 Ürünler: http://localhost/evahome/admin/products.php
echo ================================================================
echo.
pause

