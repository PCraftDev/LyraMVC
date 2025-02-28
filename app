#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Lyramvc\Lyramvc\Core\Server;
use Lyramvc\Lyramvc\Core\Migration;
use Lyramvc\Lyramvc\Core\CreateModel;
use Lyramvc\Lyramvc\Core\Database;
use Lyramvc\Lyramvc\Core\Seeder;
// Inisialisasi database


// Konfigurasi database
$pdo = new PDO("mysql:host=localhost;dbname=lyramvc", "root", "");

$commands = [
    'run'              => 'Menjalankan server development (opsi: --server:IP --port:PORT)',
    'migrate'          => 'Menjalankan semua migration yang belum dieksekusi',
    'create:migration' => 'Membuat file migration baru, contoh: php app create:migration users',
    'create:model'     => 'Membuat file model baru, contoh: php app create:model users',
    'help'             => 'Menampilkan daftar perintah'
];

// Ambil argumen dari CLI
$command = $argv[1] ?? 'help';

// Parsing opsi
$options = [];
foreach ($argv as $arg) {
    if (preg_match('/--(\w+):(.+)/', $arg, $matches)) {
        $options[$matches[1]] = $matches[2];
    }
}

switch ($command) {
    case 'run':
        $server = $options['server'] ?? 'localhost';
        $port = $options['port'] ?? 8000;
        Server::run($server, $port);
        break;

    case 'migrate':
        Migration::runMigrations($pdo);
        break;

    case 'create:migration':
        if (!isset($argv[2])) {
            echo " Harap masukkan nama tabel. Contoh:\n";
            echo " php app create:migration users\n";
            exit(1);
        }
        Migration::createMigration($argv[2]);
        break;
    case 'seed':
        $table = $argv[2] ?? null;
        $count = (int) ($argv[3] ?? 1);

        if (!$table) {
            echo "Harap tentukan tabel: php app seed <table> <count>\n";
            exit(1);
        }

        $database = new Database();
        $seeder = new Seeder($database);
        $seeder->seed($table, $count);
        break;
    case 'create:model':
        if (!isset($argv[2])) {
            echo "Harap masukkan nama Model. Contoh:\n";
            echo "   php app create:model User\n";
            exit(1);
        }
        CreateModel::createModel($argv[2]);
        break;

    case 'help':
    default:
        echo "🛠  LyraMVC CLI Commands:\n";
        foreach ($commands as $cmd => $desc) {
            echo "  php app $cmd  - $desc\n";
        }
        break;
}
