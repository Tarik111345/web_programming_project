<?php
require_once __DIR__ . '/../services/CartService.php';

$cartService = new CartService();

/**
 * @OA\Get(
 *     path="/api/cart/{userId}",
 *     tags={"Cart"},
 *     summary="Get user's cart with products",
 *     @OA\Parameter(
 *         name="userId",
 *         in="path",
 *         required=true,
 *         description="ID of the user",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cart items with product details"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
Flight::route('GET /api/cart/@userId', function($userId) use ($cartService) {
    try {
        $cart = $cartService->getCartWithProducts($userId);
        Flight::json($cart);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Post(
 *     path="/api/cart",
 *     tags={"Cart"},
 *     summary="Add item to cart",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "product_id", "quantity"},
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="product_id", type="integer", example=5),
 *             @OA\Property(property="quantity", type="integer", example=2)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Item added to cart"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     )
 * )
 */
Flight::route('POST /api/cart', function() use ($cartService) {
    try {
        $data = Flight::request()->data->getData();
        $result = $cartService->addToCart($data);
        Flight::json(['message' => 'Added to cart', 'id' => $result], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Delete(
 *     path="/api/cart/{id}",
 *     tags={"Cart"},
 *     summary="Remove item from cart",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Cart item ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Item removed from cart"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
Flight::route('DELETE /api/cart/@id', function($id) use ($cartService) {
    try {
        $cartService->delete($id);
        Flight::json(['message' => 'Removed from cart']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Delete(
 *     path="/api/cart/user/{userId}",
 *     tags={"Cart"},
 *     summary="Clear entire cart for user",
 *     @OA\Parameter(
 *         name="userId",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cart cleared"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
Flight::route('DELETE /api/cart/user/@userId', function($userId) use ($cartService) {
    try {
        $cartService->clearCart($userId);
        Flight::json(['message' => 'Cart cleared']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});
?>