<?php

namespace Lyramvc\Lyramvc\Core;

use Exception;

class CreateController
{
    protected static string $controllerPath = __DIR__ . '/../Controllers/';
    public static function CreateController($arguments)
    {
        // Cek apakah ada argumen modelname
        if (empty($arguments[1])) {
            echo "Model name is required.\n";
            return;
        }

        // Ambil nama model dari argument
        $controllerName = ucfirst($arguments) . 'Model';
        $controllerFile = "{$controllerName}.php";

        // Cek apakah file model sudah ada
        if (file_exists($controllerFile)) {
            echo "Model '{$controllerName}' already exists.\n";
            return;
        }

        // Buat template model yang mewarisi Model.php
        $controllerContent = "<?php

namespace Pcraft\Lyrammvc\Controller;

use Lyramvc\Lyramvc\Core\View;

class UserControllerModell
{
  public function __construct()
  {
    // Menginisialisasi beberapa hal yang akan digunakan
  }
  public function index()

  {         // Mengirim data pengguna ke tampilan untuk dirender
    View::render('view_name', ['title' => 'view_name']); // Render view dengan data
  }
}
";

        // Simpan model ke dalam file
        file_put_contents(
            self::$controllerPath . $controllerFile,
            $controllerContent
        );

        echo "Model '{$controllerName}' has been created successfully \n";
    }
}
