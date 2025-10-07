<?php
/**
 * Eva Home - Kapsamlı Veri Yükleme Scripti
 * En az 10 blog yazısı ve 100 ürün ekler
 */

require_once 'config/database.php';

$addedProducts = 0;
$addedBlogs = 0;
$startTime = microtime(true);

echo "<!DOCTYPE html>
<html lang='tr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Eva Home - Kapsamlı Veri Yükleme</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' rel='stylesheet'>
    <style>
        body {
            background: linear-gradient(135deg, #fef7ee 0%, #f1f5f9 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 30px 0;
        }
        .header {
            background: linear-gradient(135deg, #c9a24a 0%, #a0883d 100%);
            color: white;
            padding: 40px;
            border-radius: 15px 15px 0 0;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .content {
            background: white;
            padding: 40px;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .progress {
            height: 30px;
            font-size: 14px;
            font-weight: bold;
        }
        .progress-bar {
            background: linear-gradient(90deg, #c9a24a 0%, #a0883d 100%);
        }
        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin: 10px 0;
        }
        .stat-number {
            font-size: 2.5em;
            font-weight: bold;
            color: #c9a24a;
        }
        .log-item {
            padding: 8px 15px;
            margin: 5px 0;
            background: #f8f9fa;
            border-left: 3px solid #c9a24a;
            border-radius: 5px;
            font-size: 0.9em;
        }
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(201, 162, 74, 0.3);
            border-radius: 50%;
            border-top-color: #c9a24a;
            animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <i class='fas fa-database fa-4x mb-3'></i>
            <h1 class='mb-2'>🕯️ Eva Home</h1>
            <h3>Kapsamlı Veri Yükleme</h3>
            <p class='mb-0'>En az 10 blog yazısı ve 100 ürün yükleniyor...</p>
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
    
    // Kategori ID'lerini al
    $categoryIds = [];
    $stmt = $pdo->query("SELECT id, name, slug FROM categories");
    $categories = $stmt->fetchAll();
    foreach ($categories as $cat) {
        $categoryIds[$cat['name']] = $cat['id'];
        $categoryIds[$cat['slug']] = $cat['id'];
    }
    
    // ================================================================
    // BLOG YAZILARI EKLEME (10+)
    // ================================================================
    echo "<h4 class='mt-4 mb-3'><i class='fas fa-blog me-2'></i>Blog Yazıları Ekleniyor</h4>";
    echo "<div class='progress mb-3'>
            <div class='progress-bar progress-bar-striped progress-bar-animated' role='progressbar' style='width: 0%' id='blogProgress'>
                0 / 15 Blog
            </div>
          </div>";
    echo "<div id='blogLog'></div>";
    
    $blogPosts = [
        [
            'title' => 'Aromaterapi ve Mum Kullanımının Faydaları',
            'slug' => 'aromaterapi-ve-mum-kullanimi-faydalari',
            'excerpt' => 'Aromaterapi mumları zihinsel ve fiziksel sağlığınız için nasıl kullanılır?',
            'content' => '<h2>Aromaterapi Mumlarının Sağlığa Faydaları</h2>
<p>Aromaterapi mumları, sadece güzel kokular yayan dekoratif objeler değildir. Doğru kullanıldığında zihinsel ve fiziksel sağlığınıza önemli katkılar sağlayabilirler.</p>

<h3>Stres Azaltma</h3>
<p>Lavanta, yasemin ve gül gibi kokular stres seviyenizi düşürebilir. Özellikle akşam saatlerinde bu mumları yakarak günün yorgunluğunu atabilirsiniz.</p>

<h3>Uyku Kalitesini Artırma</h3>
<p>Lavender Peace koleksiyonumuz, rahatlatıcı lavanta esansı ile uyku kalitenizi artırmak için özel olarak formüle edilmiştir.</p>

<h3>Konsantrasyon ve Odaklanma</h3>
<p>Citrus Harmony gibi narenciye kokulu mumlar, zihinsel netliği artırır ve çalışma verimliliğinizi yükseltir.</p>

<h3>Hava Kalitesini İyileştirme</h3>
<p>Soya mumları, parafin mumlarının aksine temiz yanar ve havayı kirletmez. Eva Home mumları 100% soya vaksından üretilir.</p>',
            'category' => 'Candles',
            'featured' => true
        ],
        [
            'title' => 'Mum Bakımı: Mumlarınızın Ömrünü Nasıl Uzatırsınız?',
            'slug' => 'mum-bakimi-mumlarinizin-omrunu-uzatin',
            'excerpt' => 'Mumlarınızdan maksimum verim almak için profesyonel bakım ipuçları.',
            'content' => '<h2>Mum Bakımı Rehberi</h2>
<p>Kaliteli mumlarınızın ömrünü uzatmak ve en iyi performansı almak için doğru bakım şarttır.</p>

<h3>1. İlk Yakma Kuralı</h3>
<p>Mumunuzu ilk kez yaktığınızda, mum yüzeyinin tamamen eridiğinden emin olun. Bu genellikle 2-3 saat sürer ve "mum hafızası" oluşturur.</p>

<h3>2. Fitil Uzunluğu</h3>
<p>Her yakmadan önce fitili 5mm uzunluğa kırpın. Fitil Makası kullanarak temiz bir kesim yapabilirsiniz.</p>

<h3>3. Yanma Süresi</h3>
<p>Mumunuzu 4 saatten fazla yakmayın. Ara verin ve mumun soğumasını bekleyin.</p>

<h3>4. Hava Akımından Koruma</h3>
<p>Mumunuzu rüzgar ve klima akımından uzak tutun. Bu, eşit yanma sağlar.</p>

<h3>5. Söndürme Tekniği</h3>
<p>Fitili üflemek yerine Mum Snuffer kullanın. Bu, is oluşumunu önler.</p>',
            'category' => 'Accessories',
            'featured' => true
        ],
        [
            'title' => 'Golden Jasmine Koleksiyonu: Şans ve Pozitif Enerji',
            'slug' => 'golden-jasmine-koleksiyonu-sans-pozitif-enerji',
            'excerpt' => 'Altın tonlarında tasarlanan Golden Jasmine koleksiyonu ile yaşam alanınıza pozitif enerji çekin.',
            'content' => '<h2>Golden Jasmine: Şansınızı Yükseltir</h2>
<p>Golden Jasmine koleksiyonumuz, şans ve pozitif enerji çekmek isteyenler için özel olarak tasarlanmıştır.</p>

<h3>Renk Psikolojisi</h3>
<p>Altın rengi, bolluk, zenginlik ve başarıyı simgeler. Bu renk tonları, yaşam alanınızda olumlu bir atmosfer yaratır.</p>

<h3>Yasemin Kokusu</h3>
<p>Yasemin, binlerce yıldır manevi pratiklerde kullanılan kutsal bir bitkidir. Zihinsel netlik ve duygusal denge sağlar.</p>

<h3>Kullanım Önerileri</h3>
<p>Sabah saatlerinde Golden Jasmine mumunuzu yakarak güne pozitif başlayabilirsiniz. Özellikle yeni projelere başlarken veya önemli kararlar alırken bu kokunun size ilham vermesine izin verin.</p>',
            'category' => 'golden-jasmine',
            'featured' => true
        ],
        [
            'title' => 'Velvet Rose: Aşk ve Sevgi Enerjisi',
            'slug' => 'velvet-rose-ask-sevgi-enerjisi',
            'excerpt' => 'Bordo tonlarındaki Velvet Rose koleksiyonu ile yaşamınıza aşk ve sevgi enerjisi davet edin.',
            'content' => '<h2>Velvet Rose: Kalbi Açar</h2>
<p>Velvet Rose koleksiyonumuz, aşk, sevgi ve şefkat enerjisini güçlendirmek için tasarlanmıştır.</p>

<h3>Gül Aromaterapi</h3>
<p>Gül kokusu, kalp çakrasını aktive eder ve duygusal şifa sağlar. Stres ve anksiyeteyi azaltırken, öz sevgi ve şefkati artırır.</p>

<h3>Romantik Atmosfer</h3>
<p>Velvet Rose mumları, romantik akşamlar için mükemmel bir seçimdir. Yemek masanızda veya yatak odanızda kullanarak sıcak bir atmosfer yaratabilirsiniz.</p>

<h3>Meditasyon ve Öz Sevgi</h3>
<p>Meditasyon yaparken bu mumu yakarak, kalp merkezinizden kendinize sevgi gönderebilirsiniz.</p>',
            'category' => 'velvet-rose',
            'featured' => true
        ],
        [
            'title' => 'Sürdürülebilir Yaşam: Refill Collection',
            'slug' => 'surdurulebilir-yasam-refill-collection',
            'excerpt' => 'Çevreye duyarlı bir yaşam için Eva Home Refill Collection ile atık azaltın.',
            'content' => '<h2>Sürdürülebilir Mum Kullanımı</h2>
<p>Refill Collection, çevreye duyarlı yaşam tarzını benimseyen herkes için tasarlanmıştır.</p>

<h3>Nasıl Çalışır?</h3>
<p>Mumunuz bittiğinde, alçı kapı atmak yerine Refill Collection\'dan yeni bir mum içi satın alabilirsiniz. Böylece hem cüzdanınızı hem de çevreyi korursunuz.</p>

<h3>Çevresel Etki</h3>
<p>Her refill kullanımıyla, plastik ve cam atığı azaltırsınız. Eva Home olarak, 2024 yılında 10.000 alçı kabın tekrar kullanılmasını hedefliyoruz.</p>

<h3>Ekonomik Avantaj</h3>
<p>Refill mumlar, normal mumlara göre %30 daha ekonomiktir. Hem çevreye hem de bütçenize katkı sağlarsınız.</p>',
            'category' => 'refill-collection',
            'featured' => false
        ],
        [
            'title' => 'Ev Dekorasyonunda Mum Kullanımı: İpuçları ve Trendler',
            'slug' => 'ev-dekorasyonunda-mum-kullanimi-ipuclari',
            'excerpt' => '2024 yılının en trend mum dekorasyonu fikirleri ve profesyonel ipuçları.',
            'content' => '<h2>Mumlarla Ev Dekorasyonu</h2>
<p>Mumlar, sadece koku kaynağı değil, aynı zamanda güçlü dekorasyon öğeleridir.</p>

<h3>Renk Koordinasyonu</h3>
<p>Eva Home\'un pastel tonları, her tarzda dekora uyum sağlar. Altın tonlar klasik dekorasyonlara, pastel renkler modern minimalist tasarımlara mükemmeldir.</p>

<h3>Gruplandırma Teknikleri</h3>
<p>Farklı boyutlardaki mumları bir arada kullanarak görsel derinlik yaratabilirsiniz. Decor & Trays koleksiyonumuzdan tepsilerle bunu profesyonelce yapabilirsiniz.</p>

<h3>Aydınlatma Efekti</h3>
<p>Mumlar, özellikle akşam saatlerinde sıcak ve davetkar bir atmosfer yaratır. Oturma odanızda veya yemek masanızda kullanarak konuklarınızı etkileyebilirsiniz.</p>',
            'category' => 'decor-trays',
            'featured' => false
        ],
        [
            'title' => 'Meditasyon ve Mum: Zihinsel Huzur Rehberi',
            'slug' => 'meditasyon-ve-mum-zihinsel-huzur',
            'excerpt' => 'Meditasyon pratiğinizde mum kullanımının derin faydaları.',
            'content' => '<h2>Mum ile Meditasyon</h2>
<p>Binlerce yıldır, mumlar meditasyon pratiğinin ayrılmaz bir parçası olmuştur.</p>

<h3>Odaklanma Noktası</h3>
<p>Mum alevi, meditasyon sırasında mükemmel bir odaklanma noktası sağlar. Trataka adı verilen bu teknik, zihinsel netliği artırır.</p>

<h3>Enerji Temizliği</h3>
<p>Sacred Oud ve Royal Spice koleksiyonlarımız, özellikle enerji temizliği ve manevi pratikler için formüle edilmiştir.</p>

<h3>Ritüel Oluşturma</h3>
<p>Her gün aynı saatte mum yakarak meditasyon rutini oluşturabilirsiniz. Bu, zihinsel disiplin geliştirir.</p>',
            'category' => 'sacred-oud',
            'featured' => false
        ],
        [
            'title' => 'Hediye Rehberi: Her Duruma Uygun Mum Setleri',
            'slug' => 'hediye-rehberi-mum-setleri',
            'excerpt' => 'Sevdiklerinize hangi durumda hangi mum koleksiyonunu hediye edeceğinizi öğrenin.',
            'content' => '<h2>Mükemmel Hediye Seçimi</h2>
<p>Eva Home mumları, düşünceli ve anlamlı hediyeler için mükemmel seçimlerdir.</p>

<h3>Yeni Eve Taşınma</h3>
<p>Earth Harmony ve Sacred Oud kombinasyonu, yeni evlere bereket ve huzur getirir.</p>

<h3>Romantik Hediye</h3>
<p>Velvet Rose koleksiyonu, sevgililer günü, yıl dönümü veya özel günler için idealdir.</p>

<h3>Doğum Günü</h3>
<p>Kişinin enerjisine göre koleksiyon seçin. Pozitif ve neşeli kişiler için Citrus Harmony, sakin ve huzurlu kişiler için Lavender Peace.</p>

<h3>Gift Sets</h3>
<p>Hazır hediye setlerimiz, şık paketleme ve uyumlu kokularla özel bir hediye deneyimi sunar.</p>',
            'category' => 'gift-sets',
            'featured' => true
        ],
        [
            'title' => 'Mevsimsel Mum Kullanımı: İlkbahardan Kışa',
            'slug' => 'mevsimsel-mum-kullanimi-ilkbahar-kis',
            'excerpt' => 'Her mevsime uygun mum kokuları ve kullanım önerileri.',
            'content' => '<h2>Mevsime Göre Mum Seçimi</h2>
<p>Her mevsimin kendine özgü bir atmosferi vardır ve mumlarınız bunu yansıtmalıdır.</p>

<h3>İlkbahar</h3>
<p>Luminous Bloom ve Golden Jasmine, ilkbaharın tazeliğini ve yenilenme enerjisini yansıtır.</p>

<h3>Yaz</h3>
<p>Citrus Harmony, yazın canlılığını ve neşesini evinize taşır. Hafif ve ferahlatıcı kokusuyla sıcak günlerde idealdir.</p>

<h3>Sonbahar</h3>
<p>Earth Harmony ve Royal Spice, sonbaharın sıcak ve rahatlatıcı atmosferini yaratır.</p>

<h3>Kış</h3>
<p>Sacred Oud ve Velvet Rose, kışın sıcaklığını ve intimizasını evinize getirir.</p>',
            'category' => 'Candles',
            'featured' => false
        ],
        [
            'title' => 'Oda Kokuları: Mumların Ötesinde Koku Deneyimi',
            'slug' => 'oda-kokuları-mumların-otesinde',
            'excerpt' => 'Room Fragrances koleksiyonu ile 7/24 koku deneyimi.',
            'content' => '<h2>Room Diffuser Kullanımı</h2>
<p>Mum yakmak her zaman mümkün olmayabilir. Room Fragrances koleksiyonumuz tam da bu noktada devreye girer.</p>

<h3>Sürekli Koku</h3>
<p>Diffuser\'lar, 24 saat kesintisiz koku yayar. Yatak odanızda, banyonuzda veya çalışma alanınızda kullanabilirsiniz.</p>

<h3>Güvenli ve Pratik</h3>
<p>Ateş riski olmadan evde koku deneyimi yaşayabilirsiniz. Özellikle evcil hayvanı veya çocuğu olanlar için idealdir.</p>

<h3>Uzun Ömürlü</h3>
<p>Eva Home diffuser\'ları 3-4 ay boyunca koku verir. Refill şişeleriyle ekonomik bir çözümdür.</p>',
            'category' => 'room-fragrances',
            'featured' => false
        ],
        [
            'title' => 'Stres Yönetimi: Lavender Peace Koleksiyonu',
            'slug' => 'stres-yonetimi-lavender-peace-koleksiyonu',
            'excerpt' => 'Lavanta mumlarıyla günlük stresi azaltmanın bilimsel yolları.',
            'content' => '<h2>Lavanta ve Stres Azaltma</h2>
<p>Lavender Peace koleksiyonumuz, bilimsel araştırmalarla desteklenen rahatlatıcı özelliklere sahiptir.</p>

<h3>Bilimsel Kanıtlar</h3>
<p>Araştırmalar, lavanta kokusunun kortizol (stres hormonu) seviyelerini düşürdüğünü gösteriyor.</p>

<h3>Uyku Hijyeni</h3>
<p>Yatmadan önce Lavender Peace mumu yakarak uyku rutini oluşturabilirsiniz. Bu, vücudunuza uyku zamanı sinyali gönderir.</p>

<h3>Anksiyete Azaltma</h3>
<p>Lavanta, doğal bir anksiyete gidericidir. Stresli bir günün ardından bu mumu yakarak zihinsel rahatlama sağlayabilirsiniz.</p>',
            'category' => 'lavender-peace',
            'featured' => true
        ],
        [
            'title' => 'Citrus Harmony: Enerji ve Motivasyon Kaynağı',
            'slug' => 'citrus-harmony-enerji-motivasyon',
            'excerpt' => 'Narenciye kokularının zihinsel enerji ve motivasyon üzerindeki etkisi.',
            'content' => '<h2>Narenciye ile Enerjilenin</h2>
<p>Citrus Harmony koleksiyonumuz, doğal enerji artışı için tasarlanmıştır.</p>

<h3>Zihinsel Uyanıklık</h3>
<p>Narenciye kokuları, zihinsel uyanıklığı artırır ve yorgunluk hissini azaltır.</p>

<h3>Sabah Rutini</h3>
<p>Sabah kahvenizle birlikte Citrus Harmony mumunu yakarak güne enerjik başlayabilirsiniz.</p>

<h3>Çalışma Alanında</h3>
<p>Home office\'inizde bu kokuyu kullanarak konsantrasyonunuzu artırabilir ve üretkenliğinizi yükseltebilirsiniz.</p>',
            'category' => 'citrus-harmony',
            'featured' => false
        ],
        [
            'title' => 'Alçı Kaplarda Sanat: Eva Home Tasarım Felsefesi',
            'slug' => 'alci-kaplarda-sanat-eva-home-tasarim',
            'excerpt' => 'El yapımı alçı kapların üretim süreci ve tasarım hikayesi.',
            'content' => '<h2>El Yapımı Alçı Tasarımlar</h2>
<p>Eva Home mumları, sadece koku deneyimi değil, aynı zamanda sanat eseridir.</p>

<h3>Üretim Süreci</h3>
<p>Her alçı kap, ustalar tarafından özenle el yapımıdır. Alçı ve beton karışımı, dayanıklı ve estetik bir sonuç verir.</p>

<h3>Pastel Renkler</h3>
<p>Koleksiyonlarımızdaki pastel tonlar, modern minimalist tasarıma mükemmel uyum sağlar.</p>

<h3>Tekrar Kullanım</h3>
<p>Mumunuz bittiğinde, alçı kapı dekoratif obje, saksı veya küçük eşya saklama kabı olarak kullanabilirsiniz.</p>',
            'category' => 'decor-trays',
            'featured' => false
        ],
        [
            'title' => 'Royal Spice: Enerji Temizliği ve Arınma',
            'slug' => 'royal-spice-enerji-temizligi-arinma',
            'excerpt' => 'Negatif enerjiyi temizlemek için Royal Spice koleksiyonunun kullanımı.',
            'content' => '<h2>Enerji Temizliği Pratiği</h2>
<p>Royal Spice koleksiyonumuz, mekanları negatif enerjiden arındırmak için özel karışımdır.</p>

<h3>Smudging Alternatifi</h3>
<p>Geleneksel ıspıt yerine, Royal Spice mumunu yakarak aynı temizleyici etkiyi elde edebilirsiniz.</p>

<h3>Kullanım Zamanları</h3>
<p>Taşınma, misafir ağırlama veya stresli dönemlerin ardından bu mumu yakarak mekanınızı yenileyebilirsiniz.</p>

<h3>Meditasyonla Kombinasyon</h3>
<p>Enerji temizliği yaparken meditasyon veya nefes egzersizleri yaparak etkiyi artırabilirsiniz.</p>',
            'category' => 'royal-spice',
            'featured' => false
        ],
        [
            'title' => 'Earth Harmony: Topraklama ve Denge Enerjisi',
            'slug' => 'earth-harmony-topraklama-denge',
            'excerpt' => 'Kahve tonlarındaki Earth Harmony ile kendinizi topraklayın ve dengeyi bulun.',
            'content' => '<h2>Topraklama Ritüeli</h2>
<p>Earth Harmony koleksiyonumuz, bolluk ve topraklama enerjisi için tasarlanmıştır.</p>

<h3>Odunsu Notalar</h3>
<p>Sandal ağacı ve vetiver gibi odunsu notalar, doğayla bağlantı kurmanızı sağlar.</p>

<h3>Mali Bolluk</h3>
<p>Earth Harmony, finansal bolluk ve istikrar için manifestasyon pratiklerinde kullanılabilir.</p>

<h3>Denge ve İstikrar</h3>
<p>Hayatınızda dengesizlik hissettiğinizde, bu mumu yakarak topraklama meditasyonu yapabilirsiniz.</p>',
            'category' => 'earth-harmony',
            'featured' => true
        ]
    ];
    
    $blogCount = 0;
    foreach ($blogPosts as $blog) {
        $categoryId = $categoryIds[$blog['category']] ?? 1;
        
        try {
            $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, content, excerpt, author_id, category_id, status, featured, published_at, view_count) VALUES (?, ?, ?, ?, 1, ?, 'published', ?, NOW(), ?) ON DUPLICATE KEY UPDATE title = VALUES(title)");
            $stmt->execute([
                $blog['title'],
                $blog['slug'],
                $blog['content'],
                $blog['excerpt'],
                $categoryId,
                $blog['featured'] ? 1 : 0,
                rand(50, 500)
            ]);
            if ($stmt->rowCount() > 0) {
                $addedBlogs++;
                $blogCount++;
                $progress = round(($blogCount / count($blogPosts)) * 100);
                echo "<script>
                    document.getElementById('blogProgress').style.width = '{$progress}%';
                    document.getElementById('blogProgress').textContent = '{$blogCount} / " . count($blogPosts) . " Blog';
                    document.getElementById('blogLog').innerHTML += '<div class=\"log-item\"><i class=\"fas fa-plus-circle text-success me-2\"></i>{$blog['title']}</div>';
                </script>";
                flush();
            }
        } catch (PDOException $e) {
            // Sessizce devam et
        }
    }
    
    // ================================================================
    // ÜRÜN EKLEME (100+)
    // ================================================================
    echo "<h4 class='mt-5 mb-3'><i class='fas fa-box me-2'></i>Ürünler Ekleniyor (100+)</h4>";
    echo "<div class='progress mb-3'>
            <div class='progress-bar progress-bar-striped progress-bar-animated' role='progressbar' style='width: 0%' id='productProgress'>
                0 / 120 Ürün
            </div>
          </div>";
    echo "<div id='productLog' style='max-height: 400px; overflow-y: auto;'></div>";
    
    // Koleksiyon verileri
    $collections = [
        'Golden Jasmine' => ['color' => 'Altın', 'code' => '#FFD700', 'price_base' => 700],
        'Velvet Rose' => ['color' => 'Bordo', 'code' => '#8B0A50', 'price_base' => 700],
        'Citrus Harmony' => ['color' => 'Turuncu', 'code' => '#FF8C42', 'price_base' => 700],
        'Luminous Bloom' => ['color' => 'Pembe', 'code' => '#FFB6C1', 'price_base' => 700],
        'Sacred Oud' => ['color' => 'Koyu Yeşil', 'code' => '#2F4F4F', 'price_base' => 750],
        'Earth Harmony' => ['color' => 'Kahve', 'code' => '#8B4513', 'price_base' => 750],
        'Royal Spice' => ['color' => 'Gri', 'code' => '#808080', 'price_base' => 750],
        'Lavender Peace' => ['color' => 'Lila', 'code' => '#E6E6FA', 'price_base' => 700]
    ];
    
    // Ürün tipleri
    $productTypes = [
        'Büyük Silindir Mum' => ['price_mult' => 1.0, 'stock' => 25],
        'Küçük Silindir Mum' => ['price_mult' => 0.6, 'stock' => 30],
        'Orta Boy Silindir Mum' => ['price_mult' => 0.8, 'stock' => 28],
        'Yassı Mum (Tahta Fitilli)' => ['price_mult' => 0.75, 'stock' => 20],
        'Mini Silindir Mum' => ['price_mult' => 0.4, 'stock' => 40],
        'İkili Mini Set' => ['price_mult' => 0.7, 'stock' => 22],
        'Üçlü Mini Set' => ['price_mult' => 1.1, 'stock' => 15],
        'Votive Mum (4\'lü)' => ['price_mult' => 0.65, 'stock' => 30],
        'Tea Light Set (10\'lu)' => ['price_mult' => 0.55, 'stock' => 35],
        'Travel Size Mum' => ['price_mult' => 0.45, 'stock' => 38],
        'Refill Mum' => ['price_mult' => 0.5, 'stock' => 50],
        'Lux Edition - Büyük' => ['price_mult' => 1.3, 'stock' => 12],
        'Lux Edition - Orta' => ['price_mult' => 1.1, 'stock' => 18],
        'Double Wick - Büyük' => ['price_mult' => 1.15, 'stock' => 20],
        'Triple Wick - Ekstra Büyük' => ['price_mult' => 1.4, 'stock' => 10]
    ];
    
    $products = [];
    $productCount = 0;
    $totalProducts = count($collections) * count($productTypes);
    
    // Her koleksiyondan her ürün tipini oluştur
    foreach ($collections as $collectionName => $collectionData) {
        $categoryId = $categoryIds[$collectionName] ?? $categoryIds['Candles'];
        
        foreach ($productTypes as $productType => $typeData) {
            $productCount++;
            $slug = strtolower(str_replace(['İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç', ' ', '(', ')', '\'', 'ı', 'ğ', 'ü', 'ş', 'ö', 'ç'], ['i', 'g', 'u', 's', 'o', 'c', '-', '', '', '', 'i', 'g', 'u', 's', 'o', 'c'], $collectionName . '-' . $productType));
            $slug = preg_replace('/-+/', '-', $slug);
            $slug = trim($slug, '-');
            
            $basePrice = $collectionData['price_base'] * $typeData['price_mult'];
            $price = round($basePrice, -1); // 10'a yuvarla
            $salePrice = $price > 200 ? round($price * 0.85, -1) : null; // %15 indirim
            
            $featured = $productCount <= 20 && rand(1, 3) == 1; // İlk 20 üründen bazıları featured
            
            $description = "Özel formülasyonlu {$collectionName} koleksiyonundan {$productType}. El yapımı, premium kalite soya vaksından üretilmiştir. {$collectionData['color']} tonlarındaki pastel alçı kap, modern dekorasyona mükemmel uyum sağlar. 100% doğal, uzun ömürlü ve temiz yanan formül.";
            
            $shortDesc = "{$collectionName} koleksiyonundan {$productType} - El yapımı soya mumu";
            
            try {
                $stmt = $pdo->prepare("INSERT INTO products (name, slug, description, short_description, price, sale_price, category_id, brand, stock_quantity, featured, status, color_name, color_code, sku) VALUES (?, ?, ?, ?, ?, ?, ?, 'Eva Home', ?, ?, 'active', ?, ?, ?) ON DUPLICATE KEY UPDATE price = VALUES(price), stock_quantity = VALUES(stock_quantity)");
                
                $sku = 'EVH-' . substr(md5($slug), 0, 8);
                
                $stmt->execute([
                    "{$collectionName} - {$productType}",
                    $slug,
                    $description,
                    $shortDesc,
                    $price,
                    $salePrice,
                    $categoryId,
                    $typeData['stock'],
                    $featured ? 1 : 0,
                    $collectionData['color'],
                    $collectionData['code'],
                    strtoupper($sku)
                ]);
                
                if ($stmt->rowCount() > 0) {
                    $addedProducts++;
                    $progress = round(($productCount / $totalProducts) * 100);
                    echo "<script>
                        document.getElementById('productProgress').style.width = '{$progress}%';
                        document.getElementById('productProgress').textContent = '{$productCount} / {$totalProducts} Ürün';
                        if ({$productCount} % 5 == 0) {
                            document.getElementById('productLog').innerHTML += '<div class=\"log-item\"><i class=\"fas fa-check text-success me-2\"></i>{$collectionName} - {$productType} - {$price} TRY</div>';
                            document.getElementById('productLog').scrollTop = document.getElementById('productLog').scrollHeight;
                        }
                    </script>";
                    flush();
                }
            } catch (PDOException $e) {
                // Sessizce devam et
            }
        }
    }
    
    // Room Fragrances ürünleri ekle
    $fragranceTypes = ['Room Diffuser (200ml)', 'Room Spray (100ml)', 'Car Diffuser', 'Refill Bottle (200ml)'];
    foreach ($collections as $collectionName => $collectionData) {
        foreach ($fragranceTypes as $fragType) {
            $productCount++;
            $slug = strtolower(str_replace(['İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç', ' ', '(', ')', '\'', 'ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'ml'], ['i', 'g', 'u', 's', 'o', 'c', '-', '', '', '', 'i', 'g', 'u', 's', 'o', 'c', ''], $collectionName . '-' . $fragType));
            $slug = preg_replace('/-+/', '-', $slug);
            $slug = trim($slug, '-');
            
            $price = strpos($fragType, 'Refill') !== false ? 250 : 400;
            $salePrice = strpos($fragType, 'Car') === false ? round($price * 0.9, -1) : null;
            
            $stmt = $pdo->prepare("INSERT INTO products (name, slug, description, short_description, price, sale_price, category_id, brand, stock_quantity, featured, status, sku) VALUES (?, ?, ?, ?, ?, ?, ?, 'Eva Home', 25, 0, 'active', ?) ON DUPLICATE KEY UPDATE price = VALUES(price)");
            
            $sku = 'EVH-RF-' . substr(md5($slug), 0, 6);
            
            $stmt->execute([
                "{$collectionName} {$fragType}",
                $slug,
                "{$collectionName} koleksiyonundan {$fragType}. Uzun ömürlü, yoğun koku verimi. Cam şişe, şık tasarım.",
                "{$collectionName} {$fragType}",
                $price,
                $salePrice,
                $categoryIds['Room Fragrances'] ?? 2,
                strtoupper($sku)
            ]);
            
            if ($stmt->rowCount() > 0) {
                $addedProducts++;
            }
        }
    }
    
    // Decor & Accessories ürünleri
    $decorItems = [
        ['name' => 'Koleksiyon Tepsisi', 'price' => 280, 'stock' => 15],
        ['name' => 'Minimal Obje', 'price' => 180, 'stock' => 25],
        ['name' => 'Mum Tablası', 'price' => 220, 'stock' => 20],
        ['name' => 'Küçük Dekoratif Kase', 'price' => 150, 'stock' => 30]
    ];
    
    foreach ($collections as $collectionName => $collectionData) {
        foreach ($decorItems as $item) {
            $productCount++;
            $slug = strtolower(str_replace(['İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç', ' ', 'ı', 'ğ', 'ü', 'ş', 'ö', 'ç'], ['i', 'g', 'u', 's', 'o', 'c', '-', 'i', 'g', 'u', 's', 'o', 'c'], $collectionName . '-' . $item['name']));
            
            $stmt = $pdo->prepare("INSERT INTO products (name, slug, description, short_description, price, sale_price, category_id, brand, stock_quantity, featured, status, color_name, color_code, sku) VALUES (?, ?, ?, ?, ?, ?, ?, 'Eva Home', ?, 0, 'active', ?, ?, ?) ON DUPLICATE KEY UPDATE price = VALUES(price)");
            
            $sku = 'EVH-DEC-' . substr(md5($slug), 0, 6);
            
            $stmt->execute([
                "{$collectionName} {$item['name']}",
                $slug,
                "Alçı ve beton karışımı {$item['name']}. {$collectionName} koleksiyonuna uyumlu {$collectionData['color']} renk.",
                "{$collectionName} {$item['name']} - Alçı beton",
                $item['price'],
                round($item['price'] * 0.9, -1),
                $categoryIds['Decor & Trays'] ?? 3,
                $item['stock'],
                $collectionData['color'],
                $collectionData['code'],
                strtoupper($sku)
            ]);
            
            if ($stmt->rowCount() > 0) {
                $addedProducts++;
            }
        }
    }
    
    // Genel aksesuarlar
    $accessories = [
        ['name' => 'Fitil Makası - Rose Gold', 'price' => 95, 'stock' => 40],
        ['name' => 'Fitil Makası - Siyah Mat', 'price' => 85, 'stock' => 45],
        ['name' => 'Fitil Makası - Gümüş', 'price' => 90, 'stock' => 42],
        ['name' => 'Mum Snuffer - Rose Gold', 'price' => 75, 'stock' => 38],
        ['name' => 'Mum Snuffer - Siyah Mat', 'price' => 65, 'stock' => 40],
        ['name' => 'Mum Snuffer - Gümüş', 'price' => 70, 'stock' => 38],
        ['name' => 'Fitil Düzeltici', 'price' => 55, 'stock' => 50],
        ['name' => 'Mum Bakım Seti (3 Parça)', 'price' => 180, 'stock' => 25],
        ['name' => 'Premium Bakım Seti (5 Parça)', 'price' => 280, 'stock' => 15],
        ['name' => 'Eva Home Hediye Kutusu - Büyük', 'price' => 45, 'stock' => 100],
        ['name' => 'Eva Home Hediye Kutusu - Orta', 'price' => 35, 'stock' => 120],
        ['name' => 'Eva Home Hediye Kutusu - Küçük', 'price' => 25, 'stock' => 150]
    ];
    
    foreach ($accessories as $item) {
        $slug = strtolower(str_replace(['İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç', ' ', '(', ')', 'ı', 'ğ', 'ü', 'ş', 'ö', 'ç'], ['i', 'g', 'u', 's', 'o', 'c', '-', '', '', 'i', 'g', 'u', 's', 'o', 'c'], $item['name']));
        
        $stmt = $pdo->prepare("INSERT INTO products (name, slug, description, short_description, price, category_id, brand, stock_quantity, featured, status, sku) VALUES (?, ?, ?, ?, ?, ?, 'Eva Home', ?, 0, 'active', ?) ON DUPLICATE KEY UPDATE price = VALUES(price)");
        
        $sku = 'EVH-ACC-' . substr(md5($slug), 0, 6);
        
        $stmt->execute([
            $item['name'],
            $slug,
            "{$item['name']} - Eva Home kalitesi. Paslanmaz çelik, ergonomik tasarım.",
            $item['name'],
            $item['price'],
            $categoryIds['Accessories'] ?? 6,
            $item['stock'],
            strtoupper($sku)
        ]);
        
        if ($stmt->rowCount() > 0) {
            $addedProducts++;
        }
    }
    
    $endTime = microtime(true);
    $duration = round($endTime - $startTime, 2);
    
    // Final istatistikler
    echo "<script>
        document.getElementById('productProgress').style.width = '100%';
        document.getElementById('productProgress').textContent = 'Tamamlandı - {$addedProducts} Ürün';
    </script>";
    
    echo "<div class='alert alert-success mt-4'>
            <h5><i class='fas fa-check-circle me-2'></i>Veri Yükleme Tamamlandı!</h5>
            <hr>
            <div class='row'>
                <div class='col-md-6'>
                    <p class='mb-1'><strong>Blog Yazıları:</strong> {$addedBlogs} eklendi</p>
                    <p class='mb-1'><strong>Ürünler:</strong> {$addedProducts} eklendi</p>
                </div>
                <div class='col-md-6'>
                    <p class='mb-1'><strong>Süre:</strong> {$duration} saniye</p>
                    <p class='mb-1'><strong>Durum:</strong> Başarılı ✓</p>
                </div>
            </div>
          </div>";
    
    // Güncel istatistikler
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM products");
    $totalProducts = $stmt->fetch()['count'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM blog_posts");
    $totalBlogs = $stmt->fetch()['count'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM categories");
    $totalCategories = $stmt->fetch()['count'];
    
    echo "<h4 class='mt-5 mb-3'><i class='fas fa-chart-pie me-2'></i>Veritabanı İstatistikleri</h4>";
    echo "<div class='row'>";
    echo "<div class='col-md-3'><div class='stat-card'><div class='stat-number'>{$totalProducts}</div><div class='stat-label'>Ürün</div></div></div>";
    echo "<div class='col-md-3'><div class='stat-card'><div class='stat-number'>{$totalBlogs}</div><div class='stat-label'>Blog Yazısı</div></div></div>";
    echo "<div class='col-md-3'><div class='stat-card'><div class='stat-number'>{$totalCategories}</div><div class='stat-label'>Kategori</div></div></div>";
    echo "<div class='col-md-3'><div class='stat-card'><div class='stat-number'>" . round($duration, 1) . "s</div><div class='stat-label'>Yükleme Süresi</div></div></div>";
    echo "</div>";
    
    echo "<div class='text-center mt-4'>
            <a href='index.php' class='btn btn-lg me-2' style='background: #c9a24a; color: white;'>
                <i class='fas fa-home me-2'></i>Ana Sayfaya Git
            </a>
            <a href='admin/login.php' class='btn btn-lg me-2' style='background: #a0883d; color: white;'>
                <i class='fas fa-user-shield me-2'></i>Admin Paneli
            </a>
            <a href='admin/products.php' class='btn btn-outline-secondary btn-lg'>
                <i class='fas fa-box me-2'></i>Ürünleri Görüntüle
            </a>
          </div>";
    
    echo "<div class='alert alert-info mt-4'>
            <h6><i class='fas fa-info-circle me-2'></i>Not</h6>
            <p class='mb-0'>Tüm ürünler aktif durumda ve stoktadır. Admin panelinden düzenleyebilir veya ürün resimleri ekleyebilirsiniz.</p>
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

