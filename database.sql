-- =====================================================
-- EVA HOME VERİTABANI - EKSİKSİZ TABLO YAPISI
-- =====================================================
-- Bu dosyayı phpMyAdmin'de çalıştırarak tüm tabloları oluşturun
-- Veya install.php dosyasını tarayıcıda açın

-- Veritabanını oluştur
CREATE DATABASE IF NOT EXISTS evahome_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE evahome_db;

-- =====================================================
-- 1. KULLANICILAR TABLOSU
-- =====================================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    phone VARCHAR(20),
    role ENUM('admin', 'editor', 'user') DEFAULT 'user',
    status ENUM('active', 'inactive', 'banned') DEFAULT 'active',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_status (status)
);

-- =====================================================
-- 2. KATEGORİLER TABLOSU
-- =====================================================
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    image_url VARCHAR(255),
    parent_id INT NULL,
    sort_order INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_parent_id (parent_id),
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_sort_order (sort_order)
);

-- =====================================================
-- 3. ÜRÜNLER TABLOSU
-- =====================================================
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    short_description VARCHAR(500),
    price DECIMAL(10, 2) NOT NULL,
    sale_price DECIMAL(10, 2) NULL,
    sku VARCHAR(100) UNIQUE,
    category_id INT,
    brand VARCHAR(100),
    weight DECIMAL(8, 2),
    dimensions VARCHAR(100),
    color VARCHAR(50),
    material VARCHAR(100),
    image_url VARCHAR(255),
    color_name VARCHAR(50) COMMENT 'Ürün rengi (örn: Altın, Bordo, Pembe)',
    color_code VARCHAR(7) COMMENT 'Hex renk kodu (örn: #FFD700)',
    gallery_images TEXT,
    stock_quantity INT DEFAULT 0,
    min_stock_level INT DEFAULT 5,
    status ENUM('active', 'inactive', 'draft') DEFAULT 'active',
    featured BOOLEAN DEFAULT FALSE,
    meta_title VARCHAR(255),
    meta_description TEXT,
    meta_keywords TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_category_id (category_id),
    INDEX idx_slug (slug),
    INDEX idx_sku (sku),
    INDEX idx_status (status),
    INDEX idx_featured (featured),
    INDEX idx_price (price),
    INDEX idx_stock (stock_quantity)
);

-- =====================================================
-- 4. SİPARİŞLER TABLOSU
-- =====================================================
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(50) NOT NULL UNIQUE,
    user_id INT NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20),
    billing_address TEXT NOT NULL,
    shipping_address TEXT NOT NULL,
    shipping_method VARCHAR(100),
    payment_method VARCHAR(100),
    subtotal DECIMAL(10, 2) NOT NULL,
    shipping_cost DECIMAL(10, 2) DEFAULT 0,
    tax_amount DECIMAL(10, 2) DEFAULT 0,
    discount_amount DECIMAL(10, 2) DEFAULT 0,
    total_amount DECIMAL(10, 2) NOT NULL,
    order_status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded') DEFAULT 'pending',
    payment_status ENUM('pending', 'paid', 'failed', 'refunded', 'partially_refunded') DEFAULT 'pending',
    shipping_status ENUM('pending', 'shipped', 'delivered', 'returned') DEFAULT 'pending',
    notes TEXT,
    tracking_number VARCHAR(100),
    shipped_at TIMESTAMP NULL,
    delivered_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_order_number (order_number),
    INDEX idx_customer_email (customer_email),
    INDEX idx_order_status (order_status),
    INDEX idx_payment_status (payment_status),
    INDEX idx_created_at (created_at)
);

-- =====================================================
-- 5. SİPARİŞ ÖĞELERİ TABLOSU
-- =====================================================
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    product_sku VARCHAR(100),
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_order_id (order_id),
    INDEX idx_product_id (product_id)
);

