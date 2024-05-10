<?php
// Database credentials
$host = "localhost";
$username = "root";
$password = "rich0505";
$database = "crudphp";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
?>