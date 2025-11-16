<?php
require_once __DIR__ . '/../services/CategoryService.php';

$categoryService = new CategoryService();

/**
 * @OA\Get(
 *     path="/api/categories",
 *     tags={"Categories"},
 *     summary="Get all categories",
 *     @OA\Response(
 *         response=200,
 *         description="List of all categories"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
Flight::route('GET /api/categories', function() use ($categoryService) {
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
 *     summary="Get category by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category details"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Category not found"
 *     )
 * )
 */
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

/**
 * @OA\Post(
 *     path="/api/categories",
 *     tags={"Categories"},
 *     summary="Create new category",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", example="Protein Powders"),
 *             @OA\Property(property="description", type="string", example="High quality protein supplements")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Category created"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     )
 * )
 */
Flight::route('POST /api/categories', function() use ($categoryService) {
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
 *     summary="Update category",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Category"),
 *             @OA\Property(property="description", type="string", example="Updated description")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category updated"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     )
 * )
 */
Flight::route('PUT /api/categories/@id', function($id) use ($categoryService) {
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
 *     summary="Delete category",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category deleted"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
Flight::route('DELETE /api/categories/@id', function($id) use ($categoryService) {
    try {
        $categoryService->delete($id);
        Flight::json(['message' => 'Category deleted']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});
?>