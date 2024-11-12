<?php 
include 'database.php';

session_start();


if (isset($_SESSION['user_id'])) {
    $accNo = $_SESSION['acc_no'];
    $balance = $_SESSION['balance'];

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['amount'])){
        $amount = $_POST['amount'];

            $updateBalance = $balance + $amount;

            $query = "UPDATE users SET balance = ? WHERE acc_no = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("di", $updateBalance, $accNo);

            if($stmt->execute()){
                $_SESSION['balance'] = $updateBalance;
                echo "<p> Amount Deposited Successfully! </p>";
            }
            else{
                echo "<p> Deposit Failed! </p>";
            }
         
    }
} 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATM Simulator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Deposit</h1>

    <form method="post" action="">
        <label for="amount">Amount to Deposit</label>
        <input type="number" name="amount" placeholder="Amount to deposit" required> <br><br>
        <button type="submit">Confirm Deposit</button>
    </form>
    <br><br>

    <button onclick="location.href='menu.php'">Back To Menu</button>
</body>
</html>