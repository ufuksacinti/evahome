<?php 
require_once 'config/database.php';

// Blog ID'sini al
$blog_id = $_GET['id'] ?? null;

if (!$blog_id) {
    header('Location: blog.php');
    exit();
}

// Blog yazısını getir
try {
    $stmt = $pdo->prepare("
        SELECT b.*, c.name as category_name, u.first_name, u.last_name
        FROM blog_posts b 
        LEFT JOIN categories c ON b.category_id = c.id 
        LEFT JOIN users u ON b.author_id = u.id
        WHERE b.id = ? AND b.status = 'published'
    ");
    $stmt->execute([$blog_id]);
    $blog = $stmt->fetch();
    
    if (!$blog) {
        header('Location: blog.php');
        exit();
    }
    
    // Görüntülenme sayısını artır
    $updateStmt = $pdo->prepare("UPDATE blog_posts SET view_count = view_count + 1 WHERE id = ?");
    $updateStmt->execute([$blog_id]);
    
    // İlgili blog yazılarını getir
    $relatedStmt = $pdo->prepare("
        SELECT b.*, c.name as category_name
        FROM blog_posts b 
        LEFT JOIN categories c ON b.category_id = c.id 
        WHERE b.category_id = ? AND b.id != ? AND b.status = 'published' 
        ORDER BY b.published_at DESC 
        LIMIT 3
    ");
    $relatedStmt->execute([$blog['category_id'], $blog_id]);
    $relatedBlogs = $relatedStmt->fetchAll();
    
} catch (PDOException $e) {
    header('Location: blog.php');
    exit();
}

$page_title = $blog['title'] . ' - Eva Home Blog';
include 'header.php'; 
?>

<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="background: #f8f9fa; padding: 12px 20px; border-radius: 8px;">
            <li class="breadcrumb-item"><a href="index.php" style="color: #c9a24a; text-decoration: none;"><i class="fas fa-home"></i> Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="blog.php" style="color: #c9a24a; text-decoration: none;">Blog</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars(substr($blog['title'], 0, 50)); ?>...</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Blog Header -->
            <article>
                <?php if ($blog['category_name']): ?>
                    <span class="badge mb-3" style="background: rgba(201, 162, 74, 0.15); color: #c9a24a; border-radius: 20px; padding: 8px 16px; font-size: 14px;">
                        <?php echo htmlspecialchars($blog['category_name']); ?>
                    </span>
                <?php endif; ?>
                
                <h1 class="mb-4" style="color: #334155; font-family: 'Georgia', serif; font-size: 2.5rem; line-height: 1.3; font-weight: 700;">
                    <?php echo htmlspecialchars($blog['title']); ?>
                </h1>
                
                <div class="d-flex align-items-center mb-4" style="flex-wrap: wrap; gap: 20px; padding: 15px 0; border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
                    <?php if ($blog['first_name']): ?>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-user-circle" style="color: #c9a24a; font-size: 1.2rem;"></i>
                            <span style="color: #64748b; font-weight: 500;">
                                <?php echo htmlspecialchars($blog['first_name'] . ' ' . $blog['last_name']); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="far fa-calendar" style="color: #c9a24a;"></i>
                        <span style="color: #64748b;">
                            <?php echo date('d F Y', strtotime($blog['published_at'])); ?>
                        </span>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-eye" style="color: #c9a24a;"></i>
                        <span style="color: #64748b;">
                            <?php echo number_format($blog['view_count'] + 1); ?> görüntülenme
                        </span>
                    </div>
                </div>
                
                <!-- Featured Image -->
                <?php if ($blog['image_url']): ?>
                    <div class="mb-4" style="border-radius: 12px; overflow: hidden;">
                        <img src="<?php echo htmlspecialchars($blog['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($blog['title']); ?>"
                             style="width: 100%; height: auto; display: block;">
                    </div>
                <?php endif; ?>
                
                <!-- Excerpt -->
                <?php if ($blog['excerpt']): ?>
                    <div class="alert" style="background: rgba(201, 162, 74, 0.1); border-left: 4px solid #c9a24a; color: #334155; padding: 20px; margin-bottom: 30px; border-radius: 8px;">
                        <p class="mb-0" style="font-size: 1.1rem; line-height: 1.7; font-style: italic;">
                            <?php echo htmlspecialchars($blog['excerpt']); ?>
                        </p>
                    </div>
                <?php endif; ?>
                
                <!-- Blog Content -->
                <div class="blog-content" style="font-size: 1.1rem; line-height: 1.8; color: #334155;">
                    <?php echo $blog['content']; ?>
                </div>
                
                <!-- Tags -->
                <?php if ($blog['tags']): ?>
                    <div class="mt-5 pt-4" style="border-top: 1px solid #e5e5e5;">
                        <h6 class="mb-3" style="color: #64748b; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">
                            <i class="fas fa-tags"></i> Etiketler
                        </h6>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            <?php 
                            $tags = explode(',', $blog['tags']);
                            foreach ($tags as $tag): 
                            ?>
                                <span class="badge" style="background: #f1f5f9; color: #64748b; padding: 8px 14px; border-radius: 20px; font-weight: 500; font-size: 0.875rem;">
                                    #<?php echo htmlspecialchars(trim($tag)); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Share Buttons -->
                <div class="mt-4 pt-4" style="border-top: 1px solid #e5e5e5;">
                    <h6 class="mb-3" style="color: #64748b; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">
                        <i class="fas fa-share-alt"></i> Paylaş
                    </h6>
                    <div style="display: flex; gap: 10px;">
                        <a href="#" class="btn btn-sm" style="background: #1877f2; color: white; padding: 8px 16px; border-radius: 8px;">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="#" class="btn btn-sm" style="background: #1da1f2; color: white; padding: 8px 16px; border-radius: 8px;">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <a href="#" class="btn btn-sm" style="background: #0077b5; color: white; padding: 8px 16px; border-radius: 8px;">
                            <i class="fab fa-linkedin-in"></i> LinkedIn
                        </a>
                    </div>
                </div>
            </article>
            
            <!-- İlgili Blog Yazıları -->
            <?php if (!empty($relatedBlogs)): ?>
                <div class="mt-5 pt-5" style="border-top: 2px solid #e5e5e5;">
                    <h3 class="mb-4" style="color: #c9a24a; font-family: 'Georgia', serif;">
                        <i class="fas fa-newspaper"></i> İlgili Yazılar
                    </h3>
                    <div class="row">
                        <?php foreach ($relatedBlogs as $related): ?>
                            <div class="col-md-4 mb-3">
                                <div class="card h-100" style="border: 1px solid #e5e5e5; border-radius: 12px; overflow: hidden;">
                                    <div style="aspect-ratio: 16/10; background: #f8f9fa;">
                                        <?php if ($related['image_url']): ?>
                                            <img src="<?php echo htmlspecialchars($related['image_url']); ?>" 
                                                 style="width: 100%; height: 100%; object-fit: cover;"
                                                 alt="<?php echo htmlspecialchars($related['title']); ?>">
                                        <?php else: ?>
                                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-blog fa-3x" style="color: #c9a24a; opacity: 0.3;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <h6 style="font-size: 0.95rem; font-weight: 600; line-height: 1.4;">
                                            <a href="blog_detay.php?id=<?php echo $related['id']; ?>" 
                                               style="color: #334155; text-decoration: none;">
                                                <?php echo htmlspecialchars($related['title']); ?>
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            <?php echo date('d M Y', strtotime($related['published_at'])); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Geri Dön Butonu -->
            <div class="text-center mt-5">
                <a href="blog.php" class="btn btn-primary-custom btn-lg">
                    <i class="fas fa-arrow-left me-2"></i> Tüm Blog Yazıları
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .blog-content h2 {
        color: #c9a24a;
        font-family: 'Georgia', serif;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-size: 1.8rem;
    }
    
    .blog-content h3 {
        color: #334155;
        font-family: 'Georgia', serif;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        font-size: 1.4rem;
    }
    
    .blog-content p {
        margin-bottom: 1.5rem;
    }
    
    .blog-content ul, .blog-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }
    
    .blog-content li {
        margin-bottom: 0.5rem;
    }
    
    .blog-content a {
        color: #c9a24a;
        text-decoration: underline;
    }
    
    .blog-content a:hover {
        color: #a0883d;
    }
    
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }
</style>

<?php include 'footer.php'; ?>

