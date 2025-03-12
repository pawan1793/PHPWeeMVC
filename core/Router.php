<?php

namespace Core;

class Router {
    private static $routes = [];

    public static function get($uri, $controller) {
        self::$routes['GET'][$uri] = $controller;
    }

    public static function post($uri, $controller) {
        self::$routes['POST'][$uri] = $controller;
    }

    public static function dispatch($uri, $method) {
        $uri = trim(parse_url($uri, PHP_URL_PATH), '/');
        $uri = $uri === '' ? '' : $uri; // Ensure empty path maps to "/"
       

        if (isset(self::$routes[$method][$uri])) {
            [$controller, $action] = explode('@', self::$routes[$method][$uri]);
            $controller = "App\\Controllers\\$controller";

            if (class_exists($controller) && method_exists($controller, $action)) {
                $response = call_user_func([new $controller, $action]);

                if (is_string($response)) {
                    echo $response; // Supports Blade rendering directly
                } elseif (is_array($response)) {
                    echo json_encode($response); // Returns JSON for APIs
                } else {
                    echo "Invalid response type";
                }
                
            } else {
                http_response_code(404);
                echo "404 - Not Found";
            }
        } else {
            http_response_code(404);
            echo "404 - Not Found";
        }
    }
}
