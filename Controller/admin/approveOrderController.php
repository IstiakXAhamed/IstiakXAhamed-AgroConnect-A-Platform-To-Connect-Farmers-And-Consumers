<?php
session_start();

// Admin security check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../View/login.php");
    exit;
}

// Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ordersController.php");
    exit;
}

require_once __DIR__ . "/../../Model/dbConnect.php";

$orderId = $_POST['orderId'];
$conn = dbConnect();

// Update order status to approved
$sql = "UPDATE orders SET status = 'approved' WHERE id = $orderId";
mysqli_query($conn, $sql);

header("Location: ordersController.php?success=Order #$orderId approved!");
exit;
