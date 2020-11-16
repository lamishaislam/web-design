<?php
$servername = "localhost";
$username = "root";
$password = "";
$database_in_use = "chef";

// Create connection
$conn = new mysqli($servername, $username, $password, $database_in_use);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}else{
// echo "Connected successfully <br>";
}