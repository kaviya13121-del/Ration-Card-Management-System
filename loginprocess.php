<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

$card = $_POST['card_number'] ?? '';
$pass = $_POST['password'] ?? '';

$sql = "SELECT * FROM ration_card WHERE card_number='$card' AND `password`='$pass'";

$result = mysqli_query($conn, $sql);

if(!$result){
    die("SQL Error: " . mysqli_error($conn));
}

if(mysqli_num_rows($result) == 1){
    header("Location: dashboard.php?card=$card");
    exit();
} else {
    echo "Invalid Login";
}
?>
