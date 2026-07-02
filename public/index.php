<?php

/**
 * LaundryPro Bootstrap & Front Controller
 */

define('BASE_PATH', dirname(__DIR__));

// Register PSR-4 Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = BASE_PATH . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Load environment variables early
\App\Core\Database::loadEnv();

// Enable error reporting based on APP_DEBUG
$debug = getenv('APP_DEBUG') === 'true';
if ($debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Load the router configuration
$router = require BASE_PATH . '/routes/web.php';

// Dispatch the current request
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = $_SERVER['REQUEST_URI'] ?? '/';

try {
    $router->dispatch($method, $uri);
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<!DOCTYPE html>
    <html>
    <head>
        <meta charset='utf-8'>
        <title>500 - Erro Interno do Servidor</title>
        <style>
            body { font-family: sans-serif; padding: 50px; background-color: #f8fafc; color: #334155; max-width: 800px; margin: 0 auto; }
            h1 { color: #dc2626; font-size: 32px; margin-bottom: 20px; }
            pre { background-color: #0f172a; color: #f8fafc; padding: 20px; border-radius: 8px; overflow-x: auto; font-size: 14px; line-height: 1.5; }
            a { color: #2563eb; text-decoration: none; font-weight: bold; }
        </style>
    </head>
    <body>
        <h1>Erro Interno do Servidor (500)</h1>
        <p>Ocorreu um erro ao processar a sua requisição:</p>
        <p><strong>" . htmlspecialchars($e->getMessage()) . "</strong></p>";
    
    if ($debug) {
        echo "<h3>Trace:</h3>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    }
    
    echo "<p><a href='/'>Voltar ao Painel</a></p>
    </body>
    </html>";
}
