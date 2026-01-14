<?php
require_once __DIR__ . '/../../Controller/admin/adminDashboardController.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
</head>

<body>

    <h2>Admin Dashboard</h2>

    <!-- User Stats -->
    <h3>User Statistics</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>Total Users</th>
            <th>Active Users</th>
            <th>Pending Users</th>
        </tr>
        <tr>
            <td><?php echo $stats['totalUsers']; ?></td>
            <td><?php echo $stats['activeUsers']; ?></td>
            <td><?php echo $stats['pendingUsers']; ?></td>
        </tr>
    </table>

    <br>

    <!-- Role-wise Stats -->
    <h3>Users by Role</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>Farmers</th>
            <th>Customers</th>
            <th>Transporters</th>
        </tr>
        <tr>
            <td><?php echo $stats['totalFarmers']; ?></td>
            <td><?php echo $stats['totalCustomers']; ?></td>
            <td><?php echo $stats['totalTransporters']; ?></td>
        </tr>
    </table>

    <br>

    <!-- Products & Orders Stats -->
    <h3>Products & Orders</h3>
    <table border="1" cellpadding="10">
        <tr>
            <th>Total Products</th>
            <th>Total Orders</th>
            <th>Pending Orders</th>
            <th>Total Revenue</th>
        </tr>
        <tr>
            <td><?php echo $stats['totalProducts']; ?></td>
            <td><?php echo $stats['totalOrders']; ?></td>
            <td><?php echo $stats['pendingOrders']; ?></td>
            <td><?php echo $stats['totalRevenue']; ?> Tk</td>
        </tr>
    </table>

    <br>
    <hr>

    <!-- Recent Users Table -->
    <h3>Recent Registrations (Last 5)</h3>
    <table border="1" cellpadding="10">
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
                $status = ($user['status'] == 1) ? "Active" : "Pending";
                echo "<tr>
                    <td>{$user['id']}</td>
                    <td>{$user['name']}</td>
                    <td>{$user['email']}</td>
                    <td>{$user['role']}</td>
                    <td>{$status}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No users found</td></tr>";
        }
        ?>
    </table>

    <br>

    <!-- Pending Approval Users -->
    <h3>Pending Approval Users</h3>
    <table border="1" cellpadding="10">
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

    <br>

    <!-- Recent Orders Table -->
    <h3>Recent Orders (Last 5)</h3>
    <table border="1" cellpadding="10">
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

    <hr>

    <!-- Navigation Links -->
    <h3>Quick Links</h3>
    <a href="../../Controller/admin/manageUsersController.php">Manage Users</a> |
    <a href="../../Controller/admin/configController.php">Configuration</a> |
    <a href="../../Controller/AuthControl/logoutController.php">Logout</a>

</body>

</html>