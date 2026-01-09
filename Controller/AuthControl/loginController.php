<?php
session_start();

// UserModel include kori (etar vitorei dbConnect use hocche)
require_once __DIR__ . "/../../Model/auth/UserModel.php";

/*
   jodi POST request hoy, POST request → AJAX login attempt
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $email = trim($_POST['email'] ?? "");
    $password = trim($_POST['password'] ?? "");

    if ($email === "" || $password === "") {
        echo json_encode([
            "success" => false,
            "message" => "Email and Password both are Required"
        ]);
        exit;
    }

    $user = getUserByEmail($email);
    if ($user === false) {
        echo json_encode([
            "success" => false,
            "message" => "User not found"
        ]);
        exit;
    }
    //pass vul dile check korbo , ekhane password_verify() eta hash check kore !user ekhane assiociative array returened
    //from UserModel.php getUserByEmail function 

    if (!password_verify($password, $user["password"])) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid password"
        ]);
        exit;
    }
    //password thik thakle tokhon jodi valid input hoi ! 

    echo json_encode([
        "success" => true,
        "message" => "Login Successful",
        "redirect" => "../../View/" . $user["role"] . "/dashboard.php"
    ]);
    exit;
}

/*
    ekhane ashle mane GET request
   age check kori user already logged in kina
*/
if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'admin':
            header("Location: ../../View/admin/dashboard.php");
            exit;
        case 'farmer':
            header("Location: ../../View/farmer/dashboard.php");
            exit;
        case 'customer':
            header("Location: ../../View/customer/dashboard.php");
            exit;
        case 'transporter':
            header("Location: ../../View/transporter/dashboard.php");
            exit;
    }
}

/*
   kono session nai, tai login page dekhai
*/
require_once '../../View/login.php';
