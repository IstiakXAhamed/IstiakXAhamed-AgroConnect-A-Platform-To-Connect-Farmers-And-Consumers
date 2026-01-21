<!DOCTYPE html>
<html>

<head>
    <title>My Products</title>
    <link rel="stylesheet" href="../../View/farmer/css/farmer.css">
</head>

<body>

    <div class="header">
        <h2>My Products</h2>

        <div class="header-links">
            <a href="../../Controller/farmer/farmerDashboardController.php">Dashboard</a>
            <a href="../../Controller/farmer/add_product.php">Add Product</a>
            <a href="../../Controller/farmer/earningsController.php">View Earnings</a>
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


        <a href="add_product.php" class="add-new-btn">+Add New</a>

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
                    $img = ($p['image'] != "") ? "<img src='../../{$p['image']}' width='60'>" : "No image";

                    echo "<tr>
                    <td>{$img}</td>
                    <td>{$p['name']}</td>
                    <td>{$p['price']}</td>
                    <td>{$p['quantity']}</td>
                    <td>
                    
                    <a href='editProductController.php?id={$p['id']}'>Edit</a>
                    <form action='productController.php'
                          method='POST'
                          style='display:inline;'>
                        <input type='hidden' name='action' value='delete'>
                        <input type='hidden' name='productId' value='{$p['id']}'>
                        <button type='submit'>Delete</button>
                    </form>
                    </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No products found</td></tr>";
            }
            ?>
        </table>
        <br><a href="farmerDashboardController.php">Back</a>
</body>

</html>