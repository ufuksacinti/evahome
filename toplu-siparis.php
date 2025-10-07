<?php
require_once 'config/database.php';
$page_title = 'Toplu Sipariş - Eva Home';

$success = '';
$error = '';

// Form gönderimi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_name = trim($_POST['company_name'] ?? '');
    $contact_person = trim($_POST['contact_person'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $company_type = $_POST['company_type'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    
    $product_type = $_POST['product_type'] ?? '';
    $quantity = (int)($_POST['quantity'] ?? 0);
    $special_requests = trim($_POST['special_requests'] ?? '');
    
    $custom_label = isset($_POST['custom_label']) ? 1 : 0;
    $label_type = $_POST['label_type'] ?? 'eva_home';
    $custom_text = trim($_POST['custom_text'] ?? '');
    
    // Logo yükleme
    $logo_file = '';
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/logos/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $filename = 'logo_' . uniqid() . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $filepath)) {
            $logo_file = $filepath;
        }
    }
    
    if (empty($company_name) || empty($contact_person) || empty($email) || empty($phone) || $quantity < 50) {
        $error = 'Lütfen tüm zorunlu alanları doldurun. Minimum sipariş adedi 50\'dir.';
    } else {
        try {
            $order_number = 'WSL-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
            
            $stmt = $pdo->prepare("INSERT INTO wholesale_orders (
                order_number, company_name, contact_person, email, phone, company_type, 
                address, city, product_type, quantity, custom_label, label_type, 
                custom_text, logo_file, special_requests, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'new')");
            
            $stmt->execute([
                $order_number, $company_name, $contact_person, $email, $phone, $company_type,
                $address, $city, $product_type, $quantity, $custom_label, $label_type,
                $custom_text, $logo_file, $special_requests
            ]);
            
            $success = "Toplu sipariş talebiniz başarıyla alındı! Sipariş No: <strong>$order_number</strong><br>En kısa sürede size dönüş yapacağız.";
            
            // Formu temizle
            $_POST = [];
        } catch (PDOException $e) {
            $error = 'Hata: ' . $e->getMessage();
        }
    }
}

// Paketleri getir
try {
    $stmt = $pdo->query("SELECT * FROM wholesale_packages WHERE status = 'active' ORDER BY sort_order, name");
    $packages = $stmt->fetchAll();
} catch (PDOException $e) {
    $packages = [];
}

include 'header.php';
?>

<!-- Hero Section -->
<section style="background: linear-gradient(135deg, #fef7ee 0%, #f1f5f9 100%); padding: 4rem 0;">
    <div class="container text-center">
        <i class="fas fa-industry fa-4x mb-3" style="color: #c9a24a;"></i>
        <h1 class="display-4 mb-3" style="color: #c9a24a; font-family: 'Georgia', serif;">🏢 Toplu Sipariş</h1>
        <p class="lead text-muted mb-4">Oteller, SPA merkezleri, kurumsal firmalar ve butik mağazalar için özel üretim</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <span class="badge" style="background: rgba(201, 162, 74, 0.15); color: #c9a24a; padding: 10px 20px; font-size: 1rem;">
                <i class="fas fa-hotel me-2"></i>Butik Oteller
            </span>
            <span class="badge" style="background: rgba(201, 162, 74, 0.15); color: #c9a24a; padding: 10px 20px; font-size: 1rem;">
                <i class="fas fa-spa me-2"></i>SPA & Wellness
            </span>
            <span class="badge" style="background: rgba(201, 162, 74, 0.15); color: #c9a24a; padding: 10px 20px; font-size: 1rem;">
                <i class="fas fa-building me-2"></i>Kurumsal Hediye
            </span>
            <span class="badge" style="background: rgba(201, 162, 74, 0.15); color: #c9a24a; padding: 10px 20px; font-size: 1rem;">
                <i class="fas fa-store me-2"></i>Butik Mağazalar
            </span>
        </div>
    </div>
</section>

