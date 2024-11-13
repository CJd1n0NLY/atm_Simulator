<?php 
    session_start();

    if (isset($_SESSION['user_id']) && isset($_SESSION['name'])) {
        if (isset($_SESSION['message']) && $_SESSION['message'] != NULL) {
            
            $message = $_SESSION['message'];

            echo '<script type="text/javascript">';  
            echo "alert('$message');";  
            echo '</script>';  
            
            unset($_SESSION['message']);
        }
       
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>ATM SIMULATOR</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
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