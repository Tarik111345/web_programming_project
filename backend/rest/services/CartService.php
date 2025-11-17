<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/CartDAO.php';

class CartService extends BaseService {
    public function __construct() {
        parent::__construct(new CartDAO());
    }

    public function getByUserId($user_id) {
        return $this->dao->getByUserId($user_id);
    }

    public function getCartWithProducts($user_id) {
        return $this->dao->getCartWithProducts($user_id);
    }

    public function addToCart($data) {
        if (empty($data['user_id']) || empty($data['product_id']) || empty($data['quantity'])) {
            throw new Exception('User ID, Product ID and quantity are required');
        }

        if ($data['quantity'] <= 0) {
            throw new Exception('Quantity must be positive');
        }

        return $this->create($data);
    }

    public function clearCart($user_id) {
        return $this->dao->clearCart($user_id);
    }
}