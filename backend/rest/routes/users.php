<?php
require_once __DIR__ . '/../services/UserService.php';

$userService = new UserService();

/**
 * @OA\Get(
 *     path="/api/users",
 *     tags={"Users"},
 *     summary="Get all users - ADMIN ONLY"
 * )
 */
Flight::route('GET /api/users', function() use ($userService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    try {
        $users = $userService->getAll();
        Flight::json($users);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Get(
 *     path="/api/users/{id}",
 *     tags={"Users"},
 *     summary="Get user by ID"
 * )
 */
Flight::route('GET /api/users/@id', function($id) use ($userService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    try {
        $user = $userService->getById($id);
        if (!$user) {
            Flight::json(['error' => 'User not found'], 404);
            return;
        }
        Flight::json($user);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

/**
 * @OA\Post(
 *     path="/api/users",
 *     tags={"Users"},
 *     summary="Register new user - ADMIN ONLY"
 * )
 */
Flight::route('POST /api/users', function() use ($userService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    try {
        $data = Flight::request()->data->getData();
        $result = $userService->register($data);
        Flight::json(['message' => 'User created', 'id' => $result], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Put(
 *     path="/api/users/{id}",
 *     tags={"Users"},
 *     summary="Update user - ADMIN ONLY"
 * )
 */
Flight::route('PUT /api/users/@id', function($id) use ($userService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    try {
        $data = Flight::request()->data->getData();
        $userService->update($id, $data);
        Flight::json(['message' => 'User updated']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

/**
 * @OA\Delete(
 *     path="/api/users/{id}",
 *     tags={"Users"},
 *     summary="Delete user - ADMIN ONLY"
 * )
 */
Flight::route('DELETE /api/users/@id', function($id) use ($userService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    try {
        $userService->delete($id);
        Flight::json(['message' => 'User deleted']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});
?>