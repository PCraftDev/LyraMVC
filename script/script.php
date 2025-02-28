<?php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Muat file .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Konfigurasi database dari .env
$dbHost = $_ENV['DB_HOST'] ?? '127.0.0.1';
$dbPort = $_ENV['DB_PORT'] ?? '3306';
$dbName = $_ENV['DB_DATABASE'] ?? 'lyramvc';
$dbUser = $_ENV['DB_USERNAME'] ?? 'root';
$dbPass = $_ENV['DB_PASSWORD'] ?? '';

try {
    // Koneksi ke MySQL tanpa menentukan database (untuk membuatnya nanti)
    $pdo = new PDO("mysql:host=$dbHost;port=$dbPort", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Buat database jika belum ada
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

    echo "✅ Database `$dbName` telah dibuat atau sudah ada.\n";
} catch (Exception $e) {
    echo "❌ Gagal membuat database: " . $e->getMessage() . "\n";
    exit(1);
}
