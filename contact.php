<?php
require_once 'config/database.php';

// CSRF token kontrolü
if ($_POST && !verifyCSRFToken($_POST['csrf_token'] ?? '')) {
    die('CSRF token hatası');
}

if ($_POST && isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
    try {
        $phone = $_POST['phone'] ?? '';
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['name'],
            $_POST['email'],
            $phone,
            $_POST['subject'],
            $_POST['message']
        ]);
        
        $success = true;
    } catch (PDOException $e) {
        $error = "Mesaj gönderilirken hata oluştu: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim - Eva Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #fef7ee 0%, #f1f5f9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .contact-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .contact-header {
            background: linear-gradient(135deg, #f2740a 0%, #e35a00 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="contact-card">
                    <div class="contact-header">
                        <i class="fas fa-envelope fa-3x mb-3"></i>
                        <h2 class="mb-0">İletişim</h2>
                    </div>
                    
                    <div class="p-4">
                        <?php if (isset($success) && $success): ?>
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                Mesajınız başarıyla gönderildi! En kısa sürede size dönüş yapacağız.
                            </div>
                            <div class="text-center">
                                <a href="index.php" class="btn btn-primary">
                                    <i class="fas fa-home me-2"></i>Ana Sayfaya Dön
                                </a>
                            </div>
                        <?php elseif (isset($error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo escape($error); ?>
                            </div>
                            <div class="text-center">
                                <a href="index.php" class="btn btn-primary">
                                    <i class="fas fa-home me-2"></i>Ana Sayfaya Dön
                                </a>
                            </div>
                        <?php else: ?>
                            <form method="POST" class="row g-3">
                                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                                
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Ad Soyad</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">E-posta</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Telefon Numarası</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="+90 5XX XXX XX XX">
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label">Konu</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Mesaj</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i>Mesaj Gönder
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
