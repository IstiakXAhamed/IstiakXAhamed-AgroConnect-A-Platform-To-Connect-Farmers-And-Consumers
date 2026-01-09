<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbName = "agroconnect";
$port = 3306;

function dbConnect()
{
    global $host;
    global $user;
    global $pass;
    global $dbName;
    global $port;
    $conn = mysqli_connect($host, $user, $pass, $dbName, $port);

    if (!$conn) {
        // error show kori (debug er jonno)
        // echo "Database connect hoy nai<br>";
        // echo mysqli_connect_error();
        return false;
    } else {
        // echo "connection succefully establishe<br>";
        // var_dump($conn);
        return $conn;
    }
}
