<?php

session_start();
require_once __DIR__ . "/../../Model/auth/userModel.php";

/*
    jodi POST request hoy, POST request → AJAX register attempt
*/


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userName = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    //basic server side validation 
    if ($userName === '' || $email === '' || $phone === '' || $password === '' || $role === '' || $confirmPassword === '') {
        echo json_encode([
            "success" => false,
            "message" => "All fields are required"
        ]);
        exit;
    }

    //password match check
    if ($password !== $confirmPassword) {
        echo json_encode([
            "success" => false,
            "message" => "Passwords do not match"
        ]);
        exit;
    }

    //duplicate email check 
    if (emailExists($email)) {
        echo json_encode([
            "success" => false,
            "message" => "Email already exists"
        ]);
        exit;
    }

    //convert password to hashed password 
    $hashedPass = password_hash($password, PASSWORD_DEFAULT);

    //insert user 
    if (insertUser($userName, $email, $phone, $hashedPass, $role, 1)) {
        echo json_encode([
            "success" => true,
            "message" => "User registered successfully"
        ]);
        exit;
    } else {
        echo json_encode([
            "success" => false,
            "message" => "User registration failed"
        ]);
        exit;
    }
}
