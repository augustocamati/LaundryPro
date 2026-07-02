<?php

namespace App\Core;

class Router {
    private array $routes = [];

    /**
     * Register a route with method, path, and controller handler.
     *
     * @param string $method
     * @param string $path
     * @param string $handler "ControllerName@methodName"
     */
    public function add(string $method, string $path, string $handler): void {
        // Convert path to regex (e.g. /usuarios/{id}/editar -> /usuarios/(?P<id>[^/]+)/editar)
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';
        
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }

    public function get(string $path, string $handler): void {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, string $handler): void {
        $this->add('POST', $path, $handler);
    }

    /**
     * Match request and dispatch to controller.
     */
    public function dispatch(string $method, string $uri): void {
        // Remove trailing slashes and query parameters
        $uri = rtrim($uri, '/');
        if (empty($uri)) {
            $uri = '/';
        }

        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                list($controllerClass, $action) = explode('@', $route['handler']);
                $fullControllerClass = "App\\Controllers\\" . $controllerClass;
                
                if (class_exists($fullControllerClass)) {
                    $controller = new $fullControllerClass();
                    if (method_exists($controller, $action)) {
                        call_user_func_array([$controller, $action], $params);
                        return;
                    }
                }
                
                $this->sendNotFound("Action $action not found in $fullControllerClass.");
                return;
            }
        }

        $this->sendNotFound("Route not found for $method $uri.");
    }

    private function sendNotFound(string $message = 'Not Found'): void {
        http_response_code(404);
        echo "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <title>404 - Não Encontrado</title>
            <style>
                body { font-family: sans-serif; text-align: center; padding: 50px; background-color: #f8fafc; color: #334155; }
                h1 { color: #64748b; font-size: 48px; margin-bottom: 10px; }
                p { font-size: 18px; }
                a { color: #2563eb; text-decoration: none; font-weight: bold; }
            </style>
        </head>
        <body>
            <h1>404</h1>
            <p>Página não encontrada!</p>
            <p><small>{$message}</small></p>
            <p><a href='/'>Voltar ao Painel</a></p>
        </body>
        </html>";
    }
}
