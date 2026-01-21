<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer")
    {
        header("Location: ../../View/login.php");
        exit;
    }
    $farmerId = $_SESSION["user_id"];

    require_once __DIR__ . "/../../Model/farmer/productModel.php";

    $totalProducts = countFarmerProducts($farmerId);
    $totalEarnings = getTotalEarnings($farmerId);
    $pendingEarning = getPendingEarnings($farmerId);

    require_once __DIR__ . "/../../View/farmer/dashBoard.php";
?>