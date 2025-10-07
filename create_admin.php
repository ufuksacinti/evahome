<?php
// Admin Kullanıcısı Oluşturma Scripti
// Bu dosyayı tarayıcıda çalıştırarak admin kullanıcısını oluşturun

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
    <title>Admin Kullanıcısı Oluştur</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .success { color: #28a745; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        .info { color: #17a2b8; font-weight: bold; }
        h1 { color: #f2740a; text-align: center; margin-bottom: 30px; }
        .step { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #f2740a; }
        .btn { background: #f2740a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 5px; }
        .btn:hover { background: #e35a00; }
        .form-group { margin: 15px 0; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .btn-create { background: #28a745; padding: 15px 30px; font-size: 16px; }
        .btn-create:hover { background: #218838; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>👤 Admin Kullanıcısı Oluştur</h1>";

try {
    // MySQL'e bağlan
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div class='step'>
            <p class='success'>✅ Veritabanına başarıyla bağlandı</p>
          </div>";
    
    // Users tablosunu kontrol et
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() == 0) {
        echo "<div class='step'>
                <p class='error'>❌ Users tablosu bulunamadı!</p>
                <p>Önce veritabanı kurulumunu yapmanız gerekiyor.</p>
                <a href='install.php' class='btn'>🔧 Veritabanını Kur</a>
              </div>";
        exit;
    }
    
    // Mevcut admin kullanıcılarını kontrol et
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
    $adminCount = $stmt->fetch()['count'];
    
    if ($adminCount > 0) {
        echo "<div class='step'>
                <p class='info'>ℹ️ Zaten $adminCount admin kullanıcısı mevcut</p>
              </div>";
        
        // Mevcut admin kullanıcılarını göster
        $stmt = $pdo->query("SELECT username, email, created_at FROM users WHERE role = 'admin'");
        $admins = $stmt->fetchAll();
        
        echo "<div class='step'>
                <h3>Mevcut Admin Kullanıcıları:</h3>
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr style='background: #f2740a; color: white;'>
                        <th style='padding: 10px; border: 1px solid #ddd;'>Kullanıcı Adı</th>
                        <th style='padding: 10px; border: 1px solid #ddd;'>E-posta</th>
                        <th style='padding: 10px; border: 1px solid #ddd;'>Oluşturulma Tarihi</th>
                    </tr>";
        
        foreach ($admins as $admin) {
            echo "<tr>
                    <td style='padding: 10px; border: 1px solid #ddd;'>{$admin['username']}</td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>{$admin['email']}</td>
                    <td style='padding: 10px; border: 1px solid #ddd;'>{$admin['created_at']}</td>
                  </tr>";
        }
        
        echo "</table></div>";
        
        echo "<div style='text-align: center; margin: 30px 0;'>
                <a href='admin/login.php' class='btn'>👤 Admin Paneline Git</a>
                <a href='index.php' class='btn'>🏠 Ana Sayfa</a>
              </div>";
        
    } else {
        echo "<div class='step'>
                <p class='error'>❌ Hiç admin kullanıcısı bulunamadı!</p>
                <p>Yeni admin kullanıcısı oluşturmanız gerekiyor.</p>
              </div>";
        
        // Form göster
        if ($_POST && isset($_POST['create_admin'])) {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $email = trim($_POST['email']);
            $first_name = trim($_POST['first_name']);
            $last_name = trim($_POST['last_name']);
            
            if (empty($username) || empty($password) || empty($email)) {
                echo "<div class='step'>
                        <p class='error'>❌ Tüm alanları doldurun!</p>
                      </div>";
            } else {
                // Şifreyi hashle
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                try {
                    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, first_name, last_name, role, status) VALUES (?, ?, ?, ?, ?, 'admin', 'active')");
                    $stmt->execute([$username, $hashedPassword, $email, $first_name, $last_name]);
                    
                    echo "<div class='step'>
                            <p class='success'>✅ Admin kullanıcısı başarıyla oluşturuldu!</p>
                            <p><strong>Giriş Bilgileri:</strong></p>
                            <ul>
                                <li><strong>Kullanıcı Adı:</strong> $username</li>
                                <li><strong>Şifre:</strong> $password</li>
                                <li><strong>E-posta:</strong> $email</li>
                            </ul>
                          </div>";
                    
                    echo "<div style='text-align: center; margin: 30px 0;'>
                            <a href='admin/login.php' class='btn'>👤 Admin Paneline Git</a>
                            <a href='index.php' class='btn'>🏠 Ana Sayfa</a>
                          </div>";
                    
                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) {
                        echo "<div class='step'>
                                <p class='error'>❌ Bu kullanıcı adı veya e-posta zaten kullanılıyor!</p>
                              </div>";
                    } else {
                        echo "<div class='step'>
                                <p class='error'>❌ Hata: " . $e->getMessage() . "</p>
                              </div>";
                    }
                }
            }
        }
        
        // Form
        echo "<div class='step'>
                <h3>Yeni Admin Kullanıcısı Oluştur</h3>
                <form method='POST'>
                    <div class='form-group'>
                        <label for='username'>Kullanıcı Adı *</label>
                        <input type='text' id='username' name='username' value='admin' required>
                    </div>
                    
                    <div class='form-group'>
                        <label for='password'>Şifre *</label>
                        <input type='password' id='password' name='password' value='password' required>
                    </div>
                    
                    <div class='form-group'>
                        <label for='email'>E-posta *</label>
                        <input type='email' id='email' name='email' value='admin@evahome.com' required>
                    </div>
                    
                    <div class='form-group'>
                        <label for='first_name'>Ad</label>
                        <input type='text' id='first_name' name='first_name' value='Admin'>
                    </div>
                    
                    <div class='form-group'>
                        <label for='last_name'>Soyad</label>
                        <input type='text' id='last_name' name='last_name' value='User'>
                    </div>
                    
                    <div style='text-align: center;'>
                        <button type='submit' name='create_admin' class='btn btn-create'>👤 Admin Kullanıcısı Oluştur</button>
                    </div>
                </form>
              </div>";
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
                <li><strong>Veritabanını kontrol edin:</strong> <a href='install.php'>install.php</a></li>
                <li><strong>phpMyAdmin'e gidin:</strong> <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a></li>
            </ul>
          </div>";
}

echo "</div></body></html>";
?>
