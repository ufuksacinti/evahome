# 🚀 Eva Home - GitHub'a Yükleme Rehberi

## 📋 Hazırlık Tamamlandı

Aşağıdaki dosyalar GitHub için hazırlandı:

- ✅ `.gitignore` - Hassas dosyaları hariç tutar
- ✅ `LICENSE` - MIT lisansı
- ✅ `README_GITHUB.md` - GitHub için README
- ✅ `config/database.example.php` - DB config örneği
- ✅ `.gitkeep` dosyaları - Boş klasörler için

## 🎯 Yöntem 1: Otomatik (BAT Dosyası)

### Adımlar

1. **GIT_PUSH.bat** dosyasına çift tıklayın

2. Script otomatik olarak:
   - Git'in yüklü olduğunu kontrol eder
   - Git repository oluşturur
   - Tüm dosyaları ekler
   - İlk commit yapar
   - GitHub URL'sini sorar
   - Push eder

3. GitHub repository URL'nizi girin:
   ```
   https://github.com/KULLANICI_ADI/evahome.git
   ```

## 🎯 Yöntem 2: Manuel Komutlar

### Adım 1: GitHub'da Repository Oluşturun

1. [GitHub](https://github.com)'a gidin ve giriş yapın

2. Sağ üstteki **+** → **New repository** tıklayın

3. Repository bilgileri:
   ```
   Repository name: evahome
   Description: 🕯️ Eva Home - El yapımı mum e-ticaret sistemi
   Public/Private: Seçiminize göre
   
   ☐ Add a README file (BUNU SEÇMEYİN - bizde zaten var)
   ☐ Add .gitignore (BUNU SEÇMEYİN - bizde zaten var)
   ☑ Choose a license: MIT
   ```

4. **Create repository** butonuna tıklayın

5. Repository URL'nizi kopyalayın:
   ```
   https://github.com/KULLANICI_ADI/evahome.git
   ```

### Adım 2: Lokal Git Repository Oluşturun

Terminal veya PowerShell'de şu komutları çalıştırın:

```bash
# Proje dizinine gidin
cd C:\xampp\htdocs\evahome

# Git repository başlatın
git init

# Tüm dosyaları staging area'ya ekleyin
git add .

# İlk commit yapın
git commit -m "🕯️ Eva Home - İlk commit - Tam özellikli e-ticaret sistemi"

# Ana branch adını main yapın
git branch -M main

# GitHub remote ekleyin (KULLANICI_ADI'nizi değiştirin)
git remote add origin https://github.com/KULLANICI_ADI/evahome.git

# GitHub'a push edin
git push -u origin main
```

### Adım 3: README'yi Güncelleyin (İsteğe Bağlı)

GitHub'da repo açıldıktan sonra:

```bash
# README_GITHUB.md'yi README.md olarak kopyalayın
git mv README_GITHUB.md README.md

# Commit ve push edin
git add README.md
git commit -m "📝 README güncellendi"
git push
```

## 🔐 GitHub Authentication

GitHub artık şifre ile push kabul etmiyor. İki seçenek var:

### Seçenek A: Personal Access Token (Önerilen)

1. GitHub → Settings → Developer settings → Personal access tokens
2. **Generate new token (classic)** tıklayın
3. Scope'lar:
   - ✅ repo (tüm alt seçenekler)
4. Token oluşturun ve **kopyalayın** (bir daha görmezsiniz!)
5. Git push yaparken:
   ```
   Username: KULLANICI_ADI
   Password: GITHUB_TOKEN (kopyaladığınız token)
   ```

### Seçenek B: GitHub CLI

```bash
# GitHub CLI kurun
winget install --id GitHub.cli

# Giriş yapın
gh auth login

# Push yapın
git push -u origin main
```

## 📁 Yüklenecek/Yüklenmeyecek Dosyalar

### ✅ Yüklenecekler

- Tüm `.php` dosyaları
- `.sql` dosyaları
- CSS/JS dosyaları
- Dokümantasyon (`.md`)
- `.gitignore`, `LICENSE`
- `.gitkeep` dosyaları

### ❌ Yüklenmeyecekler (.gitignore'da)

- `config/database.php` (hassas bilgi)
- `uploads/*` (kullanıcı yüklemeleri)
- `*.log` (log dosyaları)
- `.vscode/`, `.idea/` (editor ayarları)
- Geçici dosyalar

## 🔧 Sorun Giderme

### "Git is not recognized"

```bash
# Git'i indirin
https://git-scm.com/download/win

# Kurulum sonrası PowerShell'i yeniden başlatın
```

### "Permission denied (publickey)"

```bash
# SSH key oluşturun
ssh-keygen -t ed25519 -C "your_email@example.com"

# Public key'i GitHub'a ekleyin
# Settings → SSH and GPG keys → New SSH key
```

### "Remote already exists"

```bash
# Mevcut remote'u kaldırın
git remote remove origin

# Yeniden ekleyin
git remote add origin https://github.com/KULLANICI_ADI/evahome.git
```

### "Updates were rejected"

```bash
# Force push (SADECE İLK PUSH İÇİN)
git push -u origin main --force
```

## 📊 Commit Sonrası

GitHub'da göreceğiniz yapı:

```
evahome/
├── 📁 admin/             (Admin paneli)
├── 📁 assets/            (CSS, JS, images)
├── 📁 config/            (database.example.php)
├── 📁 uploads/           (.gitkeep ile)
├── 📄 index.php          (Ana sayfa)
├── 📄 database.sql       (DB şeması)
├── 📄 .gitignore
├── 📄 LICENSE
├── 📄 README.md
└── 📄 ...
```

## 🌟 Repository Özellikleri

GitHub'da yapabilecekleriniz:

- **Issues** - Bug raporları, özellik istekleri
- **Projects** - Proje yönetimi
- **Wiki** - Detaylı dokümantasyon
- **Actions** - CI/CD (isteğe bağlı)
- **Releases** - Versiyon yönetimi

## 📝 Commit Mesajı Önerileri

```bash
# Yeni özellik
git commit -m "✨ feat: Yeni özellik eklendi"

# Hata düzeltme
git commit -m "🐛 fix: Menü sorunu düzeltildi"

# Dokümantasyon
git commit -m "📝 docs: README güncellendi"

# Performans
git commit -m "⚡ perf: Sorgu optimizasyonu"

# Stil değişikliği
git commit -m "💄 style: CSS düzenlemesi"
```

## 🎉 Başarılı Push Sonrası

Repository başarıyla oluşturuldu! Şimdi yapabilirsiniz:

1. **README'yi düzenleyin** - GitHub'da görünümünü iyileştirin
2. **Topics ekleyin** - `php`, `ecommerce`, `candles`, `wholesale`
3. **Description ekleyin** - "El yapımı mum e-ticaret sistemi"
4. **Website ekleyin** - Demo link varsa
5. **Star koyun** - Kendi projenize ⭐

## 🔗 Repository Linki

Push tamamlandıktan sonra:

```
https://github.com/KULLANICI_ADI/evahome
```

Bu linki README'ye, dokümantasyona ve web sitenize ekleyebilirsiniz!

---

**Eva Home** - Artık GitHub'da! 🕯️✨

