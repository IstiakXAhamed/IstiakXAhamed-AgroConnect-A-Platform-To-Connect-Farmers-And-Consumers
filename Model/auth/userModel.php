<?php
require_once __DIR__ . "/../dbConnect.php";

function getUserByEmail($email)
{
    $conn = dbConnect();
    // jodi connection fail hoy
    if (!$conn) {
        return false;
        var_dump($conn);
    }
    $query = "SELECT * FROM users WHERE email='$email' AND status=1";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        // associative array return korbo
        return mysqli_fetch_assoc($result);
    } else {
        //user na pele false return korbo
        return false;
    }
}
function insertUser($username, $email, $password, $role)
{
    $conn = dbConnect();
    // jodi connection fail hoy
    if (!$conn) {
        return false;
    }
    // new user insert kori
    // status=1 → active after registration 
    $query = "INSERT INTO users (username, email, password, role, status) VALUES ('$username', '$email', '$password', '$role',1)";
    $result = mysqli_query($conn, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}
function emailExists($email)
{
    $conn = dbConnect();

    if (!$conn) {
        return false;
    }

    $query = "SELECT id FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    // jodi ekta row o thake, mane email already ache
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function updateUserPassword($email, $password)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }
    $query = "UPDATE users SET password='$password' WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function deleteUser($username, $email)
{
    $conn = dbConnect();
    if (!$conn) {
        return false;
    }
    $query = "DELETE FROM users WHERE username='$username' AND email='$email'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        return true;
    } else {
        return false;
    }
}
