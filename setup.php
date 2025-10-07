<?php
require_once 'config/database.php';

$page_title = "Eva Home Kurulum";
$success = '';
$error = '';

// Veritabanı durumunu kontrol et
$dbStatus = checkDatabaseStatus();

if ($_POST && isset($_POST['setup_database'])) {
    try {
        // SQL dosyasını oku ve çalıştır
        $sqlFile = 'database.sql';
        if (file_exists($sqlFile)) {
            $sql = file_get_contents($sqlFile);
            
            // SQL komutlarını ayır
            $statements = explode(';', $sql);
            $successCount = 0;
            $errorCount = 0;
            
            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (!empty($statement) && !preg_match('/^--/', $statement)) {
                    try {
                        $pdo->exec($statement);
                        $successCount++;
                    } catch (PDOException $e) {
                        $errorCount++;
                        // Hata mesajını logla ama devam et
                        error_log("SQL Error: " . $e->getMessage());
                    }
                }
            }
            
            if ($successCount > 0) {
                $success = "Veritabanı başarıyla kuruldu! ($successCount komut çalıştırıldı) Admin paneline giriş yapabilirsiniz.";
            } else {
                $error = "Kurulum sırasında hata oluştu. Lütfen install.php dosyasını çalıştırın.";
            }
        } else {
            $error = "database.sql dosyası bulunamadı.";
        }
    } catch (PDOException $e) {
        $error = "Kurulum hatası: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #fef7ee 0%, #f1f5f9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .setup-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .setup-header {
            background: linear-gradient(135deg, #f2740a 0%, #e35a00 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .status-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .status-item:last-child {
            border-bottom: none;
        }
        .status-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        .status-success {
            background-color: #d4edda;
            color: #155724;
        }
        .status-error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .status-warning {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="setup-card">
                    <div class="setup-header">
                        <i class="fas fa-home fa-3x mb-3"></i>
                        <h2 class="mb-0">Eva Home Kurulum</h2>
                        <p class="mb-0">Web sitesi ve admin paneli kurulumu</p>
                    </div>
                    
                    <div class="p-4">
                        <?php if ($success): ?>
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo escape($success); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo escape($error); ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Sistem Durumu -->
                        <h4 class="mb-3">
                            <i class="fas fa-info-circle me-2"></i>Sistem Durumu
                        </h4>
                        
                        <div class="mb-4">
                            <div class="status-item">
                                <div class="status-icon <?php echo $dbStatus['connected'] ? 'status-success' : 'status-error'; ?>">
                                    <i class="fas <?php echo $dbStatus['connected'] ? 'fa-check' : 'fa-times'; ?>"></i>
                                </div>
                                <div>
                                    <strong>Veritabanı Bağlantısı</strong>
                                    <br><small class="text-muted">
                                        <?php if ($dbStatus['connected']): ?>
                                            ✅ Bağlantı başarılı
                                        <?php else: ?>
                                            ❌ Bağlantı hatası: <?php echo escape($dbStatus['error'] ?? 'Bilinmeyen hata'); ?>
                                        <?php endif; ?>
                                    </small>
                                </div>
                            </div>
                            
                            <?php if ($dbStatus['connected']): ?>
                                <div class="status-item">
                                    <div class="status-icon <?php echo $dbStatus['tables_count'] > 0 ? 'status-success' : 'status-warning'; ?>">
                                        <i class="fas <?php echo $dbStatus['tables_count'] > 0 ? 'fa-check' : 'fa-exclamation'; ?>"></i>
                                    </div>
                                    <div>
                                        <strong>Veritabanı Tabloları</strong>
                                        <br><small class="text-muted">
                                            <?php if ($dbStatus['tables_count'] > 0): ?>
                                                ✅ <?php echo $dbStatus['tables_count']; ?> tablo mevcut
                                            <?php else: ?>
                                                ⚠️ Tablo bulunamadı - Kurulum gerekli
                                            <?php endif; ?>
                                        </small>
                                    </div>
                                </div>
                                
                                <?php if ($dbStatus['tables_count'] > 0): ?>
                                    <div class="status-item">
                                        <div class="status-icon status-success">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div>
                                            <strong>Kurulum Durumu</strong>
                                            <br><small class="text-muted">✅ Sistem hazır</small>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Kurulum Butonları -->
                        <?php if ($dbStatus['connected'] && $dbStatus['tables_count'] == 0): ?>
                            <div class="text-center mb-4">
                                <form method="POST" class="mb-3">
                                    <button type="submit" name="setup_database" class="btn btn-primary btn-lg">
                                        <i class="fas fa-database me-2"></i>Veritabanını Kur
                                    </button>
                                </form>
                                <p class="text-muted mb-3">
                                    Bu işlem veritabanı tablolarını oluşturacak ve varsayılan verileri ekleyecektir.
                                </p>
                                <div class="alert alert-info">
                                    <strong>Alternatif Kurulum:</strong> Eğer yukarıdaki buton çalışmazsa, 
                                    <a href="install.php" target="_blank" class="alert-link">buraya tıklayarak</a> 
                                    manuel kurulum sayfasını açın.
                                </div>
                            </div>
                        <?php elseif ($dbStatus['connected'] && $dbStatus['tables_count'] > 0): ?>
                            <div class="text-center mb-4">
                                <a href="admin/login.php" class="btn btn-success btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>Admin Paneline Giriş
                                </a>
                                <a href="create_admin.php" class="btn btn-warning btn-lg ms-2">
                                    <i class="fas fa-user-plus me-2"></i>Admin Oluştur
                                </a>
                                <a href="add_sample_data.php" class="btn btn-info btn-lg ms-2">
                                    <i class="fas fa-database me-2"></i>Örnek Veri Ekle
                                </a>
                                <a href="index.php" class="btn btn-outline-primary btn-lg ms-2">
                                    <i class="fas fa-home me-2"></i>Ana Sayfa
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning" role="alert">
                                <h5><i class="fas fa-exclamation-triangle me-2"></i>Kurulum Öncesi Kontroller</h5>
                                <ol class="mb-0">
                                    <li><strong>XAMPP'ı başlatın</strong> ve MySQL servisinin çalıştığından emin olun</li>
                                    <li><strong>phpMyAdmin'e gidin:</strong> <a href="http://localhost/phpmyadmin" target="_blank">http://localhost/phpmyadmin</a></li>
                                    <li><strong>Yeni veritabanı oluşturun:</strong> 'evahome_db' adında</li>
                                    <li><strong>Bu sayfayı yenileyin</strong> ve kuruluma devam edin</li>
                                </ol>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Varsayılan Giriş Bilgileri -->
                        <?php if ($dbStatus['connected'] && $dbStatus['tables_count'] > 0): ?>
                            <div class="alert alert-info" role="alert">
                                <h6><i class="fas fa-key me-2"></i>Varsayılan Admin Giriş Bilgileri</h6>
                                <p class="mb-0">
                                    <strong>Kullanıcı Adı:</strong> admin<br>
                                    <strong>Şifre:</strong> password
                                </p>
                                <small class="text-muted">Güvenlik için ilk girişten sonra şifrenizi değiştirin.</small>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Sistem Bilgileri -->
                        <div class="mt-4">
                            <h6><i class="fas fa-info me-2"></i>Sistem Bilgileri</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>PHP Sürümü:</strong> <?php echo PHP_VERSION; ?><br>
                                        <strong>Sunucu:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Bilinmiyor'; ?>
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Veritabanı:</strong> MySQL<br>
                                        <strong>Durum:</strong> <?php echo $dbStatus['connected'] ? 'Bağlı' : 'Bağlantı Yok'; ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
