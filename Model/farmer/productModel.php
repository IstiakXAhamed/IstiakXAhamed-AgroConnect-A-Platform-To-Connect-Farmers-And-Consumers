<?php
require_once __DIR__ . "/../dbConnect.php";

// Get all categories for dropdown
function getAllCategories()
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }
    $sql = "SELECT * FROM categories ORDER BY name ASC";
    return mysqli_query($conn, $sql);
}

function addProduct($farmerId, $name, $price, $quantity, $image, $description, $categoryId)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }
    $sql = "INSERT INTO products (farmer_id, name, price, quantity, image, description, category_id, status, created_at)
    VALUES ($farmerId, '$name', $price, $quantity, '$image', '$description', $categoryId, 1, NOW())";
    return mysqli_query($conn, $sql);
}

function getProductsByFarmer($farmerId)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }
    $sql = "SELECT * FROM products WHERE farmer_id = $farmerId ORDER BY id DESC";
    return mysqli_query($conn, $sql);
}

function getProductById($productId)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }
    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($conn, $sql);

    return mysqli_fetch_assoc($result);
}

function updateProduct($productId, $name, $price, $quantity, $image, $description, $categoryId)
{
    $conn = dbConnect();

    if ($image != "") {
        $sql = "UPDATE products SET name='$name', price=$price, quantity=$quantity, image='$image', description='$description', category_id=$categoryId WHERE id=$productId";
    } else {
        $sql = "UPDATE products SET name='$name', price=$price, quantity=$quantity, description='$description', category_id=$categoryId WHERE id=$productId";
    }
    return mysqli_query($conn, $sql);
}

function deleteProduct($productId)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }
    $sql = "DELETE FROM products WHERE id = $productId";
    return mysqli_query($conn, $sql);
}

function countFarmerProducts($farmerId)
{
    $conn = dbConnect();
    if (!$conn) {
        return 0;
    }
    $sql = "SELECT id FROM products WHERE farmer_id = $farmerId";
    $result = mysqli_query($conn, $sql);

    $count = mysqli_num_rows($result);

    return $count;
}

// Total Earnings (ONLY completed orders - after customer confirms received)
function getTotalEarnings($farmerId)
{
    $conn = dbConnect();

    $sql = "SELECT SUM(order_items.price * order_items.quantity) AS total 
            FROM order_items 
            JOIN products ON order_items.product_id = products.id 
            JOIN orders ON order_items.order_id = orders.id 
            WHERE products.farmer_id = $farmerId 
            AND orders.status = 'completed'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['total'] ?? 0;
}

// Pending Earnings (pending + approved orders - not yet completed)
function getPendingEarnings($farmerId)
{
    $conn = dbConnect();

    $sql = "SELECT SUM(order_items.price * order_items.quantity) AS total 
            FROM order_items 
            JOIN products ON order_items.product_id = products.id 
            JOIN orders ON order_items.order_id = orders.id 
            WHERE products.farmer_id = $farmerId 
            AND (orders.status = 'pending' OR orders.status = 'approved')";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['total'] ?? 0;
}

// Completed Orders Count
function getCompletedOrdersCount($farmerId)
{
    $conn = dbConnect();
    if (!$conn) {
        return 0;
    }

    $sql = "SELECT COUNT(DISTINCT orders.id) AS total 
            FROM order_items 
            JOIN products ON order_items.product_id = products.id 
            JOIN orders ON order_items.order_id = orders.id 
            WHERE products.farmer_id = $farmerId 
            AND orders.status = 'completed'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['total'] ?? 0;
}

// Commission rate fetch kori admin settings theke
function getCommissionRate()
{
    $conn = dbConnect();
    if (!$conn) {
        return 5; // default 5%
    }
    $sql = "SELECT farmer_commission FROM platform_commission LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['farmer_commission'] ?? 5;
}

// Farmer er total sales (completed orders)
function getFarmerTotalSales($farmerId)
{
    $conn = dbConnect();
    if (!$conn) {
        return 0;
    }
    $sql = "SELECT SUM(order_items.price * order_items.quantity) AS total 
            FROM order_items 
            JOIN products ON order_items.product_id = products.id 
            JOIN orders ON order_items.order_id = orders.id 
            WHERE products.farmer_id = $farmerId 
            AND orders.status = 'completed'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}

// Recent 10 sales with product details
function getFarmerRecentSales($farmerId)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }
    $sql = "SELECT order_items.order_id, 
                   order_items.quantity, 
                   order_items.price, 
                   products.name AS product_name, 
                   orders.status, 
                   orders.created_at 
            FROM order_items 
            JOIN products ON order_items.product_id = products.id 
            JOIN orders ON order_items.order_id = orders.id 
            WHERE products.farmer_id = $farmerId 
            ORDER BY orders.created_at DESC 
            LIMIT 10";
    return mysqli_query($conn, $sql);
}

// ALL orders with customer name (for earnings page)
function getAllFarmerOrders($farmerId)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }
    $sql = "SELECT order_items.order_id, 
                   order_items.quantity, 
                   order_items.price, 
                   products.name AS product_name, 
                   orders.status, 
                   orders.created_at,
                   users.name AS customer_name
            FROM order_items 
            JOIN products ON order_items.product_id = products.id 
            JOIN orders ON order_items.order_id = orders.id 
            JOIN users ON orders.customer_id = users.id
            WHERE products.farmer_id = $farmerId 
            ORDER BY orders.created_at DESC";
    return mysqli_query($conn, $sql);
}
