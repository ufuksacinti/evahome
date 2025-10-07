@echo off
chcp 65001 >nul
color 0A
echo.
echo ================================================================
echo       🕯️ EVA HOME - VERİTABANI GÜNCELLEME 🕯️
echo ================================================================
echo.
echo Bu dosya veritabanınızı otomatik olarak güncelleyecek.
echo.
echo Güncellenecek öğeler:
echo   ✅ Eksik sütunlar (color_name, color_code, phone)
echo   ✅ Eva Home kategorileri ve koleksiyonları
echo   ✅ 20+ ürün (renk kodlarıyla birlikte)
echo.
echo ================================================================
echo.
pause

echo.
echo 🚀 Tarayıcıda açılıyor...
echo.

start http://localhost/evahome/complete_database.php

echo.
echo ================================================================
echo Tarayıcınızda açılan sayfadan güncelleme yapabilirsiniz.
echo.
echo Hızlı erişim linkleri:
echo   🏠 Ana Sayfa: http://localhost/evahome/
echo   ⚙️ Admin Paneli: http://localhost/evahome/admin/login.php
echo   📊 phpMyAdmin: http://localhost/phpmyadmin
echo.
echo Varsayılan giriş bilgileri:
echo   Kullanıcı: admin
echo   Şifre: password
echo ================================================================
echo.
pause

