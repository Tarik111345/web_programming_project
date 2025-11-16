<?php
require_once __DIR__ . '/../services/OrderService.php';
require_once __DIR__ . '/../services/OrderItemService.php';

$orderService = new OrderService();
$orderItemService = new OrderItemService();

/**
 * @OA\Get(
 *     path="/api/orders",
 *     tags={"Orders"},
 *     summary="Get all orders",
 *     @OA\Response(
 *         response=200,
 *         description="List of all orders"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
Flight::route('GET /api/orders', function() use ($orderService) {
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
 *     summary="Get order by ID with items",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order details with items"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Order not found"
 *     )
 * )
 */
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

/**
 * @OA\Get(
 *     path="/api/orders/user/{userId}",
 *     tags={"Orders"},
 *     summary="Get all orders for a user",
 *     @OA\Parameter(
 *         name="userId",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of user orders"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
Flight::route('GET /api/orders/user/@userId', function($userId) use ($orderService) {
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
 *     summary="Create new order",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "total_amount", "status"},
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="total_amount", type="number", format="float", example=99.99),
 *             @OA\Property(property="status", type="string", example="pending"),
 *             @OA\Property(property="shipping_address", type="string", example="123 Main St, City, Country")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Order created"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     )
 * )
 */
Flight::route('POST /api/orders', function() use ($orderService) {
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
 *     summary="Update order status",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Order ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="shipped"),
 *             @OA\Property(property="tracking_number", type="string", example="TRACK123456")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Order updated"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     )
 * )
 */
Flight::route('PUT /api/orders/@id', function($id) use ($orderService) {
    try {
        $data = Flight::request()->data->getData();
        $orderService->update($id, $data);
        Flight::json(['message' => 'Order updated']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});
?>