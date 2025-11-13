<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/ProductDAO.php';

class ProductService extends BaseService {
    public function __construct() {
        parent::__construct(new ProductDAO());
    }

    public function getByCategory($category_id) {
        return $this->dao->getByCategory($category_id);
    }

    public function createProduct($data) {
        if (empty($data['name']) || empty($data['price']) || empty($data['category_id'])) {
            throw new Exception('Name, price and category are required');
        }

        if ($data['price'] <= 0) {
            throw new Exception('Price must be a positive value');
        }

        if (isset($data['stock']) && $data['stock'] < 0) {
            throw new Exception('Stock cannot be negative');
        }

        return $this->create($data);
    }
}