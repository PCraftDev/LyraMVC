<?php

namespace Lyramvc\Lyramvc\Core;

use Exception;

class CreateModel
{
    protected static string $modelPath = __DIR__ . '/../Models/';
    public static function createModel($arguments)
    {
        // Cek apakah ada argumen modelname
        if (empty($arguments[1])) {
            echo "Model name is required.\n";
            return;
        }

        // Ambil nama model dari argument
        $modelName = ucfirst($arguments) . 'Model';
        $modelFile = "{$modelName}.php";

        // Cek apakah file model sudah ada
        if (file_exists($modelFile)) {
            echo "Model '{$modelName}' already exists.\n";
            return;
        }

        // Buat template model yang mewarisi Model.php
        $modelContent = "<?php\n\n";
        $modelContent .= "namespace Pcraft\Lyrammvc\Models;\n\n";
        $modelContent .= "use Pcraft\Lyrammvc\Models;\n\n"; // Menambahkan use Model
        $modelContent .= "class {$modelName} extends Model\n";
        $modelContent .= "{\n";
        $modelContent .= "public function __construct()
    {
        // Menginisialisasi Model dengan Database dan menentukan nama tabel 'users'
        parent::__construct('<NamaTable>');
    }";
        $modelContent .= "    // Anda bisa menambahkan properti dan metode khusus di sini\n";
        $modelContent .= "}\n";

        // Simpan model ke dalam file
        file_put_contents(
            self::$modelPath . $modelFile,
            $modelContent
        );

        echo "Model '{$modelName}' has been created successfully \n";
    }
}
