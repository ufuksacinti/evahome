@echo off
chcp 65001 >nul
color 0A
cls
echo.
echo ════════════════════════════════════════════════════════════════
echo           🚀 EVA HOME - GITHUB REPO OLUŞTURMA 🚀
echo ════════════════════════════════════════════════════════════════
echo.
echo Bu script Eva Home projesini GitHub'a yükleyecek.
echo.
echo Hazırlık:
echo   ✅ .gitignore oluşturuldu
echo   ✅ LICENSE (MIT) eklendi
echo   ✅ README_GITHUB.md hazırlandı
echo   ✅ database.example.php oluşturuldu
echo.
echo ════════════════════════════════════════════════════════════════
echo.
pause

echo.
echo 📋 GIT KONTROL EDİLİYOR...
git --version >nul 2>&1
if errorlevel 1 (
    echo.
    echo ❌ Git yüklü değil!
    echo.
    echo Lütfen Git'i indirin: https://git-scm.com/download/win
    echo.
    pause
    exit
)
echo ✅ Git bulundu
echo.

echo 🔧 Git repository oluşturuluyor...
git init
if errorlevel 1 (
    echo ❌ Git init hatası
    pause
    exit
)
echo ✅ Git repository oluşturuldu
echo.

echo 📝 Dosyalar ekleniyor...
git add .
echo ✅ Tüm dosyalar eklendi
echo.

echo 💾 İlk commit yapılıyor...
git commit -m "🕯️ Eva Home - İlk commit - Tam özellikli e-ticaret sistemi"
echo ✅ Commit tamamlandı
echo.

echo ════════════════════════════════════════════════════════════════
echo.
echo 📌 SONRAKİ ADIMLAR:
echo.
echo 1. GitHub'da yeni repository oluşturun:
echo    https://github.com/new
echo.
echo 2. Repository adı: evahome
echo    Açıklama: El yapımı mum e-ticaret sistemi
echo.
echo 3. Aşağıdaki komutları çalıştırın:
echo.
echo    git branch -M main
echo    git remote add origin https://github.com/KULLANICI_ADI/evahome.git
echo    git push -u origin main
echo.
echo ════════════════════════════════════════════════════════════════
echo.
echo GitHub repository URL'nizi girin (veya boş bırakıp manuel yapın):
set /p repo_url=Repository URL: 

if not "%repo_url%"=="" (
    echo.
    echo 🔗 Remote ekleniyor...
    git remote add origin %repo_url%
    
    echo.
    echo 📤 GitHub'a push ediliyor...
    git branch -M main
    git push -u origin main
    
    if errorlevel 1 (
        echo.
        echo ❌ Push hatası! Manuel olarak yapmanız gerekebilir.
        echo.
    ) else (
        echo.
        echo ✅ Başarıyla GitHub'a yüklendi!
        echo.
        echo 🌐 Repository: %repo_url%
        echo.
    )
)

echo.
echo ════════════════════════════════════════════════════════════════
echo              ✨ İŞLEM TAMAMLANDI ✨
echo ════════════════════════════════════════════════════════════════
echo.
pause

