<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer")
    {
        header("Location: ../login.php");
        exit;
    }
    require_once __DIR__ . '/../../Model/farmer/productModel.php';
    $farmerId = $_SESSION["user_id"];
    $products = getFarmerProducts($farmerId);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>My Products</title>
        <link rel="stylesheet" href="../../CSS/farmer.css">
    </head>
    <body>
        <h2>My Products</h2>

        <?php if (isset($GET['success'])) 
        {
            echo "<p style='colot:green;'>" . $_GET['success'] . "</p>";
        } ?>

        <a href="addProduct.php">+Add New</a><br><br>

        <table border="1" cellpadding="10">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
            <?php
             if ($products && mysqli_num_rows($products) >0)
                {
                    while ($p = mysqli_fetch_assoc($products)) {
                        $img = ($p['image'] != "") ? "<img src='../../{$p['image']}' width='50'>" : "No img";
                        echo "<tr>
                            <td>{$img}</td>
                            <td>{$p['name']}</td>
                            <td>{$p['price']}</td>
                            <td>{$p['quantity']}</td>
                            <td>
                            <a href='editProduct.php?id={$p['id']}'>Edit</a> | <form action='../../Controller/farmer/productController.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='action' value='delete'>
                            <input type='hidden' name='productId' value='{$p['id']}'>
                            <button type='submit'>Delete</button>
                            </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No products</td></tr>";
                }
                ?>
        </table>

        <br><a href="dashBoard.php">Back</a>
    </body>
</html>