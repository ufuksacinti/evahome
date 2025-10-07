<?php
/**
 * Eva Home - Analitik Tabloları Ekleme
 * Sepet ve favori takibi için gerekli tablolar
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='tr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Analitik Tabloları Ekleme</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' rel='stylesheet'>
    <style>
        body {
            background: linear-gradient(135deg, #fef7ee 0%, #f1f5f9 100%);
            padding: 30px 0;
        }
        .header {
            background: linear-gradient(135deg, #c9a24a 0%, #a0883d 100%);
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
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <i class='fas fa-chart-line fa-3x mb-3'></i>
            <h1>📊 Analitik Tabloları Ekleme</h1>
            <p class='mb-0'>Sepet ve favori takibi için gerekli tablolar oluşturuluyor</p>
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
    // 1. FAVORİLER TABLOSU
    // ================================================================
    echo "<h4 class='mt-4 mb-3'><i class='fas fa-heart me-2'></i>Favoriler Tablosu</h4>";
    
    try {
        $sql = "CREATE TABLE IF NOT EXISTS favorites (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NULL,
            product_id INT NOT NULL,
            session_id VARCHAR(100) NULL,
            ip_address VARCHAR(45),
            user_agent TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
            INDEX idx_user_id (user_id),
            INDEX idx_product_id (product_id),
            INDEX idx_session_id (session_id),
            INDEX idx_created_at (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $pdo->exec($sql);
        echo "<div class='step-card'>
                <i class='fas fa-check-circle text-success me-2'></i>
                <strong>favorites</strong> tablosu başarıyla oluşturuldu
              </div>";
        $tablesCreated++;
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'already exists') === false) {
            echo "<div class='step-card' style='border-left-color: #dc3545;'>
                    <i class='fas fa-exclamation-circle text-danger me-2'></i>
                    <strong>favorites</strong> tablosu oluşturulamadı: " . $e->getMessage() . "
                  </div>";
        } else {
            echo "<div class='step-card'>
                    <i class='fas fa-info-circle text-info me-2'></i>
                    <strong>favorites</strong> tablosu zaten mevcut
                  </div>";
        }
    }
    
    // ================================================================
    // 2. SEPET ANALİTİK TABLOSU
    // ================================================================
    echo "<h4 class='mt-4 mb-3'><i class='fas fa-shopping-cart me-2'></i>Sepet Analitik Tablosu</h4>";
    
    try {
        $sql = "CREATE TABLE IF NOT EXISTS cart_analytics (
            id INT AUTO_INCREMENT PRIMARY KEY,
            product_id INT NOT NULL,
            user_id INT NULL,
            session_id VARCHAR(100) NULL,
            quantity INT DEFAULT 1,
            action ENUM('add', 'remove', 'update') DEFAULT 'add',
            ip_address VARCHAR(45),
            user_agent TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
            INDEX idx_product_id (product_id),
            INDEX idx_user_id (user_id),
            INDEX idx_session_id (session_id),
            INDEX idx_action (action),
            INDEX idx_created_at (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        $pdo->exec($sql);
        echo "<div class='step-card'>
                <i class='fas fa-check-circle text-success me-2'></i>
                <strong>cart_analytics</strong> tablosu başarıyla oluşturuldu
              </div>";
        $tablesCreated++;
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'already exists') === false) {
            echo "<div class='step-card' style='border-left-color: #dc3545;'>
                    <i class='fas fa-exclamation-circle text-danger me-2'></i>
                    <strong>cart_analytics</strong> tablosu oluşturulamadı: " . $e->getMessage() . "
                  </div>";
        } else {
            echo "<div class='step-card'>
                    <i class='fas fa-info-circle text-info me-2'></i>
                    <strong>cart_analytics</strong> tablosu zaten mevcut
                  </div>";
        }
    }
    
    // ================================================================
    // 3. ÜRÜN İSTATİSTİKLERİ VİEW
    // ================================================================
    echo "<h4 class='mt-4 mb-3'><i class='fas fa-chart-bar me-2'></i>Ürün İstatistikleri View</h4>";
    
    try {
        $sql = "CREATE OR REPLACE VIEW product_statistics AS
        SELECT 
            p.id,
            p.name,
            p.sku,
            p.price,
            p.stock_quantity,
            p.category_id,
            c.name as category_name,
            (SELECT COUNT(*) FROM cart_analytics ca WHERE ca.product_id = p.id AND ca.action = 'add') as cart_add_count,
            (SELECT COUNT(DISTINCT ca.session_id) FROM cart_analytics ca WHERE ca.product_id = p.id) as unique_cart_users,
            (SELECT COUNT(*) FROM favorites f WHERE f.product_id = p.id) as favorite_count,
            (SELECT COUNT(DISTINCT f.session_id) FROM favorites f WHERE f.product_id = p.id) as unique_favorite_users
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.status = 'active'";
        
        $pdo->exec($sql);
        echo "<div class='step-card'>
                <i class='fas fa-check-circle text-success me-2'></i>
                <strong>product_statistics</strong> view başarıyla oluşturuldu
              </div>";
    } catch (PDOException $e) {
        echo "<div class='step-card' style='border-left-color: #ffc107;'>
                <i class='fas fa-exclamation-triangle text-warning me-2'></i>
                View oluşturulamadı (normal): " . $e->getMessage() . "
              </div>";
    }
    
    // ================================================================
    // 4. ÖRNEK VERİ EKLEME
    // ================================================================
    echo "<h4 class='mt-4 mb-3'><i class='fas fa-database me-2'></i>Örnek Analitik Veri Ekleme</h4>";
    
    // Ürünleri al
    $stmt = $pdo->query("SELECT id FROM products WHERE status = 'active' LIMIT 10");
    $products = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (!empty($products)) {
        $sampleDataAdded = 0;
        
        // Her ürün için rastgele sepet ve favori verileri ekle
        foreach ($products as $productId) {
            // Rastgele sepete eklenme sayısı (5-50 arası)
            $cartCount = rand(5, 50);
            for ($i = 0; $i < $cartCount; $i++) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO cart_analytics (product_id, session_id, quantity, action, ip_address, created_at) VALUES (?, ?, ?, 'add', ?, DATE_SUB(NOW(), INTERVAL ? DAY))");
                    $stmt->execute([
                        $productId,
                        'session_' . uniqid(),
                        rand(1, 3),
                        '192.168.' . rand(1, 255) . '.' . rand(1, 255),
                        rand(0, 30)
                    ]);
                    $sampleDataAdded++;
                } catch (PDOException $e) {
                    // Sessizce devam et
                }
            }
            
            // Rastgele favoriye eklenme sayısı (3-30 arası)
            $favoriteCount = rand(3, 30);
            for ($i = 0; $i < $favoriteCount; $i++) {
                try {
                    $stmt = $pdo->prepare("INSERT INTO favorites (product_id, session_id, ip_address, created_at) VALUES (?, ?, ?, DATE_SUB(NOW(), INTERVAL ? DAY))");
                    $stmt->execute([
                        $productId,
                        'session_' . uniqid(),
                        '192.168.' . rand(1, 255) . '.' . rand(1, 255),
                        rand(0, 30)
                    ]);
                    $sampleDataAdded++;
                } catch (PDOException $e) {
                    // Sessizce devam et
                }
            }
        }
        
        echo "<div class='alert alert-success'>
                <i class='fas fa-check-circle me-2'></i>
                <strong>$sampleDataAdded</strong> örnek analitik veri eklendi
              </div>";
    }
    
    // ================================================================
    // 5. İSTATİSTİKLER
    // ================================================================
    echo "<h4 class='mt-4 mb-3'><i class='fas fa-chart-pie me-2'></i>Oluşturulan Tablolar</h4>";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM cart_analytics");
    $cartCount = $stmt->fetch()['count'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM favorites");
    $favoriteCount = $stmt->fetch()['count'];
    
    echo "<div class='row'>";
    echo "<div class='col-md-4'><div class='stat-card'><div class='stat-number'>{$cartCount}</div><div class='stat-label'>Sepet Analitik</div></div></div>";
    echo "<div class='col-md-4'><div class='stat-card'><div class='stat-number'>{$favoriteCount}</div><div class='stat-label'>Favori</div></div></div>";
    echo "<div class='col-md-4'><div class='stat-card'><div class='stat-number'>{$tablesCreated}</div><div class='stat-label'>Tablo Oluşturuldu</div></div></div>";
    echo "</div>";
    
    echo "<style>
        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin: 10px 0;
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #c9a24a;
        }
        .stat-label {
            color: #6c757d;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>";
    
    echo "<div class='alert alert-success mt-4'>
            <h5><i class='fas fa-check-circle me-2'></i>Analitik Tabloları Başarıyla Oluşturuldu!</h5>
            <p class='mb-0'>Artık admin panelinde ürün istatistiklerini görebilirsiniz.</p>
          </div>";
    
    echo "<div class='text-center mt-4'>
            <a href='admin/dashboard.php' class='btn btn-success btn-lg me-2'>
                <i class='fas fa-chart-line me-2'></i>Admin Paneline Git
            </a>
            <a href='admin/products.php' class='btn btn-primary btn-lg'>
                <i class='fas fa-box me-2'></i>Ürün İstatistikleri
            </a>
          </div>";
    
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>
            <h5><i class='fas fa-times-circle me-2'></i>Hata Oluştu</h5>
            <p class='mb-0'>" . htmlspecialchars($e->getMessage()) . "</p>
          </div>";
}

echo "</div></div>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body></html>";
?>

