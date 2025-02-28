<?php

namespace Lyramvc\Lyramvc\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    private static $twig = null;

    public static function render($template, $data = [])
    {
        if (self::$twig === null) {
            $loader = new FilesystemLoader(__DIR__ . '/../Views');
            self::$twig = new Environment($loader, [
                'cache' => false, // Set ke 'cache/twig' jika ingin menggunakan cache
            ]);
        }

        // Menghilangkan ekstensi '.twig' jika ada
        $templateFile = rtrim($template, '.twig'); // Menghapus ekstensi .twig jika ada

        echo self::$twig->render($templateFile . '.twig', $data);
    }
}
