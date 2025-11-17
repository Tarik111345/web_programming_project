<?php
require_once 'rest/services/UserService.php';
require_once 'rest/services/ProductService.php';
require_once 'rest/services/CategoryService.php';
require_once 'rest/services/CartService.php';
require_once 'rest/services/OrderService.php';
require_once 'rest/services/OrderItemService.php';
require_once 'rest/services/PaymentService.php';

echo "<h2>Testing Services Layer</h2>";

try {
    $userService = new UserService();
    $productService = new ProductService();
    $categoryService = new CategoryService();
    $cartService = new CartService();
    $orderService = new OrderService();
    $orderItemService = new OrderItemService();
    $paymentService = new PaymentService();

    echo "<h3>✅ All Services initialized successfully!</h3>";

    echo "<h3>Users:</h3><pre>";
    print_r($userService->getAll());
    echo "</pre>";

    echo "<h3>Products:</h3><pre>";
    print_r($productService->getAll());
    echo "</pre>";

    echo "<h3>Categories:</h3><pre>";
    print_r($categoryService->getAll());
    echo "</pre>";

    echo "<h3>✅ Services Layer working perfectly!</h3>";

} catch (Exception $e) {
    echo "<h3>❌ Error: " . $e->getMessage() . "</h3>";
}
