<!DOCTYPE html>
<html>

<head>
    <title>AgroConnect - Products</title>
    <link rel="stylesheet" href="../../View/customer/css/customer.css">

    <!-- AJAX Script for Live Search with Filter -->
    <script>
        // STEP 1: callAjax() - jokhn user type kore
        // Ei function SearchResult.php ke call kore suggestion ante
        function callAjax() {
            let keyword = document.getElementById("keyword").value.trim();
            let result = document.getElementById("result");

            if (keyword.length > 0) {
                // AJAX request pathay SearchResult.php te
                let xhr = new XMLHttpRequest();
                xhr.open("GET", "../../Controller/customer/SearchResult.php?keyword=" + keyword, true);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Response asle result span e show kore
                        result.innerHTML = xhr.responseText;
                    }
                }
                xhr.send();
            } else {
                result.innerHTML = "";
                // Keyword empty hole sob product dekhai
                showAllProducts();
            }
        }

        // STEP 2: selectSuggestion() - jokhn user suggestion e CLICK kore
        // Ei function suggestion theke product name extract kore filter kore
        function selectSuggestion(suggestion) {
            // Suggestion format: "Alu (Potato)" - first word ta nite hobe
            let searchTerm = suggestion.split(" ")[0].toLowerCase();

            // Search box e suggestion ta boshai
            document.getElementById("keyword").value = suggestion;

            // Result clear kori
            document.getElementById("result").innerHTML = "<span style='color:#27ae60;'>✓ Filtering by: " + suggestion + "</span>";

            // Products filter kori
            filterProducts(searchTerm);
        }

        // STEP 3: filterProducts() - products grid e matching products rakhe
        // Baki products hide kore dey
        function filterProducts(searchTerm) {
            // Sob product card niye ashi
            let cards = document.querySelectorAll(".product-card");
            let found = 0;

            cards.forEach(function(card) {
                // Product er name ta niye ashi (h4 tag theke)
                let productName = card.querySelector("h4").innerText.toLowerCase();

                // Jodi product name e searchTerm thake tahole show kori
                if (productName.includes(searchTerm)) {
                    card.style.display = "block"; // Show 
                    found++;
                } else {
                    card.style.display = "none"; // Hide
                }
            });

            // Jodi kono product na pawa jay
            if (found == 0) {
                document.getElementById("result").innerHTML =
                    "<span style='color:#e74c3c;'>No products found matching: " + searchTerm + "</span>";
            }
        }

        // STEP 4: showAllProducts() - sob products dekhai (reset)
        function showAllProducts() {
            let cards = document.querySelectorAll(".product-card");
            cards.forEach(function(card) {
                card.style.display = "block";
            });
        }
    </script>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <h2>AgroConnect</h2>
        <div class="header-links">
            <a href="../../Controller/customer/customerDashboardController.php">Products</a>
            <a href="../../Controller/customer/cartController.php">My Cart</a>
            <a href="../../Controller/customer/ordersController.php">My Orders</a>
            <a href="../../Controller/AuthControl/logoutController.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">

        <h3 style="margin-bottom: 20px;">Available Products</h3>

        <!-- Live Search Box -->
        <div class="search-box" style="margin-bottom: 20px;">
            <input type="text" id="keyword" placeholder="Search products (e.g. alu, mango, chicken...)"
                onkeyup="callAjax()" style="padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 5px;">

            <!-- Show All Button -->
            <button onclick="showAllProducts(); document.getElementById('keyword').value=''; document.getElementById('result').innerHTML='';"
                style="margin-left: 10px; padding: 10px 15px; background: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Show All
            </button>

            <br><br>
            <!-- Suggestion appears here -->
            <span id="result"></span>
        </div>

        <!-- Product Cards Grid -->
        <div class="products-grid">

            <?php
            if ($products && mysqli_num_rows($products) > 0) {
                while ($product = mysqli_fetch_assoc($products)) {
                    // Image or placeholder
                    $imgSrc = ($product['image'] != "")
                        ? "../../{$product['image']}"
                        : "../../View/upload/no-image.png";
            ?>

                    <div class="product-card">
                        <!-- Product Image -->
                        <img src="<?php echo $imgSrc; ?>" alt="<?php echo $product['product_name']; ?>">

                        <!-- Product Info -->
                        <div class="product-info">
                            <h4><?php echo $product['product_name']; ?></h4>
                            <p class="category"><?php echo $product['category_name'] ?? 'Uncategorized'; ?></p>

                            <p class="farmer">By: <?php echo $product['farmer_name']; ?></p>
                            <p class="price">৳<?php echo $product['price']; ?></p>

                            <p class="stock">Stock: <?php echo $product['quantity']; ?></p>
                        </div>

                        <!-- Add to Cart -->
                        <form action="../../Controller/customer/cartController.php" method="POST" class="card-form">

                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="productId" value="<?php echo $product['id']; ?>">

                            <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['quantity']; ?>">
                            <button type="submit">Add to Cart</button>
                        </form>
                    </div>

            <?php
                }
            } else {
                echo "<p>No products available</p>";
            }
            ?>

        </div>

    </div>

</body>

</html>