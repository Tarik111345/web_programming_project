<?php
require_once __DIR__ . '/../services/OrderService.php';
require_once __DIR__ . '/../services/OrderItemService.php';

$orderService = new OrderService();
$orderItemService = new OrderItemService();

Flight::route('GET /api/orders', function() use ($orderService) {
    try {
        $orders = $orderService->getAll();
        Flight::json($orders);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('GET /api/orders/@id', function($id) use ($orderService, $orderItemService) {
    try {
        $order = $orderService->getById($id);
        if (!$order) {
            Flight::json(['error' => 'Order not found'], 404);
            return;
        }
        $order['items'] = $orderItemService->getOrderItemsWithProducts($id);
        Flight::json($order);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('GET /api/orders/user/@userId', function($userId) use ($orderService) {
    try {
        $orders = $orderService->getByUserId($userId);
        Flight::json($orders);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('POST /api/orders', function() use ($orderService) {
    try {
        $data = Flight::request()->data->getData();
        $result = $orderService->createOrder($data);
        Flight::json(['message' => 'Order created', 'id' => $result], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /api/orders/@id', function($id) use ($orderService) {
    try {
        $data = Flight::request()->data->getData();
        $orderService->update($id, $data);
        Flight::json(['message' => 'Order updated']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});