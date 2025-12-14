<?php
require_once __DIR__ . '/../services/CategoryService.php';

$categoryService = new CategoryService();

/**
 * @OA\Get(
 *     path="/api/categories",
 *     tags={"Categories"},
 *     summary="Get all categories"
 * )
 */
Flight::route('GET /api/categories', function() use ($categoryService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    try {
        $categories = $categoryService->getAll();
        Flight::json($categories);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/api/categories/{id}",
 *     tags={"Categories"},
 *     summary="Get category by ID"
 * )
 */
Flight::route('GET /api/categories/@id', function($id) use ($categoryService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
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

/**
 * @OA\Post(
 *     path="/api/categories",
 *     tags={"Categories"},
 *     summary="Create new category - ADMIN ONLY"
 * )
 */
Flight::route('POST /api/categories', function() use ($categoryService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    try {
        $data = Flight::request()->data->getData();
        $result = $categoryService->createCategory($data);
        Flight::json(['message' => 'Category created', 'id' => $result], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Put(
 *     path="/api/categories/{id}",
 *     tags={"Categories"},
 *     summary="Update category - ADMIN ONLY"
 * )
 */
Flight::route('PUT /api/categories/@id', function($id) use ($categoryService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    try {
        $data = Flight::request()->data->getData();
        $categoryService->update($id, $data);
        Flight::json(['message' => 'Category updated']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Delete(
 *     path="/api/categories/{id}",
 *     tags={"Categories"},
 *     summary="Delete category - ADMIN ONLY"
 * )
 */
Flight::route('DELETE /api/categories/@id', function($id) use ($categoryService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    try {
        $categoryService->delete($id);
        Flight::json(['message' => 'Category deleted']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});
?>