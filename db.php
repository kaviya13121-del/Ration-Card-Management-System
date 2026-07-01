<?php
$conn = new mysqli("localhost", "root", "", "rationsystem");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
