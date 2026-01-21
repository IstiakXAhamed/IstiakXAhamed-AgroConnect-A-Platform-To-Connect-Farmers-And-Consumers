<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../Controller/loginController.php");
    exit;
}
require_once __DIR__ . "/../Model/customer/CustomerProductModel.php";



//data load into customer page from farmer
$products = getAllActiveProducts();


require_once "../../View/customer/customerDashboard.php";