<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer")
    {
        header("Location: ../login.php");
        exit;
    }
    require_once __DIR__ . '/../../Model/farmer/productModel.php';
    $farmerId = $_SESSION["user_id"];
    $products = getProductsByFarmer($farmerId);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>My Products</title>
        <link rel="stylesheet" href="CSS/farmer.css">
    </head>
    <body>

    <div class="header">
    <h2>My Products</h2>
    
    <div class="header-links">
        <a href="dashBoard.php">Dashboard</a>
        <a href="addProduct.php">Add Product</a>
        <a href="earnings.php">View Earnings</a>
        <a href="../../Controller/AuthControl/logoutController.php" class="logout">Logout</a>
    </div>
    </div>

    <div class="main-content">
        
    <?php if (isset($_GET['success'])): ?>
        <p style="color:green; margin:10px 0;">
        <div class="success-msg">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>


    <a href="addProduct.php" class="add-new-btn">+Add New</a>

        <table border="1" cellpadding="10">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($products && mysqli_num_rows($products) > 0) {
                while ($p = mysqli_fetch_assoc($products)) {
                    $img = ($p['image'] != "") ? "<img src='../../{$p['image']}' width='60'>": "No image";
                    
                    echo "<tr>
                    <td>{$img}</td>
                    <td>{$p['name']}</td>
                    <td>{$p['price']}</td>
                    <td>{$p['quantity']}</td>
                    <td>
                    
                    <a href='editProduct.php?id={$p['id']}'>Edit</a>
                    <form action='../../Controller/farmer/productController.php'
                          method='POST'
                          style='display:inline;'>
                        <input type='hidden' name='action' value='delete'>
                        <input type='hidden' name='productId' value='{$p['id']}'>
                        <button type='submit'>Delete</button>
                    </form>
                    </td>
                    </tr>";
                    
                }
            } 
            else 
                {
                echo "<tr><td colspan='5'>No products found</td></tr>";
                }
?>
</table>
<br><a href="dashBoard.php">Back</a>
</body>
</html>