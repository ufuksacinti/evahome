<?php
require_once 'config/database.php';

$page_title = "Eva Home - Ana Sayfa";

// Veritabanı durumunu kontrol et
$dbStatus = checkDatabaseStatus();

// Eğer veritabanı kurulu değilse kurulum sayfasına yönlendir
if (!$dbStatus['connected'] || $dbStatus['tables_count'] == 0) {
    header('Location: setup.php');
    exit();
}

    // Son ürünleri getir (daha fazla ürün göster)
    try {
        $stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.stock_quantity > 0 AND p.status = 'active' ORDER BY p.featured DESC, p.created_at DESC LIMIT 12");
        $products = $stmt->fetchAll();
    } catch (PDOException $e) {
        $products = [];
    }

// Son blog yazılarını getir
try {
    $stmt = $pdo->query("SELECT bp.*, c.name as category_name FROM blog_posts bp LEFT JOIN categories c ON bp.category_id = c.id WHERE bp.status = 'published' ORDER BY bp.featured DESC, bp.published_at DESC LIMIT 4");
    $blogPosts = $stmt->fetchAll();
} catch (PDOException $e) {
    $blogPosts = [];
}

// Kategorileri getir
try {
    $stmt = $pdo->query("SELECT c.*, COUNT(p.id) as product_count FROM categories c LEFT JOIN products p ON c.id = p.category_id WHERE c.status = 'active' AND c.parent_id IS NULL GROUP BY c.id ORDER BY c.sort_order ASC LIMIT 6");
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    $categories = [];
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <header class="header">
        <nav class="nav container" style="display: flex; align-items: center; justify-content: center; position: relative; max-width: 1200px; margin: 0 auto; padding: 0 15px; height: 64px; background: #fefdfb; border-bottom: 1px solid #e5e5e5;">
            <!-- Logo - Sol Sabit -->
            <a href="index.php" class="eva-logo" style="position: absolute; left: 15px; font-family: 'Georgia', serif; font-weight: 700; color: #c9a24a; font-size: 1.5rem; text-decoration: none; letter-spacing: 0.5px;">
                <i class="fas fa-candle-holder" style="margin-right: 8px;"></i>EVA HOME
            </a>
            
            <!-- Menü - Ortada (Desktop) -->
            <ul class="nav__menu" style="display: flex; list-style: none; margin: 0; padding: 0; gap: 1rem; align-items: center;">
                <li><a href="index.php" class="nav__link" style="color: #334155; font-weight: 500; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap; display: inline-block;">
                    <i class="fas fa-home" style="margin-right: 5px;"></i>Ana Sayfa
                </a></li>
                <li><a href="urunler.php" class="nav__link" style="color: #334155; font-weight: 500; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap; display: inline-block;">
                    <i class="fas fa-box" style="margin-right: 5px;"></i>Ürünler
                </a></li>
                <li><a href="toplu-siparis.php" class="nav__link" style="color: #334155; font-weight: 500; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap; display: inline-block;">
                    <i class="fas fa-industry" style="margin-right: 5px;"></i>Toplu Sipariş
                    <span class="badge bg-danger" style="font-size: 0.65rem; margin-left: 4px;">YENİ</span>
                </a></li>
                <li><a href="blog.php" class="nav__link" style="color: #334155; font-weight: 500; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap; display: inline-block;">
                    <i class="fas fa-blog" style="margin-right: 5px;"></i>Blog
                </a></li>
                <li><a href="hakkimizda.php" class="nav__link" style="color: #334155; font-weight: 500; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap; display: inline-block;">
                    <i class="fas fa-info-circle" style="margin-right: 5px;"></i>Hakkımızda
                </a></li>
                <li><a href="iletisim.php" class="nav__link" style="color: #334155; font-weight: 500; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap; display: inline-block;">
                    <i class="fas fa-envelope" style="margin-right: 5px;"></i>İletişim
                </a></li>
            </ul>
            
            <!-- Admin & Lang - Sağ Sabit -->
            <div style="position: absolute; right: 15px; display: flex; align-items: center; gap: 1rem;">
                <div class="lang" style="display: flex; gap: 8px; align-items: center; padding: 6px 12px; border: 1px solid #e5e5e5; border-radius: 20px; background: white; font-size: 13px;">
                    <a href="#" style="color: #c9a24a; font-weight: 700; text-decoration: none;">TR</a> 
                    <span style="color: #cbd5e1;">|</span> 
                    <a href="#" style="color: #64748b; text-decoration: none; transition: color 0.3s;">EN</a>
                </div>
                <a href="admin/login.php" class="btn btn--eva-gold" style="background: #c9a24a; color: white; padding: 8px 18px; border-radius: 20px; text-decoration: none; font-weight: 500; transition: all 0.3s; display: inline-block;">Admin</a>
            </div>
        </nav>
    </header>
    
    <style>
        /* Header Hover Effects */
        .nav__link:hover {
            color: #c9a24a !important;
            background-color: rgba(201, 162, 74, 0.1) !important;
        }
        
        .btn--eva-gold:hover {
            background: #a0883d !important;
        }
        
        .lang a:hover {
            color: #c9a24a !important;
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .nav__menu {
                display: none !important;
            }
            
            div[style*="position: absolute; right: 15px"] {
                display: none !important;
            }
        }
    </style>

    <!-- Hero Section -->
    <section id="home" class="eva-hero section--large">
        <div class="container">
            <div class="hero__content animate-fade-in-up">
                <h1 class="hero__title">Eva Home</h1>
                <p class="hero__subtitle">Ev dekorasyonunda kalite ve şıklığın buluştuğu yer. Minimal, mistik, modern.</p>
                <div class="hero__actions">
                    <a href="#products" class="btn btn--eva-gold btn--large">
                        <i class="fas fa-shopping-bag"></i>Ürünleri Keşfet
                    </a>
                    <a href="#categories" class="btn btn--eva-outline btn--large">
                        <i class="fas fa-th-large"></i>Kategoriler
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="section">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Kategorilerimiz</h2>
                <p class="text-muted">İhtiyacınıza uygun ürün kategorileri</p>
            </div>
            <div class="grid">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <div class="col-4 col-6">
                            <div class="eva-category-card animate-fade-in-up" onclick="filterProductsByCategory(<?php echo $category['id']; ?>, '<?php echo escape($category['name']); ?>')" style="cursor: pointer;">
                                <div class="eva-category-icon">
                                    <?php
                                    $icons = [
                                        'Mobilya' => 'fas fa-couch',
                                        'Aydınlatma' => 'fas fa-lightbulb',
                                        'Tekstil' => 'fas fa-tshirt',
                                        'Mutfak' => 'fas fa-utensils',
                                        'Banyo' => 'fas fa-bath',
                                        'Bahçe' => 'fas fa-seedling',
                                        'Elektronik' => 'fas fa-laptop',
                                        'Candles' => 'fas fa-fire',
                                        'Room Fragrances' => 'fas fa-spray-can',
                                        'Decor & Trays' => 'fas fa-palette',
                                        'Gift Sets' => 'fas fa-gift',
                                        'Refill Collection' => 'fas fa-recycle',
                                        'Accessories' => 'fas fa-tools'
                                    ];
                                    $icon = $icons[$category['name']] ?? 'fas fa-box';
                                    ?>
                                    <i class="<?php echo $icon; ?>"></i>
                                </div>
                                <h4 class="text-bold"><?php echo escape($category['name']); ?></h4>
                                <p class="text-muted text-sm"><?php echo $category['product_count']; ?> ürün</p>
                                <button class="btn btn--eva-outline btn--small" onclick="event.stopPropagation(); filterProductsByCategory(<?php echo $category['id']; ?>, '<?php echo escape($category['name']); ?>')">Keşfet</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert--info text-center">
                            <i class="fas fa-info-circle"></i>
                            Henüz kategori eklenmemiş.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section" style="background: var(--eva-ivory);">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Neden Eva Home?</h2>
                <p class="text-muted">Ev dekorasyonunda profesyonel çözümler</p>
            </div>
            <div class="grid">
                <div class="col-4">
                    <div class="text-center animate-fade-in-up">
                        <div class="eva-category-icon mx-auto mb-3">
                            <i class="fas fa-star"></i>
                        </div>
                        <h4>Kaliteli Ürünler</h4>
                        <p class="text-muted">En kaliteli malzemelerden üretilen, dayanıklı ve şık ev dekorasyon ürünleri</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="text-center animate-fade-in-up">
                        <div class="eva-category-icon mx-auto mb-3">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h4>Hızlı Teslimat</h4>
                        <p class="text-muted">Siparişlerinizi en kısa sürede, güvenli paketleme ile kapınıza kadar getiriyoruz</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="text-center animate-fade-in-up">
                        <div class="eva-category-icon mx-auto mb-3">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4>7/24 Destek</h4>
                        <p class="text-muted">Müşteri memnuniyeti odaklı hizmet anlayışımızla her zaman yanınızdayız</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 id="products-title">Öne Çıkan Ürünler</h2>
                <p class="text-muted" id="products-subtitle">En popüler ev dekorasyon ürünlerimiz</p>
                <div class="mb-4">
                    <button class="btn btn--eva-gold" onclick="showAllProducts()">Tüm Ürünler</button>
                    <button class="btn btn--eva-outline" onclick="showFeaturedProducts()">Öne Çıkanlar</button>
                </div>
            </div>
            <div class="products" id="products-container">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <article class="eva-product-card animate-fade-in-up" onclick="window.location.href='product.php?id=<?php echo $product['id']; ?>'" style="cursor: pointer;">
                            <div class="eva-product-image">
                                <?php if ($product['image_url']): ?>
                                    <img src="<?php echo escape($product['image_url']); ?>" alt="<?php echo escape($product['name']); ?>">
                                <?php else: ?>
                                    <div class="d-flex items-center justify-center h-full">
                                        <i class="fas fa-image text-muted" style="font-size: 48px;"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="eva-product-badges">
                                    <span class="badge badge--spice"><?php echo escape($product['category_name'] ?? 'Kategori'); ?></span>
                                    <?php if ($product['featured']): ?>
                                        <span class="badge badge--gold">Öne Çıkan</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="eva-product-content">
                                <h3 class="eva-product-title"><?php echo escape($product['name']); ?></h3>
                                <p class="eva-product-description"><?php echo escape(substr($product['short_description'] ?? $product['description'], 0, 100)) . '...'; ?></p>
                                <div class="eva-product-price">
                                    <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                                        <span class="eva-product-price-current">₺<?php echo number_format($product['sale_price'], 2); ?></span>
                                        <span class="eva-product-price-original">₺<?php echo number_format($product['price'], 2); ?></span>
                                    <?php else: ?>
                                        <span class="eva-product-price-current">₺<?php echo number_format($product['price'], 2); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="eva-product-stock">Stokta: <?php echo $product['stock_quantity']; ?> adet</div>
                                <div class="eva-product-actions" onclick="event.stopPropagation()">
                                    <a href="#" class="btn btn--eva-gold btn--small" onclick="event.preventDefault(); addToCart(<?php echo $product['id']; ?>)">Sepete Ekle</a>
                                    <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn--eva-outline btn--small">Detay</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert--info text-center">
                            <i class="fas fa-info-circle"></i>
                            Henüz ürün eklenmemiş. Admin panelinden ürün ekleyebilirsiniz.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section id="blog" class="section" style="background: var(--eva-ivory);">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Son Blog Yazıları</h2>
                <p class="text-muted">Ev dekorasyonu hakkında ipuçları ve trendler</p>
            </div>
            <div class="products">
                <?php if (!empty($blogPosts)): ?>
                    <?php foreach ($blogPosts as $post): ?>
                        <article class="eva-blog-card animate-fade-in-up">
                            <div class="eva-blog-image">
                                <?php if ($post['image_url']): ?>
                                    <img src="<?php echo escape($post['image_url']); ?>" alt="<?php echo escape($post['title']); ?>">
                                <?php else: ?>
                                    <div class="d-flex items-center justify-center h-full">
                                        <i class="fas fa-newspaper text-muted" style="font-size: 48px;"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="eva-blog-content">
                                <div class="eva-blog-meta">
                                    <span class="badge badge--info"><?php echo escape($post['category_name'] ?? 'Blog'); ?></span>
                                    <?php if ($post['featured']): ?>
                                        <span class="badge badge--gold">Öne Çıkan</span>
                                    <?php endif; ?>
                                </div>
                                <h3 class="eva-blog-title"><?php echo escape($post['title']); ?></h3>
                                <p class="eva-blog-excerpt"><?php echo escape(substr(strip_tags($post['excerpt'] ?? $post['content']), 0, 120)) . '...'; ?></p>
                                <div class="eva-blog-footer">
                                    <div class="eva-blog-date">
                                        <i class="fas fa-calendar"></i>
                                        <?php echo date('d.m.Y', strtotime($post['published_at'] ?? $post['created_at'])); ?>
                                    </div>
                                    <a href="#" class="btn btn--eva-outline btn--small">Devamını Oku</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert--info text-center">
                            <i class="fas fa-info-circle"></i>
                            Henüz blog yazısı eklenmemiş. Admin panelinden blog yazısı ekleyebilirsiniz.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Toplu Sipariş Section -->
    <section id="wholesale" class="section" style="background: linear-gradient(135deg, #fef7ee 0%, #f1f5f9 100%);">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="color: #c9a24a; font-family: 'Georgia', serif;">
                    <i class="fas fa-industry me-2"></i>Kurumsal & Toplu Sipariş
                </h2>
                <p class="text-muted" style="max-width: 700px; margin: 0 auto;">
                    Oteller, SPA merkezleri, kurumsal firmalar ve butik mağazalar için özel üretim ve toplu sipariş hizmeti sunuyoruz
                </p>
            </div>
            
            <div class="row mb-5">
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="text-center">
                        <div class="mb-3" style="width: 80px; height: 80px; background: rgba(201, 162, 74, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="fas fa-hotel fa-2x" style="color: #c9a24a;"></i>
                        </div>
                        <h6 style="font-weight: 600;">Butik Oteller</h6>
                        <p class="text-muted small">Otel odaları için özel mum ve koku setleri</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="text-center">
                        <div class="mb-3" style="width: 80px; height: 80px; background: rgba(201, 162, 74, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="fas fa-spa fa-2x" style="color: #c9a24a;"></i>
                        </div>
                        <h6 style="font-weight: 600;">SPA & Wellness</h6>
                        <p class="text-muted small">Aromaterapi ve relaxation ürünleri</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="text-center">
                        <div class="mb-3" style="width: 80px; height: 80px; background: rgba(201, 162, 74, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="fas fa-building fa-2x" style="color: #c9a24a;"></i>
                        </div>
                        <h6 style="font-weight: 600;">Kurumsal Hediye</h6>
                        <p class="text-muted small">Özel etiketli kurumsal hediye çözümleri</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="text-center">
                        <div class="mb-3" style="width: 80px; height: 80px; background: rgba(201, 162, 74, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="fas fa-store fa-2x" style="color: #c9a24a;"></i>
                        </div>
                        <h6 style="font-weight: 600;">Butik Mağazalar</h6>
                        <p class="text-muted small">Perakende satış için toplu alım</p>
                    </div>
                </div>
            </div>
            
            <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-radius: 15px; overflow: hidden;">
                <div class="card-body" style="padding: 3rem;">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 style="color: #c9a24a; font-weight: 600; margin-bottom: 1rem;">
                                Özel Üretim & Etiketleme Hizmeti
                            </h4>
                            <p class="text-muted mb-3">
                                ✅ Minimum 50 adet toplu sipariş<br>
                                ✅ Kendi markanızla özel etiket seçeneği<br>
                                ✅ 8 renk koleksiyon refil setleri<br>
                                ✅ Özel fiyatlandırma ve indirimler
                            </p>
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="badge" style="background: rgba(201, 162, 74, 0.15); color: #c9a24a; padding: 8px 14px;">
                                    <i class="fas fa-tag me-1"></i>Markasız Etiket
                                </span>
                                <span class="badge" style="background: rgba(201, 162, 74, 0.15); color: #c9a24a; padding: 8px 14px;">
                                    <i class="fas fa-certificate me-1"></i>Kendi Markanız
                                </span>
                                <span class="badge" style="background: rgba(201, 162, 74, 0.15); color: #c9a24a; padding: 8px 14px;">
                                    <i class="fas fa-image me-1"></i>Logo Baskı
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="toplu-siparis.php" class="btn btn-lg" style="background: #c9a24a; color: white; padding: 1.25rem 2.5rem; border-radius: 30px; font-weight: 600; box-shadow: 0 5px 15px rgba(201, 162, 74, 0.3);">
                                <i class="fas fa-file-invoice me-2"></i>
                                Talep Oluştur
                            </a>
                            <p class="text-muted small mt-3 mb-0">Size özel teklif hazırlayalım</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section">
        <div class="container">
            <div class="text-center mb-5">
                <h2>İletişim</h2>
                <p class="text-muted">Sorularınız için bizimle iletişime geçin</p>
            </div>
            <div class="container--narrow mx-auto">
                <form action="contact.php" method="POST" class="grid">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Ad Soyad</label>
                            <input type="text" class="form-input" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="email" class="form-label">E-posta</label>
                            <input type="email" class="form-input" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="phone" class="form-label">Telefon Numarası</label>
                            <input type="tel" class="form-input" id="phone" name="phone" placeholder="+90 5XX XXX XX XX">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="subject" class="form-label">Konu</label>
                            <input type="text" class="form-input" id="subject" name="subject" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="message" class="form-label">Mesaj</label>
                            <textarea class="form-textarea" id="message" name="message" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn--eva-gold btn--large">
                            <i class="fas fa-paper-plane"></i>Mesaj Gönder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer__content">
                <div>
                    <h4>Eva Home</h4>
                    <p>Ev dekorasyonunda kalite ve şıklığın buluştuğu yer. Müşteri memnuniyeti odaklı hizmet anlayışımızla evinizi güzelleştiriyoruz.</p>
                </div>
                <div>
                    <h4>Hızlı Linkler</h4>
                    <ul class="footer__links">
                        <li><a href="#home">Ana Sayfa</a></li>
                        <li><a href="#categories">Kategoriler</a></li>
                        <li><a href="#products">Ürünler</a></li>
                        <li><a href="#blog">Blog</a></li>
                        <li><a href="#contact">İletişim</a></li>
                    </ul>
                </div>
                <div>
                    <h4>İletişim Bilgileri</h4>
                    <ul class="footer__links">
                        <li><i class="fas fa-phone"></i> +90 (212) 555 0123</li>
                        <li><i class="fas fa-envelope"></i> info@evahome.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> İstanbul, Türkiye</li>
                    </ul>
                </div>
                <div>
                    <h4>Sosyal Medya</h4>
                    <div class="flex gap-2">
                        <a href="#" class="btn btn--eva-outline btn--small">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn--eva-outline btn--small">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="btn btn--eva-outline btn--small">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer__bottom">
                <div>&copy; 2024 Eva Home. Tüm hakları saklıdır.</div>
                <div class="text-muted">Raise Your Space's Frequency</div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.classList.add('header--scrolled');
            } else {
                header.classList.remove('header--scrolled');
            }
        });

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.querySelectorAll('.animate-fade-in-up').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
        
        // Sepete ekleme fonksiyonu
        function addToCart(productId) {
            alert('Ürün sepete eklendi! (ID: ' + productId + ')');
        }
        
        // Mobile menu toggle
        function toggleMobileMenu() {
            const toggle = document.querySelector('.nav__toggle');
            const menu = document.querySelector('.nav__mobile-menu');
            
            toggle.classList.toggle('active');
            menu.classList.toggle('active');
        }
        
        // Close mobile menu
        function closeMobileMenu() {
            const toggle = document.querySelector('.nav__toggle');
            const menu = document.querySelector('.nav__mobile-menu');
            
            toggle.classList.remove('active');
            menu.classList.remove('active');
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const nav = document.querySelector('.nav');
            const toggle = document.querySelector('.nav__toggle');
            const menu = document.querySelector('.nav__mobile-menu');
            
            if (!nav.contains(event.target) && menu.classList.contains('active')) {
                closeMobileMenu();
            }
        });
        
        // Product filtering functions
        function filterProductsByCategory(categoryId, categoryName) {
            // Update title and subtitle
            document.getElementById('products-title').textContent = categoryName + ' Ürünleri';
            document.getElementById('products-subtitle').textContent = categoryName + ' kategorisindeki ürünler';
            
            // Scroll to products section
            document.getElementById('products').scrollIntoView({ behavior: 'smooth' });
            
            // Show loading
            const container = document.getElementById('products-container');
            container.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Ürünler yükleniyor...</div>';
            
            // Fetch products via AJAX
            fetch(`get_products.php?category_id=${categoryId}`)
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                    // Re-observe animated elements
                    document.querySelectorAll('.animate-fade-in-up').forEach(el => {
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(30px)';
                        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                        observer.observe(el);
                    });
                })
                .catch(error => {
                    container.innerHTML = '<div class="alert alert-danger">Ürünler yüklenirken hata oluştu.</div>';
                });
        }
        
        function showAllProducts() {
            document.getElementById('products-title').textContent = 'Tüm Ürünler';
            document.getElementById('products-subtitle').textContent = 'Tüm ev dekorasyon ürünlerimiz';
            
            const container = document.getElementById('products-container');
            container.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Ürünler yükleniyor...</div>';
            
            fetch('get_products.php')
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                    document.querySelectorAll('.animate-fade-in-up').forEach(el => {
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(30px)';
                        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                        observer.observe(el);
                    });
                })
                .catch(error => {
                    container.innerHTML = '<div class="alert alert-danger">Ürünler yüklenirken hata oluştu.</div>';
                });
        }
        
        function showFeaturedProducts() {
            document.getElementById('products-title').textContent = 'Öne Çıkan Ürünler';
            document.getElementById('products-subtitle').textContent = 'En popüler ev dekorasyon ürünlerimiz';
            
            const container = document.getElementById('products-container');
            container.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Ürünler yükleniyor...</div>';
            
            fetch('get_products.php?featured=1')
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                    document.querySelectorAll('.animate-fade-in-up').forEach(el => {
                        el.style.opacity = '0';
                        el.style.transform = 'translateY(30px)';
                        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                        observer.observe(el);
                    });
                })
                .catch(error => {
                    container.innerHTML = '<div class="alert alert-danger">Ürünler yüklenirken hata oluştu.</div>';
                });
        }
    </script>
</body>
</html>