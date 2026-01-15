<?php
session_start();

// admin security check
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../../View/login.php");
    exit;
}

// model include
require_once __DIR__ . "/../../Model/admin/configModel.php";

// POST request - AJAX update, return JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $farmerCommission = $_POST['farmerCommission'];
    $insideDeliveryCharge = $_POST['insideDeliveryCharge'];
    $outsideDeliveryCharge = $_POST['outsideDeliveryCharge'];
    $baseWeight = $_POST['baseWeight'];
    $extraUnitCharge = $_POST['extraUnitCharge'];
    $extraCharge = $_POST['extraCharge'];

    // validation - check empty
    if ($farmerCommission == "" || $insideDeliveryCharge == "" || $outsideDeliveryCharge == "" || $baseWeight == "" || $extraUnitCharge == "" || $extraCharge == "") {
        echo json_encode(
            [
                "success" => false,
                "message" => "All fields are required"
            ]
        );
        exit;
    }

    // validation - check numeric
    if (!is_numeric($farmerCommission) || !is_numeric($insideDeliveryCharge) || !is_numeric($outsideDeliveryCharge) || !is_numeric($baseWeight) || !is_numeric($extraUnitCharge) || !is_numeric($extraCharge)) {
        echo json_encode(   
            [
                "success" => false,
                "message" => "All values must be numeric"
            ]
        );
        exit;
    }

    // update database
    $commissionUpdated = updateCommission($farmerCommission);
    $deliveryUpdated = updateDeliveryRules($insideDeliveryCharge, $outsideDeliveryCharge, $baseWeight, $extraUnitCharge, $extraCharge);

    if ($commissionUpdated && $deliveryUpdated) {
        echo json_encode(
            [
                "success" => true,
                "message" => "Configuration updated successfully"
            ]
        );
    } else {
        echo json_encode(
            [
                "success" => false,
                "message" => "Configuration update failed"
            ]
        );
    }
    exit;
}

// GET request - load data and show view
$commission = getCommissionConfig();
$delivery = getDeliveryRules();

// include view
require_once __DIR__ . "/../../View/admin/configuration.php";
