<?php
// Daha Fazla Ürün Ekleme Scripti
// Bu dosyayı tarayıcıda çalıştırarak daha fazla ürün ekleyin

require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='tr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Daha Fazla Ürün Ekleme</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .success { color: #28a745; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        .info { color: #17a2b8; font-weight: bold; }
        h1 { color: #c9a24a; text-align: center; margin-bottom: 30px; }
        .step { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #c9a24a; }
        .btn { background: #c9a24a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 5px; }
        .btn:hover { background: #a0883d; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🛍️ Daha Fazla Ürün Ekleme</h1>";

try {
    // Veritabanı bağlantısını kontrol et
    if (!$pdo) {
        throw new Exception("Veritabanı bağlantısı yok");
    }
    
    echo "<div class='step'>
            <p class='success'>✅ Veritabanına başarıyla bağlandı</p>
          </div>";
    
    if ($_POST && isset($_POST['add_more_products'])) {
        $addedProducts = 0;
        
        // Kategori ID'lerini al
        $categoryIds = [];
        $stmt = $pdo->query("SELECT id, name FROM categories ORDER BY id");
        $categories = $stmt->fetchAll();
        foreach ($categories as $cat) {
            $categoryIds[$cat['name']] = $cat['id'];
        }
        
        // Daha fazla ürün ekle
        $moreProducts = [
            // Mobilya Kategorisi - Daha Fazla
            [
                'name' => 'Modern Yemek Masası',
                'slug' => 'modern-yemek-masasi',
                'description' => 'Ahşap ve metal kombinasyonu ile modern tasarım. 6 kişilik oturma kapasitesi, kolay temizlenebilir yüzey.',
                'short_description' => 'Ahşap ve metal kombinasyonu modern yemek masası',
                'price' => 2500.00,
                'sale_price' => 2200.00,
                'category_id' => $categoryIds['Mobilya'] ?? 1,
                'brand' => 'Eva Home',
                'stock_quantity' => 15,
                'featured' => true
            ],
            [
                'name' => 'Şık Koltuk Takımı',
                'slug' => 'sik-koltuk-takimi-2',
                'description' => 'Rahat ve şık 3+2+1 koltuk takımı. Premium kumaş kaplama, ergonomik tasarım.',
                'short_description' => 'Premium kumaş 3+2+1 koltuk takımı',
                'price' => 4500.00,
                'sale_price' => 4200.00,
                'category_id' => $categoryIds['Mobilya'] ?? 1,
                'brand' => 'Comfort Plus',
                'stock_quantity' => 8,
                'featured' => true
            ],
            [
                'name' => 'Yatak Odası Takımı',
                'slug' => 'yatak-odasi-takimi',
                'description' => 'Komplet yatak odası mobilya seti. Gardırop, komodin, yatak başlığı dahil.',
                'short_description' => 'Komplet yatak odası mobilya seti',
                'price' => 6800.00,
                'sale_price' => 6200.00,
                'category_id' => $categoryIds['Mobilya'] ?? 1,
                'brand' => 'Bedroom Pro',
                'stock_quantity' => 5,
                'featured' => false
            ],
            [
                'name' => 'Çalışma Masası',
                'slug' => 'calisma-masasi',
                'description' => 'Ergonomik çalışma masası. Ayarlanabilir yükseklik, kablolama sistemi dahil.',
                'short_description' => 'Ergonomik ayarlanabilir çalışma masası',
                'price' => 1200.00,
                'category_id' => $categoryIds['Mobilya'] ?? 1,
                'brand' => 'OfficeMax',
                'stock_quantity' => 20,
                'featured' => false
            ],
            [
                'name' => 'TV Ünitesi',
                'slug' => 'tv-unitesi',
                'description' => 'Modern TV ünitesi ve depolama. 55 inç TV\'ye kadar uygun, LED ışık sistemi.',
                'short_description' => 'LED ışıklı modern TV ünitesi',
                'price' => 1800.00,
                'sale_price' => 1600.00,
                'category_id' => $categoryIds['Mobilya'] ?? 1,
                'brand' => 'MediaCenter',
                'stock_quantity' => 12,
                'featured' => false
            ],
            [
                'name' => 'Kitaplık',
                'slug' => 'kitaplik',
                'description' => '5 katlı ahşap kitaplık. Ayarlanabilir raflar, modern tasarım.',
                'short_description' => '5 katlı ayarlanabilir ahşap kitaplık',
                'price' => 950.00,
                'category_id' => $categoryIds['Mobilya'] ?? 1,
                'brand' => 'BookShelf',
                'stock_quantity' => 18,
                'featured' => false
            ],
            
            // Aydınlatma Kategorisi - Daha Fazla
            [
                'name' => 'Avize - Kristal',
                'slug' => 'avize-kristal',
                'description' => 'Kristal avize, salon için. 12 ampul, dimmer kontrolü.',
                'short_description' => '12 ampullü kristal avize',
                'price' => 850.00,
                'sale_price' => 750.00,
                'category_id' => $categoryIds['Aydınlatma'] ?? 2,
                'brand' => 'Crystal Light',
                'stock_quantity' => 6,
                'featured' => true
            ],
            [
                'name' => 'Masa Lambası',
                'slug' => 'masa-lambasi',
                'description' => 'Modern masa lambası. LED teknolojisi, dokunmatik kontrol.',
                'short_description' => 'Dokunmatik kontrollü LED masa lambası',
                'price' => 180.00,
                'category_id' => $categoryIds['Aydınlatma'] ?? 2,
                'brand' => 'DeskLight',
                'stock_quantity' => 25,
                'featured' => false
            ],
            [
                'name' => 'Duvar Lambası',
                'slug' => 'duvar-lambasi',
                'description' => 'LED duvar lambası seti. 3 farklı ışık modu, uzaktan kumanda.',
                'short_description' => 'Uzaktan kumandalı LED duvar lambası',
                'price' => 320.00,
                'sale_price' => 280.00,
                'category_id' => $categoryIds['Aydınlatma'] ?? 2,
                'brand' => 'WallLight',
                'stock_quantity' => 15,
                'featured' => false
            ],
            [
                'name' => 'Bahçe Aydınlatması',
                'slug' => 'bahce-aydinlatmasi',
                'description' => 'Solar bahçe lambaları. Güneş enerjisi ile çalışır, otomatik açılma.',
                'short_description' => 'Solar enerjili bahçe lambaları',
                'price' => 450.00,
                'category_id' => $categoryIds['Aydınlatma'] ?? 2,
                'brand' => 'SolarGarden',
                'stock_quantity' => 10,
                'featured' => false
            ],
            [
                'name' => 'Spot Işık',
                'slug' => 'spot-isik',
                'description' => 'LED spot ışık sistemi. Ayarlanabilir açı, dimmer kontrolü.',
                'short_description' => 'Ayarlanabilir LED spot ışık sistemi',
                'price' => 280.00,
                'sale_price' => 250.00,
                'category_id' => $categoryIds['Aydınlatma'] ?? 2,
                'brand' => 'SpotPro',
                'stock_quantity' => 20,
                'featured' => false
            ],
            [
                'name' => 'Gece Lambası',
                'slug' => 'gece-lambasi',
                'description' => 'Çocuk odası için gece lambası. Yumuşak ışık, otomatik kapanma.',
                'short_description' => 'Çocuk odası için yumuşak ışıklı gece lambası',
                'price' => 95.00,
                'category_id' => $categoryIds['Aydınlatma'] ?? 2,
                'brand' => 'NightLight',
                'stock_quantity' => 30,
                'featured' => false
            ],
            
            // Tekstil Kategorisi - Daha Fazla
            [
                'name' => 'Yatak Takımı - Pamuk',
                'slug' => 'yatak-takimi-pamuk',
                'description' => '100% pamuk yatak takımı. Çift kişilik, kolay yıkanabilir.',
                'short_description' => '100% pamuk çift kişilik yatak takımı',
                'price' => 180.00,
                'sale_price' => 160.00,
                'category_id' => $categoryIds['Tekstil'] ?? 3,
                'brand' => 'CottonSoft',
                'stock_quantity' => 25,
                'featured' => true
            ],
            [
                'name' => 'Perde Seti',
                'slug' => 'perde-seti',
                'description' => 'Kalın kumaş perde seti. Ses yalıtımı, güneş koruması.',
                'short_description' => 'Ses yalıtımlı kalın kumaş perde seti',
                'price' => 320.00,
                'sale_price' => 280.00,
                'category_id' => $categoryIds['Tekstil'] ?? 3,
                'brand' => 'CurtainPro',
                'stock_quantity' => 12,
                'featured' => false
            ],
            [
                'name' => 'Halı - Modern',
                'slug' => 'hali-modern',
                'description' => 'Modern desenli salon halısı. Yün karışımı, kolay temizlenebilir.',
                'short_description' => 'Modern desenli yün karışımı salon halısı',
                'price' => 450.00,
                'sale_price' => 400.00,
                'category_id' => $categoryIds['Tekstil'] ?? 3,
                'brand' => 'ModernRug',
                'stock_quantity' => 8,
                'featured' => false
            ],
            [
                'name' => 'Nevresim Takımı',
                'slug' => 'nevresim-takimi',
                'description' => 'Lüks nevresim takımı. Çift kişilik, yüksek kalite kumaş.',
                'short_description' => 'Lüks çift kişilik nevresim takımı',
                'price' => 220.00,
                'category_id' => $categoryIds['Tekstil'] ?? 3,
                'brand' => 'LuxuryBed',
                'stock_quantity' => 15,
                'featured' => false
            ],
            [
                'name' => 'Battaniye',
                'slug' => 'battaniye',
                'description' => 'Yün battaniye. Tek kişilik, yumuşak dokuma.',
                'short_description' => 'Yumuşak dokuma yün battaniye',
                'price' => 150.00,
                'sale_price' => 130.00,
                'category_id' => $categoryIds['Tekstil'] ?? 3,
                'brand' => 'WoolBlanket',
                'stock_quantity' => 20,
                'featured' => false
            ],
            [
                'name' => 'Yastık Kılıfı',
                'slug' => 'yastik-kilifi',
                'description' => 'Dekoratif yastık kılıfları. 50x50 cm, çeşitli desenler.',
                'short_description' => 'Dekoratif 50x50 cm yastık kılıfları',
                'price' => 45.00,
                'category_id' => $categoryIds['Tekstil'] ?? 3,
                'brand' => 'PillowCase',
                'stock_quantity' => 35,
                'featured' => false
            ],
            
            // Mutfak Kategorisi - Daha Fazla
            [
                'name' => 'Kahve Makinesi',
                'slug' => 'kahve-makinesi',
                'description' => 'Otomatik kahve makinesi. Espresso, cappuccino, latte yapabilir.',
                'short_description' => 'Otomatik espresso ve cappuccino makinesi',
                'price' => 1200.00,
                'sale_price' => 1100.00,
                'category_id' => $categoryIds['Mutfak'] ?? 4,
                'brand' => 'CoffeeMaster',
                'stock_quantity' => 8,
                'featured' => true
            ],
            [
                'name' => 'Blender Seti',
                'slug' => 'blender-seti',
                'description' => 'Profesyonel blender seti. 6 farklı hız, paslanmaz çelik bıçak.',
                'short_description' => '6 hızlı profesyonel blender seti',
                'price' => 450.00,
                'sale_price' => 400.00,
                'category_id' => $categoryIds['Mutfak'] ?? 4,
                'brand' => 'BlendPro',
                'stock_quantity' => 12,
                'featured' => false
            ],
            [
                'name' => 'Tencere Seti',
                'slug' => 'tencere-seti',
                'description' => 'Paslanmaz çelik tencere seti. 7 parça, bulaşık makinesinde yıkanabilir.',
                'short_description' => '7 parçalık paslanmaz çelik tencere seti',
                'price' => 380.00,
                'sale_price' => 350.00,
                'category_id' => $categoryIds['Mutfak'] ?? 4,
                'brand' => 'SteelCook',
                'stock_quantity' => 15,
                'featured' => false
            ],
            [
                'name' => 'Mikrodalga Fırın',
                'slug' => 'mikrodalga-firin',
                'description' => 'Dijital mikrodalga fırın. 25 litre, çoklu pişirme programları.',
                'short_description' => '25 litrelik dijital mikrodalga fırın',
                'price' => 850.00,
                'category_id' => $categoryIds['Mutfak'] ?? 4,
                'brand' => 'MicroWave',
                'stock_quantity' => 6,
                'featured' => false
            ],
            [
                'name' => 'Tost Makinesi',
                'slug' => 'tost-makinesi',
                'description' => 'Çok fonksiyonlu tost makinesi. Sandviç, waffle, panini yapabilir.',
                'short_description' => 'Çok fonksiyonlu tost ve waffle makinesi',
                'price' => 180.00,
                'sale_price' => 160.00,
                'category_id' => $categoryIds['Mutfak'] ?? 4,
                'brand' => 'ToastMaster',
                'stock_quantity' => 20,
                'featured' => false
            ],
            [
                'name' => 'Su Isıtıcısı',
                'slug' => 'su-isiticisi',
                'description' => 'Hızlı su ısıtıcısı. 1.7 litre, otomatik kapanma.',
                'short_description' => '1.7 litrelik hızlı su ısıtıcısı',
                'price' => 120.00,
                'category_id' => $categoryIds['Mutfak'] ?? 4,
                'brand' => 'WaterBoil',
                'stock_quantity' => 25,
                'featured' => false
            ],
            
            // Banyo Kategorisi - Daha Fazla
            [
                'name' => 'Banyo Seti',
                'slug' => 'banyo-seti',
                'description' => 'Komplet banyo aksesuar seti. Diş fırçası, sabunluk, havlu askısı dahil.',
                'short_description' => 'Komplet banyo aksesuar seti',
                'price' => 280.00,
                'sale_price' => 250.00,
                'category_id' => $categoryIds['Banyo'] ?? 5,
                'brand' => 'BathSet',
                'stock_quantity' => 10,
                'featured' => true
            ],
            [
                'name' => 'Duş Kabini',
                'slug' => 'dus-kabini',
                'description' => 'Cam duş kabini. 90x90 cm, kaymaz taban.',
                'short_description' => '90x90 cm cam duş kabini',
                'price' => 1200.00,
                'sale_price' => 1100.00,
                'category_id' => $categoryIds['Banyo'] ?? 5,
                'brand' => 'ShowerPro',
                'stock_quantity' => 4,
                'featured' => false
            ],
            [
                'name' => 'Lavabo',
                'slug' => 'lavabo',
                'description' => 'Modern lavabo. Seramik, kolay temizlenebilir.',
                'short_description' => 'Modern seramik lavabo',
                'price' => 450.00,
                'sale_price' => 400.00,
                'category_id' => $categoryIds['Banyo'] ?? 5,
                'brand' => 'SinkModern',
                'stock_quantity' => 8,
                'featured' => false
            ],
            [
                'name' => 'Ayna',
                'slug' => 'ayna',
                'description' => 'Banyo aynası. 60x80 cm, su geçirmez çerçeve.',
                'short_description' => '60x80 cm su geçirmez banyo aynası',
                'price' => 180.00,
                'category_id' => $categoryIds['Banyo'] ?? 5,
                'brand' => 'MirrorBath',
                'stock_quantity' => 15,
                'featured' => false
            ],
            [
                'name' => 'Havlu Seti',
                'slug' => 'havlu-seti',
                'description' => 'Lüks havlu seti. 4 parça, yüksek emicilik.',
                'short_description' => '4 parçalık lüks havlu seti',
                'price' => 95.00,
                'sale_price' => 85.00,
                'category_id' => $categoryIds['Banyo'] ?? 5,
                'brand' => 'TowelLux',
                'stock_quantity' => 20,
                'featured' => false
            ],
            [
                'name' => 'Banyo Halısı',
                'slug' => 'banyo-halisi',
                'description' => 'Su emici banyo halısı. Kaymaz taban, kolay yıkanabilir.',
                'short_description' => 'Su emici kaymaz banyo halısı',
                'price' => 65.00,
                'category_id' => $categoryIds['Banyo'] ?? 5,
                'brand' => 'BathMat',
                'stock_quantity' => 25,
                'featured' => false
            ],
            
            // Bahçe Kategorisi - Daha Fazla
            [
                'name' => 'Bahçe Mobilyası',
                'slug' => 'bahce-mobilyasi',
                'description' => 'Ahşap bahçe mobilya seti. Masası ve 4 sandalye, hava koşullarına dayanıklı.',
                'short_description' => 'Ahşap bahçe masası ve sandalye seti',
                'price' => 1800.00,
                'sale_price' => 1600.00,
                'category_id' => $categoryIds['Bahçe'] ?? 6,
                'brand' => 'GardenWood',
                'stock_quantity' => 6,
                'featured' => true
            ],
            [
                'name' => 'Saksı Seti',
                'slug' => 'saksi-seti',
                'description' => 'Seramik saksı seti. 5 farklı boyut, drenaj delikli.',
                'short_description' => '5 farklı boyutlu seramik saksı seti',
                'price' => 120.00,
                'sale_price' => 100.00,
                'category_id' => $categoryIds['Bahçe'] ?? 6,
                'brand' => 'PotSet',
                'stock_quantity' => 30,
                'featured' => false
            ],
            [
                'name' => 'Bahçe Aletleri',
                'slug' => 'bahce-aletleri',
                'description' => 'Bahçe bakım aletleri seti. Kürek, tırmık, makas dahil.',
                'short_description' => 'Bahçe bakım aletleri seti',
                'price' => 280.00,
                'category_id' => $categoryIds['Bahçe'] ?? 6,
                'brand' => 'GardenTools',
                'stock_quantity' => 15,
                'featured' => false
            ],
            [
                'name' => 'Çim Biçme Makinesi',
                'slug' => 'cim-bicme-makinesi',
                'description' => 'Elektrikli çim biçme makinesi. 40 cm kesim genişliği.',
                'short_description' => '40 cm kesim genişlikli elektrikli çim biçme makinesi',
                'price' => 450.00,
                'sale_price' => 400.00,
                'category_id' => $categoryIds['Bahçe'] ?? 6,
                'brand' => 'LawnMower',
                'stock_quantity' => 8,
                'featured' => false
            ],
            [
                'name' => 'Sulama Sistemi',
                'slug' => 'sulama-sistemi',
                'description' => 'Otomatik sulama sistemi. Timer kontrollü, 10 fıskiye.',
                'short_description' => 'Timer kontrollü otomatik sulama sistemi',
                'price' => 320.00,
                'sale_price' => 280.00,
                'category_id' => $categoryIds['Bahçe'] ?? 6,
                'brand' => 'IrrigationPro',
                'stock_quantity' => 12,
                'featured' => false
            ],
            [
                'name' => 'Bahçe Işıkları',
                'slug' => 'bahce-isiklari',
                'description' => 'LED bahçe ışık sistemi. Solar enerjili, otomatik açılma.',
                'short_description' => 'Solar enerjili LED bahçe ışık sistemi',
                'price' => 180.00,
                'category_id' => $categoryIds['Bahçe'] ?? 6,
                'brand' => 'GardenLight',
                'stock_quantity' => 20,
                'featured' => false
            ],
            
            // Elektronik Kategorisi - Daha Fazla
            [
                'name' => 'Akıllı Ev Sistemi',
                'slug' => 'akilli-ev-sistemi',
                'description' => 'Akıllı ev otomasyon sistemi. WiFi bağlantılı, uygulama kontrolü.',
                'short_description' => 'WiFi bağlantılı akıllı ev otomasyon sistemi',
                'price' => 2500.00,
                'sale_price' => 2200.00,
                'category_id' => $categoryIds['Elektronik'] ?? 7,
                'brand' => 'SmartHome',
                'stock_quantity' => 5,
                'featured' => true
            ],
            [
                'name' => 'Güvenlik Kamerası',
                'slug' => 'guvenlik-kamerasi',
                'description' => 'IP güvenlik kamera sistemi. Gece görüş, hareket algılama.',
                'short_description' => 'Gece görüşlü IP güvenlik kamera sistemi',
                'price' => 450.00,
                'sale_price' => 400.00,
                'category_id' => $categoryIds['Elektronik'] ?? 7,
                'brand' => 'SecurityCam',
                'stock_quantity' => 12,
                'featured' => false
            ],
            [
                'name' => 'Ses Sistemi',
                'slug' => 'ses-sistemi',
                'description' => 'Bluetooth ses sistemi. 2.1 kanal, subwoofer dahil.',
                'short_description' => '2.1 kanal Bluetooth ses sistemi',
                'price' => 320.00,
                'sale_price' => 280.00,
                'category_id' => $categoryIds['Elektronik'] ?? 7,
                'brand' => 'SoundPro',
                'stock_quantity' => 15,
                'featured' => false
            ],
            [
                'name' => 'Tablet Standı',
                'slug' => 'tablet-standi',
                'description' => 'Ayarlanabilir tablet standı. 360° döndürme, katlanabilir.',
                'short_description' => '360° döndürme özellikli tablet standı',
                'price' => 85.00,
                'category_id' => $categoryIds['Elektronik'] ?? 7,
                'brand' => 'TabletStand',
                'stock_quantity' => 25,
                'featured' => false
            ],
            [
                'name' => 'Telefon Tutucu',
                'slug' => 'telefon-tutucu',
                'description' => 'Masa üstü telefon tutucu. Ayarlanabilir açı, evrensel uyum.',
                'short_description' => 'Ayarlanabilir açılı masa üstü telefon tutucu',
                'price' => 45.00,
                'sale_price' => 40.00,
                'category_id' => $categoryIds['Elektronik'] ?? 7,
                'brand' => 'PhoneHolder',
                'stock_quantity' => 30,
                'featured' => false
            ],
            [
                'name' => 'Kablosuz Şarj',
                'slug' => 'kablosuz-sarj',
                'description' => 'Kablosuz şarj cihazı. Hızlı şarj, LED göstergesi.',
                'short_description' => 'Hızlı kablosuz şarj cihazı',
                'price' => 120.00,
                'category_id' => $categoryIds['Elektronik'] ?? 7,
                'brand' => 'WirelessCharge',
                'stock_quantity' => 20,
                'featured' => false
            ]
        ];
        
        foreach ($moreProducts as $product) {
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
                <h3>🛍️ Ürün Ekleme Sonucu</h3>
                <p class='success'>✅ Toplam {$addedProducts} yeni ürün başarıyla eklendi!</p>
                <p>Artık ana sayfada daha fazla ürün görüntüleyebilirsiniz.</p>
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
                    <li>36 yeni ürün ekler (her kategoriden 6'şar ürün)</li>
                    <li>Ürünlerin fiyat, stok, kategori bilgilerini doldurur</li>
                    <li>Bazı ürünleri 'Öne Çıkan' olarak işaretler</li>
                    <li>İndirimli fiyatlar ekler</li>
                    <li>Ana sayfayı daha dolu gösterir</li>
                </ul>
              </div>";
        
        echo "<form method='POST'>
                <div class='step'>
                    <h3>🚀 Ürünleri Ekle</h3>
                    <p>Bu işlem 36 yeni ürün ekleyecek ve ana sayfayı daha dolu gösterecek.</p>
                    <button type='submit' name='add_more_products' class='btn'>
                        <i class='fas fa-plus'></i> Daha Fazla Ürün Ekle
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
