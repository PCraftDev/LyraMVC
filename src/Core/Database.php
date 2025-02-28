<?php

namespace Lyramvc\Lyramvc\Core;

use Medoo\Medoo;
use Doctrine\DBAL\DriverManager;

class Database
{
    protected $medoo;
    protected $dbal;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/config.php';

        $db = $config['database'];

        // Medoo Connection
        $this->medoo = new Medoo([
            'type' => $db['connection'],
            'host' => $db['host'],
            'database' => $db['database'],
            'username' => $db['username'],
            'password' => $db['password'],
            'port' => $db['port'],
            'charset' => 'utf8mb4',
            'error' => \PDO::ERRMODE_EXCEPTION
        ]);

        // Doctrine DBAL Connection
        $this->dbal = DriverManager::getConnection([
            'dbname' => $db['database'],
            'user' => $db['username'],
            'password' => $db['password'],
            'host' => $db['host'],
            'driver' => 'pdo_mysql',
        ]);
    }

    public function medoo()
    {
        return $this->medoo;
    }

    public function dbal()
    {
        return $this->dbal;
    }
}
