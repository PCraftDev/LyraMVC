<?php

use Lyramvc\Lyramvc\Core\Router;
use Lyramvc\Lyramvc\Controllers\HomeController;

Router::get('/', [HomeController::class, 'index']);
