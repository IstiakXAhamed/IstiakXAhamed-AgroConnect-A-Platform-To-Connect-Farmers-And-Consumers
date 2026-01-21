<!DOCTYPE html>
<html>

<head>
    <title>Farmer Dashboard</title>
    <link rel="stylesheet" href="../../View/farmer/css/farmer.css">
</head>

<body>

    <!-- Header with Navigation (Admin Style) -->
    <div class="header">
        <h2>Farmer Dashboard</h2>
        <div class="header-links">
            <a href="farmerDashboardController.php">Dashboard</a>
            <a href="productController.php">My Products</a>
            <a href="add_product.php">Add Product</a>
            <a href="earningsController.php">View Earnings</a>
            <a href="../AuthControl/logoutController.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">

        <!-- Stats Cards (Admin Style - 6 Cards) -->
        <div class="stats-grid">
            <div class="stat-card">
                <h4>Total Products</h4>
                <div class="number"><?php echo $totalProducts; ?></div>
            </div>
            <div class="stat-card">
                <h4>Total Sales</h4>
                <div class="number revenue">৳<?php echo number_format($totalSales, 2); ?></div>
            </div>
            <div class="stat-card">
                <h4>Orders Completed</h4>
                <div class="number"><?php echo $completedOrders; ?></div>
            </div>
            <div class="stat-card">
                <h4>Commission (<?php echo $commissionRate; ?>%)</h4>
                <div class="number commission">৳<?php echo number_format($commissionAmount, 2); ?></div>
            </div>
            <div class="stat-card">
                <h4>Net Profit</h4>
                <div class="number revenue">৳<?php echo number_format($netProfit, 2); ?></div>
            </div>
            <div class="stat-card">
                <h4>Pending Earnings</h4>
                <div class="number pending">৳<?php echo number_format($pendingEarnings, 2); ?></div>
            </div>
        </div>

        <!-- Recent Sales Table (Admin Style - Last 10 with Commission/Profit) -->
        <div class="section">
            <h3>Recent Sales (Last 10)</h3>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Commission (<?php echo $commissionRate; ?>%)</th>
                    <th>Profit</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                <?php
                if ($recentSales && mysqli_num_rows($recentSales) > 0) {
                    while ($sale = mysqli_fetch_assoc($recentSales)) {
                        $saleTotal = $sale['price'] * $sale['quantity'];
                        $saleCommission = $saleTotal * ($commissionRate / 100);
                        $saleProfit = $saleTotal - $saleCommission;

                        $statusClass = ($sale['status'] == 'completed') ? "status-active" : "status-pending";

                        echo "<tr>
                            <td>{$sale['order_id']}</td>
                            <td>{$sale['product_name']}</td>
                            <td>{$sale['quantity']}</td>
                            <td>৳" . number_format($sale['price'], 2) . "</td>
                            <td>৳" . number_format($saleTotal, 2) . "</td>
                            <td class='commission'>৳" . number_format($saleCommission, 2) . "</td>
                            <td class='revenue'>৳" . number_format($saleProfit, 2) . "</td>
                            <td class='{$statusClass}'>{$sale['status']}</td>
                            <td>{$sale['created_at']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No sales found</td></tr>";
                }
                ?>
            </table>
        </div>

    </div>

</body>

</html>