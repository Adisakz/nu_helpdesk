<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "nuservice2024";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}



$conn->set_charset("utf8");




?>
