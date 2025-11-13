<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/CategoryDAO.php';

class CategoryService extends BaseService {
    public function __construct() {
        parent::__construct(new CategoryDAO());
    }

    public function createCategory($data) {
        if (empty($data['name'])) {
            throw new Exception('Category name is required');
        }
        return $this->create($data);
    }
}