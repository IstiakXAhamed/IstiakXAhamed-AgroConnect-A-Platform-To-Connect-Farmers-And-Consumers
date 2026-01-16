<?php
include "../../Model/db.php";
session_start();
$fid = $_SESSION['user_id'];

$q = "SELECT SUM(products.price * orders.quantity) AS total FROM orders JOIN products ON orders.product_id=products.id WHERE products.farmer_id=$fid AND orders.status='approved'";

$res = pg_fetch_assoc(pg_query($conn,$q));
?>

<link rel="stylesheet" href="../../CSS/farmer.css">

<div class="container">
    <h2>Your Earnings</h2>
    <h1>Total <?= $res['total'] ?></h1>
</div>