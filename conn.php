<?php
$servername = "localhost";
$username = "dapps";
$password = "l1m4d1g1t";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";






?>