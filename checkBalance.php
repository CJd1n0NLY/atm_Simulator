<?php 

include 'database.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $accNo = $_SESSION['acc_no'];
    
    $query = "SELECT balance FROM users WHERE acc_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $accNo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $balance = $row["balance"];
        $_SESSION['balance'] = $balance; 
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
    <h1>Check Balance</h1>
    <p>Your current balance is : <?php echo $balance ?></p>
    <button onclick="location.href='menu.php'">Back To Menu</button>
</body>
</html>