<?php
session_start();

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer")
    {
        header("Location: ../..View/login.php");
        exit;
    }

    $farmerId = $_SESSION["user_id"];

    require_once __DIR__ . "/../../Model/farmer/productModel.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $action = $_POST['action'];

            if ($action == "add") {
                $name = $_POST['productName'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];
                $description = $_POST['description'];

                $imagePath = "";
                if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
                    $uploadDir = "../../uploads/products/";
                    $fileName = time() . "_" .$_FILES['productImage']['name'];
                    $targetPath = $uploadDir . $fileName;

                    if (move_uploaded_file($_FILES['productImage']['tmp_name'], $targetPath)) {
                        $imagePath = "uploads/products/" . $fileName;
                    }
                }
                $result = addProduct($farmerId, $name, $price, $quantity, $imagePath, $description);
                if ($result) {
                    header("Location: ../../View/farmer/myProducts.php?success=Product added");

                }
                else{
                    header("Location: ../../View/farmer/addProduct.php?error=Failed");
                }
                exit;
            }

            if ($action == "update") 
                {
                   $productId = $_POST['productId'];
                   $name = $_POST['productName'];
                   $price = $_POST['price'];
                   $quantity = $_POST['quantity'];
                   $description = $_POST['description'];
                   
                   $imagePath ="";
                   if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0)
                    {
                        $uploadDir = "../../uploads/products/";
                        $fileName = time() . "_" . $_FILES['productImage']['name'];
                        $targetPath = $uploadDir . $fileName;

                        if (move_uploaded_file($_FILES['productImage']['tmp_name'], $targetPath)) 
                            {
                                $imagePath = "uploads/products/" . $fileName;

                            }
                    }

                    $result = updateProduct($productId, $name, $price, $quantity, $imagePath, $description);

                    if ($reslt) {
                        header("Location: ../../View/farmer/myProducts.php?success=Updated");
                    }
                    else {
                        header("Location: ../farmer/editProduct.php?id=$productId&error=Failed");
                    }
                    exit;
                }

                if ($action == "delete")
                    {
                        $productId = $_POST['productId'];
                        deleteProduct($productId);
                        header("Location: ../../View/myProducts.php?success=Deleted");
                        exit;
                    }
        }
        header("Location: ../../View/farmer/dashBoard.php");
        exit;
        ?>

        
