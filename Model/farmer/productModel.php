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
    return mysql_query($conn, $sql);
}

function getProductsByFarmer($farmerId)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }
    $sql = "SELECT * FROM producyts WHERE farmer_id = $farmerId ORDER BY id DESC";
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
    if (!$conn) {
        return false;
    }
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
    $sql = "DELETE FROM products WHERE id = $productsId";
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

    return mysql_num_rows($result);
}

?>