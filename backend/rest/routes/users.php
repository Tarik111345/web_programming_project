<?php
require_once __DIR__ . '/../services/UserService.php';

$userService = new UserService();

Flight::route('GET /api/users', function() use ($userService) {
    try {
        $users = $userService->getAll();
        Flight::json($users);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});

Flight::route('GET /api/users/@id', function($id) use ($userService) {
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

Flight::route('POST /api/users', function() use ($userService) {
    try {
        $data = Flight::request()->data->getData();
        $result = $userService->register($data);
        Flight::json(['message' => 'User created', 'id' => $result], 201);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('PUT /api/users/@id', function($id) use ($userService) {
    try {
        $data = Flight::request()->data->getData();
        $userService->update($id, $data);
        Flight::json(['message' => 'User updated']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

Flight::route('DELETE /api/users/@id', function($id) use ($userService) {
    try {
        $userService->delete($id);
        Flight::json(['message' => 'User deleted']);
    } catch (Exception $e) {
        Flight::json(['error' => $e->getMessage()], 500);
    }
});