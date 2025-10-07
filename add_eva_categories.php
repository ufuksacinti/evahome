<?php
// Eva Home Gerçek Kategoriler ve Koleksiyonlar Ekleme Scripti
// Bu dosyayı tarayıcıda çalıştırarak Eva Home'un gerçek ürün kategorilerini ekleyin

require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='tr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Eva Home Kategoriler ve Koleksiyonlar</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .success { color: #28a745; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        .info { color: #17a2b8; font-weight: bold; }
        h1 { color: #c9a24a; text-align: center; margin-bottom: 30px; }
        .step { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #c9a24a; }
        .btn { background: #c9a24a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 5px; }
        .btn:hover { background: #a0883d; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
        .collection-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin: 20px 0; }
        .collection-card { background: #f8f9fa; padding: 20px; border-radius: 10px; border: 1px solid #e9ecef; }
        .collection-name { font-weight: bold; color: #c9a24a; margin-bottom: 10px; }
        .collection-description { color: #6c757d; font-size: 14px; margin-bottom: 15px; }
        .collection-products { font-size: 12px; color: #495057; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🕯️ Eva Home Kategoriler ve Koleksiyonlar</h1>";

try {
    // Veritabanı bağlantısını kontrol et
    if (!$pdo) {
        throw new Exception("Veritabanı bağlantısı yok");
    }
    
    echo "<div class='step'>
            <p class='success'>✅ Veritabanına başarıyla bağlandı</p>
          </div>";
    
    if ($_POST && isset($_POST['add_eva_categories'])) {
        $addedCategories = 0;
        $addedProducts = 0;
        
        // Eva Home Ana Kategoriler
        $evaCategories = [
            [
                'name' => 'Candles',
                'slug' => 'candles',
                'description' => 'El yapımı soya mumları, pastel renklerde alçı kaplarda',
                'parent_id' => null,
                'sort_order' => 1
            ],
            [
                'name' => 'Room Fragrances',
                'slug' => 'room-fragrances',
                'description' => 'Her mum koleksiyonuna karşılık gelen koku serisi',
                'parent_id' => null,
                'sort_order' => 2
            ],
            [
                'name' => 'Decor & Trays',
                'slug' => 'decor-trays',
                'description' => 'Alçı ve beton karışımı pastel tepsiler, mumluklar ve objeler',
                'parent_id' => null,
                'sort_order' => 3
            ],
            [
                'name' => 'Gift Sets',
                'slug' => 'gift-sets',
                'description' => 'Enerji temalı koleksiyon setleri',
                'parent_id' => null,
                'sort_order' => 4
            ],
            [
                'name' => 'Refill Collection',
                'slug' => 'refill-collection',
                'description' => 'Sürdürülebilirlik odaklı — kap atmadan yeni mumla yenileme',
                'parent_id' => null,
                'sort_order' => 5
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Tamamlayıcı ürünler ve bakım araçları',
                'parent_id' => null,
                'sort_order' => 6
            ]
        ];
        
        // Ana kategorileri ekle
        foreach ($evaCategories as $category) {
            try {
                $stmt = $pdo->prepare("INSERT IGNORE INTO categories (name, slug, description, parent_id, sort_order) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$category['name'], $category['slug'], $category['description'], $category['parent_id'], $category['sort_order']]);
                $addedCategories++;
            } catch (PDOException $e) {
                // Kategori zaten varsa devam et
            }
        }
        
        // Kategori ID'lerini al
        $categoryIds = [];
        $stmt = $pdo->query("SELECT id, name FROM categories ORDER BY id");
        $categories = $stmt->fetchAll();
        foreach ($categories as $cat) {
            $categoryIds[$cat['name']] = $cat['id'];
        }
        
        // Eva Home Koleksiyonları (Alt Kategoriler)
        $evaCollections = [
            // Candles Alt Kategorileri
            [
                'name' => 'Golden Jasmine',
                'slug' => 'golden-jasmine',
                'description' => 'Şans ve pozitif enerji - Altın tonlarında soya mumu',
                'parent_id' => $categoryIds['Candles'] ?? 1,
                'sort_order' => 1
            ],
            [
                'name' => 'Velvet Rose',
                'slug' => 'velvet-rose',
                'description' => 'Aşk ve sevgi - Bordo tonlarında soya mumu',
                'parent_id' => $categoryIds['Candles'] ?? 1,
                'sort_order' => 2
            ],
            [
                'name' => 'Citrus Harmony',
                'slug' => 'citrus-harmony',
                'description' => 'Neşe ve canlılık - Turuncu tonlarında soya mumu',
                'parent_id' => $categoryIds['Candles'] ?? 1,
                'sort_order' => 3
            ],
            [
                'name' => 'Luminous Bloom',
                'slug' => 'luminous-bloom',
                'description' => 'Yenilenme ve tazelik - Pembe tonlarında soya mumu',
                'parent_id' => $categoryIds['Candles'] ?? 1,
                'sort_order' => 4
            ],
            [
                'name' => 'Sacred Oud',
                'slug' => 'sacred-oud',
                'description' => 'Huzur ve bereket - Koyu yeşil tonlarında soya mumu',
                'parent_id' => $categoryIds['Candles'] ?? 1,
                'sort_order' => 5
            ],
            [
                'name' => 'Earth Harmony',
                'slug' => 'earth-harmony',
                'description' => 'Bolluk ve topraklama - Kahve tonlarında soya mumu',
                'parent_id' => $categoryIds['Candles'] ?? 1,
                'sort_order' => 6
            ],
            [
                'name' => 'Royal Spice',
                'slug' => 'royal-spice',
                'description' => 'Arınma ve negatif enerji temizliği - Gri tonlarında soya mumu',
                'parent_id' => $categoryIds['Candles'] ?? 1,
                'sort_order' => 7
            ],
            [
                'name' => 'Lavender Peace',
                'slug' => 'lavender-peace',
                'description' => 'Rahatlama ve stres azaltma - Lila tonlarında soya mumu',
                'parent_id' => $categoryIds['Candles'] ?? 1,
                'sort_order' => 8
            ]
        ];
        
        // Koleksiyonları ekle
        foreach ($evaCollections as $collection) {
            try {
                $stmt = $pdo->prepare("INSERT IGNORE INTO categories (name, slug, description, parent_id, sort_order) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$collection['name'], $collection['slug'], $collection['description'], $collection['parent_id'], $collection['sort_order']]);
                $addedCategories++;
            } catch (PDOException $e) {
                // Kategori zaten varsa devam et
            }
        }
        
        // Kategori ID'lerini yeniden al
        $stmt = $pdo->query("SELECT id, name FROM categories ORDER BY id");
        $categories = $stmt->fetchAll();
        foreach ($categories as $cat) {
            $categoryIds[$cat['name']] = $cat['id'];
        }
        
        // Eva Home Ürünleri
        $evaProducts = [
            // Golden Jasmine Ürünleri
            [
                'name' => 'Golden Jasmine - Büyük Silindir Mum',
                'slug' => 'golden-jasmine-buyuk-silindir-mum',
                'description' => 'Şans ve pozitif enerji getiren Golden Jasmine koleksiyonundan büyük silindir soya mumu. El yapımı, pastel altın renkli alçı kap içinde.',
                'short_description' => 'Golden Jasmine büyük silindir soya mumu - Şans ve pozitif enerji',
                'price' => 750.00,
                'sale_price' => 650.00,
                'category_id' => $categoryIds['Golden Jasmine'] ?? 1,
                'brand' => 'Eva Home',
                'stock_quantity' => 25,
                'featured' => true
            ],
            [
                'name' => 'Golden Jasmine - Küçük Silindir Mum',
                'slug' => 'golden-jasmine-kucuk-silindir-mum',
                'description' => 'Şans ve pozitif enerji getiren Golden Jasmine koleksiyonundan küçük silindir soya mumu. El yapımı, pastel altın renkli alçı kap içinde.',
                'short_description' => 'Golden Jasmine küçük silindir soya mumu - Şans ve pozitif enerji',
                'price' => 450.00,
                'sale_price' => 400.00,
                'category_id' => $categoryIds['Golden Jasmine'] ?? 1,
                'brand' => 'Eva Home',
                'stock_quantity' => 30,
                'featured' => false
            ],
            [
                'name' => 'Golden Jasmine - Yassı Mum (Tahta Fitilli)',
                'slug' => 'golden-jasmine-yassi-mum',
                'description' => 'Şans ve pozitif enerji getiren Golden Jasmine koleksiyonundan yassı soya mumu. Tahta fitilli, pastel altın renkli alçı kap içinde.',
                'short_description' => 'Golden Jasmine yassı soya mumu - Tahta fitilli',
                'price' => 550.00,
                'sale_price' => 500.00,
                'category_id' => $categoryIds['Golden Jasmine'] ?? 1,
                'brand' => 'Eva Home',
                'stock_quantity' => 20,
                'featured' => false
            ],
            [
                'name' => 'Golden Jasmine - Refill Mum',
                'slug' => 'golden-jasmine-refill-mum',
                'description' => 'Golden Jasmine koleksiyonundan refill soya mumu. Sürdürülebilirlik odaklı, kap atmadan yeniden doldurma.',
                'short_description' => 'Golden Jasmine refill soya mumu - Sürdürülebilir',
                'price' => 350.00,
                'category_id' => $categoryIds['Golden Jasmine'] ?? 1,
                'brand' => 'Eva Home',
                'stock_quantity' => 40,
                'featured' => false
            ],
            
            // Velvet Rose Ürünleri
            [
                'name' => 'Velvet Rose - Büyük Silindir Mum',
                'slug' => 'velvet-rose-buyuk-silindir-mum',
                'description' => 'Aşk ve sevgi getiren Velvet Rose koleksiyonundan büyük silindir soya mumu. El yapımı, pastel bordo renkli alçı kap içinde.',
                'short_description' => 'Velvet Rose büyük silindir soya mumu - Aşk ve sevgi',
                'price' => 750.00,
                'sale_price' => 650.00,
                'category_id' => $categoryIds['Velvet Rose'] ?? 1,
                'brand' => 'Eva Home',
                'stock_quantity' => 25,
                'featured' => true
            ],
            [
                'name' => 'Velvet Rose - Küçük Silindir Mum',
                'slug' => 'velvet-rose-kucuk-silindir-mum',
                'description' => 'Aşk ve sevgi getiren Velvet Rose koleksiyonundan küçük silindir soya mumu. El yapımı, pastel bordo renkli alçı kap içinde.',
                'short_description' => 'Velvet Rose küçük silindir soya mumu - Aşk ve sevgi',
                'price' => 450.00,
                'sale_price' => 400.00,
                'category_id' => $categoryIds['Velvet Rose'] ?? 1,
                'brand' => 'Eva Home',
                'stock_quantity' => 30,
                'featured' => false
            ],
            
            // Room Fragrances Ürünleri
            [
                'name' => 'Golden Jasmine Room Diffuser',
                'slug' => 'golden-jasmine-room-diffuser',
                'description' => 'Golden Jasmine koleksiyonundan oda kokusu difüzörü. Cam şişe, şans ve pozitif enerji getiren koku.',
                'short_description' => 'Golden Jasmine oda kokusu difüzörü - Cam şişe',
                'price' => 450.00,
                'sale_price' => 400.00,
                'category_id' => $categoryIds['Room Fragrances'] ?? 2,
                'brand' => 'Eva Home',
                'stock_quantity' => 20,
                'featured' => true
            ],
            [
                'name' => 'Velvet Rose Room Diffuser',
                'slug' => 'velvet-rose-room-diffuser',
                'description' => 'Velvet Rose koleksiyonundan oda kokusu difüzörü. Cam şişe, aşk ve sevgi getiren koku.',
                'short_description' => 'Velvet Rose oda kokusu difüzörü - Cam şişe',
                'price' => 450.00,
                'sale_price' => 400.00,
                'category_id' => $categoryIds['Room Fragrances'] ?? 2,
                'brand' => 'Eva Home',
                'stock_quantity' => 20,
                'featured' => false
            ],
            
            // Decor & Trays Ürünleri
            [
                'name' => 'Golden Jasmine Koleksiyon Tepsisi',
                'slug' => 'golden-jasmine-koleksiyon-tepsisi',
                'description' => 'Golden Jasmine koleksiyonuna uygun alçı ve beton karışımı pastel tepsi. Mum rengiyle uyumlu tasarım.',
                'short_description' => 'Golden Jasmine koleksiyon tepsisi - Alçı beton karışımı',
                'price' => 280.00,
                'sale_price' => 250.00,
                'category_id' => $categoryIds['Decor & Trays'] ?? 3,
                'brand' => 'Eva Home',
                'stock_quantity' => 15,
                'featured' => false
            ],
            [
                'name' => 'Minimal Lotus Objesi',
                'slug' => 'minimal-lotus-objesi',
                'description' => 'Alçı ve beton karışımı minimal lotus objesi. Dekoratif amaçlı, pastel renkli.',
                'short_description' => 'Minimal lotus objesi - Alçı beton karışımı',
                'price' => 180.00,
                'sale_price' => 160.00,
                'category_id' => $categoryIds['Decor & Trays'] ?? 3,
                'brand' => 'Eva Home',
                'stock_quantity' => 25,
                'featured' => false
            ],
            
            // Gift Sets Ürünleri
            [
                'name' => 'Golden Jasmine & Velvet Rose 2\'li Set',
                'slug' => 'golden-jasmine-velvet-rose-2li-set',
                'description' => 'Golden Jasmine ve Velvet Rose koleksiyonlarından 2\'li hediye seti. Şans ve aşk enerjisi kombinasyonu.',
                'short_description' => 'Golden Jasmine & Velvet Rose 2\'li hediye seti',
                'price' => 1200.00,
                'sale_price' => 1000.00,
                'category_id' => $categoryIds['Gift Sets'] ?? 4,
                'brand' => 'Eva Home',
                'stock_quantity' => 10,
                'featured' => true
            ],
            [
                'name' => 'Balance Collection 3\'lü Set',
                'slug' => 'balance-collection-3lu-set',
                'description' => 'Earth Harmony, Sacred Oud ve Royal Spice koleksiyonlarından 3\'lü hediye seti. Denge ve huzur enerjisi.',
                'short_description' => 'Balance Collection 3\'lü hediye seti - Denge enerjisi',
                'price' => 1800.00,
                'sale_price' => 1500.00,
                'category_id' => $categoryIds['Gift Sets'] ?? 4,
                'brand' => 'Eva Home',
                'stock_quantity' => 8,
                'featured' => true
            ],
            
            // Refill Collection Ürünleri
            [
                'name' => 'Silindir Mum Refill - Golden Jasmine',
                'slug' => 'silindir-mum-refill-golden-jasmine',
                'description' => 'Golden Jasmine koleksiyonundan silindir mum refill. Sürdürülebilirlik odaklı, kap atmadan yeniden doldurma.',
                'short_description' => 'Golden Jasmine silindir mum refill - Sürdürülebilir',
                'price' => 350.00,
                'category_id' => $categoryIds['Refill Collection'] ?? 5,
                'brand' => 'Eva Home',
                'stock_quantity' => 50,
                'featured' => false
            ],
            [
                'name' => 'Oda Kokusu Refill - Velvet Rose',
                'slug' => 'oda-kokusu-refill-velvet-rose',
                'description' => 'Velvet Rose koleksiyonundan oda kokusu refill. Yeniden doldurma şişesi, sürdürülebilir.',
                'short_description' => 'Velvet Rose oda kokusu refill - Yeniden doldurma',
                'price' => 250.00,
                'category_id' => $categoryIds['Refill Collection'] ?? 5,
                'brand' => 'Eva Home',
                'stock_quantity' => 40,
                'featured' => false
            ],
            
            // Accessories Ürünleri
            [
                'name' => 'Fitil Makası',
                'slug' => 'fitil-makasi',
                'description' => 'Mum bakımı için özel tasarlanmış fitil makası. Paslanmaz çelik, ergonomik tasarım.',
                'short_description' => 'Mum bakımı için fitil makası - Paslanmaz çelik',
                'price' => 85.00,
                'category_id' => $categoryIds['Accessories'] ?? 6,
                'brand' => 'Eva Home',
                'stock_quantity' => 30,
                'featured' => false
            ],
            [
                'name' => 'Mum Kapağı / Snuffer',
                'slug' => 'mum-kapagi-snuffer',
                'description' => 'Mum söndürme için özel tasarlanmış snuffer. Paslanmaz çelik, minimal tasarım.',
                'short_description' => 'Mum söndürme snuffer - Paslanmaz çelik',
                'price' => 65.00,
                'category_id' => $categoryIds['Accessories'] ?? 6,
                'brand' => 'Eva Home',
                'stock_quantity' => 35,
                'featured' => false
            ]
        ];
        
        // Ürünleri ekle
        foreach ($evaProducts as $product) {
            try {
                $stmt = $pdo->prepare("INSERT IGNORE INTO products (name, slug, description, short_description, price, sale_price, category_id, brand, stock_quantity, featured, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')");
                $stmt->execute([
                    $product['name'],
                    $product['slug'],
                    $product['description'],
                    $product['short_description'],
                    $product['price'],
                    $product['sale_price'] ?? null,
                    $product['category_id'],
                    $product['brand'],
                    $product['stock_quantity'],
                    $product['featured'] ? 1 : 0
                ]);
                $addedProducts++;
            } catch (PDOException $e) {
                // Ürün zaten varsa devam et
            }
        }
        
        echo "<div class='step'>
                <h3>🕯️ Eva Home Kategoriler ve Ürünler Eklendi</h3>
                <p class='success'>✅ Toplam {$addedCategories} kategori eklendi</p>
                <p class='success'>✅ Toplam {$addedProducts} ürün eklendi</p>
                <p>Eva Home'un gerçek kategorileri ve koleksiyonları başarıyla eklendi!</p>
              </div>";
        
        echo "<div class='step'>
                <h3>🔗 Sonraki Adımlar</h3>
                <p><a href='index.php' class='btn btn-success'>🏠 Ana Sayfayı Görüntüle</a></p>
                <p><a href='admin/login.php' class='btn'>⚙️ Admin Paneline Git</a></p>
              </div>";
        
    } else {
        echo "<div class='step'>
                <h3>📋 Bu İşlem Ne Yapar?</h3>
                <ul>
                    <li><strong>6 Ana Kategori</strong> ekler: Candles, Room Fragrances, Decor & Trays, Gift Sets, Refill Collection, Accessories</li>
                    <li><strong>8 Koleksiyon</strong> ekler: Golden Jasmine, Velvet Rose, Citrus Harmony, Luminous Bloom, Sacred Oud, Earth Harmony, Royal Spice, Lavender Peace</li>
                    <li><strong>20+ Ürün</strong> ekler: Her koleksiyondan çeşitli ürünler</li>
                    <li>Eva Home'un gerçek ürün yapısını oluşturur</li>
                    <li>Koleksiyon temalı ürün kategorilerini düzenler</li>
                </ul>
              </div>";
        
        echo "<div class='step'>
                <h3>🕯️ Eva Home Koleksiyonları</h3>
                <div class='collection-grid'>";
        
        $collections = [
            [
                'name' => 'Golden Jasmine',
                'description' => 'Şans ve pozitif enerji - Altın tonlarında soya mumu',
                'products' => 'Büyük/Küçük Silindir Mum, Yassı Mum, Refill Mum, Room Diffuser'
            ],
            [
                'name' => 'Velvet Rose',
                'description' => 'Aşk ve sevgi - Bordo tonlarında soya mumu',
                'products' => 'Büyük/Küçük Silindir Mum, Yassı Mum, Refill Mum, Room Diffuser'
            ],
            [
                'name' => 'Citrus Harmony',
                'description' => 'Neşe ve canlılık - Turuncu tonlarında soya mumu',
                'products' => 'Büyük/Küçük Silindir Mum, Yassı Mum, Refill Mum, Room Diffuser'
            ],
            [
                'name' => 'Luminous Bloom',
                'description' => 'Yenilenme ve tazelik - Pembe tonlarında soya mumu',
                'products' => 'Büyük/Küçük Silindir Mum, Yassı Mum, Refill Mum, Room Diffuser'
            ],
            [
                'name' => 'Sacred Oud',
                'description' => 'Huzur ve bereket - Koyu yeşil tonlarında soya mumu',
                'products' => 'Büyük/Küçük Silindir Mum, Yassı Mum, Refill Mum, Room Diffuser'
            ],
            [
                'name' => 'Earth Harmony',
                'description' => 'Bolluk ve topraklama - Kahve tonlarında soya mumu',
                'products' => 'Büyük/Küçük Silindir Mum, Yassı Mum, Refill Mum, Room Diffuser'
            ],
            [
                'name' => 'Royal Spice',
                'description' => 'Arınma ve negatif enerji temizliği - Gri tonlarında soya mumu',
                'products' => 'Büyük/Küçük Silindir Mum, Yassı Mum, Refill Mum, Room Diffuser'
            ],
            [
                'name' => 'Lavender Peace',
                'description' => 'Rahatlama ve stres azaltma - Lila tonlarında soya mumu',
                'products' => 'Büyük/Küçük Silindir Mum, Yassı Mum, Refill Mum, Room Diffuser'
            ]
        ];
        
        foreach ($collections as $collection) {
            echo "<div class='collection-card'>
                    <div class='collection-name'>{$collection['name']}</div>
                    <div class='collection-description'>{$collection['description']}</div>
                    <div class='collection-products'><strong>Ürünler:</strong> {$collection['products']}</div>
                  </div>";
        }
        
        echo "</div></div>";
        
        echo "<form method='POST'>
                <div class='step'>
                    <h3>🚀 Eva Home Kategorilerini Ekle</h3>
                    <p>Bu işlem Eva Home'un gerçek kategorilerini, koleksiyonlarını ve ürünlerini ekleyecek.</p>
                    <button type='submit' name='add_eva_categories' class='btn'>
                        <i class='fas fa-plus'></i> Eva Home Kategorilerini Ekle
                    </button>
                </div>
              </form>";
    }
    
} catch (Exception $e) {
    echo "<div class='step'>
            <p class='error'>❌ Hata: " . $e->getMessage() . "</p>
          </div>";
}

echo "</div></body></html>";
?>
