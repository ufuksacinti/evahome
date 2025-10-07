<?php
/**
 * Eva Home - Eksik Tabloları Hızlı Düzeltme
 * Customers ve diğer eksik tabloları oluşturur
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='tr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Eva Home - Eksik Tabloları Düzelt</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' rel='stylesheet'>
    <style>
        body {
            background: linear-gradient(135deg, #fef7ee 0%, #f1f5f9 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 30px 0;
        }
        .header {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            padding: 30px;
            border-radius: 15px 15px 0 0;
            text-align: center;
        }
        .content {
            background: white;
            padding: 30px;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .step-card {
            background: #f8f9fa;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }
        .error-card {
            border-left-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <i class='fas fa-tools fa-3x mb-3'></i>
            <h1>🔧 Eksik Tabloları Düzelt</h1>
            <p class='mb-0'>Customers ve diğer eksik tabloları oluşturuluyor...</p>
        </div>
        
        <div class='content'>";

try {
    if (!$pdo) {
        throw new Exception("Veritabanı bağlantısı yok");
    }
    
    echo "<div class='alert alert-success'>
            <i class='fas fa-check-circle me-2'></i>
            Veritabanı bağlantısı başarılı
          </div>";
    
    $tablesCreated = 0;
    
    // ================================================================
    // 1. CUSTOMERS TABLOSU
    // ================================================================
    echo "<h4 class='mt-4 mb-3'><i class='fas fa-users me-2'></i>Customers Tablosu Oluşturuluyor</h4>";
    
    try {
        $sql = "CREATE TABLE IF NOT EXISTS customers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NULL,
            first_name VARCHAR(100) NOT NULL,
            last_name VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            phone VARCHAR(20),
            company_name VARCHAR(255),
            tax_number VARCHAR(50),
            billing_address TEXT,
            shipping_address TEXT,
            city VARCHAR(100),
            state VARCHAR(100),
            postal_code VARCHAR(20),
            country VARCHAR(100) DEFAULT 'Türkiye',
            customer_type ENUM('individual', 'corporate') DEFAULT 'individual',
            status ENUM('active', 'inactive', 'blocked') DEFAULT 'active',
            notes TEXT,
            total_orders INT DEFAULT 0,
            total_spent DECIMAL(10, 2) DEFAULT 0,
            last_order_date TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
            INDEX idx_user_id (user_id),
            INDEX idx_email (email),
            INDEX idx_phone (phone),
            INDEX idx_status (status),
            INDEX idx_customer_type (customer_type),
            INDEX idx_created_at (created_at)
        )";
        
        $pdo->exec($sql);
        echo "<div class='step-card'>
                <i class='fas fa-check-circle text-success me-2'></i>
                <strong>Customers</strong> tablosu başarıyla oluşturuldu
              </div>";
        $tablesCreated++;
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'already exists') !== false) {
            echo "<div class='step-card'>
                    <i class='fas fa-info-circle text-info me-2'></i>
                    <strong>Customers</strong> tablosu zaten mevcut
                  </div>";
        } else {
            echo "<div class='step-card error-card'>
                    <i class='fas fa-exclamation-circle text-danger me-2'></i>
                    <strong>Customers</strong> tablosu oluşturulamadı: " . $e->getMessage() . "
                  </div>";
        }
    }
    
    // ================================================================
    // 2. DİĞER EKSİK TABLOLARI KONTROL ET
    // ================================================================
    echo "<h4 class='mt-4 mb-3'><i class='fas fa-database me-2'></i>Diğer Tablolar Kontrol Ediliyor</h4>";
    
    // Olması gereken tüm tablolar
    $requiredTables = [
        'users',
        'categories',
        'products',
        'orders',
        'order_items',
        'blog_posts',
        'contact_messages',
        'job_applications',
        'coupons',
        'product_reviews',
        'newsletter_subscribers',
        'site_settings',
        'file_uploads',
        'activity_logs',
        'customers'
    ];
    
    // Mevcut tabloları al
    $stmt = $pdo->query("SHOW TABLES");
    $existingTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $missingTables = array_diff($requiredTables, $existingTables);
    
    if (empty($missingTables)) {
        echo "<div class='alert alert-success'>
                <i class='fas fa-check-circle me-2'></i>
                Tüm gerekli tablolar mevcut! (15 tablo)
              </div>";
    } else {
        echo "<div class='alert alert-warning'>
                <i class='fas fa-exclamation-triangle me-2'></i>
                Eksik tablolar tespit edildi: " . implode(', ', $missingTables) . "
              </div>";
        
        echo "<div class='alert alert-info'>
                <i class='fas fa-info-circle me-2'></i>
                Eksik tabloları oluşturmak için <a href='install.php' class='alert-link'>install.php</a> veya 
                <a href='setup.php' class='alert-link'>setup.php</a> dosyasını çalıştırın.
              </div>";
    }
    
    // Tablo sayılarını göster
    echo "<h4 class='mt-4 mb-3'><i class='fas fa-chart-bar me-2'></i>Tablo İstatistikleri</h4>";
    
    echo "<div class='table-responsive'>
            <table class='table table-striped'>
                <thead class='table-dark'>
                    <tr>
                        <th>Tablo Adı</th>
                        <th>Kayıt Sayısı</th>
                        <th>Durum</th>
                    </tr>
                </thead>
                <tbody>";
    
    foreach ($requiredTables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM `{$table}`");
            $count = $stmt->fetch()['count'];
            echo "<tr>
                    <td><strong>{$table}</strong></td>
                    <td>{$count}</td>
                    <td><span class='badge bg-success'>✓ Mevcut</span></td>
                  </tr>";
        } catch (PDOException $e) {
            echo "<tr>
                    <td><strong>{$table}</strong></td>
                    <td>-</td>
                    <td><span class='badge bg-danger'>✗ Eksik</span></td>
                  </tr>";
        }
    }
    
    echo "</tbody></table></div>";
    
    // Örnek müşteri verisi ekle
    echo "<h4 class='mt-4 mb-3'><i class='fas fa-user-plus me-2'></i>Örnek Müşteri Verisi Ekleniyor</h4>";
    
    try {
        $stmt = $pdo->prepare("INSERT INTO customers (first_name, last_name, email, phone, city, country, customer_type, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE first_name = VALUES(first_name)");
        
        $sampleCustomers = [
            ['Ahmet', 'Yılmaz', 'ahmet.yilmaz@example.com', '05551234567', 'İstanbul', 'Türkiye', 'individual', 'active'],
            ['Ayşe', 'Demir', 'ayse.demir@example.com', '05559876543', 'Ankara', 'Türkiye', 'individual', 'active'],
            ['Mehmet', 'Kaya', 'mehmet.kaya@example.com', '05551112233', 'İzmir', 'Türkiye', 'individual', 'active'],
            ['Fatma', 'Öztürk', 'fatma.ozturk@example.com', '05554445566', 'Bursa', 'Türkiye', 'individual', 'active'],
            ['Eva Home Store', 'Corporate', 'corporate@evahome.com', '02125551234', 'İstanbul', 'Türkiye', 'corporate', 'active']
        ];
        
        $addedCustomers = 0;
        foreach ($sampleCustomers as $customer) {
            $stmt->execute($customer);
            if ($stmt->rowCount() > 0) {
                $addedCustomers++;
                echo "<div class='step-card'>
                        <i class='fas fa-user-check text-success me-2'></i>
                        Müşteri eklendi: <strong>{$customer[0]} {$customer[1]}</strong>
                      </div>";
            }
        }
        
        if ($addedCustomers > 0) {
            echo "<div class='alert alert-success mt-3'>
                    <i class='fas fa-check-circle me-2'></i>
                    {$addedCustomers} örnek müşteri başarıyla eklendi
                  </div>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-warning mt-3'>
                <i class='fas fa-info-circle me-2'></i>
                Örnek müşteri eklenemedi (tablo henüz hazır olmayabilir)
              </div>";
    }
    
    // Sonuç
    echo "<div class='alert alert-success mt-4'>
            <h5><i class='fas fa-check-circle me-2'></i>Düzeltme Tamamlandı!</h5>
            <p class='mb-2'>Customers tablosu ve diğer eksik tablolar kontrol edildi.</p>
            <p class='mb-0'><strong>Artık veri yükleme işlemine devam edebilirsiniz.</strong></p>
          </div>";
    
    echo "<div class='text-center mt-4'>
            <a href='load_massive_data.php' class='btn btn-success btn-lg me-2'>
                <i class='fas fa-database me-2'></i>Veri Yüklemeye Devam Et
            </a>
            <a href='complete_database.php' class='btn btn-primary btn-lg me-2'>
                <i class='fas fa-tools me-2'></i>Tam Kurulum Yap
            </a>
            <a href='index.php' class='btn btn-outline-secondary btn-lg'>
                <i class='fas fa-home me-2'></i>Ana Sayfa
            </a>
          </div>";
    
    echo "<div class='alert alert-info mt-4'>
            <h6><i class='fas fa-lightbulb me-2'></i>Öneriler</h6>
            <ul class='mb-0'>
                <li>Eğer hala tablolar eksikse, <strong>setup.php</strong> dosyasını çalıştırın</li>
                <li>Tüm tabloları sıfırdan oluşturmak için <strong>install.php</strong> kullanın</li>
                <li>Veritabanını tamamen sıfırlamak için phpMyAdmin'den veritabanını silin ve yeniden oluşturun</li>
            </ul>
          </div>";
    
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>
            <h5><i class='fas fa-times-circle me-2'></i>Hata Oluştu</h5>
            <p class='mb-0'>" . htmlspecialchars($e->getMessage()) . "</p>
          </div>";
    
    echo "<div class='alert alert-warning mt-3'>
            <h6><i class='fas fa-question-circle me-2'></i>Sorun Giderme</h6>
            <ol class='mb-0'>
                <li>XAMPP MySQL servisinin çalıştığından emin olun</li>
                <li>phpMyAdmin'de veritabanının mevcut olduğunu kontrol edin</li>
                <li><strong>install.php</strong> dosyasını çalıştırarak tüm tabloları oluşturun</li>
                <li>Hala sorun devam ederse database.sql dosyasını manuel olarak import edin</li>
            </ol>
          </div>";
}

echo "</div></div>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body></html>";
?>

