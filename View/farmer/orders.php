<?php
include "../../Model/db.php";
session_start();
$fid = $_SESSION['user_id'];

$q = "SELECT products.name, orders.quantity, orders.status FROM orders JOIN products ON orders.product_id=products.id WHERE products.farmer_id=$fid";

$res = pg_query($conn,$q);
?>

<link rel="stylesheet" href="../../CSS/farmer.css">

<div class="container">
    <h2>Orders</h2>
    <table>
        <tr>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Status</th>
            </tr>
            <?php while($product = pg_fetch_assoc($res)){ ?>
            <td><?=$product['name'] ?></td><br>
            <td><?=$product['quantity'] ?></td><br>
            <td><?=$product['status'] ?></td><br>
        </tr>
        <?php } ?>
    </table>
</div>