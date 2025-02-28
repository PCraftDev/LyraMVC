<?php

namespace Lyramvc\Lyramvc\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig
{
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader, [
            'cache' => __DIR__ . '/../storage/cache',
            'debug' => true
        ]);
    }

    public function render($view, $data = [])
    {
        echo $this->twig->render($view . '.twig', $data);
    }
}
