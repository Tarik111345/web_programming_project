<?php
require_once __DIR__ . '/../services/ProductService.php';

$productService = new ProductService();

/**
 * @OA\Get(
 *     path="/api/products",
 *     tags={"Products"},
 *     summary="Get all products"
 * )
 */
Flight::route('GET /api/products', function() use ($productService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    try {
        $products = $productService->getAll();
        Flight::json($products);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/api/products/{id}",
 *     tags={"Products"},
 *     summary="Get product by ID"
 * )
 */
Flight::route('GET /api/products/@id', function($id) use ($productService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    try {
        $product = $productService->getById($id);
        if (!$product) {
            Flight::json(['error' => 'Product not found'], 404);
            return;
        }
        Flight::json($product);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/api/products/category/{categoryId}",
 *     tags={"Products"},
 *     summary="Get products by category"
 * )
 */
Flight::route('GET /api/products/category/@categoryId', function($categoryId) use ($productService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    try {
        $products = $productService->getByCategory($categoryId);
        Flight::json($products);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Post(
 *     path="/api/products",
 *     tags={"Products"},
 *     summary="Create new product - ADMIN ONLY"
 * )
 */
Flight::route('POST /api/products', function() use ($productService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    try {
        $data = Flight::request()->data->getData();
        $result = $productService->createProduct($data);
        Flight::json(['message' => 'Product created', 'id' => $result], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Put(
 *     path="/api/products/{id}",
 *     tags={"Products"},
 *     summary="Update product - ADMIN ONLY"
 * )
 */
Flight::route('PUT /api/products/@id', function($id) use ($productService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    try {
        $data = Flight::request()->data->getData();
        $productService->update($id, $data);
        Flight::json(['message' => 'Product updated']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Delete(
 *     path="/api/products/{id}",
 *     tags={"Products"},
 *     summary="Delete product - ADMIN ONLY"
 * )
 */
Flight::route('DELETE /api/products/@id', function($id) use ($productService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    try {
        $productService->delete($id);
        Flight::json(['message' => 'Product deleted']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});
?>