-- =====================================================
-- 6. BLOG YAZILARI TABLOSU
-- =====================================================
CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT NOT NULL,
    excerpt TEXT,
    image_url VARCHAR(255),
    author_id INT NOT NULL,
    category_id INT,
    tags TEXT,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    featured BOOLEAN DEFAULT FALSE,
    view_count INT DEFAULT 0,
    meta_title VARCHAR(255),
    meta_description TEXT,
    meta_keywords TEXT,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_author_id (author_id),
    INDEX idx_category_id (category_id),
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_featured (featured),
    INDEX idx_published_at (published_at)
);

-- =====================================================
-- 7. İLETİŞİM MESAJLARI TABLOSU
-- =====================================================
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) COMMENT 'Telefon numarası',
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied', 'closed') DEFAULT 'new',
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    assigned_to INT NULL,
    reply TEXT,
    replied_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_priority (priority),
    INDEX idx_assigned_to (assigned_to),
    INDEX idx_created_at (created_at)
);

-- =====================================================
-- 8. İŞ BAŞVURULARI TABLOSU
-- =====================================================
CREATE TABLE IF NOT EXISTS job_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    position VARCHAR(255) NOT NULL,
    department VARCHAR(100),
    experience_level ENUM('entry', 'mid', 'senior', 'executive') DEFAULT 'entry',
    cv_url VARCHAR(255),
    cover_letter TEXT,
    portfolio_url VARCHAR(255),
    expected_salary DECIMAL(10, 2),
    availability_date DATE,
    status ENUM('new', 'reviewed', 'interviewed', 'accepted', 'rejected', 'withdrawn') DEFAULT 'new',
    notes TEXT,
    assigned_to INT NULL,
    interview_date TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_position (position),
    INDEX idx_assigned_to (assigned_to),
    INDEX idx_created_at (created_at)
);

-- =====================================================
-- 9. KUPONLAR TABLOSU
-- =====================================================
CREATE TABLE IF NOT EXISTS coupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('percentage', 'fixed') NOT NULL,
    value DECIMAL(10, 2) NOT NULL,
    minimum_amount DECIMAL(10, 2) DEFAULT 0,
    maximum_discount DECIMAL(10, 2) NULL,
    usage_limit INT NULL,
    used_count INT DEFAULT 0,
    valid_from TIMESTAMP NOT NULL,
    valid_until TIMESTAMP NOT NULL,
    status ENUM('active', 'inactive', 'expired') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_code (code),
    INDEX idx_status (status),
    INDEX idx_valid_from (valid_from),
    INDEX idx_valid_until (valid_until)
);

-- =====================================================
-- 10. MÜŞTERİ YORUMLARI TABLOSU
-- =====================================================
CREATE TABLE IF NOT EXISTS product_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255),
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    title VARCHAR(255),
    comment TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    helpful_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_product_id (product_id),
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_rating (rating),
    INDEX idx_created_at (created_at)
);

-- =====================================================
-- 11. HABER BÜLTENİ TABLOSU
-- =====================================================
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255),
    status ENUM('active', 'unsubscribed', 'bounced') DEFAULT 'active',
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    unsubscribed_at TIMESTAMP NULL,
    
    INDEX idx_email (email),
    INDEX idx_status (status)
);

-- =====================================================
-- 12. SİTE AYARLARI TABLOSU
-- =====================================================
CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    setting_type ENUM('text', 'number', 'boolean', 'json') DEFAULT 'text',
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_setting_key (setting_key)
);

-- =====================================================
-- 13. DOSYA YÖNETİMİ TABLOSU
-- =====================================================
CREATE TABLE IF NOT EXISTS file_uploads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    original_name VARCHAR(255) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size INT NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    file_type ENUM('image', 'document', 'video', 'audio', 'other') NOT NULL,
    uploaded_by INT NULL,
    related_table VARCHAR(50),
    related_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_uploaded_by (uploaded_by),
    INDEX idx_file_type (file_type),
    INDEX idx_related (related_table, related_id)
);

