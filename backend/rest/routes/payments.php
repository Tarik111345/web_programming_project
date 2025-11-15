<?php
require_once __DIR__ . '/../services/PaymentService.php';

$paymentService = new PaymentService();

Flight::route('GET /api/payments/order/@orderId', function($orderId) use ($paymentService) {
    try {
        $payments = $paymentService->getByOrder($orderId);
        Flight::json($payments);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('POST /api/payments', function() use ($paymentService) {
    try {
        $data = Flight::request()->data->getData();
        $result = $paymentService->createPayment($data);
        Flight::json(['message' => 'Payment created', 'id' => $result], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});