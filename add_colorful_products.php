<?php
// Eva Home Renkli Ürünler Ekleme Scripti
require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='tr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Eva Home Renkli Ürünler Ekleme</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .success { color: #28a745; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        .info { color: #17a2b8; font-weight: bold; }
        h1 { color: #c9a24a; text-align: center; margin-bottom: 30px; }
        h2 { color: #1D1D1B; margin-top: 25px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .step { background: #fef7ee; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #c9a24a; }
        .btn { background: #c9a24a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 5px; }
        .btn:hover { background: #a8863a; }
        ul { list-style-type: disc; margin-left: 20px; }
        li { margin-bottom: 5px; }
        .color-box { display: inline-block; width: 20px; height: 20px; margin-right: 10px; border-radius: 3px; vertical-align: middle; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🎨 Eva Home Renkli Ürünler Ekleme</h1>";

try {
    if (!$pdo) {
        throw new Exception("Veritabanı bağlantısı yok");
    }
    echo "<div class='step'><p class='success'>✅ Veritabanına başarıyla bağlandı</p></div>";

    // Renk paleti
    $colors = [
        'Rose Gold' => '#E8B4B8',
        'Sage Green' => '#9CAF88', 
        'Lavender' => '#B7A7D9',
        'Cream' => '#F5F5DC',
        'Dusty Blue' => '#A8B5C0',
        'Terracotta' => '#D4A574',
        'Blush Pink' => '#F4C2C2',
        'Mint' => '#98E4D6',
        'Coral' => '#FF7F7F',
        'Ivory' => '#F7F4EF',
        'Charcoal' => '#36454F',
        'Gold' => '#C9A24A'
    ];

    // Koleksiyonlar ve renkleri
    $collections = [
        'Golden Jasmine' => ['Rose Gold', 'Cream', 'Gold'],
        'Velvet Rose' => ['Blush Pink', 'Rose Gold', 'Cream'],
        'Citrus Harmony' => ['Coral', 'Mint', 'Cream'],
        'Luminous Bloom' => ['Lavender', 'Blush Pink', 'Ivory'],
        'Sacred Oud' => ['Sage Green', 'Charcoal', 'Cream'],
        'Earth Harmony' => ['Terracotta', 'Sage Green', 'Cream'],
        'Royal Spice' => ['Charcoal', 'Gold', 'Cream'],
        'Lavender Peace' => ['Lavender', 'Dusty Blue', 'Ivory']
    ];

    // Ürün tipleri ve renk varyasyonları
    $productTypes = [
        'Büyük Silindir Mum' => ['price' => 750.00, 'base_colors' => 3],
        'Küçük Silindir Mum' => ['price' => 450.00, 'base_colors' => 3],
        'Yassı Mum (Tahta Fitilli)' => ['price' => 600.00, 'base_colors' => 2],
        'Refill Mum' => ['price' => 300.00, 'base_colors' => 2],
        'Cam Şişe Difüzör' => ['price' => 550.00, 'base_colors' => 2],
        'Refill Oda Kokusu' => ['price' => 350.00, 'base_colors' => 2],
        'Koleksiyon Tepsisi' => ['price' => 300.00, 'base_colors' => 2],
        'Minimal Lotus Objesi' => ['price' => 180.00, 'base_colors' => 2],
        'Minimal Taş Formu Objesi' => ['price' => 150.00, 'base_colors' => 2],
        '2\'li Mum Seti' => ['price' => 1100.00, 'base_colors' => 1],
        '3\'lü Denge Koleksiyonu Seti' => ['price' => 1600.00, 'base_colors' => 1],
        'Deluxe Set (Mum + Koku + Tepsi)' => ['price' => 1500.00, 'base_colors' => 1],
        'Silindir Mum Refill' => ['price' => 280.00, 'base_colors' => 2],
        'Yassı Mum Refill' => ['price' => 250.00, 'base_colors' => 2],
        'Oda Kokusu Refill' => ['price' => 320.00, 'base_colors' => 2],
        'Fitil Makası' => ['price' => 120.00, 'base_colors' => 1],
        'Mum Kapağı / Snuffer' => ['price' => 90.00, 'base_colors' => 1],
        'Hediye Paketleme Seti' => ['price' => 75.00, 'base_colors' => 1]
    ];

    echo "<h2>Renkli Ürünler Ekleniyor...</h2>";

    $addedCount = 0;
    foreach ($collections as $collectionName => $collectionColors) {
        // Koleksiyon ID'sini bul
        $stmt = $pdo->prepare("SELECT id FROM categories WHERE name = ?");
        $stmt->execute([$collectionName]);
        $collectionId = $stmt->fetchColumn();
        
        if (!$collectionId) {
            echo "<div class='step'><p class='error'>❌ Koleksiyon bulunamadı: " . $collectionName . "</p></div>";
            continue;
        }

        foreach ($productTypes as $productType => $typeInfo) {
            $baseColors = array_slice($collectionColors, 0, $typeInfo['base_colors']);
            
            foreach ($baseColors as $colorName) {
                $colorCode = $colors[$colorName];
                
                // Ürün adı oluştur
                $productName = $collectionName . ' ' . $colorName . ' ' . $productType;
                $slug = strtolower(str_replace([' ', '\'', '(', ')'], ['-', '', '', ''], $productName));
                
                // Açıklama oluştur
                $description = $collectionName . ' koleksiyonundan ' . $colorName . ' renkli ' . strtolower($productType) . '. ' . $collectionName . ' enerjisi ile evinizi şenlendirin.';
                $shortDescription = $collectionName . ' koleksiyonu ' . $colorName . ' renkli ' . strtolower($productType);
                
                // Fiyat hesapla (renk bazlı fark)
                $priceMultiplier = 1.0;
                if (in_array($colorName, ['Gold', 'Rose Gold'])) {
                    $priceMultiplier = 1.1; // Premium renkler %10 daha pahalı
                } elseif (in_array($colorName, ['Charcoal', 'Coral'])) {
                    $priceMultiplier = 1.05; // Özel renkler %5 daha pahalı
                }
                
                $price = round($typeInfo['price'] * $priceMultiplier, 2);
                $salePrice = ($price * 0.9); // %10 indirim
                
                try {
                    $stmt = $pdo->prepare("INSERT IGNORE INTO products (name, slug, description, short_description, price, sale_price, category_id, brand, stock_quantity, featured, status, image_url, color_name, color_code) VALUES (?, ?, ?, ?, ?, ?, ?, 'Eva Home', ?, ?, 'active', ?, ?, ?)");
                    
                    $featured = (rand(0, 3) == 0) ? 1 : 0; // %25 öne çıkan
                    $stock = rand(5, 25);
                    $imageUrl = 'assets/images/' . strtolower(str_replace(' ', '-', $productType)) . '-' . strtolower(str_replace(' ', '-', $colorName)) . '.jpg';
                    
                    $stmt->execute([
                        $productName,
                        $slug,
                        $description,
                        $shortDescription,
                        $price,
                        $salePrice,
                        $collectionId,
                        $stock,
                        $featured,
                        $imageUrl,
                        $colorName,
                        $colorCode
                    ]);
                    
                    $addedCount++;
                    echo "<div class='step'><p class='success'>✅ Ürün Eklendi: " . $productName . " <span class='color-box' style='background-color: " . $colorCode . "'></span>" . $colorName . " - ₺" . number_format($price, 2) . "</p></div>";
                    
                } catch (PDOException $e) {
                    echo "<div class='step'><p class='error'>❌ Ürün Eklenemedi: " . $productName . " - " . $e->getMessage() . "</p></div>";
                }
            }
        }
    }

    // Ana kategoriler için de renkli ürünler ekle
    $mainCategories = [
        'Room Fragrances' => ['Dusty Blue', 'Lavender', 'Mint'],
        'Decor & Trays' => ['Sage Green', 'Terracotta', 'Cream'],
        'Gift Sets' => ['Gold', 'Rose Gold', 'Cream'],
        'Refill Collection' => ['Mint', 'Sage Green', 'Cream'],
        'Accessories' => ['Charcoal', 'Gold', 'Cream']
    ];

    echo "<h2>Ana Kategoriler için Renkli Ürünler...</h2>";
    
    foreach ($mainCategories as $categoryName => $categoryColors) {
        $stmt = $pdo->prepare("SELECT id FROM categories WHERE name = ?");
        $stmt->execute([$categoryName]);
        $categoryId = $stmt->fetchColumn();
        
        if (!$categoryId) continue;
        
        foreach ($categoryColors as $colorName) {
            $colorCode = $colors[$colorName];
            
            // Bu kategori için uygun ürün tiplerini seç
            $suitableTypes = [];
            if ($categoryName == 'Room Fragrances') {
                $suitableTypes = ['Cam Şişe Difüzör', 'Refill Oda Kokusu'];
            } elseif ($categoryName == 'Decor & Trays') {
                $suitableTypes = ['Koleksiyon Tepsisi', 'Minimal Lotus Objesi', 'Minimal Taş Formu Objesi'];
            } elseif ($categoryName == 'Gift Sets') {
                $suitableTypes = ['2\'li Mum Seti', '3\'lü Denge Koleksiyonu Seti', 'Deluxe Set (Mum + Koku + Tepsi)'];
            } elseif ($categoryName == 'Refill Collection') {
                $suitableTypes = ['Silindir Mum Refill', 'Yassı Mum Refill', 'Oda Kokusu Refill'];
            } elseif ($categoryName == 'Accessories') {
                $suitableTypes = ['Fitil Makası', 'Mum Kapağı / Snuffer', 'Hediye Paketleme Seti'];
            }
            
            foreach ($suitableTypes as $productType) {
                if (!isset($productTypes[$productType])) continue;
                
                $productName = $categoryName . ' ' . $colorName . ' ' . $productType;
                $slug = strtolower(str_replace([' ', '\'', '(', ')'], ['-', '', '', ''], $productName));
                
                $description = $categoryName . ' kategorisinden ' . $colorName . ' renkli ' . strtolower($productType) . '. Ev dekorasyonunuza şıklık katın.';
                $shortDescription = $categoryName . ' ' . $colorName . ' renkli ' . strtolower($productType);
                
                $price = $productTypes[$productType]['price'];
                $salePrice = ($price * 0.95); // %5 indirim
                
                try {
                    $stmt = $pdo->prepare("INSERT IGNORE INTO products (name, slug, description, short_description, price, sale_price, category_id, brand, stock_quantity, featured, status, image_url, color_name, color_code) VALUES (?, ?, ?, ?, ?, ?, ?, 'Eva Home', ?, ?, 'active', ?, ?, ?)");
                    
                    $featured = (rand(0, 4) == 0) ? 1 : 0; // %20 öne çıkan
                    $stock = rand(3, 20);
                    $imageUrl = 'assets/images/' . strtolower(str_replace(' ', '-', $productType)) . '-' . strtolower(str_replace(' ', '-', $colorName)) . '.jpg';
                    
                    $stmt->execute([
                        $productName,
                        $slug,
                        $description,
                        $shortDescription,
                        $price,
                        $salePrice,
                        $categoryId,
                        $stock,
                        $featured,
                        $imageUrl,
                        $colorName,
                        $colorCode
                    ]);
                    
                    $addedCount++;
                    echo "<div class='step'><p class='success'>✅ Ürün Eklendi: " . $productName . " <span class='color-box' style='background-color: " . $colorCode . "'></span>" . $colorName . " - ₺" . number_format($price, 2) . "</p></div>";
                    
                } catch (PDOException $e) {
                    echo "<div class='step'><p class='error'>❌ Ürün Eklenemedi: " . $productName . " - " . $e->getMessage() . "</p></div>";
                }
            }
        }
    }

    echo "<div class='step'><p class='info'>🎉 Toplam " . $addedCount . " renkli ürün başarıyla eklendi!</p></div>";
    echo "<div class='step'>
            <p>Renk paleti:</p>
            <div style='display: flex; flex-wrap: wrap; gap: 10px; margin: 10px 0;'>";
    
    foreach ($colors as $colorName => $colorCode) {
        echo "<div style='display: flex; align-items: center; margin: 5px;'>
                <span class='color-box' style='background-color: " . $colorCode . "'></span>
                <span style='font-size: 12px;'>" . $colorName . "</span>
              </div>";
    }
    
    echo "</div></div>";
    
    echo "<div class='step'>
            <p>Şimdi ana sayfayı ziyaret edebilirsiniz:</p>
            <a href='index.php' class='btn'>Ana Sayfaya Git</a>
            <a href='admin/login.php' class='btn'>Admin Paneline Git</a>
          </div>";

} catch (Exception $e) {
    echo "<div class='step'><p class='error'>❌ Hata: " . $e->getMessage() . "</p></div>";
}

echo "</div></body></html>";
?>
