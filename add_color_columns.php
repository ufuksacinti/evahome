<?php
// Veritabanına renk sütunları ekleme scripti
require_once 'config/database.php';

echo "<!DOCTYPE html>
<html lang='tr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Veritabanı Renk Sütunları Ekleme</title>
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
        <h1>🎨 Veritabanı Renk Sütunları Ekleme</h1>";

try {
    if (!$pdo) {
        throw new Exception("Veritabanı bağlantısı yok");
    }
    echo "<div class='step'><p class='success'>✅ Veritabanına başarıyla bağlandı</p></div>";

    // color_name sütunu ekle
    try {
        $pdo->exec("ALTER TABLE products ADD COLUMN color_name VARCHAR(50) NULL AFTER image_url");
        echo "<div class='step'><p class='success'>✅ color_name sütunu eklendi</p></div>";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "<div class='step'><p class='success'>✅ color_name sütunu zaten mevcut</p></div>";
        } else {
            echo "<div class='step'><p class='error'>❌ color_name sütunu eklenemedi: " . $e->getMessage() . "</p></div>";
        }
    }

    // color_code sütunu ekle
    try {
        $pdo->exec("ALTER TABLE products ADD COLUMN color_code VARCHAR(7) NULL AFTER color_name");
        echo "<div class='step'><p class='success'>✅ color_code sütunu eklendi</p></div>";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "<div class='step'><p class='success'>✅ color_code sütunu zaten mevcut</p></div>";
        } else {
            echo "<div class='step'><p class='error'>❌ color_code sütunu eklenemedi: " . $e->getMessage() . "</p></div>";
        }
    }

    echo "<div class='step'><p class='success'>🎉 Veritabanı güncellemesi tamamlandı!</p></div>";
    echo "<div class='step'>
            <p>Şimdi renkli ürünleri ekleyebilirsiniz:</p>
            <a href='add_colorful_products.php' class='btn'>Renkli Ürünleri Ekle</a>
            <a href='index.php' class='btn'>Ana Sayfaya Git</a>
          </div>";

} catch (Exception $e) {
    echo "<div class='step'><p class='error'>❌ Hata: " . $e->getMessage() . "</p></div>";
}

echo "</div></body></html>";
?>
