<?php
session_start();

// Security check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../../View/login.php");
    exit;
}

require_once __DIR__ . "/../../Model/customer/CustomerProductModel.php";

$customerId = $_SESSION['user_id'];

// Get cart total
$cartTotal = getCartTotal($customerId);

// Check if cart is empty
if ($cartTotal <= 0) {
    header("Location: cartController.php?error=Cart is empty");
    exit;
}

// Get cart items
$cartItems = getCartItems($customerId);

// Create new order
$orderId = placeOrder($customerId, $cartTotal);

if ($orderId) {
    // Add each cart item to order_items
    mysqli_data_seek($cartItems, 0); // Reset pointer
    while ($item = mysqli_fetch_assoc($cartItems)) {
        addOrderItem($orderId, $item['product_id'], $item['cart_quantity'], $item['price']);
    }

    // Clear the cart
    clearCart($customerId);

    // Redirect to success page
    header("Location: ordersController.php?success=Order placed successfully! Order ID: " . $orderId);
    exit;
} else {
    header("Location: cartController.php?error=Order failed. Please try again.");
    exit;
}
