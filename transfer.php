<?php 
include 'database.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $balance = $_SESSION['balance'];
    $accNo = $_SESSION['acc_no'];

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['amount']) && isset($_POST['transfer_acc_no']) && isset($_POST['pin_code'])) {
        $amount = $_POST['amount'];
        $transferAccNo = $_POST['transfer_acc_no'];
        $pinCode = $_POST['pin_code'];

        // check current balance first
        if ($amount <= 0) {
            echo "<p>Invalid amount.</p>";
        } elseif ($amount > $balance) {
            echo "<p>Insufficient balance.</p>";
        } else {
            $stmt = $conn->prepare("SELECT pin_code FROM users WHERE acc_no = ?");
            $stmt->bind_param("s", $accNo);
            $stmt->execute();
            $stmt->bind_result($dbPin);
            $stmt->fetch();
            $stmt->close();

            if (md5($pinCode) != $dbPin) {
                echo "<p>Incorrect pin code.</p>";
            } else {
                // check transfer account if it is existing in the database
                $stmt = $conn->prepare("SELECT acc_no, balance FROM users WHERE acc_no = ?");
                $stmt->bind_param("s", $transferAccNo);
                $stmt->execute();
                $stmt->bind_result($transfereeAccNo, $transfereeBalance);
                if ($stmt->fetch()) {
                    $stmt->close();

                    // logged in account balance first
                    $updatedBalance = $balance - $amount;
                    $stmt = $conn->prepare("UPDATE users SET balance = ? WHERE acc_no = ?");
                    $stmt->bind_param("ds", $updatedBalance, $accNo);
                    $stmt->execute();
                    $stmt->close();

                    // then the transferee balance
                    $updatedBalance = $transfereeBalance + $amount;
                    $stmt = $conn->prepare("UPDATE users SET balance = ? WHERE acc_no = ?");
                    $stmt->bind_param("ds", $updatedBalance, $transferAccNo);
                    $stmt->execute();
                    $stmt->close();
                    echo "<p>Transfer Successful!.</p>";
                } else {
                    $stmt->close();
                    echo "<p>Transferee account does not exist!.</p>";
                }
            }
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
    <h1>Transfer Money</h1>

    <form method="post" action="">
        <label>Account Number</label>
        <input type="text" name="transfer_acc_no" placeholder="Account Number" required><br>

        <label for="amount">Amount to Transfer</label>
        <input type="number" name="amount" placeholder="Amount to transfer" required> <br><br>

        <label>Pin Code</label>
        <input type="password" name="pin_code" placeholder="Pin Code" required><br>

        <button type="submit">Confirm Transfer</button>
    </form>
    <br><br><br>

    <button onclick="location.href='menu.php'">Back To Menu</button>


</body>
</html>
