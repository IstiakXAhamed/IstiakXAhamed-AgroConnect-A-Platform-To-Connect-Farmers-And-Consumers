<?php
session_start();

// Farmer security check
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer") {
    header("Location: ../../View/login.php");
    exit;
}

$farmerId = $_SESSION["user_id"];

require_once __DIR__ . "/../../Model/farmer/productModel.php";

// Stats collect kori (Admin style)
$totalProducts = countFarmerProducts($farmerId);
$totalSales = getFarmerTotalSales($farmerId);
$completedOrders = getCompletedOrdersCount($farmerId);
$pendingEarnings = getPendingEarnings($farmerId);

// Commission calculate kori
$commissionRate = getCommissionRate();
$commissionAmount = $totalSales * ($commissionRate / 100);
$netProfit = $totalSales - $commissionAmount;

// Recent 10 sales collect kori
$recentSales = getFarmerRecentSales($farmerId);

// View load kori
require_once __DIR__ . "/../../View/farmer/dashBoard.php";
