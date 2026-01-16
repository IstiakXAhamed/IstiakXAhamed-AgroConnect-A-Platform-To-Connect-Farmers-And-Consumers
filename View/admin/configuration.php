<!DOCTYPE html>
<html>

<head>
    <title>Admin Configuration</title>
    <link rel="stylesheet" href="../../View/admin/css/adminDashBoard.css">
    <script>
        function updateConfig() {
            let farmerCommission = document.getElementById("farmerCommission").value;
            let insideDeliveryCharge = document.getElementById("insideDeliveryCharge").value;
            let outsideDeliveryCharge = document.getElementById("outsideDeliveryCharge").value;
            let baseWeight = document.getElementById("baseWeight").value;
            let extraUnitCharge = document.getElementById("extraUnitCharge").value;
            let extraCharge = document.getElementById("extraCharge").value;
            let result = document.getElementById("result");

            result.innerHTML = "";

            if (farmerCommission == "" || insideDeliveryCharge == "" || outsideDeliveryCharge == "" ||
                baseWeight == "" || extraUnitCharge == "" || extraCharge == "") {
                result.innerHTML = "All fields are required";
                result.style.color = "red";
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "configController.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    let response = JSON.parse(xhr.responseText);
                    result.innerHTML = response.message;
                    result.style.color = response.success ? "green" : "red";
                }
            }

            xhr.send("farmerCommission=" + farmerCommission + "&insideDeliveryCharge=" + insideDeliveryCharge + "&outsideDeliveryCharge=" + outsideDeliveryCharge + "&baseWeight=" + baseWeight + "&extraUnitCharge=" + extraUnitCharge + "&extraCharge=" + extraCharge);
        }
    </script>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <h2>Configuration</h2>
        <div class="header-links">
            <a href="../../Controller/admin/adminDashboardController.php">Dashboard</a>
            <a href="../../Controller/admin/manageUsersController.php">Manage Users</a>
            <a href="../../Controller/AuthControl/logoutController.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">

        <!-- Current Settings -->
        <div class="section">
            <h3>Current Settings</h3>
            <table>
                <tr>
                    <th>Setting</th>
                    <th>Current Value</th>
                    <th>Description</th>
                </tr>
                <tr>
                    <td>Farmer Commission</td>
                    <td><?php echo $commission['farmer_commission']; ?>%</td>
                    <td>Platform takes this % from farmer sales</td>
                </tr>
                <tr>
                    <td>Inside City Charge</td>
                    <td><?php echo $delivery['inside_city_charge']; ?> Tk</td>
                    <td>Base delivery charge for inside city</td>
                </tr>
                <tr>
                    <td>Outside City Charge</td>
                    <td><?php echo $delivery['outside_city_charge']; ?> Tk</td>
                    <td>Base delivery charge for outside city</td>
                </tr>
                <tr>
                    <td>Base Weight</td>
                    <td><?php echo $delivery['base_weight']; ?> kg</td>
                    <td>Minimum weight required to place order</td>
                </tr>
                <tr>
                    <td>Extra Unit Charge</td>
                    <td><?php echo $delivery['extra_weight_unit']; ?> Tk/kg</td>
                    <td>Per kg charge above base weight</td>
                </tr>
                <tr>
                    <td>Extra Charge</td>
                    <td><?php echo $delivery['extra_charge']; ?> Tk</td>
                    <td>Flat charge if weight exceeds base weight</td>
                </tr>
            </table>
        </div>

        <!-- Update Form -->
        <div class="section">
            <h3>Update Settings</h3>
            <form id="configForm">

                <label>Farmer Commission (%):</label><br>
                <input type="number" id="farmerCommission" value="<?php echo $commission['farmer_commission']; ?>">
                <br><br>

                <label>Inside City Charge (Tk):</label><br>
                <input type="number" id="insideDeliveryCharge" value="<?php echo $delivery['inside_city_charge']; ?>">
                <br><br>

                <label>Outside City Charge (Tk):</label><br>
                <input type="number" id="outsideDeliveryCharge" value="<?php echo $delivery['outside_city_charge']; ?>">
                <br><br>

                <label>Base Weight (kg):</label><br>
                <input type="number" id="baseWeight" value="<?php echo $delivery['base_weight']; ?>">
                <br><br>

                <label>Extra Unit Charge (Tk/kg):</label><br>
                <input type="number" id="extraUnitCharge" value="<?php echo $delivery['extra_weight_unit']; ?>">
                <br><br>

                <label>Extra Charge (Tk):</label><br>
                <input type="number" id="extraCharge" value="<?php echo $delivery['extra_charge']; ?>">
                <br><br>

                <button type="button" class="btn-approve" onclick="updateConfig()">Update Configuration</button>
                <span id="result"></span>
            </form>
        </div>

    </div>

</body>

</html>