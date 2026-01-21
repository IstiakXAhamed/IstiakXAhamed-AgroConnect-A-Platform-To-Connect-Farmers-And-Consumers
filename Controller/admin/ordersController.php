<?php
session_start();

// Admin security check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../View/login.php");
    exit;
}

require_once __DIR__ . "/../../Model/dbConnect.php";

$conn = dbConnect();

// Get all orders
$sql = "SELECT orders.*, users.name AS customer_name 
        FROM orders 
        JOIN users ON orders.customer_id = users.id 
        ORDER BY orders.created_at DESC";
$orders = mysqli_query($conn, $sql);

require_once __DIR__ . "/../../View/admin/orders.php";
