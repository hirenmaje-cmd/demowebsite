<?php
$host = 'localhost';
$db_user = 'root';
$db_pass = ''; // Insert your database password here
$db_name = 'prg_gaming';

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>