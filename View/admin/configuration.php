<!DOCTYPE html>
<html>

<head>
    <title>Admin Configuration</title>
    <script>
        function updateConfig() {
            var farmerCommission = document.getElementById("farmerCommission").value;
            var insideDeliveryCharge = document.getElementById("insideDeliveryCharge").value;
            var outsideDeliveryCharge = document.getElementById("outsideDeliveryCharge").value;
            var baseWeight = document.getElementById("baseWeight").value;
            var extraUnitCharge = document.getElementById("extraUnitCharge").value;
            var extraCharge = document.getElementById("extraCharge").value;
            var result = document.getElementById("result");

            result.innerHTML = "";

            if (farmerCommission == "" || insideDeliveryCharge == "" || outsideDeliveryCharge == "" ||
                baseWeight == "" || extraUnitCharge == "" || extraCharge == "") {
                result.innerHTML = "All fields are required";
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../../Controller/admin/configController.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    result.innerHTML = response.message;
                }
            }

            xhr.send("farmerCommission=" + farmerCommission + "&insideDeliveryCharge=" + insideDeliveryCharge + "&outsideDeliveryCharge=" + outsideDeliveryCharge + "&baseWeight=" + baseWeight + "&extraUnitCharge=" + extraUnitCharge + "&extraCharge=" + extraCharge);
        }
    </script>
</head>

<body>
    <h2>Admin Configuration</h2>

    <!-- Current Settings Table -->
    <h3>Current Settings</h3>
    <table border="1" cellpadding="10">
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
        <tr>
            <td>Updated At</td>
            <td><?php echo $delivery['updated_at']; ?></td>
            <td>When settings were last updated</td>
        </tr>
    </table>

    <br>
    <hr><br>

    <!-- Update Form - no table, just simple form -->
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

        <button type="button" onclick="updateConfig()">Update Configuration</button>
        <span id="result"></span>
    </form>

    <br>
    <a href="../../View/admin/dashBoard.php">Back to Dashboard</a>
</body>

</html>