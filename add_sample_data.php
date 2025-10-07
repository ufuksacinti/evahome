<?php
// Örnek Veri Ekleme Scripti
// Bu dosyayı tarayıcıda çalıştırarak örnek blog yazıları ve ürünler ekleyin

require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='tr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Örnek Veri Ekleme</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .success { color: #28a745; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        .info { color: #17a2b8; font-weight: bold; }
        h1 { color: #f2740a; text-align: center; margin-bottom: 30px; }
        .step { background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #f2740a; }
        .btn { background: #f2740a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 5px; }
        .btn:hover { background: #e35a00; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>📝 Örnek Veri Ekleme</h1>";

try {
    // Veritabanı bağlantısını kontrol et
    if (!$pdo) {
        throw new Exception("Veritabanı bağlantısı yok");
    }
    
    echo "<div class='step'>
            <p class='success'>✅ Veritabanına başarıyla bağlandı</p>
          </div>";
    
    if ($_POST && isset($_POST['add_sample_data'])) {
        $addedProducts = 0;
        $addedBlogs = 0;
        $addedCategories = 0;
        
        // Ek kategoriler ekle
        $additionalCategories = [
            ['name' => 'Oturma Grubu', 'slug' => 'oturma-grubu', 'description' => 'Koltuk takımları ve oturma grupları', 'parent_id' => 1],
            ['name' => 'Yatak Odası Seti', 'slug' => 'yatak-odasi-seti', 'description' => 'Yatak odası mobilyaları', 'parent_id' => 1],
            ['name' => 'Mutfak Dolabı', 'slug' => 'mutfak-dolabi', 'description' => 'Mutfak dolapları ve depolama', 'parent_id' => 4],
            ['name' => 'Banyo Aksesuarı', 'slug' => 'banyo-aksesuari', 'description' => 'Banyo aksesuarları ve dekorasyon', 'parent_id' => 5],
            ['name' => 'Bahçe Mobilyası', 'slug' => 'bahce-mobilyasi', 'description' => 'Bahçe ve teras mobilyaları', 'parent_id' => 6],
            ['name' => 'Akıllı Ev', 'slug' => 'akilli-ev', 'description' => 'Akıllı ev teknolojileri', 'parent_id' => 7]
        ];
        
        foreach ($additionalCategories as $cat) {
            try {
                $stmt = $pdo->prepare("INSERT IGNORE INTO categories (name, slug, description, parent_id, sort_order) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$cat['name'], $cat['slug'], $cat['description'], $cat['parent_id'], 10]);
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
        
        // Örnek ürünler ekle
        $sampleProducts = [
            [
                'name' => 'Şık Koltuk Takımı',
                'slug' => 'sik-koltuk-takimi',
                'description' => 'Modern ve şık tasarımıyla dikkat çeken koltuk takımı. Premium kumaş kaplama ve rahat oturma deneyimi sunar. 3+2+1 oturma grubu olarak tasarlanmıştır.',
                'short_description' => 'Modern tasarım premium kumaş koltuk takımı',
                'price' => 3200.00,
                'sale_price' => 2800.00,
                'category_id' => $categoryIds['Koltuk Takımları'] ?? 1,
                'brand' => 'Eva Home',
                'stock_quantity' => 8,
                'featured' => true
            ],
            [
                'name' => 'Vintage Yemek Masası',
                'slug' => 'vintage-yemek-masasi',
                'description' => 'Vintage tarzda tasarlanmış yemek masası. Sağlam meşe ağacından üretilmiş, 6 kişilik oturma kapasitesi. Antik görünümü ile evinize karakter katacak.',
                'short_description' => 'Vintage tarz meşe ağacı yemek masası',
                'price' => 1800.00,
                'category_id' => $categoryIds['Yemek Masası'] ?? 1,
                'brand' => 'Classic',
                'stock_quantity' => 5,
                'featured' => false
            ],
            [
                'name' => 'Modern LED Avize',
                'slug' => 'modern-led-avize',
                'description' => 'Enerji tasarruflu LED teknolojisi ile üretilmiş modern avize. Uzaktan kumanda ile kontrol edilebilir, 3 farklı ışık seviyesi. Çelik ve cam kombinasyonu.',
                'short_description' => 'Uzaktan kumandalı LED avize',
                'price' => 650.00,
                'sale_price' => 550.00,
                'category_id' => $categoryIds['Aydınlatma'] ?? 2,
                'brand' => 'LightTech',
                'stock_quantity' => 12,
                'featured' => true
            ],
            [
                'name' => 'El Dokuması Kilim',
                'slug' => 'el-dokumasi-kilim',
                'description' => 'Geleneksel el dokuması kilim. Doğal yün ipliklerden üretilmiş, geleneksel desenlerle süslenmiş. 200x300 cm boyutlarında.',
                'short_description' => 'Geleneksel el dokuması yün kilim',
                'price' => 1200.00,
                'category_id' => $categoryIds['Tekstil'] ?? 3,
                'brand' => 'Handmade',
                'stock_quantity' => 3,
                'featured' => false
            ],
            [
                'name' => 'Paslanmaz Çelik Mutfak Seti',
                'slug' => 'paslanmaz-celik-mutfak-seti',
                'description' => '18/10 paslanmaz çelikten üretilmiş 15 parçalık mutfak seti. Ergonomik tasarım, kolay temizlik. Bulaşık makinesinde yıkanabilir.',
                'short_description' => '15 parçalık paslanmaz çelik mutfak seti',
                'price' => 450.00,
                'category_id' => $categoryIds['Mutfak'] ?? 4,
                'brand' => 'SteelPro',
                'stock_quantity' => 15,
                'featured' => false
            ],
            [
                'name' => 'Büyük Boy Banyo Aynası',
                'slug' => 'buyuk-boy-banyo-aynasi',
                'description' => '80x120 cm boyutlarında büyük banyo aynası. Su geçirmez çerçeve, LED aydınlatma özelliği. Dokunmatik kontrol ile 3 farklı ışık modu.',
                'short_description' => 'LED aydınlatmalı büyük banyo aynası',
                'price' => 280.00,
                'category_id' => $categoryIds['Banyo'] ?? 5,
                'brand' => 'MirrorTech',
                'stock_quantity' => 8,
                'featured' => false
            ],
            [
                'name' => 'Bahçe Masası ve Sandalyeler',
                'slug' => 'bahce-masasi-ve-sandalyeler',
                'description' => 'Hava koşullarına dayanıklı bahçe masası ve 4 sandalye seti. Teak ağacından üretilmiş, doğal yağ ile korunmuş. 6 kişilik oturma kapasitesi.',
                'short_description' => 'Teak ağacı bahçe masası ve sandalye seti',
                'price' => 2200.00,
                'category_id' => $categoryIds['Bahçe'] ?? 6,
                'brand' => 'GardenLife',
                'stock_quantity' => 4,
                'featured' => true
            ],
            [
                'name' => 'Akıllı Termostat',
                'slug' => 'akilli-termostat',
                'description' => 'WiFi bağlantılı akıllı termostat. Uygulama ile kontrol edilebilir, enerji tasarrufu sağlar. Sesli komut desteği ve öğrenme algoritması.',
                'short_description' => 'WiFi bağlantılı akıllı termostat',
                'price' => 350.00,
                'category_id' => $categoryIds['Elektronik'] ?? 7,
                'brand' => 'SmartHome',
                'stock_quantity' => 20,
                'featured' => false
            ]
        ];
        
        foreach ($sampleProducts as $product) {
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
        
        // Örnek blog yazıları ekle
        $sampleBlogs = [
            [
                'title' => '2024 Ev Dekorasyon Trendleri: Minimalizmden Maksimalizme',
                'slug' => '2024-ev-dekorasyon-trendleri',
                'content' => '<h2>2024 Yılının En Popüler Dekorasyon Trendleri</h2>
                <p>2024 yılında ev dekorasyonunda büyük değişimler yaşanıyor. Minimalist yaklaşımdan uzaklaşarak daha kişisel ve renkli alanlar yaratma eğilimi artıyor.</p>
                
                <h3>1. Doğal Malzemeler</h3>
                <p>Ahşap, taş, jüt gibi doğal malzemeler bu yılın en çok tercih edilen dekorasyon öğeleri. Sürdürülebilir yaşam anlayışının yaygınlaşmasıyla birlikte doğal malzemeler ön plana çıkıyor.</p>
                
                <h3>2. Pastel Renkler</h3>
                <p>Soft pink, lavanta, mint yeşili gibi pastel tonlar evlerde huzur verici bir atmosfer yaratıyor. Bu renkler özellikle yatak odalarında ve oturma alanlarında tercih ediliyor.</p>
                
                <h3>3. Vintage Aksesuarlar</h3>
                <p>Eski eşyaların yeniden değerlendirilmesi ve vintage aksesuarların kullanımı artıyor. Bu trend hem çevre dostu hem de kişisel bir dokunuş sağlıyor.</p>
                
                <h3>4. Çok Fonksiyonlu Mobilyalar</h3>
                <p>Küçük yaşam alanlarında çok fonksiyonlu mobilyalar büyük önem kazanıyor. Depolama özellikli yataklar, dönüştürülebilir masalar gibi pratik çözümler tercih ediliyor.</p>',
                'excerpt' => '2024 yılında ev dekorasyonunda doğal malzemeler, pastel renkler ve vintage aksesuarlar ön plana çıkıyor.',
                'category_id' => $categoryIds['Mobilya'] ?? 1,
                'featured' => true
            ],
            [
                'title' => 'Mutfak Organizasyonu: Küçük Mutfaklarda Büyük Çözümler',
                'slug' => 'mutfak-organizasyonu-kucuk-mutfaklar',
                'content' => '<h2>Küçük Mutfakları Büyük Göstermenin Yolları</h2>
                <p>Küçük mutfaklar, doğru organizasyon ve tasarım teknikleriyle çok daha ferah ve kullanışlı hale getirilebilir.</p>
                
                <h3>1. Dikey Depolama</h3>
                <p>Duvar rafları, askılı sistemler ve dikey depolama çözümleri ile mutfağınızın depolama kapasitesini artırabilirsiniz. Bu yöntem hem pratik hem de dekoratif.</p>
                
                <h3>2. Açık Raf Sistemleri</h3>
                <p>Açık raflar hem depolama hem de dekorasyon işlevi görür. Günlük kullandığınız eşyaları bu raflarda sergileyebilir, mutfağınıza kişisel bir dokunuş katabilirsiniz.</p>
                
                <h3>3. Çok Fonksiyonlu Eşyalar</h3>
                <p>Çok fonksiyonlu mutfak eşyaları küçük alanlarda büyük fark yaratır. Örneğin, kesme tahtası olarak da kullanılabilen servis tepsileri gibi.</p>
                
                <h3>4. Aydınlatma Stratejisi</h3>
                <p>Doğru aydınlatma mutfağınızı daha büyük gösterebilir. Alt dolapların altına LED şeritler, tezgah üstü aydınlatmalar kullanabilirsiniz.</p>',
                'excerpt' => 'Küçük mutfakları büyük göstermenin pratik yolları ve organizasyon teknikleri.',
                'category_id' => $categoryIds['Mutfak'] ?? 4,
                'featured' => false
            ],
            [
                'title' => 'Aydınlatma Tasarımı: Evinizde Doğru Işığı Yaratın',
                'slug' => 'aydinlatma-tasarimi-dogru-isik',
                'content' => '<h2>Evinizde Mükemmel Aydınlatma Nasıl Sağlanır?</h2>
                <p>Aydınlatma, bir evin atmosferini belirleyen en önemli faktörlerden biridir. Doğru aydınlatma ile evinizi daha konforlu ve çekici hale getirebilirsiniz.</p>
                
                <h3>1. Katmanlı Aydınlatma</h3>
                <p>Genel aydınlatma, görev aydınlatması ve dekoratif aydınlatma olmak üzere üç katmanlı bir sistem kurun. Bu yaklaşım farklı ihtiyaçlarınızı karşılar.</p>
                
                <h3>2. LED Teknolojisi</h3>
                <p>LED aydınlatma hem enerji tasarrufu sağlar hem de uzun ömürlüdür. Renk sıcaklığını ayarlayabilen LED\'ler farklı atmosferler yaratmanıza olanak tanır.</p>
                
                <h3>3. Doğal Işık</h3>
                <p>Gün ışığından maksimum faydalanın. Büyük pencereler, açık renkli perdeler ve aynalar ile doğal ışığı evinizin her köşesine yayın.</p>
                
                <h3>4. Akıllı Aydınlatma Sistemleri</h3>
                <p>Akıllı aydınlatma sistemleri ile evinizin aydınlatmasını uzaktan kontrol edebilir, farklı senaryolar oluşturabilirsiniz.</p>',
                'excerpt' => 'Evinizde mükemmel aydınlatma için katmanlı sistem, LED teknolojisi ve akıllı çözümler.',
                'category_id' => $categoryIds['Aydınlatma'] ?? 2,
                'featured' => true
            ],
            [
                'title' => 'Banyo Dekorasyonu: Küçük Banyolarda Büyük Değişimler',
                'slug' => 'banyo-dekorasyonu-kucuk-banyolar',
                'content' => '<h2>Küçük Banyolarda Büyük Değişimler Yaratın</h2>
                <p>Küçük banyolar, doğru tasarım ve dekorasyon teknikleriyle çok daha ferah ve kullanışlı hale getirilebilir.</p>
                
                <h3>1. Açık Renkler</h3>
                <p>Beyaz, açık gri, pastel mavi gibi açık renkler banyoyu daha büyük gösterir. Koyu renklerden kaçının ve tek renk paleti kullanın.</p>
                
                <h3>2. Dikey Depolama</h3>
                <p>Duvar rafları, askılı sistemler ve dikey depolama çözümleri ile banyonuzun depolama kapasitesini artırabilirsiniz.</p>
                
                <h3>3. Büyük Aynalar</h3>
                <p>Büyük aynalar mekanı genişletir ve daha ferah gösterir. LED aydınlatmalı aynalar hem pratik hem de dekoratif.</p>
                
                <h3>4. Şeffaf Elemanlar</h3>
                <p>Şeffaf duş kabinleri, cam raflar gibi şeffaf elemanlar mekanı daha açık gösterir ve ferahlık hissi yaratır.</p>',
                'excerpt' => 'Küçük banyolarda büyük değişimler yaratmak için pratik dekorasyon ipuçları.',
                'category_id' => $categoryIds['Banyo'] ?? 5,
                'featured' => false
            ],
            [
                'title' => 'Bahçe Dekorasyonu: Dış Mekanı Yaşam Alanına Çevirin',
                'slug' => 'bahce-dekorasyonu-dis-mekan',
                'content' => '<h2>Bahçenizi Yaşam Alanına Çevirin</h2>
                <p>Bahçe ve teras alanları, doğru dekorasyon ile evinizin en sevilen bölümlerinden biri haline gelebilir.</p>
                
                <h3>1. Konforlu Oturma Alanları</h3>
                <p>Bahçe mobilyaları seçerken konfor ve dayanıklılığı ön planda tutun. Hava koşullarına dayanıklı malzemeler tercih edin.</p>
                
                <h3>2. Doğal Aydınlatma</h3>
                <p>Bahçe aydınlatması için güneş enerjili lambalar, LED şeritler ve mumlar kullanabilirsiniz. Romantik bir atmosfer yaratın.</p>
                
                <h3>3. Bitki Düzenlemesi</h3>
                <p>Farklı boyutlarda bitkiler, çiçekler ve ağaçlar ile bahçenize derinlik katın. Mevsimlik bitkiler ile sürekli değişen bir görünüm yaratın.</p>
                
                <h3>4. Su Öğeleri</h3>
                <p>Küçük havuzlar, çeşmeler veya su sesi çıkaran dekoratif öğeler bahçenize huzur verici bir atmosfer katar.</p>',
                'excerpt' => 'Bahçe ve teras alanlarını yaşam alanına çevirmek için dekorasyon ipuçları.',
                'category_id' => $categoryIds['Bahçe'] ?? 6,
                'featured' => false
            ]
        ];
        
        foreach ($sampleBlogs as $blog) {
            try {
                $stmt = $pdo->prepare("INSERT IGNORE INTO blog_posts (title, slug, content, excerpt, author_id, category_id, status, featured, published_at) VALUES (?, ?, ?, ?, 1, ?, 'published', ?, NOW())");
                $stmt->execute([
                    $blog['title'],
                    $blog['slug'],
                    $blog['content'],
                    $blog['excerpt'],
                    $blog['category_id'],
                    $blog['featured'] ? 1 : 0
                ]);
                $addedBlogs++;
            } catch (PDOException $e) {
                // Blog zaten varsa devam et
            }
        }
        
        echo "<div class='step'>
                <h3>✅ Örnek Veriler Başarıyla Eklendi!</h3>
                <p class='success'>Eklenen veriler:</p>
                <ul>
                    <li><strong>Kategoriler:</strong> $addedCategories adet</li>
                    <li><strong>Ürünler:</strong> $addedProducts adet</li>
                    <li><strong>Blog Yazıları:</strong> $addedBlogs adet</li>
                </ul>
              </div>";
        
        echo "<div style='text-align: center; margin: 30px 0;'>
                <a href='index.php' class='btn btn-success'>🏠 Ana Sayfayı Görüntüle</a>
                <a href='admin/dashboard.php' class='btn'>👤 Admin Paneli</a>
              </div>";
        
    } else {
        // Mevcut veri sayılarını göster
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM products");
        $productCount = $stmt->fetch()['count'];
        
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM blog_posts");
        $blogCount = $stmt->fetch()['count'];
        
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM categories");
        $categoryCount = $stmt->fetch()['count'];
        
        echo "<div class='step'>
                <h3>📊 Mevcut Veri Durumu</h3>
                <ul>
                    <li><strong>Kategoriler:</strong> $categoryCount adet</li>
                    <li><strong>Ürünler:</strong> $productCount adet</li>
                    <li><strong>Blog Yazıları:</strong> $blogCount adet</li>
                </ul>
              </div>";
        
        echo "<div class='step'>
                <h3>📝 Örnek Veri Ekleme</h3>
                <p>Web sitesinin yapısını daha iyi görebilmek için örnek blog yazıları ve ürünler ekleyebilirsiniz.</p>
                <form method='POST'>
                    <button type='submit' name='add_sample_data' class='btn btn-success' style='font-size: 16px; padding: 15px 30px;'>
                        📝 Örnek Verileri Ekle
                    </button>
                </form>
              </div>";
    }
    
} catch (Exception $e) {
    echo "<div class='step'>
            <h3>❌ Hata</h3>
            <p class='error'>Hata: " . $e->getMessage() . "</p>
          </div>";
}

echo "</div></body></html>";
?>
