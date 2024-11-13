<?php 
include 'database.php';

session_start();


if (isset($_SESSION['user_id'])) {
    $accNo = $_SESSION['acc_no'];

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['current_pin_code'])){
        $currentPin = $_POST['current_pin_code'];
        $newPin = $_POST['new_pin_code'];
        $confirmPin = $_POST['confirm_pin_code'];

        $stmt = $conn->prepare("SELECT pin_code FROM users WHERE acc_no = ?");
            $stmt->bind_param("s", $accNo);
            $stmt->execute();
            $stmt->bind_result($dbPin);
            $stmt->fetch();
            $stmt->close();

            if (md5($currentPin) != $dbPin) {
                echo '<script>alert("Incorrect pin code.")</script>';
            } else {
                    if($newPin == $confirmPin){
                            $hashNewPin = md5($newPin);

                            $query = "UPDATE users SET pin_code = ? WHERE acc_no = ?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("si", $hashNewPin, $accNo);

                            if($stmt->execute()){
                                $_SESSION['pin_code'] = $hashNewPin;
                                header("Location: menu.php");
                                $_SESSION['message'] = "Pin code changed successfully!";                            }
                            else{
                                echo '<script>alert("Pin code change failed!")</script>';
                            }
                        }
                        else{
                            echo '<script>alert("New pin and Confirm pin is not the same")</script>';
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
    <h1>Change Pin Code</h1>

    <form method="post" action="">

        <label>Current Pin </label>
        <input type="password" name="current_pin_code" placeholder="Current Pin Code" required><br>

        <label>New Pin </label>
        <input type="password" name="new_pin_code" placeholder="New Pin Code" required><br>

        <label>Confirm New Pin </label>
        <input type="password" name="confirm_pin_code" placeholder="Confirm Pin Code" required><br><br>


        <button type="submit">Confirm Transfer</button>
    </form>
    <br><br><br>

    <button onclick="location.href='menu.php'">Back To Menu</button>

</body>
</html>