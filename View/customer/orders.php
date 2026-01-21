<!DOCTYPE html>
<html>

<head>
    <title>My Orders</title>
    <link rel="stylesheet" href="../../View/customer/css/customer.css">
</head>

<body>

    <!-- Header -->
    <div class="header">
        <h2>My Orders</h2>
        <div class="header-links">
            <a href="customerDashboardController.php">Products</a>
            <a href="cartController.php">My Cart</a>
            <a href="ordersController.php">My Orders</a>
            <a href="../AuthControl/logoutController.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">

        <div class="section">
            <h3>Order History</h3>

            <?php if ($orders && mysqli_num_rows($orders) > 0): ?>
                <table>
                    <tr>
                        <th>Order ID</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    while ($order = mysqli_fetch_assoc($orders)) {
                        $statusClass = ($order['status'] == 'completed') ? 'revenue' : '';

                        echo "<tr>
                            <td>#{$order['id']}</td>
                            <td class='revenue'>৳{$order['total_amount']}</td>
                            <td class='{$statusClass}'>{$order['status']}</td>
                            <td>{$order['created_at']}</td>
                            <td>
                                <a href='orderDetailsController.php?id={$order['id']}'>View Details</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </table>
            <?php else: ?>
                <p>No orders yet. <a href="customerDashboardController.php">Start shopping!</a></p>
            <?php endif; ?>

        </div>

    </div>

</body>

</html>