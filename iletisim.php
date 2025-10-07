<?php 
$page_title = "İletişim - Eva Home";
include 'header.php'; 
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="display-4 fw-bold text-center mb-5">İletişim</h1>
            <p class="lead text-center text-muted mb-5">Sorularınız, önerileriniz veya özel siparişleriniz için bizimle iletişime geçin</p>
        </div>
    </div>

    <div class="row">
        <!-- Contact Info -->
        <div class="col-lg-4 mb-5">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="fas fa-envelope text-warning fa-lg"></i>
                                </div>
                                <div>
                                    <h5>E-posta</h5>
                                    <p class="text-warning fw-bold mb-1">info@evahome.com</p>
                                    <small class="text-muted">7/24 e-posta desteği</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="fas fa-phone text-warning fa-lg"></i>
                                </div>
                                <div>
                                    <h5>Telefon</h5>
                                    <p class="text-warning fw-bold mb-1">+90 555 123 45 67</p>
                                    <small class="text-muted">Pazartesi-Cuma 09:00-18:00</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="fas fa-map-marker-alt text-warning fa-lg"></i>
                                </div>
                                <div>
                                    <h5>Adres</h5>
                                    <p class="text-warning fw-bold mb-1">İstanbul, Türkiye</p>
                                    <small class="text-muted">Atölye ziyareti için randevu alın</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3">
                                    <i class="fas fa-clock text-warning fa-lg"></i>
                                </div>
                                <div>
                                    <h5>Çalışma Saatleri</h5>
                                    <p class="text-warning fw-bold mb-1">Pazartesi-Cuma</p>
                                    <small class="text-muted">09:00 - 18:00</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Sosyal Medya</h5>
                            <div class="d-flex gap-3">
                                <a href="#" class="btn btn-primary-custom rounded-circle">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                <a href="#" class="btn btn-primary-custom rounded-circle">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="btn btn-primary-custom rounded-circle">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <h2 class="mb-4">Mesaj Gönderin</h2>
                    
                    <form action="#" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Ad Soyad *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">E-posta *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">Konu *</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="message" class="form-label">Mesaj *</label>
                            <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary-custom btn-lg w-100">
                            <i class="fas fa-paper-plane me-2"></i>Mesaj Gönder
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="bg-light p-5 text-center">
                        <i class="fas fa-map-marker-alt text-muted fa-3x mb-3"></i>
                        <h5 class="text-muted">Harita burada görüntülenecek</h5>
                        <p class="text-muted">Google Maps entegrasyonu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
