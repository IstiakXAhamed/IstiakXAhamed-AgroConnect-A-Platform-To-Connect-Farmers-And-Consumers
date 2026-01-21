<?php
session_start();

// Security check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../../View/login.php");
    exit;
}

require_once __DIR__ . "/../../Model/customer/CustomerProductModel.php";

$customerId = $_SESSION['user_id'];

// POST request - Add/Update/Remove cart items
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Add to cart
    if ($action === 'add') {
        $productId = $_POST['productId'];
        $quantity = $_POST['quantity'] ?? 1;

        addToCart($customerId, $productId, $quantity);
        header("Location: cartController.php?success=Added to cart");

        exit;
    }

    // Update quantity
    if ($action === 'update') {
        $cartId = $_POST['cartId'];


        $quantity = $_POST['quantity'];

        updateCartQuantity($cartId, $quantity);

        header("Location: cartController.php?success=Updated");
        exit;
    }


    // Remove from cart
    if ($action === 'remove') {
        $cartId = $_POST['cartId'];
        removeFromCart($cartId);
        header("Location: cartController.php?success=Removed");
        exit;
    }
}

// GET - Show cart
$cartItems = getCartItems($customerId);
$cartTotal = getCartTotal($customerId);
$cartCount = getCartCount($customerId);

require_once __DIR__ . "/../../View/customer/cart.php";
