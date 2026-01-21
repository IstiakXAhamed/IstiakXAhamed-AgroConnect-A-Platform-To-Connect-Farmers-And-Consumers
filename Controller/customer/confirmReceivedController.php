<?php
session_start();

// Security check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../../View/login.php");
    exit;
}

// Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ordersController.php");
    exit;
}

require_once __DIR__ . "/../../Model/customer/CustomerProductModel.php";

$customerId = $_SESSION['user_id'];
$orderId = $_POST['orderId'];

// Verify this order belongs to customer and is approved
$conn = dbConnect();
$checkSql = "SELECT * FROM orders WHERE id = $orderId AND customer_id = $customerId AND status = 'approved'";
$checkResult = mysqli_query($conn, $checkSql);

if (mysqli_num_rows($checkResult) === 0) {
    header("Location: ordersController.php?error=Invalid order");
    exit;
}

// Get order items and deduct stock
$orderItemsSql = "SELECT product_id, quantity FROM order_items WHERE order_id = $orderId";
$orderItemsResult = mysqli_query($conn, $orderItemsSql);

while ($item = mysqli_fetch_assoc($orderItemsResult)) {
    $productId = $item['product_id'];
    $orderedQty = $item['quantity'];

    // Deduct quantity from products table
    $deductSql = "UPDATE products SET quantity = quantity - $orderedQty WHERE id = $productId";
    mysqli_query($conn, $deductSql);
}

// Update order status to 'completed'
$updateSql = "UPDATE orders SET status = 'completed' WHERE id = $orderId";
mysqli_query($conn, $updateSql);

// Redirect with success message
header("Location: orderDetailsController.php?id=$orderId&success=Order marked as completed! Stock updated.");
exit;
