<?php
require_once __DIR__ . "/../dbConnect.php";

//customer landing page 
function getAllActiveProducts()
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }
    //for selecting products from farmer to customer landing page  
    $query = "SELECT
            p.id,
            p.name AS product_name,
            p.price,
            p.quantity,
            p.image,
            c.name AS category_name,
            u.name AS farmer_name
        FROM products p
        JOIN users u ON p.farmer_id = u.id
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.status = 1
          AND u.role = 'farmer'
          AND u.status = 1
        ORDER BY p.created_at DESC
    ";
    $result = mysqli_query($conn, $query);
    $products = [];
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)){
            $products[] = $row;
        }
        return $products;
    } else {
        return false;
    }
}
