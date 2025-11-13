<?php
require_once 'BaseDAO.php';

class PaymentDAO extends BaseDAO {
    public function __construct() {
        parent::__construct("payments");
    }

    public function getByOrder($order_id) {
        $stmt = $this->connection->prepare("SELECT * FROM payments WHERE order_id = :oid");
        $stmt->bindParam(':oid', $order_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
