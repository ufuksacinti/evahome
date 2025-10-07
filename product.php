<?php
require_once 'config/database.php';

// Ürün ID'sini al
$product_id = $_GET['id'] ?? null;

if (!$product_id) {
    header('Location: index.php');
    exit();
}

// Ürün bilgilerini getir
try {
    $stmt = $pdo->prepare("
        SELECT p.*, c.name as category_name, c.slug as category_slug 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.id = ? AND p.status = 'active'
    ");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    
    if (!$product) {
        header('Location: index.php');
        exit();
    }
    
    // İlgili ürünleri getir (aynı kategoriden)
    $stmt = $pdo->prepare("
        SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.category_id = ? AND p.id != ? AND p.status = 'active' 
        ORDER BY p.featured DESC, p.created_at DESC 
        LIMIT 4
    ");
    $stmt->execute([$product['category_id'], $product_id]);
    $relatedProducts = $stmt->fetchAll();
    
} catch (PDOException $e) {
    header('Location: index.php');
    exit();
}

$page_title = $product['name'] . ' - Eva Home';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <style>
        .product-detail {
            padding: var(--s5) 0;
        }
        
        .product-gallery {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--s3);
            margin-bottom: var(--s5);
        }
        
        .product-main-image {
            aspect-ratio: 1;
            background: var(--gray-100);
            border-radius: var(--radius);
            overflow: hidden;
            position: relative;
        }
        
        .product-main-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-thumbnails {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: var(--s2);
        }
        
        .product-thumbnail {
            aspect-ratio: 1;
            background: var(--gray-100);
            border-radius: var(--radius-sm);
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color var(--t-fast) var(--easing);
        }
        
        .product-thumbnail:hover,
        .product-thumbnail.active {
            border-color: var(--eva-gold);
        }
        
        .product-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-info {
            padding-left: var(--s4);
        }
        
        .product-breadcrumb {
            margin-bottom: var(--s3);
            font-size: var(--fs-300);
            color: var(--muted);
        }
        
        .product-breadcrumb a {
            color: var(--eva-gold);
            text-decoration: none;
        }
        
        .product-breadcrumb a:hover {
            text-decoration: underline;
        }
        
        .product-title {
            font-family: var(--ff-serif);
            font-size: var(--fs-700);
            font-weight: 600;
            margin-bottom: var(--s2);
            color: var(--eva-ink);
        }
        
        .product-collection {
            font-size: var(--fs-400);
            color: var(--eva-gold);
            font-weight: 500;
            margin-bottom: var(--s3);
        }
        
        .product-price {
            margin-bottom: var(--s4);
        }
        
        .product-price-current {
            font-size: var(--fs-700);
            font-weight: 700;
            color: var(--eva-gold);
        }
        
        .product-price-original {
            font-size: var(--fs-500);
            color: var(--muted);
            text-decoration: line-through;
            margin-left: var(--s2);
        }
        
        .product-description {
            font-size: var(--fs-400);
            line-height: 1.6;
            color: var(--eva-ink);
            margin-bottom: var(--s4);
        }
        
        .product-features {
            margin-bottom: var(--s4);
        }
        
        .product-features h4 {
            font-family: var(--ff-serif);
            font-size: var(--fs-500);
            margin-bottom: var(--s2);
            color: var(--eva-ink);
        }
        
        .product-features ul {
            list-style: none;
            padding: 0;
        }
        
        .product-features li {
            padding: var(--s1) 0;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: var(--s2);
        }
        
        .product-features li:last-child {
            border-bottom: none;
        }
        
        .product-features i {
            color: var(--eva-gold);
            width: 16px;
        }
        
        .product-actions {
            display: flex;
            gap: var(--s2);
            margin-bottom: var(--s4);
        }
        
        .product-quantity {
            display: flex;
            align-items: center;
            gap: var(--s2);
            margin-bottom: var(--s3);
        }
        
        .quantity-input {
            width: 80px;
            padding: var(--s1) var(--s2);
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-sm);
            text-align: center;
        }
        
        .product-meta {
            padding: var(--s3);
            background: var(--eva-ivory);
            border-radius: var(--radius);
            margin-bottom: var(--s4);
        }
        
        .product-meta-item {
            display: flex;
            justify-content: space-between;
            padding: var(--s1) 0;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .product-meta-item:last-child {
            border-bottom: none;
        }
        
        .product-meta-label {
            font-weight: 500;
            color: var(--eva-ink);
        }
        
        .product-meta-value {
            color: var(--muted);
        }
        
        .related-products {
            padding: var(--s5) 0;
            background: var(--eva-ivory);
        }
        
        .related-products h3 {
            font-family: var(--ff-serif);
            font-size: var(--fs-600);
            text-align: center;
            margin-bottom: var(--s4);
            color: var(--eva-ink);
        }
        
        @media (max-width: 768px) {
            .product-gallery {
                grid-template-columns: 1fr;
            }
            
            .product-info {
                padding-left: 0;
                margin-top: var(--s4);
            }
            
            .product-thumbnails {
                grid-template-columns: repeat(6, 1fr);
            }
            
            .product-actions {
                flex-direction: column;
            }
            
            /* Mobilde menüyü gizle */
            .nav__menu {
                display: none !important;
            }
        }
        
        /* Header Navigation Hover Effects */
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
    </style>
</head>
<body>
    <!-- Navigation -->
    <header class="header">
        <nav class="nav container" style="display: flex; align-items: center; justify-content: center; position: relative; max-width: 1200px; margin: 0 auto; padding: 0 15px;">
            <a href="index.php" class="eva-logo" style="position: absolute; left: 15px; font-family: 'Georgia', serif; font-weight: 700; color: #c9a24a; font-size: 1.5rem; text-decoration: none;">
                <i class="fas fa-candle-holder" style="margin-right: 8px;"></i>EVA HOME
            </a>
            <ul class="nav__menu" style="display: flex; list-style: none; margin: 0; padding: 0; gap: 1rem; align-items: center;">
                <li><a href="index.php" class="nav__link" style="color: #334155; font-weight: 500; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap;">
                    <i class="fas fa-home" style="margin-right: 5px;"></i>Ana Sayfa
                </a></li>
                <li><a href="urunler.php" class="nav__link" style="color: #334155; font-weight: 500; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap;">
                    <i class="fas fa-box" style="margin-right: 5px;"></i>Ürünler
                </a></li>
                <li><a href="toplu-siparis.php" class="nav__link" style="color: #334155; font-weight: 500; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap;">
                    <i class="fas fa-industry" style="margin-right: 5px;"></i>Toplu Sipariş
                    <span class="badge bg-danger" style="font-size: 0.65rem; margin-left: 4px;">YENİ</span>
                </a></li>
                <li><a href="blog.php" class="nav__link" style="color: #334155; font-weight: 500; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap;">
                    <i class="fas fa-blog" style="margin-right: 5px;"></i>Blog
                </a></li>
                <li><a href="hakkimizda.php" class="nav__link" style="color: #334155; font-weight: 500; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap;">
                    <i class="fas fa-info-circle" style="margin-right: 5px;"></i>Hakkımızda
                </a></li>
                <li><a href="iletisim.php" class="nav__link" style="color: #334155; font-weight: 500; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap;">
                    <i class="fas fa-envelope" style="margin-right: 5px;"></i>İletişim
                </a></li>
            </ul>
            <div style="position: absolute; right: 15px; display: flex; align-items: center; gap: 1rem;">
                <div class="lang" style="display: flex; gap: 8px; align-items: center; padding: 6px 12px; border: 1px solid #e5e5e5; border-radius: 20px; background: white; font-size: 13px;">
                    <a href="#" class="active" style="color: #c9a24a; font-weight: 700; text-decoration: none;">TR</a> 
                    <span style="color: #cbd5e1;">|</span> 
                    <a href="#" style="color: #64748b; text-decoration: none;">EN</a>
                </div>
                <a href="admin/login.php" class="btn btn--eva-gold" style="background: #c9a24a; color: white; padding: 8px 18px; border-radius: 20px; text-decoration: none; font-weight: 500; transition: all 0.3s;">Admin</a>
            </div>
        </nav>
    </header>

    <!-- Product Detail -->
    <section class="product-detail">
        <div class="container">
            <!-- Breadcrumb -->
            <div class="product-breadcrumb">
                <a href="index.php">Ana Sayfa</a> / 
                <a href="index.php#categories">Kategoriler</a> / 
                <a href="#"><?php echo escape($product['category_name'] ?? 'Kategori'); ?></a> / 
                <span><?php echo escape($product['name']); ?></span>
            </div>
            
            <div class="product-gallery">
                <!-- Product Images -->
                <div>
                    <div class="product-main-image">
                        <?php if ($product['image_url']): ?>
                            <img src="<?php echo escape($product['image_url']); ?>" alt="<?php echo escape($product['name']); ?>" id="mainImage">
                        <?php else: ?>
                            <div class="d-flex items-center justify-center h-full">
                                <i class="fas fa-image text-muted" style="font-size: 64px;"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-thumbnails">
                        <?php for ($i = 0; $i < 4; $i++): ?>
                            <div class="product-thumbnail <?php echo $i === 0 ? 'active' : ''; ?>" onclick="changeMainImage(this)">
                                <?php if ($product['image_url']): ?>
                                    <img src="<?php echo escape($product['image_url']); ?>" alt="<?php echo escape($product['name']); ?>">
                                <?php else: ?>
                                    <div class="d-flex items-center justify-center h-full">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="product-info">
                    <div class="product-collection">
                        <i class="fas fa-star"></i> <?php echo escape($product['category_name'] ?? 'Koleksiyon'); ?>
                    </div>
                    
                    <h1 class="product-title"><?php echo escape($product['name']); ?></h1>
                    
                    <div class="product-price">
                        <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                            <span class="product-price-current">₺<?php echo number_format($product['sale_price'], 2); ?></span>
                            <span class="product-price-original">₺<?php echo number_format($product['price'], 2); ?></span>
                        <?php else: ?>
                            <span class="product-price-current">₺<?php echo number_format($product['price'], 2); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-description">
                        <?php echo nl2br(escape($product['description'])); ?>
                    </div>
                    
                    <div class="product-features">
                        <h4>Özellikler</h4>
                        <ul>
                            <li>
                                <i class="fas fa-check"></i>
                                <span>El yapımı soya mumu</span>
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                <span>Pastel renkli alçı kap</span>
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                <span>Doğal fitil</span>
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                <span>Yaklaşık 40 saat yanma süresi</span>
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                <span>Sürdürülebilir ambalaj</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="product-quantity">
                        <label for="quantity">Adet:</label>
                        <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>">
                    </div>
                    
                    <div class="product-actions">
                        <button class="btn btn--eva-gold btn--large" onclick="addToCart()">
                            <i class="fas fa-shopping-cart"></i>Sepete Ekle
                        </button>
                        <button class="btn btn--eva-outline btn--large" onclick="addToWishlist()">
                            <i class="fas fa-heart"></i>Favorilere Ekle
                        </button>
                    </div>
                    
                    <div class="product-meta">
                        <div class="product-meta-item">
                            <span class="product-meta-label">Marka:</span>
                            <span class="product-meta-value"><?php echo escape($product['brand'] ?? 'Eva Home'); ?></span>
                        </div>
                        <div class="product-meta-item">
                            <span class="product-meta-label">Stok Durumu:</span>
                            <span class="product-meta-value">
                                <?php if ($product['stock_quantity'] > 0): ?>
                                    <span style="color: var(--eva-admin-success);">Stokta (<?php echo $product['stock_quantity']; ?> adet)</span>
                                <?php else: ?>
                                    <span style="color: var(--eva-admin-danger);">Stokta Yok</span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="product-meta-item">
                            <span class="product-meta-label">SKU:</span>
                            <span class="product-meta-value"><?php echo escape($product['slug']); ?></span>
                        </div>
                        <div class="product-meta-item">
                            <span class="product-meta-label">Kategori:</span>
                            <span class="product-meta-value"><?php echo escape($product['category_name'] ?? 'Kategori'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
    <section class="related-products">
        <div class="container">
            <h3>İlgili Ürünler</h3>
            <div class="products">
                <?php foreach ($relatedProducts as $relatedProduct): ?>
                    <article class="eva-product-card animate-fade-in-up">
                        <div class="eva-product-image">
                            <?php if ($relatedProduct['image_url']): ?>
                                <img src="<?php echo escape($relatedProduct['image_url']); ?>" alt="<?php echo escape($relatedProduct['name']); ?>">
                            <?php else: ?>
                                <div class="d-flex items-center justify-center h-full">
                                    <i class="fas fa-image text-muted" style="font-size: 48px;"></i>
                                </div>
                            <?php endif; ?>
                            <div class="eva-product-badges">
                                <span class="badge badge--spice"><?php echo escape($relatedProduct['category_name'] ?? 'Kategori'); ?></span>
                                <?php if ($relatedProduct['featured']): ?>
                                    <span class="badge badge--gold">Öne Çıkan</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="eva-product-content">
                            <h3 class="eva-product-title"><?php echo escape($relatedProduct['name']); ?></h3>
                            <p class="eva-product-description"><?php echo escape(substr($relatedProduct['short_description'] ?? $relatedProduct['description'], 0, 100)) . '...'; ?></p>
                            <div class="eva-product-price">
                                <?php if ($relatedProduct['sale_price'] && $relatedProduct['sale_price'] < $relatedProduct['price']): ?>
                                    <span class="eva-product-price-current">₺<?php echo number_format($relatedProduct['sale_price'], 2); ?></span>
                                    <span class="eva-product-price-original">₺<?php echo number_format($relatedProduct['price'], 2); ?></span>
                                <?php else: ?>
                                    <span class="eva-product-price-current">₺<?php echo number_format($relatedProduct['price'], 2); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="eva-product-stock">Stokta: <?php echo $relatedProduct['stock_quantity']; ?> adet</div>
                            <div class="eva-product-actions">
                                <a href="product.php?id=<?php echo $relatedProduct['id']; ?>" class="btn btn--eva-gold btn--small">Detay</a>
                                <a href="#" class="btn btn--eva-outline btn--small">Sepete Ekle</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

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
                        <li><a href="index.php#home">Ana Sayfa</a></li>
                        <li><a href="index.php#categories">Kategoriler</a></li>
                        <li><a href="index.php#products">Ürünler</a></li>
                        <li><a href="index.php#blog">Blog</a></li>
                        <li><a href="index.php#contact">İletişim</a></li>
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
        // Ana görsel değiştirme
        function changeMainImage(thumbnail) {
            const mainImage = document.getElementById('mainImage');
            const thumbnailImg = thumbnail.querySelector('img');
            
            if (mainImage && thumbnailImg) {
                mainImage.src = thumbnailImg.src;
                
                // Aktif thumbnail'i güncelle
                document.querySelectorAll('.product-thumbnail').forEach(t => t.classList.remove('active'));
                thumbnail.classList.add('active');
            }
        }
        
        // Sepete ekleme
        function addToCart() {
            const quantity = document.getElementById('quantity').value;
            alert(`Sepete eklendi: <?php echo escape($product['name']); ?> (${quantity} adet)`);
        }
        
        // Favorilere ekleme
        function addToWishlist() {
            alert('Favorilere eklendi: <?php echo escape($product['name']); ?>');
        }
        
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
    </script>
</body>
</html>
