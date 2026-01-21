<?php
session_start();

// Security check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../../View/login.php");
    exit;
}

require_once __DIR__ . "/../../Model/customer/CustomerProductModel.php";

$customerId = $_SESSION['user_id'];

// Get all orders for this customer
$orders = getCustomerOrders($customerId);

require_once __DIR__ . "/../../View/customer/orders.php";
