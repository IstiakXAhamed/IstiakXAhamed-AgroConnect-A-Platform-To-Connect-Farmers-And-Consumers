<?php
session_start();
require_once __DIR__ . '/../../Model/farmer/productModel.php';

// Security check
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer") {
    header("Location: ../../View/login.php");
    exit;
}

$farmerId = $_SESSION['user_id'];

// POST request - handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    if ($action === "delete") {
        $productId = $_POST['productId'];
        deleteProduct($productId);
        header("Location: productController.php?success=Deleted");
        exit;
    }

    if ($action === "update") {
        $productId = $_POST['productId'];
        $name = $_POST['productName'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $desc = $_POST['description'];
        $categoryId = $_POST['categoryId'];

        $imagePath = "";

        // Image update kori , path update kori
        if (!empty($_FILES['productImage']['name'])) {
            $imgName = time() . "_" . $_FILES['productImage']['name'];
            $tmp = $_FILES['productImage']['tmp_name'];
            move_uploaded_file($tmp, "../../uploads/" . $imgName);
            $imagePath = "uploads/" . $imgName;
        }

        updateProduct($productId, $name, $price, $quantity, $imagePath, $desc, $categoryId);
        header("Location: productController.php?success=Updated");
        exit;
    }

    if ($action === "add") {
        $name = $_POST['productName'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $desc = $_POST['description'];
        $categoryId = $_POST['categoryId'];

        $imagePath = "";
        // Image add kori , path add kori
        if (!empty($_FILES['productImage']['name'])) {
            $imgName = time() . "_" . $_FILES['productImage']['name'];
            $tmp = $_FILES['productImage']['tmp_name'];
            move_uploaded_file($tmp, "../../uploads/" . $imgName);
            $imagePath = "uploads/" . $imgName;
        }

        addProduct($farmerId, $name, $price, $quantity, $imagePath, $desc, $categoryId);
        header("Location: productController.php?success=Added");
        exit;
    }
}

// GET request - show products list
$products = getProductsByFarmer($farmerId);

require_once __DIR__ . "/../../View/farmer/myProducts.php";
