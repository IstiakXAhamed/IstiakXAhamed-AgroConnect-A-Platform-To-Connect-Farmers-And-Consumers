<?php
session_start();

// Farmer security check
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer") {
    header("Location: ../../View/login.php");
    exit;
}

// Product ID check
if (!isset($_GET['id'])) {
    header("Location: productController.php");
    exit;
}

require_once __DIR__ . '/../../Model/farmer/productModel.php';

$productId = $_GET['id'];
$product = getProductById($productId);

if (!$product) {
    header("Location: productController.php");
    exit;
}

// View load kori
require_once __DIR__ . "/../../View/farmer/editProduct.php";
