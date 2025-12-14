<?php
// Fix Apache not passing custom headers
if (function_exists('getallheaders')) {
    $headers = getallheaders();
    if (isset($headers['Authentication'])) {
        $_SERVER['HTTP_AUTHENTICATION'] = $headers['Authentication'];
    }
    if (isset($headers['Authorization'])) {
        $_SERVER['HTTP_AUTHORIZATION'] = $headers['Authorization'];
    }
}

require 'vendor/autoload.php';
require 'rest/services/AuthService.php';
require 'middleware/AuthMiddleware.php';
require 'data/Roles.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, Authentication');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

Flight::register('auth_service', 'AuthService');
Flight::register('auth_middleware', 'AuthMiddleware');

Flight::route('/*', function() {
    $url = Flight::request()->url;
    
    if(
        strpos($url, 'login') !== false || 
        strpos($url, 'register') !== false ||
        strpos($url, 'docs') !== false
    ) {
        return TRUE;
    }
    
    try {
        $token = null;
        
        // PRIORITY 1: Check query parameter
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
        }
        
        // PRIORITY 2: Check headers
        if (!$token && isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $token = $_SERVER['HTTP_AUTHORIZATION'];
        } elseif (!$token && isset($_SERVER['HTTP_AUTHENTICATION'])) {
            $token = $_SERVER['HTTP_AUTHENTICATION'];
        }
        
        // Remove "Bearer " prefix if present
        if ($token && strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        }
        
        if (!$token) {
            Flight::halt(401, "Missing authentication header");
        }
        
        Flight::auth_middleware()->verifyToken($token);
        return TRUE;
    } catch (\Exception $e) {
        Flight::halt(401, $e->getMessage());
    }
});

require 'rest/routes/AuthRoutes.php';
require 'rest/routes/users.php';
require 'rest/routes/products.php';
require 'rest/routes/categories.php';
require 'rest/routes/cart.php';
require 'rest/routes/orders.php';
require 'rest/routes/payments.php';

Flight::start();