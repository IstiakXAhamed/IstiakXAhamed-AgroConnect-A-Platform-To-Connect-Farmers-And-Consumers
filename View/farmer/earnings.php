<!DOCTYPE html>
<html>

<head>
    <title>Farmer Earnings</title>
    <link rel="stylesheet" href="../../View/farmer/css/farmer.css">
</head>

<body>

    <div class="header">
        <h2>My Earnings</h2>

        <div class="header-links">
            <a href="farmerDashboardController.php">Dashboard</a>
            <a href="productController.php">My Products</a>
            <a href="add_product.php">Add Product</a>
            <a href="../AuthControl/logoutController.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <h4>Total Earnings</h4>
                <div class="number revenue">৳<?php echo number_format($totalEarnings, 2); ?></div>
            </div>

            <div class="stat-card">
                <h4>Commission (<?php echo $commissionRate; ?>%)</h4>
                <div class="number commission">৳<?php echo number_format($totalCommission, 2); ?></div>
            </div>

            <div class="stat-card">
                <h4>Net Profit</h4>
                <div class="number revenue">৳<?php echo number_format($netProfit, 2); ?></div>
            </div>

            <div class="stat-card">
                <h4>Completed Orders</h4>
                <div class="number"><?php echo $completedOrders; ?></div>
            </div>

            <div class="stat-card">
                <h4>Pending Earnings</h4>
                <div class="number pending">৳<?php echo number_format($pendingEarnings, 2); ?></div>
            </div>
        </div>

        <!-- All Orders Table -->
        <div class="section">
            <h3>All Orders Details</h3>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Commission</th>
                    <th>Profit</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                <?php
                if ($allOrders && mysqli_num_rows($allOrders) > 0) {
                    while ($order = mysqli_fetch_assoc($allOrders)) {
                        $orderTotal = $order['price'] * $order['quantity'];
                        $orderCommission = $orderTotal * ($commissionRate / 100);
                        $orderProfit = $orderTotal - $orderCommission;

                        $statusClass = ($order['status'] == 'completed') ? "status-active" : "status-pending";

                        echo "<tr>
                            <td>{$order['order_id']}</td>
                            <td>{$order['customer_name']}</td>
                            <td>{$order['product_name']}</td>
                            <td>{$order['quantity']}</td>
                            <td>৳" . number_format($order['price'], 2) . "</td>
                            <td>৳" . number_format($orderTotal, 2) . "</td>
                            <td class='commission'>৳" . number_format($orderCommission, 2) . "</td>
                            <td class='revenue'>৳" . number_format($orderProfit, 2) . "</td>
                            <td class='{$statusClass}'>{$order['status']}</td>
                            <td>{$order['created_at']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No orders found</td></tr>";
                }
                ?>
            </table>
        </div>

    </div>

</body>

</html>