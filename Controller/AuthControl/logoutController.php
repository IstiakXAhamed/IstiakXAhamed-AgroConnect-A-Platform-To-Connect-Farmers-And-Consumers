<?php


session_start();
session_unset();
session_destroy();

// login page e redirect kori
header("Location: ../../View/login.php");
exit;
