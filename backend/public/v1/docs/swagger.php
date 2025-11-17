<?php
ini_set('display_errors', 0);
error_reporting(0);


if (ob_get_level()) {
    ob_end_clean();
}

require __DIR__ . '/../../../vendor/autoload.php';

use OpenApi\Generator;

// Define BASE_URL
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    define('BASE_URL', 'http://localhost/hadrofit/backend');
} else {
    define('BASE_URL', 'https://production-server-url/backend');
}

try {
    $openapi = Generator::scan([
        __DIR__ . '/doc_setup.php',
        __DIR__ . '/../../../rest/routes'
    ]);
    
    header('Content-Type: application/json');
    echo $openapi->toJson();
    
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}