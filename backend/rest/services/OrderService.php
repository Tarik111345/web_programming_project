<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/OrderDAO.php';

class OrderService extends BaseService {
    public function __construct() {
        parent::__construct(new OrderDAO());
    }

    public function getByUserId($user_id) {
        return $this->dao->getByUserId($user_id);
    }

    public function createOrder($data) {
        if (empty($data['user_id']) || empty($data['total']) || empty($data['shipping_address'])) {
            throw new Exception('User ID, total and shipping address are required');
        }

        if ($data['total'] <= 0) {
            throw new Exception('Total must be a positive value');
        }

        return $this->create($data);
    }
}