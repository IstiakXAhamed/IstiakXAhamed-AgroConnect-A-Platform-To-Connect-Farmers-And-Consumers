<?php
require_once __DIR__ . "/../dbConnect.php";

// platform commission config db theke anbo
function getCommissionConfig()
{
    $conn = dbConnect();
    if (!$conn) {
        // default values return kori
        return array("farmer_commission" => "0");
    }

    $sql = "SELECT farmer_commission FROM platform_commission LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    //debugging er jonno add korsi 
    // database e data nai, default return
    return array("farmer_commission" => "0");
}

// delivery rules db theke anbo
function getDeliveryRules()
{
    $conn = dbConnect();
    if (!$conn) {
        //debugging er jonno add korsi
        echo "Database connection failed";
        // default values return kori
        return array(
            "inside_city_charge" => "0",
            "outside_city_charge" => "0",
            "base_weight" => "0",
            "extra_weight_unit" => "0",
            "extra_charge" => "0"
        );
    }

    $sql = "SELECT * FROM delivery_rules LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    //debugging er jonno add korsi 
    // database e data nai, default return
    return array(
        "inside_city_charge" => "0",
        "outside_city_charge" => "0",
        "base_weight" => "0",
        "extra_weight_unit" => "0",
        "extra_charge" => "0"
    );
}


// farmer commission update
function updateCommission($farmerCommission)
{
    $conn = dbConnect();
    if (!$conn) return false;

    $farmerCommission = (float)$farmerCommission;

    // check if record exists
    $check = mysqli_query($conn, "SELECT id FROM platform_commission LIMIT 1");
    //debugging er jonno add korsi 
    if ($check && mysqli_num_rows($check) > 0) {
        $sql = "UPDATE platform_commission SET farmer_commission = $farmerCommission, updated_at = NOW() WHERE id = 1";
    } else {
        $sql = "INSERT INTO platform_commission (farmer_commission, updated_at) VALUES ($farmerCommission, NOW())";
    }

    return mysqli_query($conn, $sql);
}


//delivery rules update
function updateDeliveryRules($inside, $outside, $base, $unit, $charge)
{
    $conn = dbConnect();
    if (!$conn) return false;

    // check if record exists
    $check = mysqli_query($conn, "SELECT id FROM delivery_rules LIMIT 1");

    if ($check && mysqli_num_rows($check) > 0) {
        $sql = "UPDATE delivery_rules SET inside_city_charge = $inside, outside_city_charge = $outside, base_weight = $base, extra_weight_unit = $unit, extra_charge = $charge, updated_at = NOW() WHERE id = 1";
    } else {
        $sql = "INSERT INTO delivery_rules (inside_city_charge, outside_city_charge, base_weight, extra_weight_unit, extra_charge, updated_at) VALUES ($inside, $outside, $base, $unit, $charge, NOW())";
    }

    return mysqli_query($conn, $sql);
}
