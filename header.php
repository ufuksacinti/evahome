<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Eva Home - El Yapımı Mum ve Dekoratif Eşyalar'; ?></title>
    <meta name="description" content="Eva Home - El yapımı mum ve dekoratif eşyalar. Evinizi güzelleştiren özel tasarımlar.">
    <meta name="keywords" content="el yapımı mum, dekoratif eşya, ev dekorasyonu, handmade, eva home">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Eva Home Global Stiller */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #334155;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', Georgia, serif;
            color: #1D1D1B;
        }
        
        .btn-primary-custom {
            background-color: #c9a24a;
            border-color: #c9a24a;
            padding: 12px 30px;
            font-weight: 500;
            color: white;
        }
        
        .btn-primary-custom:hover {
            background-color: #a0883d;
            border-color: #a0883d;
            color: white;
        }
        
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .footer {
            background-color: #1e293b;
            color: white;
            padding: 50px 0 20px;
        }
        
        /* Container genişliği */
        @media (min-width: 1200px) {
            .container {
                max-width: 1140px;
            }
        }
        
        /* Hamburger icon */
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(201, 162, 74, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.25rem rgba(201, 162, 74, 0.25);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-light sticky-top" style="padding: 1rem 0; background: #fefdfb; border-bottom: 1px solid #e5e5e5;">
        <div style="display: flex; align-items: center; justify-content: center; position: relative; max-width: 1200px; margin: 0 auto; padding: 0 15px; width: 100%;">
            <!-- Logo - Sol Sabit -->
            <a href="index.php" style="position: absolute; left: 15px; font-family: 'Georgia', serif; font-weight: 700; color: #c9a24a; font-size: 1.5rem; text-decoration: none; letter-spacing: 0.5px;">
                <i class="fas fa-candle-holder" style="margin-right: 8px;"></i>Eva Home
            </a>
            
            <!-- Menü - Ortada (Desktop) -->
            <ul class="navbar-nav-desktop" style="display: flex; list-style: none; margin: 0; padding: 0; gap: 0.5rem; align-items: center;">
                <li>
                    <a href="index.php" class="nav-link-custom <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" style="color: <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? '#c9a24a' : '#334155'; ?>; font-weight: <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? '600' : '500'; ?>; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap; background-color: <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'rgba(201, 162, 74, 0.15)' : 'transparent'; ?>; display: inline-block;">
                        <i class="fas fa-home" style="margin-right: 5px;"></i>Ana Sayfa
                    </a>
                </li>
                <li>
                    <a href="urunler.php" class="nav-link-custom <?php echo basename($_SERVER['PHP_SELF']) == 'urunler.php' ? 'active' : ''; ?>" style="color: <?php echo basename($_SERVER['PHP_SELF']) == 'urunler.php' ? '#c9a24a' : '#334155'; ?>; font-weight: <?php echo basename($_SERVER['PHP_SELF']) == 'urunler.php' ? '600' : '500'; ?>; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap; background-color: <?php echo basename($_SERVER['PHP_SELF']) == 'urunler.php' ? 'rgba(201, 162, 74, 0.15)' : 'transparent'; ?>; display: inline-block;">
                        <i class="fas fa-box" style="margin-right: 5px;"></i>Ürünler
                    </a>
                </li>
                <li>
                    <a href="toplu-siparis.php" class="nav-link-custom <?php echo basename($_SERVER['PHP_SELF']) == 'toplu-siparis.php' ? 'active' : ''; ?>" style="color: <?php echo basename($_SERVER['PHP_SELF']) == 'toplu-siparis.php' ? '#c9a24a' : '#334155'; ?>; font-weight: <?php echo basename($_SERVER['PHP_SELF']) == 'toplu-siparis.php' ? '600' : '500'; ?>; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap; background-color: <?php echo basename($_SERVER['PHP_SELF']) == 'toplu-siparis.php' ? 'rgba(201, 162, 74, 0.15)' : 'transparent'; ?>; display: inline-block;">
                        <i class="fas fa-industry" style="margin-right: 5px;"></i>Toplu Sipariş
                        <span class="badge bg-danger" style="font-size: 0.65rem; margin-left: 4px;">YENİ</span>
                    </a>
                </li>
                <li>
                    <a href="blog.php" class="nav-link-custom <?php echo basename($_SERVER['PHP_SELF']) == 'blog.php' ? 'active' : ''; ?>" style="color: <?php echo basename($_SERVER['PHP_SELF']) == 'blog.php' ? '#c9a24a' : '#334155'; ?>; font-weight: <?php echo basename($_SERVER['PHP_SELF']) == 'blog.php' ? '600' : '500'; ?>; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap; background-color: <?php echo basename($_SERVER['PHP_SELF']) == 'blog.php' ? 'rgba(201, 162, 74, 0.15)' : 'transparent'; ?>; display: inline-block;">
                        <i class="fas fa-blog" style="margin-right: 5px;"></i>Blog
                    </a>
                </li>
                <li>
                    <a href="hakkimizda.php" class="nav-link-custom <?php echo basename($_SERVER['PHP_SELF']) == 'hakkimizda.php' ? 'active' : ''; ?>" style="color: <?php echo basename($_SERVER['PHP_SELF']) == 'hakkimizda.php' ? '#c9a24a' : '#334155'; ?>; font-weight: <?php echo basename($_SERVER['PHP_SELF']) == 'hakkimizda.php' ? '600' : '500'; ?>; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap; background-color: <?php echo basename($_SERVER['PHP_SELF']) == 'hakkimizda.php' ? 'rgba(201, 162, 74, 0.15)' : 'transparent'; ?>; display: inline-block;">
                        <i class="fas fa-info-circle" style="margin-right: 5px;"></i>Hakkımızda
                    </a>
                </li>
                <li>
                    <a href="iletisim.php" class="nav-link-custom <?php echo basename($_SERVER['PHP_SELF']) == 'iletisim.php' ? 'active' : ''; ?>" style="color: <?php echo basename($_SERVER['PHP_SELF']) == 'iletisim.php' ? '#c9a24a' : '#334155'; ?>; font-weight: <?php echo basename($_SERVER['PHP_SELF']) == 'iletisim.php' ? '600' : '500'; ?>; padding: 0.5rem 1rem; text-decoration: none; border-radius: 8px; transition: all 0.3s; white-space: nowrap; background-color: <?php echo basename($_SERVER['PHP_SELF']) == 'iletisim.php' ? 'rgba(201, 162, 74, 0.15)' : 'transparent'; ?>; display: inline-block;">
                        <i class="fas fa-envelope" style="margin-right: 5px;"></i>İletişim
                    </a>
                </li>
            </ul>
            
            <!-- Admin Butonu - Sağ Sabit -->
            <div style="position: absolute; right: 15px; display: flex; align-items: center; gap: 1rem;">
                <div style="display: flex; gap: 8px; align-items: center; padding: 6px 12px; border: 1px solid #e5e5e5; border-radius: 20px; background: white; font-size: 13px;">
                    <a href="#" style="color: #c9a24a; font-weight: 700; text-decoration: none;">TR</a>
                    <span style="color: #cbd5e1;">|</span>
                    <a href="#" style="color: #64748b; text-decoration: none; transition: color 0.3s;">EN</a>
                </div>
                <a href="admin/login.php" style="background: #c9a24a; color: white; padding: 8px 18px; border-radius: 20px; text-decoration: none; font-weight: 500; transition: all 0.3s; display: inline-block;">Admin</a>
            </div>
            
            <!-- Hamburger Menü (Mobil) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavMobile" style="position: absolute; right: 15px; display: none; border-color: #c9a24a; padding: 0.5rem 0.75rem;">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Mobil Menü -->
            <div class="collapse navbar-collapse" id="navbarNavMobile" style="position: absolute; top: 100%; left: 0; right: 0; background: white; border-top: 1px solid #e5e5e5; box-shadow: 0 5px 15px rgba(0,0,0,0.1); z-index: 1000; display: none;">
                <ul class="navbar-nav" style="padding: 1rem; list-style: none; margin: 0;">
                    <li style="margin-bottom: 0.5rem;">
                        <a href="index.php" style="display: block; padding: 0.75rem; color: #334155; text-decoration: none; border-radius: 8px; transition: background 0.3s;">
                            <i class="fas fa-home me-2"></i>Ana Sayfa
                        </a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="urunler.php" style="display: block; padding: 0.75rem; color: #334155; text-decoration: none; border-radius: 8px; transition: background 0.3s;">
                            <i class="fas fa-box me-2"></i>Ürünler
                        </a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="toplu-siparis.php" style="display: block; padding: 0.75rem; color: #334155; text-decoration: none; border-radius: 8px; transition: background 0.3s;">
                            <i class="fas fa-industry me-2"></i>Toplu Sipariş
                            <span class="badge bg-danger ms-2" style="font-size: 0.65rem;">YENİ</span>
                        </a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="blog.php" style="display: block; padding: 0.75rem; color: #334155; text-decoration: none; border-radius: 8px; transition: background 0.3s;">
                            <i class="fas fa-blog me-2"></i>Blog
                        </a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="hakkimizda.php" style="display: block; padding: 0.75rem; color: #334155; text-decoration: none; border-radius: 8px; transition: background 0.3s;">
                            <i class="fas fa-info-circle me-2"></i>Hakkımızda
                        </a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="iletisim.php" style="display: block; padding: 0.75rem; color: #334155; text-decoration: none; border-radius: 8px; transition: background 0.3s;">
                            <i class="fas fa-envelope me-2"></i>İletişim
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <style>
        /* Hover Efektleri */
        .nav-link-custom:hover {
            color: #c9a24a !important;
            background-color: rgba(201, 162, 74, 0.1) !important;
        }
        
        a[href="admin/login.php"]:hover {
            background: #a0883d !important;
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .navbar-nav-desktop {
                display: none !important;
            }
            
            .navbar-toggler {
                display: block !important;
            }
            
            div[style*="position: absolute; right: 15px"] > div:first-child,
            div[style*="position: absolute; right: 15px"] > a {
                display: none;
            }
        }
        
        @media (min-width: 992px) {
            #navbarNavMobile {
                display: none !important;
            }
        }
        
        /* Mobil Menü Hover */
        #navbarNavMobile a:hover {
            background-color: rgba(201, 162, 74, 0.1) !important;
            color: #c9a24a !important;
        }
    </style>
