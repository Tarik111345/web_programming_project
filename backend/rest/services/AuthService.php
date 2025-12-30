<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/AuthDAO.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService extends BaseService {
    private $auth_dao;
    
    public function __construct() {
        $this->auth_dao = new AuthDAO();
        parent::__construct(new AuthDAO());
    }

    public function get_user_by_email($email){
        return $this->auth_dao->get_user_by_email($email);
    }

    public function register($entity) {
        // Validate required fields
        if (empty($entity['email']) || empty($entity['password']) || empty($entity['name'])) {
            return ['success' => false, 'error' => 'Name, email and password are required.'];
        }

        // Validate name length (min 3 characters)
        if (strlen(trim($entity['name'])) < 3) {
            return ['success' => false, 'error' => 'Name must be at least 3 characters long.'];
        }

        // Validate email format
        if (!filter_var($entity['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Invalid email format.'];
        }

        // Validate password length (6-20 characters)
        if (strlen($entity['password']) < 6) {
            return ['success' => false, 'error' => 'Password must be at least 6 characters long.'];
        }
        if (strlen($entity['password']) > 20) {
            return ['success' => false, 'error' => 'Password cannot be longer than 20 characters.'];
        }

        $email_exists = $this->auth_dao->get_user_by_email($entity['email']);
        if($email_exists){
            return ['success' => false, 'error' => 'Email already registered.'];
        }

        // Add default role if not provided
        if (!isset($entity['role']) || empty($entity['role'])) {
            $entity['role'] = Roles::USER;
        }

        $entity['password'] = password_hash($entity['password'], PASSWORD_BCRYPT);
        $entity = parent::add($entity);
        unset($entity['password']);

        return ['success' => true, 'data' => $entity];
    }

    public function login($entity) {  
        if (empty($entity['email']) || empty($entity['password'])) {
            return ['success' => false, 'error' => 'Email and password are required.'];
        }

        $user = $this->auth_dao->get_user_by_email($entity['email']);
        if(!$user){
            return ['success' => false, 'error' => 'Invalid username or password.'];
        }

        if(!password_verify($entity['password'], $user['password']))
            return ['success' => false, 'error' => 'Invalid username or password.'];

        unset($user['password']);
       
        $jwt_payload = [
            'user' => $user,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24)
        ];

        $token = JWT::encode(
            $jwt_payload,
            Database::JWT_SECRET(),
            'HS256'
        );

        return ['success' => true, 'data' => array_merge($user, ['token' => $token])];             
    }
}