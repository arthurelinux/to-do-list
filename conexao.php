<?php

$servername = "db";
$username = "admin";
$password = "root";
$dbname = "testephp";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";