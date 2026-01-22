<!DOCTYPE html>
<html>

<head>
    <title>Order #<?php echo $orderId; ?> Details</title>
    <link rel="stylesheet" href="../../View/customer/css/customer.css">
</head>

<body>

    <!-- Header -->
    <div class="header">
        <h2>Order #<?php echo $orderId; ?></h2>
        <div class="header-links">
            <a href="customerDashboardController.php">Products</a>
            <a href="cartController.php">My Cart</a>
            <a href="ordersController.php">My Orders</a>
            <a href="../AuthControl/logoutController.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">

        <?php if (isset($_GET['success'])): ?>
            <div class="success-msg"><?php echo $_GET['success']; ?></div>
        <?php endif; ?>

        <!-- Order Info -->
        <div class="section">
            <h3>Order Information</h3>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>#<?php echo $order['id']; ?></td>
                    <td class="revenue">৳<?php echo $order['total_amount']; ?></td>
                    <td><?php echo $order['status']; ?></td>
                    <td><?php echo $order['created_at']; ?></td>
                    <td>
                        <?php if ($order['status'] === 'approved'): ?>
                            <form action="../../Controller/customer/confirmReceivedController.php" method="POST" style="display:inline;">
                                <input type="hidden" name="orderId" value="<?php echo $order['id']; ?>">
                                <button type="submit" class="btn-cart" onclick="return confirm('Confirm you received this order?')">
                                    ✓ Mark as Received
                                </button>
                            </form>
                        <?php elseif ($order['status'] === 'completed'): ?>
                            <span style="color:green; font-weight:bold;">✓ Completed</span>
                        <?php else: ?>
                            <span style="color:orange;">Waiting for approval</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Order Items -->
        <div class="section">
            <h3>Order Items</h3>
            <table>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Farmer</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                <?php
                if ($orderItems && mysqli_num_rows($orderItems) > 0) {
                    while ($item = mysqli_fetch_assoc($orderItems)) {
                        $img = ($item['image'] != "")
                            ? "<img src='../../{$item['image']}' width='50'>"
                            : "No image";
                        $itemTotal = $item['price'] * $item['quantity'];

                        echo "<tr>
                            <td>{$img}</td>
                            <td>{$item['product_name']}</td>
                            <td>{$item['farmer_name']}</td>
                            <td>৳{$item['price']}</td>
                            <td>{$item['quantity']}</td>
                            <td class='revenue'>৳{$itemTotal}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No items found</td></tr>";
                }
                ?>
            </table>
        </div>

        <a href="ordersController.php" style="display:inline-block; margin-top:15px;">← Back to Orders</a>

    </div>

</body>

</html>