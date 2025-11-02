<?php
require_once 'BaseDAO.php';

class ProductDAO extends BaseDAO {
    public function __construct() {
        parent::__construct("products");
    }

    public function getByCategory($category_id) {
        $stmt = $this->connection->prepare("SELECT * FROM products WHERE category_id = :cat");
        $stmt->bindParam(':cat', $category_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
