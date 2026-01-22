<?php
session_start();

// Simple Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

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

use App\Core\Router;
use App\Core\Config;

// Define Routes
$router = new Router();

// Auth Routes
$router->get('/', ['App\Controllers\AuthController', 'login']); // Default to login if not authenticated
$router->get('/login', ['App\Controllers\AuthController', 'login']);
$router->post('/login', ['App\Controllers\AuthController', 'authenticate']);
$router->get('/register', ['App\Controllers\AuthController', 'register']);
$router->post('/register', ['App\Controllers\AuthController', 'store']);
$router->get('/logout', ['App\Controllers\AuthController', 'logout']);

// App Routes (Protected)
$router->get('/dashboard', ['App\Controllers\ExpenseController', 'index']);
$router->get('/api/expenses', ['App\Controllers\ExpenseController', 'list']);
$router->post('/api/expenses', ['App\Controllers\ExpenseController', 'create']);
$router->post('/api/expenses/delete', ['App\Controllers\ExpenseController', 'delete']);

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
