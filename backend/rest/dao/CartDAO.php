<?php
require_once 'BaseDAO.php';

class CartDAO extends BaseDAO {
    public function __construct() {
        parent::__construct("cart");
    }

    public function getByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM cart WHERE user_id = :uid");
        $stmt->bindParam(':uid', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCartWithProducts($user_id) {
        $sql = "SELECT c.*, p.name, p.price, p.image, p.stock,
                       (c.quantity * p.price) as subtotal
                FROM cart c
                JOIN products p ON c.product_id = p.id
                WHERE c.user_id = :uid";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':uid', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function clearCart($user_id) {
        $stmt = $this->connection->prepare("DELETE FROM cart WHERE user_id = :uid");
        $stmt->bindParam(':uid', $user_id);
        return $stmt->execute();
    }
}