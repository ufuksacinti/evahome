<?php
/**
 * Eva Home Veritabanı Eksikliklerini Tamamlama Scripti
 * Bu dosyayı tarayıcıda çalıştırarak tüm veritabanı eksikliklerini tamamlayın
 */

require_once 'config/database.php';

$results = [];
$errors = [];

echo "<!DOCTYPE html>
<html lang='tr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Eva Home - Veritabanı Güncelleme</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' rel='stylesheet'>
    <style>
        body {
            background: linear-gradient(135deg, #fef7ee 0%, #f1f5f9 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 30px 0;
        }
        .container {
            max-width: 1000px;
        }
        .header {
            background: linear-gradient(135deg, #c9a24a 0%, #a0883d 100%);
            color: white;
            padding: 30px;
            border-radius: 15px 15px 0 0;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .content {
            background: white;
            padding: 30px;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .step-card {
            background: #f8f9fa;
            padding: 20px;
            margin: 15px 0;
            border-radius: 10px;
            border-left: 4px solid #c9a24a;
            transition: all 0.3s ease;
        }
        .step-card:hover {
            transform: translateX(5px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .success-icon {
            color: #28a745;
            font-size: 1.2em;
            margin-right: 10px;
        }
        .error-icon {
            color: #dc3545;
            font-size: 1.2em;
            margin-right: 10px;
        }
        .info-icon {
            color: #17a2b8;
            font-size: 1.2em;
            margin-right: 10px;
        }
        .warning-icon {
            color: #ffc107;
            font-size: 1.2em;
            margin-right: 10px;
        }
        .btn-custom {
            background: #c9a24a;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background: #a0883d;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(201, 162, 74, 0.3);
        }
        .progress-bar-custom {
            background: linear-gradient(90deg, #c9a24a 0%, #a0883d 100%);
        }
        .stat-box {
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
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <i class='fas fa-home fa-3x mb-3'></i>
            <h1 class='mb-2'>🕯️ Eva Home</h1>
            <h3>Veritabanı Güncelleme ve Tamamlama</h3>
            <p class='mb-0'>Eksik sütunlar, kategoriler ve ürünler ekleniyor...</p>
        </div>
        
        <div class='content'>";

try {
    if (!$pdo) {
        throw new Exception("Veritabanı bağlantısı yok");
    }
    
    echo "<div class='step-card'>
            <i class='fas fa-check-circle success-icon'></i>
            <strong>Veritabanı Bağlantısı Başarılı</strong>
          </div>";
    
    // ================================================================
    // 1. PRODUCTS TABLOSUNA RENK SÜTUNLARI EKLE
    // ================================================================
    echo "<h4 class='mt-4 mb-3'><i class='fas fa-palette me-2'></i>Ürün Renk Sütunları Ekleniyor</h4>";
    
    // color_name sütunu
    try {
        $pdo->exec("ALTER TABLE products ADD COLUMN IF NOT EXISTS color_name VARCHAR(50) NULL AFTER material");
        echo "<div class='step-card'>
                <i class='fas fa-check-circle success-icon'></i>
                <code>color_name</code> sütunu eklendi
              </div>";
        $results[] = "color_name sütunu eklendi";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "<div class='step-card'>
                    <i class='fas fa-info-circle info-icon'></i>
                    <code>color_name</code> sütunu zaten mevcut
                  </div>";
        } else {
            echo "<div class='step-card'>
                    <i class='fas fa-exclamation-circle error-icon'></i>
                    <code>color_name</code> sütunu eklenemedi: " . $e->getMessage() . "
                  </div>";
            $errors[] = "color_name: " . $e->getMessage();
        }
    }
    
    // color_code sütunu
    try {
        $pdo->exec("ALTER TABLE products ADD COLUMN IF NOT EXISTS color_code VARCHAR(7) NULL AFTER color_name COMMENT 'Hex color code (örn: #FFD700)'");
        echo "<div class='step-card'>
                <i class='fas fa-check-circle success-icon'></i>
                <code>color_code</code> sütunu eklendi
              </div>";
        $results[] = "color_code sütunu eklendi";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "<div class='step-card'>
                    <i class='fas fa-info-circle info-icon'></i>
                    <code>color_code</code> sütunu zaten mevcut
                  </div>";
        } else {
            echo "<div class='step-card'>
                    <i class='fas fa-exclamation-circle error-icon'></i>
                    <code>color_code</code> sütunu eklenemedi: " . $e->getMessage() . "
                  </div>";
            $errors[] = "color_code: " . $e->getMessage();
        }
    }
    
    // ================================================================
    // 2. CONTACT_MESSAGES TABLOSUNA PHONE SÜTUNU EKLE
    // ================================================================
    echo "<h4 class='mt-4 mb-3'><i class='fas fa-phone me-2'></i>İletişim Mesajları Telefon Sütunu Ekleniyor</h4>";
    
    try {
        $pdo->exec("ALTER TABLE contact_messages ADD COLUMN IF NOT EXISTS phone VARCHAR(20) NULL AFTER email");
        echo "<div class='step-card'>
                <i class='fas fa-check-circle success-icon'></i>
                <code>contact_messages.phone</code> sütunu eklendi
              </div>";
        $results[] = "contact_messages.phone sütunu eklendi";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "<div class='step-card'>
                    <i class='fas fa-info-circle info-icon'></i>
                    <code>contact_messages.phone</code> sütunu zaten mevcut
                  </div>";
        } else {
            echo "<div class='step-card'>
                    <i class='fas fa-exclamation-circle error-icon'></i>
                    <code>contact_messages.phone</code> sütunu eklenemedi: " . $e->getMessage() . "
                  </div>";
            $errors[] = "contact_messages.phone: " . $e->getMessage();
        }
    }
    
    // ================================================================
    // 3. EVA HOME KATEGORİLERİNİ EKLE
    // ================================================================
    echo "<h4 class='mt-4 mb-3'><i class='fas fa-list me-2'></i>Eva Home Kategorileri ve Koleksiyonları Ekleniyor</h4>";
    
    $addedCategories = 0;
    
    // Ana kategoriler
    $evaCategories = [
        ['name' => 'Candles', 'slug' => 'candles', 'description' => 'El yapımı soya mumları, pastel renklerde alçı kaplarda', 'parent_id' => null, 'sort_order' => 1],
        ['name' => 'Room Fragrances', 'slug' => 'room-fragrances', 'description' => 'Her mum koleksiyonuna karşılık gelen koku serisi', 'parent_id' => null, 'sort_order' => 2],
        ['name' => 'Decor & Trays', 'slug' => 'decor-trays', 'description' => 'Alçı ve beton karışımı pastel tepsiler, mumluklar ve objeler', 'parent_id' => null, 'sort_order' => 3],
        ['name' => 'Gift Sets', 'slug' => 'gift-sets', 'description' => 'Enerji temalı koleksiyon setleri', 'parent_id' => null, 'sort_order' => 4],
        ['name' => 'Refill Collection', 'slug' => 'refill-collection', 'description' => 'Sürdürülebilirlik odaklı — kap atmadan yeni mumla yenileme', 'parent_id' => null, 'sort_order' => 5],
        ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Tamamlayıcı ürünler ve bakım araçları', 'parent_id' => null, 'sort_order' => 6]
    ];
    
    foreach ($evaCategories as $category) {
        try {
            $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description, parent_id, sort_order, status) VALUES (?, ?, ?, ?, ?, 'active') ON DUPLICATE KEY UPDATE description = VALUES(description)");
            $stmt->execute([$category['name'], $category['slug'], $category['description'], $category['parent_id'], $category['sort_order']]);
            if ($stmt->rowCount() > 0) {
                $addedCategories++;
                echo "<div class='step-card'>
                        <i class='fas fa-plus-circle success-icon'></i>
                        Kategori eklendi: <strong>{$category['name']}</strong>
                      </div>";
            }
        } catch (PDOException $e) {
            // Kategori zaten varsa sessizce devam et
        }
    }
    
    // Kategori ID'lerini al
    $categoryIds = [];
    $stmt = $pdo->query("SELECT id, name FROM categories");
    $categories = $stmt->fetchAll();
    foreach ($categories as $cat) {
        $categoryIds[$cat['name']] = $cat['id'];
    }
    
    // Alt kategoriler (Koleksiyonlar)
    $evaCollections = [
        ['name' => 'Golden Jasmine', 'slug' => 'golden-jasmine', 'description' => 'Şans ve pozitif enerji - Altın tonlarında soya mumu', 'parent' => 'Candles', 'color' => '#FFD700'],
        ['name' => 'Velvet Rose', 'slug' => 'velvet-rose', 'description' => 'Aşk ve sevgi - Bordo tonlarında soya mumu', 'parent' => 'Candles', 'color' => '#8B0A50'],
        ['name' => 'Citrus Harmony', 'slug' => 'citrus-harmony', 'description' => 'Neşe ve canlılık - Turuncu tonlarında soya mumu', 'parent' => 'Candles', 'color' => '#FF8C42'],
        ['name' => 'Luminous Bloom', 'slug' => 'luminous-bloom', 'description' => 'Yenilenme ve tazelik - Pembe tonlarında soya mumu', 'parent' => 'Candles', 'color' => '#FFB6C1'],
        ['name' => 'Sacred Oud', 'slug' => 'sacred-oud', 'description' => 'Huzur ve bereket - Koyu yeşil tonlarında soya mumu', 'parent' => 'Candles', 'color' => '#2F4F4F'],
        ['name' => 'Earth Harmony', 'slug' => 'earth-harmony', 'description' => 'Bolluk ve topraklama - Kahve tonlarında soya mumu', 'parent' => 'Candles', 'color' => '#8B4513'],
        ['name' => 'Royal Spice', 'slug' => 'royal-spice', 'description' => 'Arınma ve negatif enerji temizliği - Gri tonlarında soya mumu', 'parent' => 'Candles', 'color' => '#808080'],
        ['name' => 'Lavender Peace', 'slug' => 'lavender-peace', 'description' => 'Rahatlama ve stres azaltma - Lila tonlarında soya mumu', 'parent' => 'Candles', 'color' => '#E6E6FA']
    ];
    
    foreach ($evaCollections as $collection) {
        $parentId = $categoryIds[$collection['parent']] ?? null;
        try {
            $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description, parent_id, sort_order, status) VALUES (?, ?, ?, ?, ?, 'active') ON DUPLICATE KEY UPDATE description = VALUES(description)");
            $stmt->execute([$collection['name'], $collection['slug'], $collection['description'], $parentId, 10]);
            if ($stmt->rowCount() > 0) {
                $addedCategories++;
                echo "<div class='step-card'>
                        <i class='fas fa-plus-circle success-icon'></i>
                        Koleksiyon eklendi: <strong>{$collection['name']}</strong> 
                        <span class='badge' style='background-color: {$collection['color']}; color: white;'>{$collection['color']}</span>
                      </div>";
            }
        } catch (PDOException $e) {
            // Koleksiyon zaten varsa sessizce devam et
        }
    }
    
    $results[] = "Toplam $addedCategories kategori/koleksiyon eklendi";
    
    // ================================================================
    // 4. EVA HOME ÜRÜNLERİNİ EKLE
    // ================================================================
    echo "<h4 class='mt-4 mb-3'><i class='fas fa-box me-2'></i>Eva Home Ürünleri Ekleniyor</h4>";
    
    // Kategori ID'lerini yeniden al
    $stmt = $pdo->query("SELECT id, name FROM categories");
    $categories = $stmt->fetchAll();
    foreach ($categories as $cat) {
        $categoryIds[$cat['name']] = $cat['id'];
    }
    
    $addedProducts = 0;
    
    $evaProducts = [
        // Golden Jasmine Ürünleri
        ['name' => 'Golden Jasmine - Büyük Silindir Mum', 'slug' => 'golden-jasmine-buyuk-silindir-mum', 'description' => 'Şans ve pozitif enerji getiren Golden Jasmine koleksiyonundan büyük silindir soya mumu. El yapımı, pastel altın renkli alçı kap içinde.', 'short_description' => 'Golden Jasmine büyük silindir soya mumu - Şans ve pozitif enerji', 'price' => 750.00, 'sale_price' => 650.00, 'category' => 'Golden Jasmine', 'brand' => 'Eva Home', 'stock' => 25, 'featured' => true, 'color_name' => 'Altın', 'color_code' => '#FFD700'],
        ['name' => 'Golden Jasmine - Küçük Silindir Mum', 'slug' => 'golden-jasmine-kucuk-silindir-mum', 'description' => 'Şans ve pozitif enerji getiren Golden Jasmine koleksiyonundan küçük silindir soya mumu. El yapımı, pastel altın renkli alçı kap içinde.', 'short_description' => 'Golden Jasmine küçük silindir soya mumu', 'price' => 450.00, 'sale_price' => 400.00, 'category' => 'Golden Jasmine', 'brand' => 'Eva Home', 'stock' => 30, 'featured' => false, 'color_name' => 'Altın', 'color_code' => '#FFD700'],
        ['name' => 'Golden Jasmine - Yassı Mum (Tahta Fitilli)', 'slug' => 'golden-jasmine-yassi-mum', 'description' => 'Şans ve pozitif enerji getiren Golden Jasmine koleksiyonundan yassı soya mumu. Tahta fitilli, pastel altın renkli alçı kap içinde.', 'short_description' => 'Golden Jasmine yassı soya mumu - Tahta fitilli', 'price' => 550.00, 'sale_price' => 500.00, 'category' => 'Golden Jasmine', 'brand' => 'Eva Home', 'stock' => 20, 'featured' => false, 'color_name' => 'Altın', 'color_code' => '#FFD700'],
        
        // Velvet Rose Ürünleri
        ['name' => 'Velvet Rose - Büyük Silindir Mum', 'slug' => 'velvet-rose-buyuk-silindir-mum', 'description' => 'Aşk ve sevgi getiren Velvet Rose koleksiyonundan büyük silindir soya mumu. El yapımı, pastel bordo renkli alçı kap içinde.', 'short_description' => 'Velvet Rose büyük silindir soya mumu - Aşk ve sevgi', 'price' => 750.00, 'sale_price' => 650.00, 'category' => 'Velvet Rose', 'brand' => 'Eva Home', 'stock' => 25, 'featured' => true, 'color_name' => 'Bordo', 'color_code' => '#8B0A50'],
        ['name' => 'Velvet Rose - Küçük Silindir Mum', 'slug' => 'velvet-rose-kucuk-silindir-mum', 'description' => 'Aşk ve sevgi getiren Velvet Rose koleksiyonundan küçük silindir soya mumu. El yapımı, pastel bordo renkli alçı kap içinde.', 'short_description' => 'Velvet Rose küçük silindir soya mumu', 'price' => 450.00, 'sale_price' => 400.00, 'category' => 'Velvet Rose', 'brand' => 'Eva Home', 'stock' => 30, 'featured' => false, 'color_name' => 'Bordo', 'color_code' => '#8B0A50'],
        
        // Citrus Harmony Ürünleri
        ['name' => 'Citrus Harmony - Büyük Silindir Mum', 'slug' => 'citrus-harmony-buyuk-silindir-mum', 'description' => 'Neşe ve canlılık getiren Citrus Harmony koleksiyonundan büyük silindir soya mumu. El yapımı, pastel turuncu renkli alçı kap içinde.', 'short_description' => 'Citrus Harmony büyük silindir soya mumu - Neşe ve canlılık', 'price' => 750.00, 'sale_price' => 650.00, 'category' => 'Citrus Harmony', 'brand' => 'Eva Home', 'stock' => 25, 'featured' => true, 'color_name' => 'Turuncu', 'color_code' => '#FF8C42'],
        
        // Luminous Bloom Ürünleri
        ['name' => 'Luminous Bloom - Büyük Silindir Mum', 'slug' => 'luminous-bloom-buyuk-silindir-mum', 'description' => 'Yenilenme ve tazelik getiren Luminous Bloom koleksiyonundan büyük silindir soya mumu. El yapımı, pastel pembe renkli alçı kap içinde.', 'short_description' => 'Luminous Bloom büyük silindir soya mumu - Yenilenme ve tazelik', 'price' => 750.00, 'sale_price' => 650.00, 'category' => 'Luminous Bloom', 'brand' => 'Eva Home', 'stock' => 25, 'featured' => true, 'color_name' => 'Pembe', 'color_code' => '#FFB6C1'],
        
        // Sacred Oud Ürünleri
        ['name' => 'Sacred Oud - Büyük Silindir Mum', 'slug' => 'sacred-oud-buyuk-silindir-mum', 'description' => 'Huzur ve bereket getiren Sacred Oud koleksiyonundan büyük silindir soya mumu. El yapımı, koyu yeşil renkli alçı kap içinde.', 'short_description' => 'Sacred Oud büyük silindir soya mumu - Huzur ve bereket', 'price' => 750.00, 'sale_price' => 650.00, 'category' => 'Sacred Oud', 'brand' => 'Eva Home', 'stock' => 25, 'featured' => true, 'color_name' => 'Koyu Yeşil', 'color_code' => '#2F4F4F'],
        
        // Earth Harmony Ürünleri
        ['name' => 'Earth Harmony - Büyük Silindir Mum', 'slug' => 'earth-harmony-buyuk-silindir-mum', 'description' => 'Bolluk ve topraklama enerjisi getiren Earth Harmony koleksiyonundan büyük silindir soya mumu. El yapımı, kahve renkli alçı kap içinde.', 'short_description' => 'Earth Harmony büyük silindir soya mumu - Bolluk ve topraklama', 'price' => 750.00, 'sale_price' => 650.00, 'category' => 'Earth Harmony', 'brand' => 'Eva Home', 'stock' => 25, 'featured' => true, 'color_name' => 'Kahve', 'color_code' => '#8B4513'],
        
        // Royal Spice Ürünleri
        ['name' => 'Royal Spice - Büyük Silindir Mum', 'slug' => 'royal-spice-buyuk-silindir-mum', 'description' => 'Arınma ve negatif enerji temizliği için Royal Spice koleksiyonundan büyük silindir soya mumu. El yapımı, gri renkli alçı kap içinde.', 'short_description' => 'Royal Spice büyük silindir soya mumu - Arınma enerjisi', 'price' => 750.00, 'sale_price' => 650.00, 'category' => 'Royal Spice', 'brand' => 'Eva Home', 'stock' => 25, 'featured' => true, 'color_name' => 'Gri', 'color_code' => '#808080'],
        
        // Lavender Peace Ürünleri
        ['name' => 'Lavender Peace - Büyük Silindir Mum', 'slug' => 'lavender-peace-buyuk-silindir-mum', 'description' => 'Rahatlama ve stres azaltma için Lavender Peace koleksiyonundan büyük silindir soya mumu. El yapımı, lila renkli alçı kap içinde.', 'short_description' => 'Lavender Peace büyük silindir soya mumu - Rahatlama enerjisi', 'price' => 750.00, 'sale_price' => 650.00, 'category' => 'Lavender Peace', 'brand' => 'Eva Home', 'stock' => 25, 'featured' => true, 'color_name' => 'Lila', 'color_code' => '#E6E6FA'],
        
        // Room Fragrances
        ['name' => 'Golden Jasmine Room Diffuser', 'slug' => 'golden-jasmine-room-diffuser', 'description' => 'Golden Jasmine koleksiyonundan oda kokusu difüzörü. Cam şişe, şans ve pozitif enerji getiren koku.', 'short_description' => 'Golden Jasmine oda kokusu difüzörü', 'price' => 450.00, 'sale_price' => 400.00, 'category' => 'Room Fragrances', 'brand' => 'Eva Home', 'stock' => 20, 'featured' => true, 'color_name' => null, 'color_code' => null],
        ['name' => 'Velvet Rose Room Diffuser', 'slug' => 'velvet-rose-room-diffuser', 'description' => 'Velvet Rose koleksiyonundan oda kokusu difüzörü. Cam şişe, aşk ve sevgi getiren koku.', 'short_description' => 'Velvet Rose oda kokusu difüzörü', 'price' => 450.00, 'sale_price' => 400.00, 'category' => 'Room Fragrances', 'brand' => 'Eva Home', 'stock' => 20, 'featured' => false, 'color_name' => null, 'color_code' => null],
        
        // Decor & Trays
        ['name' => 'Golden Jasmine Koleksiyon Tepsisi', 'slug' => 'golden-jasmine-koleksiyon-tepsisi', 'description' => 'Golden Jasmine koleksiyonuna uygun alçı ve beton karışımı pastel tepsi. Mum rengiyle uyumlu tasarım.', 'short_description' => 'Golden Jasmine koleksiyon tepsisi', 'price' => 280.00, 'sale_price' => 250.00, 'category' => 'Decor & Trays', 'brand' => 'Eva Home', 'stock' => 15, 'featured' => false, 'color_name' => 'Altın', 'color_code' => '#FFD700'],
        ['name' => 'Minimal Lotus Objesi', 'slug' => 'minimal-lotus-objesi', 'description' => 'Alçı ve beton karışımı minimal lotus objesi. Dekoratif amaçlı, pastel renkli.', 'short_description' => 'Minimal lotus objesi', 'price' => 180.00, 'sale_price' => 160.00, 'category' => 'Decor & Trays', 'brand' => 'Eva Home', 'stock' => 25, 'featured' => false, 'color_name' => null, 'color_code' => null],
        
        // Gift Sets
        ['name' => 'Golden Jasmine & Velvet Rose 2\'li Set', 'slug' => 'golden-jasmine-velvet-rose-2li-set', 'description' => 'Golden Jasmine ve Velvet Rose koleksiyonlarından 2\'li hediye seti. Şans ve aşk enerjisi kombinasyonu.', 'short_description' => 'Golden Jasmine & Velvet Rose 2\'li hediye seti', 'price' => 1200.00, 'sale_price' => 1000.00, 'category' => 'Gift Sets', 'brand' => 'Eva Home', 'stock' => 10, 'featured' => true, 'color_name' => null, 'color_code' => null],
        
        // Accessories
        ['name' => 'Fitil Makası', 'slug' => 'fitil-makasi', 'description' => 'Mum bakımı için özel tasarlanmış fitil makası. Paslanmaz çelik, ergonomik tasarım.', 'short_description' => 'Mum bakımı için fitil makası', 'price' => 85.00, 'category' => 'Accessories', 'brand' => 'Eva Home', 'stock' => 30, 'featured' => false, 'color_name' => null, 'color_code' => null],
        ['name' => 'Mum Kapağı / Snuffer', 'slug' => 'mum-kapagi-snuffer', 'description' => 'Mum söndürme için özel tasarlanmış snuffer. Paslanmaz çelik, minimal tasarım.', 'short_description' => 'Mum söndürme snuffer', 'price' => 65.00, 'category' => 'Accessories', 'brand' => 'Eva Home', 'stock' => 35, 'featured' => false, 'color_name' => null, 'color_code' => null]
    ];
    
    foreach ($evaProducts as $product) {
        $categoryId = $categoryIds[$product['category']] ?? null;
        if (!$categoryId) continue;
        
        try {
            $stmt = $pdo->prepare("INSERT INTO products (name, slug, description, short_description, price, sale_price, category_id, brand, stock_quantity, featured, status, color_name, color_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', ?, ?) ON DUPLICATE KEY UPDATE price = VALUES(price), sale_price = VALUES(sale_price), stock_quantity = VALUES(stock_quantity)");
            $stmt->execute([
                $product['name'],
                $product['slug'],
                $product['description'],
                $product['short_description'],
                $product['price'],
                $product['sale_price'] ?? null,
                $categoryId,
                $product['brand'],
                $product['stock'],
                $product['featured'] ? 1 : 0,
                $product['color_name'],
                $product['color_code']
            ]);
            if ($stmt->rowCount() > 0) {
                $addedProducts++;
                $colorBadge = $product['color_code'] ? "<span class='badge' style='background-color: {$product['color_code']}; color: white;'>{$product['color_name']}</span>" : "";
                echo "<div class='step-card'>
                        <i class='fas fa-plus-circle success-icon'></i>
                        Ürün eklendi: <strong>{$product['name']}</strong> $colorBadge
                      </div>";
            }
        } catch (PDOException $e) {
            // Ürün zaten varsa sessizce devam et
        }
    }
    
    $results[] = "Toplam $addedProducts ürün eklendi";
    
    // ================================================================
    // 5. İSTATİSTİKLER
    // ================================================================
    echo "<h4 class='mt-4 mb-3'><i class='fas fa-chart-bar me-2'></i>Veritabanı İstatistikleri</h4>";
    
    $stats = [];
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM categories");
    $stats['categories'] = $stmt->fetch()['count'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM products");
    $stats['products'] = $stmt->fetch()['count'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM blog_posts");
    $stats['blogs'] = $stmt->fetch()['count'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $stats['users'] = $stmt->fetch()['count'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM orders");
    $stats['orders'] = $stmt->fetch()['count'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM contact_messages");
    $stats['messages'] = $stmt->fetch()['count'];
    
    echo "<div class='row'>";
    echo "<div class='col-md-4'><div class='stat-box'><div class='stat-number'>{$stats['categories']}</div><div class='stat-label'>Kategori</div></div></div>";
    echo "<div class='col-md-4'><div class='stat-box'><div class='stat-number'>{$stats['products']}</div><div class='stat-label'>Ürün</div></div></div>";
    echo "<div class='col-md-4'><div class='stat-box'><div class='stat-number'>{$stats['blogs']}</div><div class='stat-label'>Blog Yazısı</div></div></div>";
    echo "<div class='col-md-4'><div class='stat-box'><div class='stat-number'>{$stats['users']}</div><div class='stat-label'>Kullanıcı</div></div></div>";
    echo "<div class='col-md-4'><div class='stat-box'><div class='stat-number'>{$stats['orders']}</div><div class='stat-label'>Sipariş</div></div></div>";
    echo "<div class='col-md-4'><div class='stat-box'><div class='stat-number'>{$stats['messages']}</div><div class='stat-label'>Mesaj</div></div></div>";
    echo "</div>";
    
    // ================================================================
    // 6. SONUÇ
    // ================================================================
    echo "<div class='alert alert-success mt-4' role='alert'>
            <h5><i class='fas fa-check-circle me-2'></i>Veritabanı Güncelleme Tamamlandı!</h5>
            <hr>
            <ul class='mb-0'>";
    foreach ($results as $result) {
        echo "<li>$result</li>";
    }
    echo "</ul></div>";
    
    if (!empty($errors)) {
        echo "<div class='alert alert-warning mt-3' role='alert'>
                <h6><i class='fas fa-exclamation-triangle me-2'></i>Bazı Hatalar Oluştu</h6>
                <ul class='mb-0'>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul></div>";
    }
    
    // Navigasyon butonları
    echo "<div class='text-center mt-4'>
            <a href='index.php' class='btn btn-custom btn-lg me-2'>
                <i class='fas fa-home me-2'></i>Ana Sayfaya Git
            </a>
            <a href='admin/login.php' class='btn btn-custom btn-lg me-2'>
                <i class='fas fa-user-shield me-2'></i>Admin Paneli
            </a>
            <a href='add_sample_data.php' class='btn btn-outline-secondary btn-lg'>
                <i class='fas fa-database me-2'></i>Daha Fazla Örnek Veri Ekle
            </a>
          </div>";
    
    echo "<div class='alert alert-info mt-4' role='alert'>
            <h6><i class='fas fa-key me-2'></i>Varsayılan Admin Giriş Bilgileri</h6>
            <p class='mb-0'>
                <strong>Kullanıcı Adı:</strong> admin<br>
                <strong>Şifre:</strong> password
            </p>
          </div>";
    
} catch (Exception $e) {
    echo "<div class='alert alert-danger' role='alert'>
            <h5><i class='fas fa-times-circle me-2'></i>Hata Oluştu</h5>
            <p class='mb-0'>" . escape($e->getMessage()) . "</p>
          </div>";
}

echo "</div></div></body></html>";
?>

