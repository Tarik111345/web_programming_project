<?php
require_once __DIR__ . '/../services/CategoryService.php';

$categoryService = new CategoryService();

Flight::route('GET /api/categories', function() use ($categoryService) {
    try {
        $categories = $categoryService->getAll();
        Flight::json($categories);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('GET /api/categories/@id', function($id) use ($categoryService) {
    try {
        $category = $categoryService->getById($id);
        if (!$category) {
            Flight::json(['error' => 'Category not found'], 404);
            return;
        }
        Flight::json($category);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('POST /api/categories', function() use ($categoryService) {
    try {
        $data = Flight::request()->data->getData();
        $result = $categoryService->createCategory($data);
        Flight::json(['message' => 'Category created', 'id' => $result], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /api/categories/@id', function($id) use ($categoryService) {
    try {
        $data = Flight::request()->data->getData();
        $categoryService->update($id, $data);
        Flight::json(['message' => 'Category updated']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('DELETE /api/categories/@id', function($id) use ($categoryService) {
    try {
        $categoryService->delete($id);
        Flight::json(['message' => 'Category deleted']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});