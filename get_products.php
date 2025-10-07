<?php
require_once 'config/database.php';

// Parametreleri al
$category_id = $_GET['category_id'] ?? null;
$featured = $_GET['featured'] ?? null;

try {
    // SQL sorgusu oluştur
    $sql = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.status = 'active'";
    $params = [];
    
    if ($category_id) {
        $sql .= " AND p.category_id = ?";
        $params[] = $category_id;
    }
    
    if ($featured) {
        $sql .= " AND p.featured = 1";
    }
    
    $sql .= " ORDER BY p.featured DESC, p.created_at DESC LIMIT 12";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll();
    
    if (!empty($products)) {
        foreach ($products as $product) {
            ?>
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
                        <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                            <span class="badge badge--danger">%<?php echo round((($product['price'] - $product['sale_price']) / $product['price']) * 100); ?> İndirim</span>
                        <?php endif; ?>
                        <?php if (!empty($product['color_name'])): ?>
                            <span class="badge badge--color" style="background-color: <?php echo escape($product['color_code'] ?? '#ccc'); ?>; color: white;">
                                <span class="color-dot" style="background-color: <?php echo escape($product['color_code'] ?? '#ccc'); ?>;"></span>
                                <?php echo escape($product['color_name']); ?>
                            </span>
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
            <?php
        }
    } else {
        ?>
        <div class="col-12">
            <div class="alert alert--info text-center">
                <i class="fas fa-info-circle"></i>
                Bu kategoride henüz ürün bulunmuyor.
            </div>
        </div>
        <?php
    }
    
} catch (PDOException $e) {
    ?>
    <div class="col-12">
        <div class="alert alert--danger text-center">
            <i class="fas fa-exclamation-triangle"></i>
            Ürünler yüklenirken hata oluştu.
        </div>
    </div>
    <?php
}
?>
