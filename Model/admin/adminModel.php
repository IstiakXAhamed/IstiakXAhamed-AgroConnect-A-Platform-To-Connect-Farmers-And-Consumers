<?php
require_once __DIR__ . "/../dbConnect.php";

// admin dashboard er stats collect korbo 
function getAdminDashboardStats()
{
    $conn = dbConnect();

    if (!$conn) {
        return false;
    }

    $data = array();

    // total users
    $result = mysqli_query($conn, "SELECT id FROM users");
    $data['totalUsers'] = mysqli_num_rows($result);

    // pending users (status=0)
    $result = mysqli_query($conn, "SELECT id FROM users WHERE status=0");
    $data["pendingUsers"] = mysqli_num_rows($result);

    // active users (status=1)
    $result = mysqli_query($conn, "SELECT id FROM users WHERE status=1");
    $data["activeUsers"] = mysqli_num_rows($result);

    // total farmers
    $result = mysqli_query($conn, "SELECT id FROM users WHERE role='farmer'");
    $data["totalFarmers"] = mysqli_num_rows($result);

    // total customers
    $result = mysqli_query($conn, "SELECT id FROM users WHERE role='customer'");
    $data["totalCustomers"] = mysqli_num_rows($result);

    // total transporters
    $result = mysqli_query($conn, "SELECT id FROM users WHERE role='transporter'");
    $data["totalTransporters"] = mysqli_num_rows($result);

    // total products
    $result = mysqli_query($conn, "SELECT id FROM products");
    $data["totalProducts"] = mysqli_num_rows($result);

    // total orders
    $result = mysqli_query($conn, "SELECT id FROM orders");
    $data["totalOrders"] = mysqli_num_rows($result);

    // pending orders
    $result = mysqli_query($conn, "SELECT id FROM orders WHERE status='pending'");
    $data["pendingOrders"] = mysqli_num_rows($result);

    // total commission earned by admin from COMPLETED orders only
    // Step 1: Get commission rate from platform_commission table
    $commissionRate = 10; // Default 10% if not set
    $commRateResult = mysqli_query($conn, "SELECT farmer_commission FROM platform_commission LIMIT 1");
    if ($commRateResult && $commRateRow = mysqli_fetch_assoc($commRateResult)) {
        $commissionRate = $commRateRow['farmer_commission'];
    }

    // Step 2: Calculate total commission from completed orders
    $result = mysqli_query($conn, "SELECT SUM(total_amount) as totalSales FROM orders WHERE status = 'completed'");
    $row = mysqli_fetch_assoc($result);
    if ($row['totalSales']) {
        // Commission = Total Sales * (Commission Rate / 100)
        $data["totalCommission"] = round($row['totalSales'] * ($commissionRate / 100), 2);
    } else {
        $data["totalCommission"] = 0;
    }

    return $data;
}

// recent 5 users ano
function getRecentUsers()
{
    $conn = dbConnect();

    if (!$conn) {
        return false;
    }

    $sql = "SELECT id, name, email, role, status FROM users ORDER BY id DESC LIMIT 5";
    $result = mysqli_query($conn, $sql);

    return $result;
}

// pending users list ano
function getPendingUsers()
{
    $conn = dbConnect();

    if (!$conn) {
        return false;
    }

    $sql = "SELECT id, name, email, role FROM users WHERE status=0";
    $result = mysqli_query($conn, $sql);

    return $result;
}

// recent 5 orders ano
function getRecentOrders()
{
    $conn = dbConnect();

    if (!$conn) {
        return false;
    }

    $sql = "SELECT id, customer_id, total_amount, status, created_at FROM orders ORDER BY id DESC LIMIT 5";
    $result = mysqli_query($conn, $sql);

    return $result;
}

// user approve or block kori
function updateUserStatus($userId, $status)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }

    return mysqli_query($conn, "UPDATE users SET status = $status WHERE id=$userId");
}

// all users ano
function getAllUsers()
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }

    return mysqli_query($conn, "SELECT * FROM users");
}
