<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "db.php";

$card_number = $_GET['card'] ?? '';

include "db.php";

$card_number = $_GET['card'] ?? '';


$sql = "SELECT * FROM ration_card WHERE card_number='$card_number'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Card not found");
}

$card = $result->fetch_assoc();
$card_id = $card['card_id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Ration Dashboard</title>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    background: #f4f6f8;
}

.header {
    background: #2E7D32;
    color: white;
    padding: 20px;
    text-align: center;
}

.container {
    width: 90%;
    margin: 30px auto;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin-bottom: 25px;
}

h3 {
    margin-top: 0;
    color: #2E7D32;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

th {
    background: #e8f5e9;
}

.badge {
    display: inline-block;
    padding: 6px 12px;
    background: #4CAF50;
    color: white;
    border-radius: 20px;
    font-size: 13px;
}
</style>

</head>
<body>

<div class="header">
    <h2>Ration Card Citizen Dashboard</h2>
</div>

<div class="container">

<!-- Card Details -->
<div class="card">
    <h3>Card Details</h3>
    <p><b>Card Number:</b> <?php echo $card['card_number']; ?></p>
    <p><b>Head Name:</b> <?php echo $card['head_name']; ?></p>
    <p><b>Address:</b> <?php echo $card['address']; ?></p>
    <p><b>Type:</b> <span class="badge"><?php echo $card['card_type']; ?></span></p>
    <p><b>Phone:</b> <?php echo $card['phone']; ?></p>
</div>

<!-- Family Members -->
<div class="card">
<h3>Family Members</h3>
<table>
<tr>
    <th>Name</th>
    <th>Age</th>
    <th>Gender</th>
    <th>Relation</th>
</tr>

<?php
$members = $conn->query("SELECT * FROM family_member WHERE card_id=$card_id");
while($m = $members->fetch_assoc()) {
    echo "<tr>
            <td>{$m['name']}</td>
            <td>{$m['age']}</td>
            <td>{$m['gender']}</td>
            <td>{$m['relation']}</td>
          </tr>";
}
?>
</table>
</div>

<!-- Transactions -->
<div class="card">
<h3>Recent Transactions</h3>
<table>
<tr>
    <th>Date</th>
    <th>Product</th>
    <th>Quantity</th>
    <th>Amount</th>
</tr>

<?php
$tx = $conn->query("
SELECT t.*, p.product_name 
FROM transactions t
JOIN products p ON t.product_id=p.product_id
WHERE t.card_id=$card_id
ORDER BY t.txn_date DESC
");

while($t = $tx->fetch_assoc()) {
    echo "<tr>
            <td>{$t['txn_date']}</td>
            <td>{$t['product_name']}</td>
            <td>{$t['quantity']}</td>
            <td>{$t['amount']}</td>
          </tr>";
}
?>
</table>
</div>

</div>
</body>
</html>
