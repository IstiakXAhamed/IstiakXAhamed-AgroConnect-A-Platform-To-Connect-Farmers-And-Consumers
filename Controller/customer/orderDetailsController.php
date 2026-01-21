<?php
session_start();

// Security check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../../View/login.php");
    exit;
}

require_once __DIR__ . "/../../Model/customer/CustomerProductModel.php";

$customerId = $_SESSION['user_id'];

// Check if order ID provided
if (!isset($_GET['id'])) {
    header("Location: ordersController.php");
    exit;
}

$orderId = $_GET['id'];

// Get order details
$orderItems = getOrderDetails($orderId);

// Get order info (total, status)
$conn = dbConnect();
$orderSql = "SELECT * FROM orders WHERE id = $orderId AND customer_id = $customerId";
$orderResult = mysqli_query($conn, $orderSql);
$order = mysqli_fetch_assoc($orderResult);

// Security: Check if this order belongs to this customer
if (!$order) {
    header("Location: ordersController.php?error=Order not found");
    exit;
}

require_once __DIR__ . "/../../View/customer/orderDetails.php";
