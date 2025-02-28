<?php

namespace Lyramvc\Lyramvc\Core;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Router
{
    private static array $routes = [];

    public static function get(string $path, array $handler)
    {
        self::$routes[] = ['GET', $path, $handler];
    }

    public static function post(string $path, array $handler)
    {
        self::$routes[] = ['POST', $path, $handler];
    }

    public static function run()
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $r) {
            foreach (self::$routes as $route) {
                [$method, $path, $handler] = $route;
                $r->addRoute($method, $path, $handler);
            }
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                http_response_code(404);
                echo "404 - Not Found";
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                http_response_code(405);
                echo "405 - Method Not Allowed";
                break;
            case \FastRoute\Dispatcher::FOUND:
                [$controller, $method] = $routeInfo[1];
                $vars = $routeInfo[2];

                if (!class_exists($controller)) {
                    throw new \Exception("Controller $controller not found");
                }

                $controllerInstance = new $controller();
                call_user_func_array([$controllerInstance, $method], $vars);
                break;
        }
    }
}
