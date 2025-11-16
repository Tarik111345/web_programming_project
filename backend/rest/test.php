<?php
require_once 'dao/UserDAO.php';
require_once 'dao/ProductDAO.php';
require_once 'dao/CategoryDAO.php';
require_once 'dao/OrderDAO.php';
require_once 'dao/PaymentDAO.php';
require_once 'dao/CartDAO.php';
require_once 'dao/OrderItemDAO.php';

$userDao = new UserDAO();
$productDao = new ProductDAO();
$categoryDao = new CategoryDAO();
$orderDao = new OrderDAO();
$paymentDao = new PaymentDAO();
$cartDao = new CartDAO();
$orderItemDao = new OrderItemDAO();

echo "<h2>Testing DAO Layer - HadroFit</h2>";

echo "<h3>Users:</h3>";
echo "<pre>";
print_r($userDao->getAll());
echo "</pre>";

echo "<h3>Categories:</h3>";
echo "<pre>";
print_r($categoryDao->getAll());
echo "</pre>";

echo "<h3>Products:</h3>";
echo "<pre>";
print_r($productDao->getAll());
echo "</pre>";

echo "<h3>Cart:</h3>";
echo "<pre>";
print_r($cartDao->getAll());
echo "</pre>";

echo "<h3>Orders:</h3>";
echo "<pre>";
print_r($orderDao->getAll());
echo "</pre>";

echo "<h3>Order Items:</h3>";
echo "<pre>";
print_r($orderItemDao->getAll());
echo "</pre>";

echo "<h3>Payments:</h3>";
echo "<pre>";
print_r($paymentDao->getAll());
echo "</pre>";

echo "<h3>All DAO tests completed!</h3>";