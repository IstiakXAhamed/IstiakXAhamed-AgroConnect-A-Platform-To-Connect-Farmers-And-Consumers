<?php
session_start();

//admin security er jonno role checking 

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../../View/login.php");
    exit;
}


//model include 
require_once __DIR__ . "/../../Model/admin/adminModel.php";
require_once __DIR__ . "/../../Model/admin/configModel.php";

// AjaxPOST request handle korbo 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userId = $_POST['userId'] ?? "";
    $action = $_POST['action'] ?? "";

    if ($userId === "" || ($action !== "approve" && $action !== "block")) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid request"
        ]);
        exit;
    }

    // approve = 1, block = 0
    $status = ($action === "approve") ? 1 : 0;

    if (updateUserStatus($userId, $status)) {
        echo json_encode([
            "success" => true,
            "message" => "User status updated"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Database update failed"
        ]);
    }
    exit;
}
//load and view data of users ! 
$users = getAllUsers();
require_once __DIR__ . "/../../View/admin/manageUsers.php";
