<?php
require_once __DIR__ . "/../dbConnect.php";

function addProduct($farmerId, $name, $price, $quantity, $image, $description)
{
    $conn = dbConnect();
    if (!$conn){
        return false;
    }
    $sql = "INSERT INTO products (farmer_id, name, price, quantity, image, description, status, created_at)
    VALUES ($farmerId, '$name', $price, $quantity, '$image', '$description', 1, NOW())";
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

function updateProduct($productId, $name, $price,$quantity, $image, $description)
{
    $conn = dbConnect();
    
    if ($image != "") {
        $sql = "UPDATE products SET name= '$name', price=$price, quantity=$quantity, image='$image', description='$description' WHERE id=$productId";
    } 
    else
        {
            $sql = "UPDATE products SET name= '$name', price=$price, quantity=$quantity, description='$description' WHERE id=$productId";
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
function getTotalEarnings($farmerId)
{
    $conn = dbConnect();

    $sql = " SELECT SUM(oi.price * oi.quantity) AS total FROM order_items oi JOIN products p ON oi.product_id = p.id JOIN orders o ON oi.order_id = o.id WHERE p.farmer_id = $farmerId AND o.status = 'approved' ";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['total'] ?? 0;
}

function getPendingEarnings($farmerId)
{
    $conn = dbConnect();

    $sql = "SELECT SUM(oi.price * oi.quantity) AS total FROM order_items oi JOIN products p ON oi.product_id = p.id JOIN orders o ON oi.order_id = o.id WHERE p.farmer_id = $farmerId AND o.status = 'pending' ";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['total'] ?? 0;
}

function getCompletedOrdersCount($farmerId)
{
    $conn = dbConnect();
    if (!$conn) {
        return 0;
    }

    $sql = " SELECT COUNT(*) AS total FROM order_items oi JOIN products p ON oi.product_id = p.id JOIN orders o ON oi.order_id = o.id WHERE p.farmer_id = $farmerId AND o.status = 'apporvoed' ";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['total'] ?? 0;
}
?>