<?php 
require_once 'config/database.php';
$page_title = 'Blog - Eva Home';

// Blog yazılarını çek
try {
    $stmt = $pdo->query("
        SELECT b.*, c.name as category_name, u.first_name, u.last_name
        FROM blog_posts b 
        LEFT JOIN categories c ON b.category_id = c.id 
        LEFT JOIN users u ON b.author_id = u.id
        WHERE b.status = 'published' 
        ORDER BY b.featured DESC, b.published_at DESC
    ");
    $blogs = $stmt->fetchAll();
} catch (PDOException $e) {
    $blogs = [];
}

include 'header.php'; 
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="display-4 fw-bold text-center mb-3" style="color: #c9a24a; font-family: 'Georgia', serif;">📝 Eva Home Blog</h1>
            <p class="lead text-center text-muted mb-5">Mum bakımı, aromaterapi ve ev dekorasyonu hakkında faydalı bilgiler</p>
        </div>
    </div>

    <?php if (empty($blogs)): ?>
        <div class="alert alert-info text-center">
            <h4>Henüz blog yazısı eklenmemiş</h4>
            <p>Veritabanına blog yazısı eklemek için <a href="load_massive_data.php">buraya tıklayın</a></p>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($blogs as $blog): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card card-hover h-100" style="border: 1px solid #e5e5e5; border-radius: 12px; overflow: hidden;">
                        <div style="position: relative; aspect-ratio: 16/10; background: #f8f9fa; overflow: hidden;">
                            <?php if ($blog['image_url']): ?>
                                <img src="<?php echo htmlspecialchars($blog['image_url']); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo htmlspecialchars($blog['title']); ?>"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #fef7ee 0%, #f1f5f9 100%);">
                                    <i class="fas fa-blog fa-4x" style="color: #c9a24a; opacity: 0.3;"></i>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($blog['featured']): ?>
                                <span class="badge" style="position: absolute; top: 10px; left: 10px; background: #c9a24a; color: white; padding: 6px 12px; border-radius: 20px;">
                                    <i class="fas fa-star"></i> Öne Çıkan
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-body" style="padding: 1.5rem;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <?php if ($blog['category_name']): ?>
                                    <span class="badge" style="background: rgba(201, 162, 74, 0.15); color: #c9a24a; border-radius: 20px; padding: 6px 12px; font-size: 12px;">
                                        <?php echo htmlspecialchars($blog['category_name']); ?>
                                    </span>
                                <?php endif; ?>
                                <small class="text-muted">
                                    <i class="far fa-calendar"></i>
                                    <?php echo date('d M Y', strtotime($blog['published_at'])); ?>
                                </small>
                            </div>
                            
                            <h5 class="card-title" style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.75rem; color: #334155; line-height: 1.4;">
                                <?php echo htmlspecialchars($blog['title']); ?>
                            </h5>
                            
                            <?php if ($blog['excerpt']): ?>
                                <p class="card-text text-muted" style="font-size: 0.9rem; line-height: 1.6; margin-bottom: 1rem;">
                                    <?php echo htmlspecialchars(substr($blog['excerpt'], 0, 120)) . '...'; ?>
                                </p>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div>
                                    <?php if ($blog['first_name']): ?>
                                        <small class="text-muted">
                                            <i class="fas fa-user"></i>
                                            <?php echo htmlspecialchars($blog['first_name'] . ' ' . $blog['last_name']); ?>
                                        </small>
                                    <?php endif; ?>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-eye"></i>
                                        <?php echo number_format($blog['view_count'] ?? 0); ?> görüntülenme
                                    </small>
                                </div>
                                <a href="blog_detay.php?id=<?php echo $blog['id']; ?>" 
                                   class="btn btn-outline-primary btn-sm" 
                                   style="padding: 8px 16px; font-size: 0.875rem; border-color: #c9a24a; color: #c9a24a; border-radius: 20px;">
                                    Devamını Oku <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <p class="text-muted">
                <i class="fas fa-newspaper"></i> 
                Toplam <strong><?php echo count($blogs); ?></strong> blog yazısı gösteriliyor
            </p>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
