<?php 
    session_start();

    if (isset($_SESSION['user_id']) && isset($_SESSION['name'])) {
       
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>ATM SIMULATOR</title>
    </head>
    <body>
        
        <h2>Hello, <?php echo $_SESSION['name']; ?></h2>
        <button onclick="location.href='checkBalance.php'">Check Balance</button><br><br>
        <button onclick="location.href='withdraw.php'">Withdraw</button><br><br>
        <button onclick="location.href='deposit.php'">Deposit</button><br><br>
        <button onclick="location.href='transfer.php'">Transfer Money</button><br><br>
        <button onclick="location.href='change-pin.php'">Change Pincode</button><br><br>
        <a href="logout.php">Logout</a>
    </body>
    </html>

    <?php 
    }else{
        header("Location: index.php");
        exit();
    }
?>