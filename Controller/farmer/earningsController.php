<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer") {
    header("Location: ../../View/login.php");
    exit();
}

require_once __DIR__ . "/../../Model/farmer/productModel.php";

$farmerId = $_SESSION["user_id"];

$totalEarnings    = getTotalEarnings($farmerId);
$pendingEarnings  = getPendingEarnings($farmerId);
$completedOrders  = getCompletedOrdersCount($farmerId);
?>