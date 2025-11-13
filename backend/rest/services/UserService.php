<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/UserDAO.php';

class UserService extends BaseService {
    public function __construct() {
        parent::__construct(new UserDAO());
    }

    public function getByEmail($email) {
        return $this->dao->getByEmail($email);
    }

    public function register($data) {
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            throw new Exception('Name, email and password are required');
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }

        if (strlen($data['password']) < 6) {
            throw new Exception('Password must be at least 6 characters');
        }

        $existingUser = $this->getByEmail($data['email']);
        if ($existingUser) {
            throw new Exception('Email already exists');
        }

        return $this->create($data);
    }
}