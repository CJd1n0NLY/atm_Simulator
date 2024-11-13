<?php 
include 'database.php';

session_start();


if (isset($_SESSION['user_id'])) {
    $accNo = $_SESSION['acc_no'];
    $balance = $_SESSION['balance'];

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['amount'])){
        $amount = $_POST['amount'];

        if($amount > 0 && $amount <= $balance){
            $withdrawnBalance = $balance - $amount;

            $query = "UPDATE users SET balance = ? WHERE acc_no = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("di", $withdrawnBalance, $accNo);

            if($stmt->execute()){
                $_SESSION['balance'] = $withdrawnBalance;
                echo '<p>Withdrawal Successful</p>';
            }
            else{
                echo '<p>Withdrawal Failed</p>';
            }
        }
        else{
            echo '<p>Invalid amount. Please enter a valid amount.</p>';
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
    <h1>Withdraw</h1>

    <form method="post" action="">
        <label for="amount">Amount to Withdraw</label>
        <input type="number" name="amount" placeholder="Amount to withdraw" required> <br><br>
        <button type="submit">Confirm Withdraw</button>
    </form>
    <br><br>

    <button onclick="location.href='menu.php'">Back To Menu</button>
</body>
</html>