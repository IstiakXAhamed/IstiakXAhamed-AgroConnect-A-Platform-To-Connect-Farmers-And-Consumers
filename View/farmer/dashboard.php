<?php
require_once __DIR__ . '/../../Controller/farmer/farmerDashboardController.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Farmer Dashboard</title>
        <link rel="stylesheet" href="../../CSS/farmer.css">
    </head>
    <body>
        <h2>farmer Dashboard</h2>
        <p>Welcome, <?php echo $_SESSION["user_id"]; ?>!</p>

        <h3>Status</h3>
        <table border="1" cellpadding="10">
            <tr>
                <th>Total Products</th>
                <tr>
                    <td><?php echo $totalProducts; ?></td>
                </tr>
        </table>

        <hr>
        <a href="myProducts.php">My Products</a>
        <a href="addProducts.php">Add Product</a>
        <a href="../../Controller/AutControl/logoutController.php">Logout</a>
    </body>
</html>



