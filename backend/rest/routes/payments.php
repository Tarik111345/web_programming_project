<?php
require_once __DIR__ . '/../services/PaymentService.php';

$paymentService = new PaymentService();

/**
 * @OA\Get(
 *     path="/api/payments/order/{orderId}",
 *     tags={"Payments"},
 *     summary="Get payments for an order",
 *     @OA\Parameter(
 *         name="orderId",
 *         in="path",
 *         required=true,
 *         description="Order ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of payments for order"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
Flight::route('GET /api/payments/order/@orderId', function($orderId) use ($paymentService) {
    try {
        $payments = $paymentService->getByOrder($orderId);
        Flight::json($payments);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Post(
 *     path="/api/payments",
 *     tags={"Payments"},
 *     summary="Create payment for order",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"order_id", "amount", "payment_method"},
 *             @OA\Property(property="order_id", type="integer", example=1),
 *             @OA\Property(property="amount", type="number", format="float", example=99.99),
 *             @OA\Property(property="payment_method", type="string", example="credit_card"),
 *             @OA\Property(property="status", type="string", example="completed"),
 *             @OA\Property(property="transaction_id", type="string", example="TXN123456789")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Payment created"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     )
 * )
 */
Flight::route('POST /api/payments', function() use ($paymentService) {
    try {
        $data = Flight::request()->data->getData();
        $result = $paymentService->createPayment($data);
        Flight::json(['message' => 'Payment created', 'id' => $result], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});
?>