<?php
require_once __DIR__ . "/../dbConnect.php";


// Ei function customer landing page e shob approved products dekhabe

function getAllActiveProducts()
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }

    $sql = "SELECT 
                products.id,
                products.name AS product_name,
                products.price,
                products.quantity,
                products.image,
                products.description,
                categories.name AS category_name,
                users.name AS farmer_name
             FROM products
            JOIN users ON products.farmer_id = users.id
               LEFT JOIN categories ON products.category_id = categories.id
            WHERE products.status = 1
              AND users.role = 'farmer'
              AND users.status = 1
             ORDER BY products.created_at DESC";

    return mysqli_query($conn, $sql);
}


// Category wise filter korte customer use korbe
function getProductsByCategory($categoryId)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }

    $sql = "SELECT 
                products.id,
                products.name AS product_name,
                products.price,
                products.quantity,
                products.image,
                categories.name AS category_name,
                users.name AS farmer_name
            FROM products
            JOIN users ON products.farmer_id = users.id
            LEFT JOIN categories ON products.category_id = categories.id
            WHERE products.status = 1
              AND products.category_id = $categoryId
              AND users.status = 1
            ORDER BY products.created_at DESC";

    return mysqli_query($conn, $sql);
}


// Customer ekta product click korle full details dekhbe
function getProductDetails($productId)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }

    $sql = "SELECT 
                products.*,
                categories.name AS category_name,
                users.name AS farmer_name,
                users.phone AS farmer_phone
            FROM products
            JOIN users ON products.farmer_id = users.id
            LEFT JOIN categories ON products.category_id = categories.id
            WHERE products.id = $productId
              AND products.status = 1";

    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}


// 4. GET ALL CATEGORIES (For Filter Dropdown)

function getAllCategories()
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }
    $sql = "SELECT * FROM categories ORDER BY name ASC";
    return mysqli_query($conn, $sql);
}


// 5. SEARCH PRODUCTS

// Customer product search korte parbe
function searchProducts($keyword)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }

    $sql = "SELECT 
                products.id,
                products.name AS product_name,
                products.price,
                products.quantity,
                products.image,
                categories.name AS category_name,
                users.name AS farmer_name
            FROM products
            JOIN users ON products.farmer_id = users.id
            LEFT JOIN categories ON products.category_id = categories.id
            WHERE products.status = 1
              AND users.status = 1
              AND (products.name LIKE '%$keyword%' 
                   OR products.description LIKE '%$keyword%')
            ORDER BY products.created_at DESC";

    return mysqli_query($conn, $sql);
}


// 6. ADD TO CART

// Customer cart e product add korbe
function addToCart($customerId, $productId, $quantity)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }

    // Check if already in cart
    $check = mysqli_query($conn, "SELECT * FROM cart WHERE customer_id = $customerId AND product_id = $productId");

    if (mysqli_num_rows($check) > 0) {
        // Already exists, update quantity
        $sql = "UPDATE cart SET quantity = quantity + $quantity WHERE customer_id = $customerId AND product_id = $productId";
    } else {
        // New item, insert
        $sql = "INSERT INTO cart (customer_id, product_id, quantity) VALUES ($customerId, $productId, $quantity)";
    }

    return mysqli_query($conn, $sql);
}

// 7. GET CART ITEMS

// Customer er cart e ki ki ache
function getCartItems($customerId)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }

    $sql = "SELECT 
                cart.id AS cart_id,
                cart.quantity AS cart_quantity,
                products.id AS product_id,
                products.name AS product_name,
                products.price,
                products.image,
                users.name AS farmer_name
            FROM cart
            JOIN products ON cart.product_id = products.id
            JOIN users ON products.farmer_id = users.id
            WHERE cart.customer_id = $customerId";

    return mysqli_query($conn, $sql);
}

// 8. UPDATE CART QUANTITY

function updateCartQuantity($cartId, $quantity)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }

    $sql = "UPDATE cart SET quantity = $quantity WHERE id = $cartId";
    return mysqli_query($conn, $sql);
}

// 9. REMOVE FROM CART
function removeFromCart($cartId)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }

    $sql = "DELETE FROM cart WHERE id = $cartId";
    return mysqli_query($conn, $sql);
}

// 10. CLEAR CART (After order placed)
function clearCart($customerId)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }

    $sql = "DELETE FROM cart WHERE customer_id = $customerId";
    return mysqli_query($conn, $sql);
}

// 11. PLACE ORDER
// Customer order place korbe
function placeOrder($customerId, $totalAmount)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }

    $sql = "INSERT INTO orders (customer_id, total_amount, status, created_at) 
            VALUES ($customerId, $totalAmount, 'pending', NOW())";

    if (mysqli_query($conn, $sql)) {
        return mysqli_insert_id($conn); // Return new order ID
    }
    return false;
}

// 12. ADD ORDER ITEMS
// Order e ki ki product ache
function addOrderItem($orderId, $productId, $quantity, $price)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }

    $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
            VALUES ($orderId, $productId, $quantity, $price)";

    return mysqli_query($conn, $sql);
}

// 13. GET CUSTOMER ORDER HISTORY
// Customer er shob orders
function getCustomerOrders($customerId)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }

    $sql = "SELECT * FROM orders 
            WHERE customer_id = $customerId 
            ORDER BY created_at DESC";

    return mysqli_query($conn, $sql);
}

// 14. GET ORDER DETAILS
// Specific order er details
function getOrderDetails($orderId)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }

    $sql = "SELECT 
                order_items.*,
                products.name AS product_name,
                products.image,
                users.name AS farmer_name
            FROM order_items
            JOIN products ON order_items.product_id = products.id
            JOIN users ON products.farmer_id = users.id
            WHERE order_items.order_id = $orderId";

    return mysqli_query($conn, $sql);
}

// 15. GET CART COUNT (For navbar badge)
function getCartCount($customerId)
{
    $conn = dbConnect();
    if (!$conn) {
        return 0;
    }

    $sql = "SELECT COUNT(*) AS count FROM cart WHERE customer_id = $customerId";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['count'] ?? 0;
}

// 16. GET CART TOTAL
function getCartTotal($customerId)
{
    $conn = dbConnect();
    if (!$conn) {
        return 0;
    }

    $sql = "SELECT SUM(products.price * cart.quantity) AS total 
            FROM cart 
            JOIN products ON cart.product_id = products.id 
            WHERE cart.customer_id = $customerId";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['total'] ?? 0;
}
