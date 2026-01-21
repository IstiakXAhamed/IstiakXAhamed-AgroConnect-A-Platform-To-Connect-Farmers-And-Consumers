<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer")
    {
        header("Location: ../login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Add Product</title>
        <link rel="stylesheet" href="CSS/farmer.css">
    </head>
    <body>

    <div class="header">
        <h2>Add New Product</h2>
        <div class="header-links">
        <a href="dashBoard.php">Dashboard</a>
        <a href="myProducts.php">My Products</a>
        <a href="earnings.php">View Earnings</a>
        <a href="../../Controller/AuthControl/logoutController.php" class="logout">Logout</a>
    </div>
    <div class="main-content">
        
        <?php if (isset($_GET['error'])) 
        {
            echo "<p style='color:red;'>" . $_GET['error'] . "</p>";
        } ?>

        <form action="../../Controller/farmer/productController.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">

                <p>Product Name<br>
        <input type="text" name="productName" required>
    </p>

    <p>Price (Taka)<br>
        <input type="number" name="price" required>
    </p>

    <p>Quantity<br>
        <input type="number" name="quantity" required>
    </p>

    <p>Description<br>
        <textarea name="description"></textarea>
    </p>

    <p>Product Image<br>
        <input type="file" name="productImage">
    </p>
    
    <button type="submit" value="Add Product">

    </form>
    <div class="page-actions">
        <a href="dashBoard.php">Back</a>
    </div>
</div>
    
</body>
</html>