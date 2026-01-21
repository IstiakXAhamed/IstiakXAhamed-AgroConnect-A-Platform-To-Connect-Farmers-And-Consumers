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

        // Check stock limit
        $conn = dbConnect();
        $stockCheck = mysqli_query($conn, "SELECT quantity FROM products WHERE id = $productId");
        $product = mysqli_fetch_assoc($stockCheck);
        $maxStock = $product['quantity'];

        if ($quantity > $maxStock) {
            header("Location: customerDashboardController.php?error=Only $maxStock items available");
            exit;
        }

        addToCart($customerId, $productId, $quantity);
        header("Location: cartController.php?success=Added to cart");
        exit;
    }

    // Update quantity
    if ($action === 'update') {
        $cartId = $_POST['cartId'];
        $quantity = $_POST['quantity'];

        // Check stock limit before update
        $conn = dbConnect();
        $cartItem = mysqli_query($conn, "SELECT product_id FROM cart WHERE id = $cartId");
        $item = mysqli_fetch_assoc($cartItem);
        $productId = $item['product_id'];

        $stockCheck = mysqli_query($conn, "SELECT quantity FROM products WHERE id = $productId");
        $product = mysqli_fetch_assoc($stockCheck);
        $maxStock = $product['quantity'];

        if ($quantity > $maxStock) {
            header("Location: cartController.php?error=Only $maxStock items available in stock");
            exit;
        }

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
