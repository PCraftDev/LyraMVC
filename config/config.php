<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

return [
    'app_name' => $_ENV['APP_NAME'] ?? 'MyMVC App',
    'debug' => filter_var($_ENV['APP_DEBUG'], FILTER_VALIDATE_BOOLEAN),

    'database' => [
        'connection' => $_ENV['DB_CONNECTION'] ?? 'mysql',
        'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
        'port' => $_ENV['DB_PORT'] ?? '3306',
        'database' => $_ENV['DB_DATABASE'] ?? '',
        'username' => $_ENV['DB_USERNAME'] ?? '',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
    ],
];
