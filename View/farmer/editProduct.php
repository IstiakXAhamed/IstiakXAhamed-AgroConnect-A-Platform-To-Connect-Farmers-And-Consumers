<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer") {
    header("Location: ../login.php");
    exit;
}
require_once __DIR__ . '/../../Model/farmer/productModel.php';
$productId = $GET['id'];
$product = getProductById($productId);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Product</title>
        <link rel="stylesheet" href="../../CSS/farmer.css">
    </head>
    <body>
        <h2>Edit Product</h2>

        <form action="../../Controller/farmer/productController.php" method="POST" enctype="multipart"/form-data">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="productId" value="<?php echo $product['id']; ?>">

        Name:<br>
        <input type="text" name="productName" value="<?php echo $product['name']; ?>"><br><br>

        Price:<br>
        <input type="number" name="price" value="<?php echo $product['price']; ?>"><br><br>

        Quantity:<br>
        <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>"><br><br>

        Description:<br>
        <textarea name="description"><?php echo $product['description']; ?></textarea><br><br>

        Current Image:<br>
        <?php if ($product['image'] != "") {
            echo "<img src='../../{$product['image']}' width='100'>";
        } ?><br><br>

        New Image (optional):<br>
        <input type="file" name="productImage"><br><br>
        <input type="submit" value="Update">
        </form>
        <br><a href="myProducts.php">Back</a>
    </body>
</html>

