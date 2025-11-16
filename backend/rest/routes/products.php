<?php
require_once __DIR__ . '/../services/ProductService.php';

$productService = new ProductService();

/**
 * @OA\Get(
 *     path="/api/products",
 *     tags={"Products"},
 *     summary="Get all products",
 *     @OA\Response(
 *         response=200,
 *         description="List of all products"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
Flight::route('GET /api/products', function() use ($productService) {
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
 *     summary="Get product by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product details"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Product not found"
 *     )
 * )
 */
Flight::route('GET /api/products/@id', function($id) use ($productService) {
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
 *     summary="Get products by category",
 *     @OA\Parameter(
 *         name="categoryId",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of products in category"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
Flight::route('GET /api/products/category/@categoryId', function($categoryId) use ($productService) {
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
 *     summary="Create new product",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "price", "category_id"},
 *             @OA\Property(property="name", type="string", example="Whey Protein"),
 *             @OA\Property(property="description", type="string", example="Premium whey protein powder"),
 *             @OA\Property(property="price", type="number", format="float", example=49.99),
 *             @OA\Property(property="category_id", type="integer", example=1),
 *             @OA\Property(property="stock", type="integer", example=100),
 *             @OA\Property(property="image_url", type="string", example="https://example.com/image.jpg")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Product created"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     )
 * )
 */
Flight::route('POST /api/products', function() use ($productService) {
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
 *     summary="Update product",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Product"),
 *             @OA\Property(property="description", type="string", example="Updated description"),
 *             @OA\Property(property="price", type="number", format="float", example=59.99),
 *             @OA\Property(property="stock", type="integer", example=50),
 *             @OA\Property(property="image_url", type="string", example="https://example.com/new-image.jpg")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product updated"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     )
 * )
 */
Flight::route('PUT /api/products/@id', function($id) use ($productService) {
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
 *     summary="Delete product",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product deleted"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
Flight::route('DELETE /api/products/@id', function($id) use ($productService) {
    try {
        $productService->delete($id);
        Flight::json(['message' => 'Product deleted']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});
?>