<?php
require_once __DIR__ . '/../services/CartService.php';

$cartService = new CartService();

Flight::route('GET /api/cart/@userId', function($userId) use ($cartService) {
    try {
        $cart = $cartService->getCartWithProducts($userId);
        Flight::json($cart);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('POST /api/cart', function() use ($cartService) {
    try {
        $data = Flight::request()->data->getData();
        $result = $cartService->addToCart($data);
        Flight::json(['message' => 'Added to cart', 'id' => $result], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('DELETE /api/cart/@id', function($id) use ($cartService) {
    try {
        $cartService->delete($id);
        Flight::json(['message' => 'Removed from cart']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('DELETE /api/cart/user/@userId', function($userId) use ($cartService) {
    try {
        $cartService->clearCart($userId);
        Flight::json(['message' => 'Cart cleared']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});