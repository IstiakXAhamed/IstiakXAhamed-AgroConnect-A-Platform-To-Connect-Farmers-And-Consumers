<?php
session_start();
require_once __DIR__ . '/../../Model/farmer/productModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../View/farmer/dashBoard.php");
    exit;
}

$action = $_POST['action'] ?? '';

if ($action === "delete") {

    $productId = $_POST['productId'];
    deleteProduct($productId);

    header("Location: ../../View/farmer/myProducts.php?success=Deleted");
    exit;
}

if ($action === "update") {

    $productId = $_POST['productId'];
    $name = $_POST['productName'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $desc = $_POST['description'];

    $imagePath = $product['image'];

    if (!empty($_FILES['productImage']['name'])) {
        $imgName = time() . "_" . $_FILES['productImage']['name'];
        $tmp = $_FILES['productImage']['tmp_name'];

        move_uploaded_file($tmp, "../../uploads/" . $imgName);
        $imagePath = "uploads/" . $imgName;
    }

    updateProduct($productId, $name, $price, $quantity, $imagePath, $desc);

    header("Location: ../../View/farmer/myProducts.php?success=Updated");
    exit;
}

if ($action === "add") {

    $farmerId = $_SESSION['user_id'];
    $name = $_POST['productName'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $desc = $_POST['description'];

    $imagePath = "";

    if (!empty($_FILES['productImage']['name'])) {
        $imgName = time() . "_" . $_FILES['productImage']['name'];
        $tmp = $_FILES['productImage']['tmp_name'];

        move_uploaded_file($tmp, "../../uploads/" . $imgName);
        $imagePath = "uploads/" . $imgName;
    }

    addProduct($farmerId, $name, $price, $quantity, $imagePath, $desc);

    header("Location: ../../View/farmer/myProducts.php?success=Added");
    exit;
}

header("Location: ../../View/farmer/dashBoard.php");
exit;
?>
