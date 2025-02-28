<?php

namespace Lyramvc\Lyramvc\Core;

use Faker\Factory;
use PDO;
use PDOException;

class Seeder
{
    private PDO $pdo;
    private $faker;

    public function __construct(Database $database)
    {
        $this->pdo = $database->medoo()->pdo;
        $this->faker = Factory::create();
    }

    public function seed(string $table, int $count)
    {
        echo "🔄 Generating {$count} dummy records for '{$table}'...\n";

        // Ambil struktur tabel secara otomatis
        $columns = $this->getTableColumns($table);

        if (empty($columns)) {
            echo "❌ Table '{$table}' not found or has no columns!\n";
            return;
        }

        // Loop untuk membuat data dummy
        for ($i = 0; $i < $count; $i++) {
            $data = [];
            foreach ($columns as $column) {
                if ($column['Key'] === 'PRI' || $column['Extra'] === 'auto_increment') {
                    continue; // Skip Primary Key atau Auto Increment
                }

                // Generate data berdasarkan tipe kolom dan nama kolom
                $data[$column['Field']] = $this->generateFakeData($column['Field'], $column['Type']);
            }

            // Insert data ke database
            $this->insert($table, $data);
        }

        echo "✅ Seeding complete!\n";
    }

    private function getTableColumns($table)
    {
        try {
            $stmt = $this->pdo->prepare("SHOW COLUMNS FROM `{$table}`");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "❌ Error fetching columns: " . $e->getMessage() . "\n";
            return [];
        }
    }

    private function generateFakeData($columnName, $type)
    {
        // Jika nama kolom mengandung kata tertentu, atur data sesuai kebutuhan
        if (stripos($columnName, 'name') !== false) {
            return $this->faker->name;
        }
        if (stripos($columnName, 'username') !== false) {
            return $this->faker->userName;
        }
        if (stripos($columnName, 'email') !== false) {
            return $this->faker->unique()->safeEmail;
        }
        if (stripos($columnName, 'password') !== false) {
            return password_hash('password123', PASSWORD_DEFAULT);
        }
        if (stripos($columnName, 'phone') !== false || stripos($columnName, 'nomor') !== false) {
            return $this->faker->phoneNumber;
        }

        // Berdasarkan tipe data MySQL
        if (strpos($type, 'int') !== false) {
            return $this->faker->randomNumber(5);
        }
        if (strpos($type, 'varchar') !== false || strpos($type, 'text') !== false) {
            return $this->faker->sentence;
        }
        if (strpos($type, 'timestamp') !== false || strpos($type, 'datetime') !== false) {
            return date('Y-m-d H:i:s');
        }

        return $this->faker->word; // Default
    }

    private function insert($table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO `{$table}` ({$columns}) VALUES ({$placeholders})";

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($data);
            echo "✅ Inserted into '{$table}': " . json_encode($data) . "\n";
        } catch (PDOException $e) {
            echo "❌ Insert error: " . $e->getMessage() . "\n";
        }
    }
}
