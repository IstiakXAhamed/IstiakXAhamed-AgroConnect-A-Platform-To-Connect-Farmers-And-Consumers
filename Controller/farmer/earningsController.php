<?php
session_start();

// Farmer security check
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer") {
    header("Location: ../../View/login.php");
    exit;
}

require_once __DIR__ . "/../../Model/farmer/productModel.php";

$farmerId = $_SESSION["user_id"];

// Stats collect kori
$totalEarnings = getTotalEarnings($farmerId);
$pendingEarnings = getPendingEarnings($farmerId);
$completedOrders = getCompletedOrdersCount($farmerId);

// Commission calculate kori
$commissionRate = getCommissionRate();
$totalCommission = $totalEarnings * ($commissionRate / 100);
$netProfit = $totalEarnings - $totalCommission;

// ALL orders collect kori (with customer name)
$allOrders = getAllFarmerOrders($farmerId);

// View load kori
require_once __DIR__ . "/../../View/farmer/earnings.php";