-- =====================================================
-- 14. LOGLAR TABLOSU
-- =====================================================
CREATE TABLE IF NOT EXISTS activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    action VARCHAR(100) NOT NULL,
    table_name VARCHAR(50),
    record_id INT,
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_action (action),
    INDEX idx_table_name (table_name),
    INDEX idx_created_at (created_at)
);

-- =====================================================
-- 15. MÜŞTERİLER TABLOSU
-- =====================================================
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    company_name VARCHAR(255),
    tax_number VARCHAR(50),
    billing_address TEXT,
    shipping_address TEXT,
    city VARCHAR(100),
    state VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100) DEFAULT 'Türkiye',
    customer_type ENUM('individual', 'corporate') DEFAULT 'individual',
    status ENUM('active', 'inactive', 'blocked') DEFAULT 'active',
    notes TEXT,
    total_orders INT DEFAULT 0,
    total_spent DECIMAL(10, 2) DEFAULT 0,
    last_order_date TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_email (email),
    INDEX idx_phone (phone),
    INDEX idx_status (status),
    INDEX idx_customer_type (customer_type),
    INDEX idx_created_at (created_at)
);

-- =====================================================
-- VARSAYILAN VERİLER
-- =====================================================

-- Admin kullanıcısı (şifre: password)
-- Önce mevcut admin kullanıcısını sil
DELETE FROM users WHERE username = 'admin';

-- Yeni admin kullanıcısını oluştur
INSERT INTO users (username, password, email, first_name, last_name, role, status) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@evahome.com', 'Admin', 'User', 'admin', 'active');

-- Ana kategoriler
INSERT IGNORE INTO categories (name, slug, description, sort_order) VALUES 
('Mobilya', 'mobilya', 'Ev mobilyaları ve dekorasyon ürünleri', 1),
('Aydınlatma', 'aydinlatma', 'Lambalar ve aydınlatma sistemleri', 2),
('Tekstil', 'tekstil', 'Perde, halı ve tekstil ürünleri', 3),
('Mutfak', 'mutfak', 'Mutfak eşyaları ve aksesuarları', 4),
('Banyo', 'banyo', 'Banyo dekorasyonu ve aksesuarları', 5),
('Bahçe', 'bahce', 'Bahçe mobilyaları ve dekorasyon', 6),
('Elektronik', 'elektronik', 'Ev elektroniği ve teknoloji ürünleri', 7);

-- Alt kategoriler
INSERT IGNORE INTO categories (name, slug, description, parent_id, sort_order) VALUES 
('Koltuk Takımları', 'koltuk-takimlari', 'Oturma grupları ve koltuk takımları', 1, 1),
('Yatak Odası', 'yatak-odasi', 'Yatak, komodin ve gardırop', 1, 2),
('Yemek Masası', 'yemek-masasi', 'Yemek masası ve sandalyeler', 1, 3),
('Çalışma Masası', 'calisma-masasi', 'Ofis ve çalışma masaları', 1, 4);

-- Örnek ürünler
INSERT IGNORE INTO products (name, slug, description, short_description, price, category_id, stock_quantity, status, featured) VALUES 
('Modern Koltuk Takımı', 'modern-koltuk-takimi', 'Rahat ve şık modern koltuk takımı. Premium kumaş kaplama ile üretilmiştir. 3+2+1 oturma grubu.', 'Premium kumaş kaplama modern koltuk takımı', 2500.00, 8, 5, 'active', TRUE),
('LED Avize', 'led-avize', 'Enerji tasarruflu LED avize. Modern tasarım ve uzun ömürlü LED teknolojisi.', 'Enerji tasarruflu LED avize', 450.00, 2, 10, 'active', FALSE),
('Yün Halı', 'yun-hali', 'El dokuması yün halı. Doğal renkler ve geleneksel desenler.', 'El dokuması yün halı', 800.00, 3, 3, 'active', TRUE),
('Mutfak Seti', 'mutfak-seti', '12 parçalık mutfak takımı. Paslanmaz çelik malzeme ile üretilmiştir.', '12 parçalık paslanmaz çelik mutfak seti', 350.00, 4, 8, 'active', FALSE),
('Banyo Aynası', 'banyo-aynasi', 'Büyük boy banyo aynası. Çerçeveli tasarım ve su geçirmez özellik.', 'Çerçeveli banyo aynası', 120.00, 5, 15, 'active', FALSE);

