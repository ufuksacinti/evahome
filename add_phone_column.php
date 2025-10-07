<?php
// Contact messages tablosuna phone sütunu ekleme scripti
require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='tr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Contact Messages Tablosu Güncelleme</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .success { color: #28a745; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        h1 { color: #c9a24a; text-align: center; margin-bottom: 30px; }
        .step { background: #fef7ee; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #c9a24a; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>📞 Contact Messages Tablosu Güncelleme</h1>";

try {
    if (!$pdo) {
        throw new Exception("Veritabanı bağlantısı yok");
    }
    echo "<div class='step'><p class='success'>✅ Veritabanına başarıyla bağlandı</p></div>";

    // phone sütunu ekle
    try {
        $pdo->exec("ALTER TABLE contact_messages ADD COLUMN phone VARCHAR(20) NULL AFTER email");
        echo "<div class='step'><p class='success'>✅ phone sütunu eklendi</p></div>";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "<div class='step'><p class='success'>✅ phone sütunu zaten mevcut</p></div>";
        } else {
            echo "<div class='step'><p class='error'>❌ phone sütunu eklenemedi: " . $e->getMessage() . "</p></div>";
        }
    }

    echo "<div class='step'><p class='success'>🎉 Contact messages tablosu güncellemesi tamamlandı!</p></div>";
    echo "<div class='step'>
            <p>Artık iletişim formunda telefon numarası alınabilir:</p>
            <a href='index.php#contact' class='btn'>İletişim Formunu Test Et</a>
            <a href='admin/messages.php' class='btn'>Admin Panelinde Mesajları Gör</a>
          </div>";

} catch (Exception $e) {
    echo "<div class='step'><p class='error'>❌ Hata: " . $e->getMessage() . "</p></div>";
}

echo "</div></body></html>";
?>
