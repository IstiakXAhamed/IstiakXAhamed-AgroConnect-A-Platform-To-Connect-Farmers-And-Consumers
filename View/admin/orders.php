<!DOCTYPE html>
<html>

<head>
    <title>Manage Orders</title>
    <link rel="stylesheet" href="../../View/admin/css/adminDashBoard.css">
</head>

<body>

    <div class="header">
        <h2>Manage Orders</h2>
        <div class="header-links">
            <a href="adminDashboardController.php">Dashboard</a>
            <a href="manageUsersController.php">Users</a>
            <a href="ordersController.php">Orders</a>
            <a href="configController.php">Config</a>
            <a href="../AuthControl/logoutController.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">
 
        <?php if (isset($_GET['success'])): ?>
            <p style="color:green; background:#F0FFF4 ; padding:10px; border-radius:4px;">
                <?php echo $_GET['success']; ?>
            </p>
        <?php endif; ?>

        <div class="section">
            <h3>All Orders</h3>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php
                if ($orders && mysqli_num_rows($orders) > 0) {
                    while ($order = mysqli_fetch_assoc($orders)) {
                        echo "<tr>
                            <td>#{$order['id']}</td>
                            <td>{$order['customer_name']}</td>
                            <td>৳{$order['total_amount']}</td>
                            <td>{$order['status']}</td>
                            <td>{$order['created_at']}</td>
                            <td>";

                        // Show Approve button only for pending orders
                        if ($order['status'] === 'pending') {
                            echo "<form action='approveOrderController.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='orderId' value='{$order['id']}'>
                                <button type='submit' class='btn-approve'>Approve</button>
                            </form>";
                        } else {
                            echo "<span style='color:green;'>✓ {$order['status']}</span>";
                        }

                        echo "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No orders found</td></tr>";
                }
                ?>
            </table>
        </div>

    </div>

</body>

</html>