-- Site ayarları
INSERT IGNORE INTO site_settings (setting_key, setting_value, setting_type, description) VALUES 
('site_name', 'Eva Home', 'text', 'Site adı'),
('site_description', 'Ev dekorasyonunda kalite ve şıklığın buluştuğu yer', 'text', 'Site açıklaması'),
('contact_email', 'info@evahome.com', 'text', 'İletişim e-posta adresi'),
('contact_phone', '+90 (212) 555 0123', 'text', 'İletişim telefonu'),
('currency', 'TRY', 'text', 'Para birimi'),
('tax_rate', '18', 'number', 'KDV oranı'),
('shipping_cost', '50', 'number', 'Kargo ücreti'),
('free_shipping_limit', '500', 'number', 'Ücretsiz kargo limiti'),
('maintenance_mode', 'false', 'boolean', 'Bakım modu');

-- Örnek blog yazıları
INSERT IGNORE INTO blog_posts (title, slug, content, excerpt, author_id, category_id, status, featured, published_at) VALUES 
('Ev Dekorasyonunda 2024 Trendleri', 'ev-dekorasyonunda-2024-trendleri', '2024 yılında ev dekorasyonunda öne çıkan trendler ve tasarım ipuçları...', '2024 yılında ev dekorasyonunda öne çıkan trendler', 1, 1, 'published', TRUE, NOW()),
('Mutfak Organizasyonu İpuçları', 'mutfak-organizasyonu-ipuclari', 'Mutfaklarınızı daha düzenli ve fonksiyonel hale getirmenin yolları...', 'Mutfak organizasyonu için pratik ipuçları', 1, 4, 'published', FALSE, NOW()),
('Aydınlatma Tasarımı Rehberi', 'aydinlatma-tasarimi-rehberi', 'Evlerinizde doğru aydınlatma seçimi ve tasarım önerileri...', 'Doğru aydınlatma seçimi için rehber', 1, 2, 'published', FALSE, NOW());

-- Örnek sipariş
INSERT IGNORE INTO orders (order_number, customer_name, customer_email, customer_phone, billing_address, shipping_address, subtotal, total_amount, order_status, payment_status) VALUES 
('EVH-2024-001', 'Ahmet Yılmaz', 'ahmet@example.com', '05551234567', 'İstanbul, Kadıköy, Moda Mahallesi, No: 123', 'İstanbul, Kadıköy, Moda Mahallesi, No: 123', 2500.00, 2500.00, 'pending', 'pending');

-- Örnek sipariş öğesi
INSERT IGNORE INTO order_items (order_id, product_id, product_name, product_sku, quantity, unit_price, total_price) VALUES 
(1, 1, 'Modern Koltuk Takımı', 'EVH-KOLTUK-001', 1, 2500.00, 2500.00);

-- Örnek iletişim mesajı
INSERT IGNORE INTO contact_messages (name, email, subject, message, status) VALUES 
('Ayşe Demir', 'ayse@example.com', 'Ürün Sorgusu', 'Merhaba, koltuk takımınız hakkında bilgi almak istiyorum.', 'new');

-- Örnek iş başvurusu
INSERT IGNORE INTO job_applications (name, email, phone, position, department, experience_level, cover_letter, status) VALUES 
('Mehmet Kaya', 'mehmet@example.com', '05559876543', 'Satış Temsilcisi', 'Satış', 'mid', 'Eva Home ailesine katılmak istiyorum. Satış alanında 3 yıllık deneyimim var.', 'new');

-- =====================================================
-- KURULUM TAMAMLANDI
-- =====================================================
SELECT 'Eva Home veritabanı başarıyla kuruldu!' as message,
       'Tüm tablolar ve örnek veriler oluşturuldu.' as details,
       'Admin giriş: admin / password' as login_info;