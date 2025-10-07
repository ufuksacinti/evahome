<?php
/**
 * Eva Home - Toplu/Kurumsal Sipariş Tabloları
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='tr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Toplu Sipariş Tabloları Kurulumu</title>
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
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <i class='fas fa-industry fa-3x mb-3'></i>
            <h1>🏢 Toplu Sipariş Sistemi Kurulumu</h1>
            <p class='mb-0'>Kurumsal müşteriler için toplu sipariş tabloları oluşturuluyor</p>
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
    
    // ================================================================
    // TOPLU SİPARİŞLER TABLOSU
    // ================================================================
    echo "<h4 class='mt-4'><i class='fas fa-table me-2'></i>Toplu Siparişler Tablosu</h4>";
    
    $sql = "CREATE TABLE IF NOT EXISTS wholesale_orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_number VARCHAR(50) NOT NULL UNIQUE,
        company_name VARCHAR(255) NOT NULL,
        contact_person VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        company_type ENUM('hotel', 'spa', 'corporate', 'boutique', 'other') NOT NULL,
        tax_office VARCHAR(255),
        tax_number VARCHAR(50),
        address TEXT NOT NULL,
        city VARCHAR(100),
        country VARCHAR(100) DEFAULT 'Türkiye',
        
        product_type VARCHAR(255) NOT NULL COMMENT 'Ürün türü (refil setleri, koleksiyonlar vb.)',
        product_details TEXT COMMENT 'Detaylı ürün açıklaması',
        quantity INT NOT NULL COMMENT 'Sipariş adedi',
        unit_price DECIMAL(10, 2),
        total_amount DECIMAL(10, 2),
        
        custom_label BOOLEAN DEFAULT FALSE COMMENT 'Özel etiket istiyor mu?',
        label_type ENUM('markasiz', 'kendi_markasi', 'eva_home') DEFAULT 'eva_home',
        custom_text TEXT COMMENT 'Etiket üzerinde yazacak özel metin',
        logo_file VARCHAR(255) COMMENT 'Yüklenen logo dosyası',
        label_color VARCHAR(50),
        
        special_requests TEXT COMMENT 'Özel talepler ve notlar',
        
        status ENUM('new', 'reviewing', 'quoted', 'confirmed', 'production', 'shipped', 'delivered', 'cancelled') DEFAULT 'new',
        priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
        assigned_to INT NULL COMMENT 'Atanan admin',
        
        quote_amount DECIMAL(10, 2) COMMENT 'Teklif tutarı',
        quote_notes TEXT COMMENT 'Teklif notları',
        quoted_at TIMESTAMP NULL,
        
        confirmed_at TIMESTAMP NULL,
        production_started_at TIMESTAMP NULL,
        shipped_at TIMESTAMP NULL,
        delivered_at TIMESTAMP NULL,
        
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        
        FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
        INDEX idx_order_number (order_number),
        INDEX idx_company_name (company_name),
        INDEX idx_email (email),
        INDEX idx_status (status),
        INDEX idx_company_type (company_type),
        INDEX idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "<div class='alert alert-success'>
            <i class='fas fa-check-circle me-2'></i>
            <strong>wholesale_orders</strong> tablosu başarıyla oluşturuldu
          </div>";
    
    // ================================================================
    // ÜRÜN PAKETLERİ TABLOSU
    // ================================================================
    echo "<h4 class='mt-4'><i class='fas fa-box me-2'></i>Toplu Sipariş Ürün Paketleri</h4>";
    
    $sql = "CREATE TABLE IF NOT EXISTS wholesale_packages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        product_type VARCHAR(100) NOT NULL,
        min_quantity INT NOT NULL DEFAULT 50,
        unit_price DECIMAL(10, 2) NOT NULL,
        includes TEXT COMMENT 'Pakete dahil olanlar',
        custom_label_available BOOLEAN DEFAULT TRUE,
        image_url VARCHAR(255),
        status ENUM('active', 'inactive') DEFAULT 'active',
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        
        INDEX idx_product_type (product_type),
        INDEX idx_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "<div class='alert alert-success'>
            <i class='fas fa-check-circle me-2'></i>
            <strong>wholesale_packages</strong> tablosu başarıyla oluşturuldu
          </div>";
    
    // ================================================================
    // ÖRNEK PAKETLER EKLE
    // ================================================================
    echo "<h4 class='mt-4'><i class='fas fa-plus me-2'></i>Örnek Paketler Ekleniyor</h4>";
    
    $packages = [
        [
            'name' => '8 Renk Koleksiyon Refil Seti',
            'description' => 'Tüm Eva Home koleksiyonlarından birer refil mumu içeren set. Her koleksiyonun benzersiz enerjisini deneyimleyin.',
            'product_type' => 'refill_set',
            'min_quantity' => 50,
            'unit_price' => 280.00,
            'includes' => 'Golden Jasmine, Velvet Rose, Citrus Harmony, Luminous Bloom, Sacred Oud, Earth Harmony, Royal Spice, Lavender Peace refil mumları',
            'custom_label_available' => 1
        ],
        [
            'name' => 'Mini Mum Hediye Seti (4\'lü)',
            'description' => 'Kurumsal hediye için ideal mini mum seti. Şık kutuda, markasız veya özel etiketli.',
            'product_type' => 'mini_set',
            'min_quantity' => 100,
            'unit_price' => 180.00,
            'includes' => '4 adet mini silindir mum (renk seçiminize göre), hediye kutusu',
            'custom_label_available' => 1
        ],
        [
            'name' => 'Lux Koleksiyon Seti (3\'lü)',
            'description' => 'Premium alçı kaplarda büyük silindir mumlar. Oteller ve SPA merkezleri için özel.',
            'product_type' => 'lux_set',
            'min_quantity' => 30,
            'unit_price' => 650.00,
            'includes' => '3 adet büyük silindir mum, premium alçı kaplar, özel paketleme',
            'custom_label_available' => 1
        ],
        [
            'name' => 'Room Diffuser Toplu Paket',
            'description' => 'Otel odaları ve SPA alanları için room diffuser toplu paketi.',
            'product_type' => 'diffuser_bulk',
            'min_quantity' => 50,
            'unit_price' => 320.00,
            'includes' => 'Room diffuser (200ml), refill bottle, çubuklar',
            'custom_label_available' => 1
        ],
        [
            'name' => 'Butik Mağaza Başlangıç Paketi',
            'description' => 'Perakende satış yapmak isteyen butik mağazalar için starter paket.',
            'product_type' => 'boutique_starter',
            'min_quantity' => 20,
            'unit_price' => 450.00,
            'includes' => 'Karışık koleksiyonlardan 20 adet mum, sergileme standı, broşürler',
            'custom_label_available' => 0
        ]
    ];
    
    $added = 0;
    foreach ($packages as $package) {
        try {
            $stmt = $pdo->prepare("INSERT INTO wholesale_packages (name, description, product_type, min_quantity, unit_price, includes, custom_label_available) VALUES (?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE name = VALUES(name)");
            $stmt->execute([
                $package['name'],
                $package['description'],
                $package['product_type'],
                $package['min_quantity'],
                $package['unit_price'],
                $package['includes'],
                $package['custom_label_available']
            ]);
            if ($stmt->rowCount() > 0) {
                $added++;
                echo "<div class='alert alert-info'>
                        <i class='fas fa-box me-2'></i>
                        <strong>{$package['name']}</strong> - Min: {$package['min_quantity']} adet, Fiyat: ₺{$package['unit_price']}
                      </div>";
            }
        } catch (PDOException $e) {
            // Sessizce devam et
        }
    }
    
    echo "<div class='alert alert-success mt-3'>
            <i class='fas fa-check-circle me-2'></i>
            <strong>$added</strong> örnek paket eklendi
          </div>";
    
    echo "<div class='alert alert-success mt-4'>
            <h5><i class='fas fa-check-circle me-2'></i>Kurulum Tamamlandı!</h5>
            <p class='mb-0'>Toplu sipariş sistemi başarıyla kuruldu.</p>
          </div>";
    
    echo "<div class='text-center mt-4'>
            <a href='toplu-siparis.php' class='btn btn-lg me-2' style='background: #c9a24a; color: white;'>
                <i class='fas fa-industry me-2'></i>Toplu Sipariş Sayfası
            </a>
            <a href='admin/wholesale_orders.php' class='btn btn-lg btn-success'>
                <i class='fas fa-cog me-2'></i>Admin: Toplu Siparişler
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

