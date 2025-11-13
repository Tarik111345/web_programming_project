<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/OrderItemDAO.php';

class OrderItemService extends BaseService {
    public function __construct() {
        parent::__construct(new OrderItemDAO());
    }

    public function getByOrderId($order_id) {
        return $this->dao->getByOrderId($order_id);
    }

    public function getOrderItemsWithProducts($order_id) {
        return $this->dao->getOrderItemsWithProducts($order_id);
    }
}