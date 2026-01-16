<?php
include "../..Model/db.php";
session_start();

$fid = $_SESSION['user_id'];

$name = $POST['name'];
$price = $POST['price'];
$qty = $POST['quantity'];
$desc = $POST['description'];

$img = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

move_uploaded_file($tmp,"../../uploads/".$img);

$path = "uploads/".$img;

pg_query($conn,"INSERT INTO products(farmer_id,name,price,quantity,description,image_path)VALUES($fid,'$name',$price,$qty,'$desc','$path')");

header("Location: ../../View/farmer/dashboard.pdp");
?>
