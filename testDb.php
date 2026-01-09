<?php
require_once "Model/auth/UserModel.php";

$user = getUserByEmail("admin@test.com");

if ($user) {
    echo "User found: " . $user['name'];
} else {
    echo "User not found";
}
