<?php
require 'vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require 'rest/routes/users.php';
require 'rest/routes/products.php';
require 'rest/routes/categories.php';
require 'rest/routes/cart.php';
require 'rest/routes/orders.php';
require 'rest/routes/payments.php';

Flight::start();