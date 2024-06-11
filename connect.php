<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "manchester_united_db";
$port = "3307";  

$conn = new mysqli($servername, $username, $password, $dbname, $port); 
if ($conn->connect_error) {
    die("Konekcija nije uspjela: " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8");
define('UPLPATH', 'uploads/'); 
?>
