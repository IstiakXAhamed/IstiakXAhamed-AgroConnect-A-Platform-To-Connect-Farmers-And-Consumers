<?php
include "../../Model/db.php";
$id = $_GET['id'];

pg_query($conn,"DELETE FROM products WHERE id=$id");

header("Location: ../../View/farmer/dashboard.php");
?>