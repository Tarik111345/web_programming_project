<?php
require_once 'BaseDAO.php';

class CategoryDAO extends BaseDAO {
    public function __construct() {
        parent::__construct("categories");
    }
}
