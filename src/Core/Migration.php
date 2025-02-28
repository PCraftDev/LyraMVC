<?php

namespace Lyramvc\Lyramvc\Core;

use PDO;
use Exception;

class Migration
{
    protected static string $migrationPath = __DIR__ . '/../Migration/';
    protected static string $cachePath = __DIR__ . '/../Migration/cache/';

    /**
     * Menjalankan semua migration yang belum dieksekusi
     */
    public static function runMigrations(PDO $pdo)
    {
        // Pastikan folder cache ada
        if (!is_dir(self::$cachePath)) {
            mkdir(self::$cachePath, 0777, true);
        }

        // Ambil semua file migration
        $migrations = glob(self::$migrationPath . '*.php');
        $executedMigrations = glob(self::$cachePath . '*.php');

        // Ubah menjadi array nama file saja
        $executedFiles = array_map('basename', $executedMigrations);

        foreach ($migrations as $migration) {
            $fileName = basename($migration);

            if (in_array($fileName, $executedFiles)) {
                echo "⚠️  Skipping: $fileName (already executed)\n";
                continue;
            }

            require_once $migration;
            $className = pathinfo($fileName, PATHINFO_FILENAME);

            if (class_exists($className)) {
                $migrationInstance = new $className();
                if (method_exists($migrationInstance, 'up')) {
                    try {
                        $migrationInstance->up($pdo);
                        echo "✅ Migrated: $fileName\n";
                        copy($migration, self::$cachePath . $fileName);
                    } catch (Exception $e) {
                        echo "❌ Error in $fileName: " . $e->getMessage() . "\n";
                    }
                } else {
                    echo "⚠️  No 'up' method found in $fileName\n";
                }
            } else {
                echo "❌ Class $className not found in $fileName\n";
            }
        }
    }

    /**
     * Membuat file migration baru
     */
    public static function createMigration($tableName)
    {
        // Format nama file
        $timestamp = date('Ymd_His');
        $className = '_' . ucfirst($timestamp) . '_create_' . ucfirst($tableName) . '_table';
        $fileName = "{$className}.php";

        // Template migration
        $template = <<<PHP
<?php

class $className
{
    public function up(\$pdo)
    {
        \$query = "CREATE TABLE IF NOT EXISTS {$tableName} (
            id INT AUTO_INCREMENT PRIMARY KEY
        )";
        \$pdo->exec(\$query);
    }
}
PHP;


        // Simpan file migration
        file_put_contents(self::$migrationPath . $fileName, $template);
        echo "✅ Migration file created: $fileName\n";
    }
}