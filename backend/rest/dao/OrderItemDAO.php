<?php
require_once 'BaseDAO.php';

class OrderItemDAO extends BaseDAO {
    public function __construct() {
        parent::__construct("order_items");
    }

    public function getByOrderId($order_id) {
        $stmt = $this->connection->prepare("SELECT * FROM order_items WHERE order_id = :oid");
        $stmt->bindParam(':oid', $order_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOrderItemsWithProducts($order_id) {
        $sql = "SELECT oi.*, p.name, p.image,
                       (oi.quantity * oi.price_at_purchase) as item_total
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = :oid";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':oid', $order_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}