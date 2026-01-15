<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../View/admin/css/adminDashBoard.css">
</head>

<body>

    <!-- Header with Navigation -->
    <div class="header">
        <h2>Admin Dashboard</h2>
        <div class="header-links">
            <a href="../../Controller/admin/manageUsersController.php">Manage Users</a>
            <a href="../../Controller/admin/configController.php">Configuration</a>
            <a href="../../Controller/admin/logoutController.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">

        <!-- Stats Cards Row -->
        <div class="stats-grid">
            <div class="stat-card">
                <h4>Total Users</h4>
                <div class="number"><?php echo $stats['totalUsers']; ?></div>
            </div>
            <div class="stat-card">
                <h4>Active Users</h4>
                <div class="number"><?php echo $stats['activeUsers']; ?></div>
            </div>
            <div class="stat-card">
                <h4>Pending Users</h4>
                <div class="number"><?php echo $stats['pendingUsers']; ?></div>
            </div>
            <div class="stat-card">
                <h4>Total Farmers</h4>
                <div class="number"><?php echo $stats['totalFarmers']; ?></div>
            </div>
            <div class="stat-card">
                <h4>Total Customers</h4>
                <div class="number"><?php echo $stats['totalCustomers']; ?></div>
            </div>
            <div class="stat-card">
                <h4>Total Transporters</h4>
                <div class="number"><?php echo $stats['totalTransporters']; ?></div>
            </div>
            <div class="stat-card">
                <h4>Total Products</h4>
                <div class="number"><?php echo $stats['totalProducts']; ?></div>
            </div>
            <div class="stat-card">
                <h4>Total Orders</h4>
                <div class="number"><?php echo $stats['totalOrders']; ?></div>
            </div>
            <div class="stat-card">
                <h4>Total Revenue</h4>
                <div class="number revenue"><?php echo $stats['totalRevenue']; ?> Tk</div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="section">
            <h3>Recent Registrations</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                </tr>
                <?php
                if ($recentUsers && mysqli_num_rows($recentUsers) > 0) {
                    while ($user = mysqli_fetch_assoc($recentUsers)) {
                        $statusClass = ($user['status'] == 1) ? "status-active" : "status-pending";
                        $statusText = ($user['status'] == 1) ? "Active" : "Pending";
                        echo "<tr>
                            <td>{$user['id']}</td>
                            <td>{$user['name']}</td>
                            <td>{$user['email']}</td>
                            <td>{$user['role']}</td>
                            <td class='{$statusClass}'>{$statusText}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No users found</td></tr>";
                }
                ?>
            </table>
        </div>

        <!-- Pending Users -->
        <div class="section">
            <h3>Pending Approval Users</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
                <?php
                if ($pendingUsers && mysqli_num_rows($pendingUsers) > 0) {
                    while ($user = mysqli_fetch_assoc($pendingUsers)) {
                        echo "<tr>
                            <td>{$user['id']}</td>
                            <td>{$user['name']}</td>
                            <td>{$user['email']}</td>
                            <td>{$user['role']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No pending users</td></tr>";
                }
                ?>
            </table>
        </div>

        <!-- Recent Orders -->
        <div class="section">
            <h3>Recent Orders</h3>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                <?php
                if ($recentOrders && mysqli_num_rows($recentOrders) > 0) {
                    while ($order = mysqli_fetch_assoc($recentOrders)) {
                        echo "<tr>
                            <td>{$order['id']}</td>
                            <td>{$order['customer_id']}</td>
                            <td>{$order['total_amount']} Tk</td>
                            <td>{$order['status']}</td>
                            <td>{$order['created_at']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No orders found</td></tr>";
                }
                ?>
            </table>
        </div>

    </div>

</body>

</html>