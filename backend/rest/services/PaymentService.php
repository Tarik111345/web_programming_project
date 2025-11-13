<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/PaymentDAO.php';

class PaymentService extends BaseService {
    public function __construct() {
        parent::__construct(new PaymentDAO());
    }

    public function getByOrder($order_id) {
        return $this->dao->getByOrder($order_id);
    }

    public function createPayment($data) {
        if (empty($data['order_id']) || empty($data['amount'])) {
            throw new Exception('Order ID and amount are required');
        }

        if ($data['amount'] <= 0) {
            throw new Exception('Amount must be positive');
        }

        return $this->create($data);
    }
}