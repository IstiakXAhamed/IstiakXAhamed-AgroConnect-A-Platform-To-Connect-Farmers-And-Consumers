<!DOCTYPE html>
<html>

<head>
    <title>My Cart</title>
    <link rel="stylesheet" href="../../View/customer/css/customer.css">
</head>

<body>

    <!-- Header -->
    <div class="header">
        <h2>My Cart (<?php echo $cartCount; ?> items)</h2>
        <div class="header-links">
            <a href="customerDashboardController.php">Products</a>
            <a href="cartController.php">My Cart</a>
            <a href="ordersController.php">My Orders</a>
            <a href="../AuthControl/logoutController.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">



        <div class="section">
            <h3>Cart Items</h3>

            <?php if ($cartItems && mysqli_num_rows($cartItems) > 0):
                echo "<table>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Farmer</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    ";
                while ($item = mysqli_fetch_assoc($cartItems)) {

                    $img = ($item['image'] != "")
                        ? "<img src='../../{$item['image']}' width='50'>"
                        : "No image";
                    $itemTotal = $item['price'] * $item['cart_quantity'];

                    echo "<tr>
                            <td>{$img}</td>
                            <td>{$item['product_name']}</td>
                            <td>{$item['farmer_name']}</td>
                            <td>৳{$item['price']}</td>
                            <td>
                                <form action='cartController.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='action' value='update'>
                                    <input type='hidden' name='cartId' value='{$item['cart_id']}'>
                                    <input type='number' name='quantity' value='{$item['cart_quantity']}' min='1' style='width:50px;'>
                                    <button type='submit'>Update</button>
                                </form>
                            </td>
                            <td class='revenue'>৳{$itemTotal}</td>
                            <td>
                                <form action='cartController.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='action' value='remove'>
                                    <input type='hidden' name='cartId' value='{$item['cart_id']}'>
                                    <button type='submit' class='btn-remove'>Remove</button>
                                </form>
                            </td>
                        </tr>";
                }
            ?>
                </table>

                <!-- Cart Total -->
                <div style="margin-top:20px; text-align:right;">
                    <h3>Total: <span class="revenue">৳<?php echo number_format($cartTotal, 2); ?></span></h3>
                    <br>
                    <form action="checkoutController.php" method="POST">
                        <button type="submit" class="btn-cart" style="padding:12px 30px; font-size:16px;">
                            Proceed to Checkout
                        </button>
                    </form>
                </div>

            <?php else: ?>
                <p>Your cart is empty. <a href="customerDashboardController.php">Browse products</a></p>
            <?php endif; ?>

        </div>

    </div>

</body>

</html>