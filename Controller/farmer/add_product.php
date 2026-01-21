<?php
session_start();

// Security check
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer") {
    header("Location: ../../View/login.php");
    exit;
}

require_once __DIR__ . "/../../Model/farmer/productModel.php";

// Get categories for dropdown
$categories = getAllCategories();

// Show add product form
require_once __DIR__ . "/../../View/farmer/addProduct.php";
