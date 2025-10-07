<?php 
require_once 'config/database.php';
$page_title = 'Ürünler - Eva Home';

// Ürünleri çek
try {
    $stmt = $pdo->query("
        SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE p.status = 'active' 
        ORDER BY p.featured DESC, p.created_at DESC
    ");
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $products = [];
}

include 'header.php'; 
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="display-4 fw-bold text-center mb-3" style="color: #c9a24a; font-family: 'Georgia', serif;">🕯️ Eva Home Ürünleri</h1>
            <p class="lead text-center text-muted mb-5">El yapımı soya mumları ve aromaterapi ürünlerimizi keşfedin</p>
        </div>
    </div>

    <?php if (empty($products)): ?>
        <div class="alert alert-info text-center">
            <h4>Henüz ürün eklenmemiş</h4>
            <p>Veritabanına ürün eklemek için <a href="load_massive_data.php">buraya tıklayın</a></p>
        </div>
    <?php else: ?>
        <!-- Products Grid -->
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card card-hover h-100" style="border: 1px solid #e5e5e5; border-radius: 12px; overflow: hidden;">
                        <div style="position: relative; aspect-ratio: 1; background: #f8f9fa; overflow: hidden;">
                            <?php if ($product['image_url']): ?>
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #fef7ee 0%, #f1f5f9 100%);">
                                    <i class="fas fa-candle-holder fa-4x" style="color: #c9a24a; opacity: 0.3;"></i>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($product['featured']): ?>
                                <span class="badge" style="position: absolute; top: 10px; left: 10px; background: #c9a24a; color: white; padding: 6px 12px; border-radius: 20px;">
                                    <i class="fas fa-star"></i> Öne Çıkan
                                </span>
                            <?php endif; ?>
                            
                            <?php if ($product['sale_price']): ?>
                                <span class="badge bg-danger" style="position: absolute; top: 10px; right: 10px; padding: 6px 12px; border-radius: 20px;">
                                    İndirim
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-body" style="padding: 1.25rem;">
                            <?php if ($product['category_name']): ?>
                                <span class="badge mb-2" style="background: rgba(201, 162, 74, 0.15); color: #c9a24a; border-radius: 20px; padding: 4px 10px; font-size: 11px;">
                                    <?php echo htmlspecialchars($product['category_name']); ?>
                                </span>
                            <?php endif; ?>
                            
                            <h5 class="card-title" style="font-size: 1rem; font-weight: 600; margin-bottom: 0.75rem; color: #334155;">
                                <?php echo htmlspecialchars($product['name']); ?>
                            </h5>
                            
                            <?php if ($product['short_description']): ?>
                                <p class="card-text text-muted" style="font-size: 0.875rem; line-height: 1.5; margin-bottom: 1rem;">
                                    <?php echo htmlspecialchars(substr($product['short_description'], 0, 80)) . '...'; ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ($product['color_name'] && $product['color_code']): ?>
                                <div style="margin-bottom: 0.75rem; display: flex; align-items: center; gap: 8px;">
                                    <span style="display: inline-block; width: 20px; height: 20px; border-radius: 50%; background: <?php echo htmlspecialchars($product['color_code']); ?>; border: 2px solid #e5e5e5;"></span>
                                    <small class="text-muted"><?php echo htmlspecialchars($product['color_name']); ?></small>
                                </div>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div>
                                    <?php if ($product['sale_price']): ?>
                                        <h4 class="mb-0" style="color: #c9a24a; font-weight: 700; font-size: 1.25rem;">
                                            ₺<?php echo number_format($product['sale_price'], 0, ',', '.'); ?>
                                        </h4>
                                        <small class="text-muted" style="text-decoration: line-through;">
                                            ₺<?php echo number_format($product['price'], 0, ',', '.'); ?>
                                        </small>
                                    <?php else: ?>
                                        <h4 class="mb-0" style="color: #c9a24a; font-weight: 700; font-size: 1.25rem;">
                                            ₺<?php echo number_format($product['price'], 0, ',', '.'); ?>
                                        </h4>
                                    <?php endif; ?>
                                </div>
                                <a href="product.php?id=<?php echo $product['id']; ?>" 
                                   class="btn btn-primary-custom btn-sm" 
                                   style="padding: 8px 16px; font-size: 0.875rem; white-space: nowrap;">
                                    <i class="fas fa-eye"></i> Detay
                                </a>
                            </div>
                            
                            <?php if ($product['stock_quantity'] <= 5 && $product['stock_quantity'] > 0): ?>
                                <div class="mt-2">
                                    <small class="text-warning">
                                        <i class="fas fa-exclamation-triangle"></i> 
                                        Son <?php echo $product['stock_quantity']; ?> adet!
                                    </small>
                                </div>
                            <?php elseif ($product['stock_quantity'] <= 0): ?>
                                <div class="mt-2">
                                    <small class="text-danger">
                                        <i class="fas fa-times-circle"></i> Stokta yok
                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <p class="text-muted">
                <i class="fas fa-box"></i> 
                Toplam <strong><?php echo count($products); ?></strong> ürün gösteriliyor
            </p>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
