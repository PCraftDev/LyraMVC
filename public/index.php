<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Lyramvc\Lyramvc\Core\Router;

require_once __DIR__ . '/../router/web.php';

Router::run();