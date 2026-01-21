<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="../../View/farmer/css/farmer.css">
</head>

<body>

    <div class="header">
        <h2>Add New Product</h2>
        <div class="header-links">
            <a href="farmerDashboardController.php">Dashboard</a>
            <a href="productController.php">My Products</a>
            <a href="earningsController.php">View Earnings</a>
            <a href="../AuthControl/logoutController.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">

        <?php if (isset($_GET['error'])) {
            echo "<p style='color:red;'>" . $_GET['error'] . "</p>";
        } ?>

        <form action="productController.php" method="POST" enctype="multipart/form-data" class="add-product-form">
            <input type="hidden" name="action" value="add">

            <div class="form-row">
                <label>Product Name:</label>
                <input type="text" name="productName" required>
            </div>

            <div class="form-row">
                <label>Price (Taka):</label>
                <input type="number" name="price" required>
            </div>

            <div class="form-row">
                <label>Quantity:</label>
                <input type="number" name="quantity" required>
            </div>

            <div class="form-row">
                <label>Category:</label>
                <select name="categoryId" required>
                    <option value="">Select Category</option>
                    <?php
                    if ($categories && mysqli_num_rows($categories) > 0) {
                        while ($cat = mysqli_fetch_assoc($categories)) {
                            echo "<option value='{$cat['id']}'>{$cat['name']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-row">
                <label>Description:</label>
                <textarea name="description"></textarea>
            </div>

            <div class="form-row">
                <label>Product Image:</label>
                <input type="file" name="productImage">
            </div>

            <button type="submit">Add Product</button>

            <div class="page-actions">
                <a href="farmerDashboardController.php">Back</a>
            </div>
        </form>

    </div>

</body>

</html>