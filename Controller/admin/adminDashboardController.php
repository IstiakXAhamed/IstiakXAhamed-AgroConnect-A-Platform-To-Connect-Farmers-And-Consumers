<?php
session_start();
// admin security check 
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../../View/login.php");
    exit;
}
require_once __DIR__ . "/../../Model/admin/adminModel.php";
require_once __DIR__ . "/../../Model/admin/configModel.php";


// stats collect kori 
$stats = getAdminDashboardStats();

if (!$stats) {
    $stats = array(
        "totalUsers" => "0",
        "pendingUsers" => "0",
        "activeUsers" => "0",
        "totalFarmers" => "0",
        "totalCustomers" => "0",
        "totalTransporters" => "0",
        "totalProducts" => "0",
        "totalOrders" => "0",
        "pendingOrders" => "0",
        "totalRevenue" => "0"
    );
}

// recent users collect kori
$recentUsers = getRecentUsers();

// pending users collect kori
$pendingUsers = getPendingUsers();

// recent orders collect kori
$recentOrders = getRecentOrders();

// view load kori
require_once __DIR__ . "/../../View/admin/dashBoard.php";
