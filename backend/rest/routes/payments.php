<?php
require_once __DIR__ . '/../services/PaymentService.php';

$paymentService = new PaymentService();

/**
 * @OA\Get(
 *     path="/api/payments/order/{orderId}",
 *     tags={"Payments"},
 *     summary="Get payments for an order"
 * )
 */
Flight::route('GET /api/payments/order/@orderId', function($orderId) use ($paymentService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
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
 *     summary="Create payment for order"
 * )
 */
Flight::route('POST /api/payments', function() use ($paymentService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    try {
        $data = Flight::request()->data->getData();
        $result = $paymentService->createPayment($data);
        Flight::json(['message' => 'Payment created', 'id' => $result], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});
?>