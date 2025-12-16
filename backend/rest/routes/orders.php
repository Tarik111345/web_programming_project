<?php
require_once __DIR__ . '/../services/OrderService.php';
require_once __DIR__ . '/../services/OrderItemService.php';

$orderService = new OrderService();
$orderItemService = new OrderItemService();

/**
 * @OA\Get(
 *     path="/api/orders",
 *     tags={"Orders"},
 *     summary="Get all orders"
 * )
 */
Flight::route('GET /api/orders', function() use ($orderService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    try {
        $orders = $orderService->getAll();
        Flight::json($orders);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/api/orders/{id}",
 *     tags={"Orders"},
 *     summary="Get order by ID with items"
 * )
 */
Flight::route('GET /api/orders/@id', function($id) use ($orderService, $orderItemService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
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

/**
 * @OA\Get(
 *     path="/api/orders/user/{userId}",
 *     tags={"Orders"},
 *     summary="Get all orders for a user"
 * )
 */
Flight::route('GET /api/orders/user/@userId', function($userId) use ($orderService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    try {
        $orders = $orderService->getByUserId($userId);
        Flight::json($orders);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Post(
 *     path="/api/orders",
 *     tags={"Orders"},
 *     summary="Create new order"
 * )
 */
Flight::route('POST /api/orders', function() use ($orderService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    try {
        $data = Flight::request()->data->getData();
        $result = $orderService->createOrder($data);
        Flight::json(['message' => 'Order created', 'id' => $result], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Put(
 *     path="/api/orders/{id}",
 *     tags={"Orders"},
 *     summary="Update order status"
 * )
 */
Flight::route('PUT /api/orders/@id', function($id) use ($orderService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    try {
        $data = Flight::request()->data->getData();
        $orderService->update($id, $data);
        Flight::json(['message' => 'Order updated']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});
?>