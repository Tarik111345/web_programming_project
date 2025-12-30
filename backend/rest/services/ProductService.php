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

        // Validate name length (min 3 characters)
        if (strlen(trim($data['name'])) < 3) {
            throw new Exception('Product name must be at least 3 characters long');
        }

        if ($data['price'] <= 0) {
            throw new Exception('Price must be a positive value');
        }

        if (isset($data['stock']) && $data['stock'] < 0) {
            throw new Exception('Stock cannot be negative');
        }

        // Validate category_id is positive integer
        if (!is_numeric($data['category_id']) || $data['category_id'] < 1) {
            throw new Exception('Invalid category ID');
        }

        // Fix: Convert image_url to image for database
        if (isset($data['image_url'])) {
            $data['image'] = $data['image_url'];
            unset($data['image_url']);
        }

        // Use add() instead of create() to get the inserted ID
        $result = $this->add($data);
        return $result['id'];
    }

    public function updateProduct($id, $data) {
        // Validate name if provided
        if (isset($data['name']) && strlen(trim($data['name'])) < 3) {
            throw new Exception('Product name must be at least 3 characters long');
        }

        // Validate price if provided
        if (isset($data['price']) && $data['price'] <= 0) {
            throw new Exception('Price must be a positive value');
        }

        // Validate stock if provided
        if (isset($data['stock']) && $data['stock'] < 0) {
            throw new Exception('Stock cannot be negative');
        }

        // Validate category_id if provided
        if (isset($data['category_id']) && (!is_numeric($data['category_id']) || $data['category_id'] < 1)) {
            throw new Exception('Invalid category ID');
        }

        // Fix: Convert image_url to image for database
        if (isset($data['image_url'])) {
            $data['image'] = $data['image_url'];
            unset($data['image_url']);
        }

        return $this->update($id, $data);
    }
}