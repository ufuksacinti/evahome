<?php
// Eva Home - Eksiksiz Veritabanı Kurulum Scripti
// Bu dosyayı tarayıcıda çalıştırarak tüm tabloları oluşturun

// Veritabanı ayarları
$host = 'localhost';
$dbname = 'evahome_db';
$username = 'root';
$password = '';

echo "<!DOCTYPE html>
<html lang='tr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Eva Home - Veritabanı Kurulum</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .success { color: #28a745; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        .info { color: #17a2b8; font-weight: bold; }
        .warning { color: #ffc107; font-weight: bold; }
        h1 { color: #f2740a; text-align: center; margin-bottom: 30px; }
        h2 { color: #333; border-bottom: 2px solid #f2740a; padding-bottom: 10px; }
        .step { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #f2740a; }
        .btn { background: #f2740a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 5px; }
        .btn:hover { background: #e35a00; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2740a; color: white; }
        .stats { display: flex; justify-content: space-around; margin: 20px 0; }
        .stat-box { text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px; }
        .stat-number { font-size: 2em; font-weight: bold; color: #f2740a; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🏠 Eva Home - Veritabanı Kurulum</h1>";

try {
    // MySQL'e bağlan
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div class='step'>
            <p class='success'>✅ MySQL sunucusuna başarıyla bağlandı</p>
            <p><strong>Sunucu:</strong> $host</p>
            <p><strong>Kullanıcı:</strong> $username</p>
          </div>";
    
    // Veritabanını oluştur
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<div class='step'>
            <p class='success'>✅ Veritabanı '$dbname' oluşturuldu/seçildi</p>
          </div>";
    
    // Veritabanını seç
    $pdo->exec("USE $dbname");
    
    // SQL dosyasını oku ve çalıştır
    $sqlFile = __DIR__ . '/database.sql';
    if (file_exists($sqlFile)) {
        $sql = file_get_contents($sqlFile);
        
        // SQL komutlarını ayır
        $statements = explode(';', $sql);
        $successCount = 0;
        $errorCount = 0;
        $errors = [];
        
        echo "<div class='step'>
                <h3>📋 SQL Komutları İşleniyor...</h3>
              </div>";
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement) && !preg_match('/^--/', $statement) && !preg_match('/^CREATE DATABASE/', $statement) && !preg_match('/^USE/', $statement)) {
                try {
                    $pdo->exec($statement);
                    $successCount++;
                } catch (PDOException $e) {
                    $errorCount++;
                    $errors[] = $e->getMessage();
                }
            }
        }
        
        echo "<div class='step'>
                <p class='success'>✅ $successCount SQL komutu başarıyla çalıştırıldı</p>";
        if ($errorCount > 0) {
            echo "<p class='warning'>⚠️ $errorCount komutta hata oluştu (normal olabilir)</p>";
        }
        echo "</div>";
    } else {
        echo "<div class='step'>
                <p class='error'>❌ database.sql dosyası bulunamadı</p>
              </div>";
    }
    
    // Tabloları kontrol et
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<div class='step'>
            <h3>📊 Oluşturulan Tablolar</h3>
            <p class='success'>Toplam " . count($tables) . " tablo oluşturuldu:</p>
            <table>
                <tr><th>Tablo Adı</th><th>Durum</th></tr>";
    
    foreach ($tables as $table) {
        echo "<tr><td>$table</td><td class='success'>✅ Oluşturuldu</td></tr>";
    }
    
    echo "</table></div>";
    
    // Veri sayılarını kontrol et
    $stats = [];
    $tableCounts = [
        'users' => 'Kullanıcılar',
        'categories' => 'Kategoriler', 
        'products' => 'Ürünler',
        'orders' => 'Siparişler',
        'order_items' => 'Sipariş Öğeleri',
        'blog_posts' => 'Blog Yazıları',
        'contact_messages' => 'İletişim Mesajları',
        'job_applications' => 'İş Başvuruları',
        'coupons' => 'Kuponlar',
        'product_reviews' => 'Ürün Yorumları',
        'newsletter_subscribers' => 'Haber Bülteni',
        'site_settings' => 'Site Ayarları',
        'file_uploads' => 'Dosya Yüklemeleri',
        'activity_logs' => 'Aktivite Logları'
    ];
    
    echo "<div class='step'>
            <h3>📈 Veri İstatistikleri</h3>
            <div class='stats'>";
    
    foreach ($tableCounts as $table => $name) {
        if (in_array($table, $tables)) {
            try {
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM $table");
                $count = $stmt->fetch()['count'];
                $stats[$table] = $count;
                echo "<div class='stat-box'>
                        <div class='stat-number'>$count</div>
                        <div>$name</div>
                      </div>";
            } catch (PDOException $e) {
                echo "<div class='stat-box'>
                        <div class='stat-number'>-</div>
                        <div>$name</div>
                      </div>";
            }
        }
    }
    
    echo "</div></div>";
    
    // Admin kullanıcısını kontrol et ve oluştur
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE username = 'admin'");
    $adminCount = $stmt->fetch()['count'];
    
    if ($adminCount == 0) {
        // Admin kullanıcısını oluştur
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password, email, first_name, last_name, role, status) VALUES (?, ?, ?, ?, ?, 'admin', 'active')");
            $hashedPassword = password_hash('password', PASSWORD_DEFAULT);
            $stmt->execute(['admin', $hashedPassword, 'admin@evahome.com', 'Admin', 'User']);
            
            echo "<div class='step'>
                    <h3>👤 Admin Kullanıcısı</h3>
                    <p class='success'>✅ Admin kullanıcısı başarıyla oluşturuldu</p>
                    <p><strong>Giriş Bilgileri:</strong></p>
                    <ul>
                        <li><strong>Kullanıcı Adı:</strong> admin</li>
                        <li><strong>Şifre:</strong> password</li>
                        <li><strong>E-posta:</strong> admin@evahome.com</li>
                    </ul>
                  </div>";
        } catch (PDOException $e) {
            echo "<div class='step'>
                    <p class='error'>❌ Admin kullanıcısı oluşturulamadı: " . $e->getMessage() . "</p>
                    <p><a href='create_admin.php' class='btn'>👤 Manuel Admin Oluştur</a></p>
                  </div>";
        }
    } else {
        echo "<div class='step'>
                <h3>👤 Admin Kullanıcısı</h3>
                <p class='success'>✅ Admin kullanıcısı zaten mevcut</p>
                <p><strong>Giriş Bilgileri:</strong></p>
                <ul>
                    <li><strong>Kullanıcı Adı:</strong> admin</li>
                    <li><strong>Şifre:</strong> password</li>
                    <li><strong>E-posta:</strong> admin@evahome.com</li>
                </ul>
              </div>";
    }
    
    // Site ayarlarını kontrol et
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM site_settings");
    $settingsCount = $stmt->fetch()['count'];
    
    echo "<div class='step'>
            <h3>⚙️ Site Ayarları</h3>
            <p class='success'>✅ $settingsCount site ayarı oluşturuldu</p>
          </div>";
    
    echo "<div class='step'>
            <h3>🎉 Kurulum Tamamlandı!</h3>
            <p class='success'>✅ Eva Home veritabanı başarıyla kuruldu</p>
            <p>Artık web sitenizi kullanmaya başlayabilirsiniz.</p>
          </div>";
    
    echo "<div style='text-align: center; margin: 30px 0;'>
            <a href='setup.php' class='btn'>🔧 Kurulum Sayfası</a>
            <a href='admin/login.php' class='btn'>👤 Admin Paneli</a>
            <a href='index.php' class='btn'>🏠 Ana Sayfa</a>
          </div>";
    
    // Hata varsa göster
    if (!empty($errors)) {
        echo "<div class='step'>
                <h3>⚠️ Hata Detayları</h3>
                <p class='warning'>Aşağıdaki hatalar oluştu ancak kurulum devam etti:</p>
                <ul>";
        foreach (array_slice($errors, 0, 5) as $error) {
            echo "<li class='warning'>$error</li>";
        }
        if (count($errors) > 5) {
            echo "<li class='warning'>... ve " . (count($errors) - 5) . " hata daha</li>";
        }
        echo "</ul></div>";
    }
    
} catch (PDOException $e) {
    echo "<div class='step'>
            <h3>❌ Veritabanı Hatası</h3>
            <p class='error'>Hata: " . $e->getMessage() . "</p>
          </div>";
    
    echo "<div class='step'>
            <h3>🔧 Çözüm Önerileri</h3>
            <ul>
                <li><strong>XAMPP'ı başlatın</strong> ve MySQL servisinin çalıştığından emin olun</li>
                <li><strong>phpMyAdmin'e gidin:</strong> <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a></li>
                <li><strong>Yeni veritabanı oluşturun:</strong> 'evahome_db' adında</li>
                <li><strong>SQL dosyasını import edin:</strong> database.sql</li>
                <li><strong>Bu sayfayı yenileyin</strong> ve tekrar deneyin</li>
            </ul>
          </div>";
}

echo "</div></body></html>";
?>