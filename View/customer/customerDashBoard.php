<!DOCTYPE html>
<html>
    <head>
        <title>
            Customer Dahsboard 
        </title>
    </head>
<body>
    <h2>Available Products </h2>

    <?php
    if(empty($products)){
        echo "No products Available !";

    }
    else{
        echo  "
        <table border='1'>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Product Quantity</th>
                <th>Product Description</th>
                <th>Product Image</th>
                <th>Product Category</th>
                <th>Product Stock</th>
                <th>Product Status</th>
                <th>Product Added Date</th>
                <th>Product Added By</th>
            </tr>
        ";

        foreach($products as $product){
            

    }    
    ?>

</body>
</html>