<?php
require_once __DIR__ . '/../../Controller/farmer/earningsController.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Farmer Earnings</title>
    <link rel="stylesheet" href="CSS/farmer.css">
</head>
<body>

<div class="header">
            <h2>Your Earnings</h2>
            
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
    <div class="stats-grid">
        <div class="stat-card">
            <h4>Total Earnings</h4>
            <div class="number">৳ <?php echo $totalEarnings; ?></div>
        </div>

        <div class="stat-card">
            <h4>Completed Orders</h4>
            <div class="number"><?php echo $completedOrders; ?></div>
        </div>

        <div class="stat-card">
            <h4>Pending Earnings</h4>
            <div class="number">৳ <?php echo $pendingEarnings; ?></div>
        </div>
    </div>
</div>

</body>
</html>

