<?php
require_once __DIR__ . '/../services/ProductService.php';

$productService = new ProductService();

Flight::route('GET /api/products', function() use ($productService) {
    try {
        $products = $productService->getAll();
        Flight::json($products);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

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

Flight::route('GET /api/products/category/@categoryId', function($categoryId) use ($productService) {
    try {
        $products = $productService->getByCategory($categoryId);
        Flight::json($products);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('POST /api/products', function() use ($productService) {
    try {
        $data = Flight::request()->data->getData();
        $result = $productService->createProduct($data);
        Flight::json(['message' => 'Product created', 'id' => $result], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /api/products/@id', function($id) use ($productService) {
    try {
        $data = Flight::request()->data->getData();
        $productService->update($id, $data);
        Flight::json(['message' => 'Product updated']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('DELETE /api/products/@id', function($id) use ($productService) {
    try {
        $productService->delete($id);
        Flight::json(['message' => 'Product deleted']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});