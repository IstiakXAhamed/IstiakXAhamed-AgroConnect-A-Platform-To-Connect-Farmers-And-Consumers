<!DOCTYPE html>
<html>

<head>
    <title>AgroConnect - Products</title>
    <link rel="stylesheet" href="../../View/customer/css/customer.css">
</head>

<body>

    <!-- Header -->
    <div class="header">
        <h2>AgroConnect</h2>
        <div class="header-links">
            <a href="customerDashboardController.php">Products</a>
            <a href="cartController.php">My Cart</a>
            <a href="ordersController.php">My Orders</a>
            <a href="../AuthControl/logoutController.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">

        <h3 style="margin-bottom: 20px;">Available Products</h3>

        <!-- Product Cards Grid -->
        <div class="products-grid">

            <?php
            if ($products && mysqli_num_rows($products) > 0) {
                while ($p = mysqli_fetch_assoc($products)) {
                    // Image or placeholder
                    $imgSrc = ($p['image'] != "")
                        ? "../../{$p['image']}"
                        : "https://via.placeholder.com/200x150?text=No+Image";
            ?>

                    <div class="product-card">
                        <!-- Product Image (Big) -->
                        <img src="<?php echo $imgSrc; ?>" alt="<?php echo $p['product_name']; ?>">

                        <!-- Product Info -->
                        <div class="product-info">
                            <h4><?php echo $p['product_name']; ?></h4>
                            <p class="category"><?php echo $p['category_name'] ?? 'Uncategorized'; ?></p>
                            <p class="farmer">By: <?php echo $p['farmer_name']; ?></p>
                            <p class="price">৳<?php echo $p['price']; ?></p>
                            <p class="stock">Stock: <?php echo $p['quantity']; ?></p>
                        </div>

                        <!-- Add to Cart -->
                        <form action="cartController.php" method="POST" class="card-form">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="productId" value="<?php echo $p['id']; ?>">
                            <input type="number" name="quantity" value="1" min="1" max="<?php echo $p['quantity']; ?>">
                            <button type="submit">Add to Cart</button>
                        </form>
                    </div>

            <?php
                }
            } else {
                echo "<p>No products available</p>";
            }
            ?>

        </div>

    </div>

</body>

</html>