<div class="container py-5">
    <?php if ($success): ?>
        <div class="alert alert-success" style="border-radius: 12px; border-left: 4px solid #28a745;">
            <h5><i class="fas fa-check-circle me-2"></i>Başarılı!</h5>
            <p class="mb-0"><?php echo $success; ?></p>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger" style="border-radius: 12px; border-left: 4px solid #dc3545;">
            <h5><i class="fas fa-exclamation-circle me-2"></i>Hata!</h5>
            <p class="mb-0"><?php echo $error; ?></p>
        </div>
    <?php endif; ?>

    <!-- Paketler -->
    <section class="mb-5">
        <h2 class="text-center mb-4" style="color: #c9a24a; font-family: 'Georgia', serif;">
            📦 Toplu Sipariş Paketleri
        </h2>
        <div class="row">
            <?php foreach ($packages as $package): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100" style="border: 2px solid #e5e5e5; border-radius: 12px; transition: all 0.3s;">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #c9a24a; font-weight: 600;">
                                <?php echo htmlspecialchars($package['name']); ?>
                            </h5>
                            <p class="card-text text-muted" style="font-size: 0.9rem;">
                                <?php echo htmlspecialchars($package['description']); ?>
                            </p>
                            <hr>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1"><strong>Pakete Dahil:</strong></small>
                                <small><?php echo htmlspecialchars($package['includes']); ?></small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block">Min. Sipariş</small>
                                    <strong><?php echo $package['min_quantity']; ?> adet</strong>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Birim Fiyat</small>
                                    <h5 class="mb-0" style="color: #c9a24a;">₺<?php echo number_format($package['unit_price'], 2); ?></h5>
                                </div>
                            </div>
                            <?php if ($package['custom_label_available']): ?>
                                <div class="mt-3">
                                    <span class="badge" style="background: rgba(201, 162, 74, 0.15); color: #c9a24a; width: 100%;">
                                        <i class="fas fa-tag me-1"></i>Özel Etiket Uygulanabilir
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Sipariş Formu -->
    <section>
        <div class="card" style="border: none; box-shadow: 0 5px 20px rgba(0,0,0,0.1); border-radius: 15px;">
            <div class="card-header" style="background: linear-gradient(135deg, #c9a24a 0%, #a0883d 100%); color: white; border-radius: 15px 15px 0 0; padding: 2rem;">
                <h3 class="mb-0">
                    <i class="fas fa-file-invoice me-2"></i>
                    Toplu Sipariş Talebi Oluştur
                </h3>
                <p class="mb-0 mt-2" style="opacity: 0.9;">Lütfen aşağıdaki formu doldurun, size özel teklif hazırlayalım</p>
            </div>
            <div class="card-body" style="padding: 2rem;">
                <form method="POST" enctype="multipart/form-data">
                    <!-- Firma Bilgileri -->
                    <h5 class="mb-3" style="color: #c9a24a;">
                        <i class="fas fa-building me-2"></i>Firma Bilgileri
                    </h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Firma Adı <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="company_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Yetkili Kişi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contact_person" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">E-posta <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telefon <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="phone" required placeholder="+90 5XX XXX XX XX">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Firma Türü <span class="text-danger">*</span></label>
                            <select class="form-select" name="company_type" required>
                                <option value="">Seçiniz</option>
                                <option value="hotel">🏨 Butik Otel</option>
                                <option value="spa">💆 SPA & Wellness Merkezi</option>
                                <option value="corporate">🏢 Kurumsal Firma</option>
                                <option value="boutique">🏪 Butik Mağaza (Perakende)</option>
                                <option value="other">📋 Diğer</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Şehir</label>
                            <input type="text" class="form-control" name="city" placeholder="İstanbul">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Adres <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="address" rows="2" required></textarea>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Ürün Bilgileri -->
                    <h5 class="mb-3" style="color: #c9a24a;">
                        <i class="fas fa-box me-2"></i>Ürün Bilgileri
                    </h5>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Ürün Paketi <span class="text-danger">*</span></label>
                            <select class="form-select" name="product_type" id="productType" required onchange="updateMinQuantity()">
                                <option value="">Paket Seçiniz</option>
                                <?php foreach ($packages as $package): ?>
                                    <option value="<?php echo htmlspecialchars($package['product_type']); ?>" 
                                            data-min="<?php echo $package['min_quantity']; ?>"
                                            data-price="<?php echo $package['unit_price']; ?>"
                                            data-custom="<?php echo $package['custom_label_available']; ?>">
                                        <?php echo htmlspecialchars($package['name']); ?> 
                                        (Min: <?php echo $package['min_quantity']; ?> adet - ₺<?php echo number_format($package['unit_price'], 2); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Adet <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="quantity" id="quantity" min="50" required onchange="calculateTotal()">
                            <small class="text-muted" id="minQuantityText">Min: 50 adet</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="alert" style="background: rgba(201, 162, 74, 0.1); border-left: 4px solid #c9a24a;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Tahmini Tutar:</strong>
                                        <p class="mb-0 text-muted small">Nihai fiyat teklifimizle birlikte bildirilecektir</p>
                                    </div>
                                    <h3 class="mb-0" style="color: #c9a24a;" id="estimatedTotal">₺0.00</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Özel Etiket Seçenekleri -->
                    <h5 class="mb-3" style="color: #c9a24a;">
                        <i class="fas fa-tag me-2"></i>Özel Etiket Seçenekleri
                    </h5>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="customLabel" name="custom_label" onchange="toggleCustomLabel()">
                            <label class="form-check-label" for="customLabel">
                                <strong>Özel Etiket İstiyorum</strong>
                                <br>
                                <small class="text-muted">Kendi markanız veya logonuzla özel etiket</small>
                            </label>
                        </div>
                    </div>

                    <div id="customLabelOptions" style="display: none;">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Etiket Türü</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="label_type" value="markasiz" id="markasiz">
                                            <label class="form-check-label" for="markasiz">
                                                <strong>Markasız</strong>
                                                <br><small class="text-muted">Sadece ürün bilgisi</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="label_type" value="kendi_markasi" id="kendi_markasi">
                                            <label class="form-check-label" for="kendi_markasi">
                                                <strong>Kendi Markanız</strong>
                                                <br><small class="text-muted">Logo ve metin</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="label_type" value="eva_home" id="eva_home" checked>
                                            <label class="form-check-label" for="eva_home">
                                                <strong>Eva Home</strong>
                                                <br><small class="text-muted">Standart etiket</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Etiket Üzerindeki Metin (Opsiyonel)</label>
                                <textarea class="form-control" name="custom_text" rows="3" placeholder="Örn: 'Your Hotel Name' veya 'Special Gift for You'"></textarea>
                                <small class="text-muted">Maks 100 karakter</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Logo Yükle (Opsiyonel)</label>
                                <input type="file" class="form-control" name="logo" accept="image/*,.pdf,.ai,.eps" onchange="previewLogo(this)">
                                <small class="text-muted">PNG, JPG, PDF, AI, EPS (Max: 5MB)</small>
                                <div id="logoPreview" class="mt-2"></div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Özel Talepler -->
                    <h5 class="mb-3" style="color: #c9a24a;">
                        <i class="fas fa-comment me-2"></i>Özel Talepler ve Notlar
                    </h5>
                    <div class="mb-3">
                        <textarea class="form-control" name="special_requests" rows="4" placeholder="Özel renk tercihi, teslimat tarihi, paketleme detayları vb. taleplerinizi buraya yazabilirsiniz"></textarea>
                    </div>

                    <!-- Gönder Butonu -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-lg" style="background: #c9a24a; color: white; padding: 1rem 3rem; border-radius: 30px; font-weight: 600;">
                            <i class="fas fa-paper-plane me-2"></i>Sipariş Talebini Gönder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Bilgilendirme -->
    <section class="mt-5">
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-shipping-fast fa-3x" style="color: #c9a24a;"></i>
                    </div>
                    <h5>Hızlı Teslimat</h5>
                    <p class="text-muted">Toplu siparişleriniz için özel üretim ve hızlı teslimat</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-tags fa-3x" style="color: #c9a24a;"></i>
                    </div>
                    <h5>Özel Fiyatlandırma</h5>
                    <p class="text-muted">Toplu siparişler için özel indirimli fiyatlar</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-headset fa-3x" style="color: #c9a24a;"></i>
                    </div>
                    <h5>Özel Destek</h5>
                    <p class="text-muted">Kurumsal müşterilerimiz için özel müşteri temsilcisi</p>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
function toggleCustomLabel() {
    const checkbox = document.getElementById('customLabel');
    const options = document.getElementById('customLabelOptions');
    options.style.display = checkbox.checked ? 'block' : 'none';
}

function updateMinQuantity() {
    const select = document.getElementById('productType');
    const option = select.options[select.selectedIndex];
    const minQty = option.dataset.min || 50;
    
    document.getElementById('quantity').min = minQty;
    document.getElementById('minQuantityText').textContent = 'Min: ' + minQty + ' adet';
    
    calculateTotal();
}

function calculateTotal() {
    const select = document.getElementById('productType');
    const option = select.options[select.selectedIndex];
    const price = parseFloat(option.dataset.price) || 0;
    const quantity = parseInt(document.getElementById('quantity').value) || 0;
    
    const total = price * quantity;
    document.getElementById('estimatedTotal').textContent = '₺' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

function previewLogo(input) {
    const preview = document.getElementById('logoPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" class="img-fluid" style="max-height: 100px; border-radius: 8px; border: 2px solid #e5e5e5;">';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include 'footer.php'; ?>

