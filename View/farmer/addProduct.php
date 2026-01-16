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
        <link rel="stylesheet" href="../../CSS/farmer.css">
    </head>
    <body>
        <h2>Add New Product</h2>
        
        <?php if (isset($_GET['error'])) {
            echo "<p style='color:red;'>" . $_GET['error'] . "</p>";
        } ?>

        <from action="../../Controller/farmer/productController.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">

            Product Name:<br>
            <input type="text" name="productName" required><br><br>

            Price (Taka):<br>
            <input type="number" name="price" required><br><br>

            Quantity:<br>
            <input type="number" name="quantity" required><br><br>

            Description:<br>
            <textarea name="description"></textarea><br><br>

            Product Image:<br>
            <input type="file" name="productImage" accept="image/*"><br><br>

            <input type="submit" value="Add Product">
        </from>
        <br><a href="dashBoard.php">Back</a>
    </body>
</html>