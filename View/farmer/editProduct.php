<!DOCTYPE html>
<html>

<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="../../View/farmer/css/farmer.css">
</head>

<body>

    <div class="header">
        <h2>Edit Product</h2>
        <div class="header-links">
            <a href="farmerDashboardController.php">Dashboard</a>
            <a href="productController.php">My Products</a>
            <a href="earningsController.php">View Earnings</a>
            <a href="../AuthControl/logoutController.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">

        <form action="productController.php" method="POST" enctype="multipart/form-data" class="add-product-form">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="productId" value="<?php echo $product['id']; ?>">

            <div class="form-row">
                <label>Product Name:</label>
                <input type="text" name="productName" value="<?php echo $product['name']; ?>" required>
            </div>

            <div class="form-row">
                <label>Price (Taka):</label>
                <input type="number" name="price" value="<?php echo $product['price']; ?>" required>
            </div>

            <div class="form-row">
                <label>Quantity:</label>
                <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" required>
            </div>

            <div class="form-row">
                <label>Category:</label>
                <select name="categoryId" required>
                    <option value="">Select Category</option>
                    <?php
                    if ($categories && mysqli_num_rows($categories) > 0) {
                        while ($cat = mysqli_fetch_assoc($categories)) {
                            $selected = ($cat['id'] == $product['category_id']) ? "selected" : "";
                            echo "<option value='{$cat['id']}' {$selected}>{$cat['name']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-row">
                <label>Description:</label>
                <textarea name="description"><?php echo $product['description']; ?></textarea>
            </div>

            <div class="form-row">
                <label>Current Image:</label>
                <?php if ($product['image'] != "") {
                    echo "<img src='../../{$product['image']}' width='100'>";
                } else {
                    echo "<span>No image</span>";
                } ?>
            </div>

            <div class="form-row">
                <label>New Image:</label>
                <input type="file" name="productImage">
            </div>

            <button type="submit">Update Product</button>
            <div class="page-actions">
                <a href="productController.php">Back</a>
            </div>

        </form>



    </div>

</body>

</html>