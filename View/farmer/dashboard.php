<?php
require_once __DIR__ . '/../../Controller/farmer/farmerDashboardController.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Farmer Dashboard</title>
        <link rel="stylesheet" href="CSS/farmer.css">
    </head>
    <body>
        <div class="header">
            <h2>Farmer Dashboard</h2>
            
            <div class="header-links">
                <a href="dashBoard.php">Dashboard</a>
                <a href="myProducts.php">My Products</a>
                <a href="addProduct.php">Add Product</a>
                <a href="earnings.php">View Earnings</a>
                <a href="../../Controller/AuthControl/logoutController.php" class="logout">
                    Logout
                </a>
            </div>
        </div>

        <div class="main-content">
        
        <p>Welcome, Farmer</p><br>

        <div class="stats-grid">
            <div class="stat-card">
                <h4>Total Products</h4>
                <div class="number"><?php echo $totalProducts; ?></div>
        </div>

        <div class="stat-card">
            <h4>Total Earnings</h4>
            <div class="number">৳ <?php echo $totalEarnings ?? 0; ?></div>
        </div>

        <div class="stat-card">
            <h4>Pending Earnings</h4>
            <div class="number">৳ <?php echo $pendingEarning ?? 0; ?></div>
        </div>
        
    </body>
</html>
<?php