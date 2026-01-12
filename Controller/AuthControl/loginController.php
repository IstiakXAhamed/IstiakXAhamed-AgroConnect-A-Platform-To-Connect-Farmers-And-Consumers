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
    $remember = isset($_POST['remember']) && $_POST['remember'] === 'true';

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
    //password thik thakle tokhon jodi valid input hoi!

    // Session e user info store kori
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];

    // Remember Me cookie set kori
    if ($remember) {
        // 30 din er jonno cookie set (password base64 encoded)
        setcookie('remember_email', $email, time() + (30 * 24 * 60 * 60), '/');
        setcookie('remember_pass', base64_encode($password), time() + (30 * 24 * 60 * 60), '/');
    } else {
        // Cookie delete kori
        setcookie('remember_email', '', time() - 3600, '/');
        setcookie('remember_pass', '', time() - 3600, '/');
    }

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
