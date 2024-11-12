<?php 
    session_start(); 
    include "database.php";

    if (isset($_POST['acc_no']) && isset($_POST['pin_code'])) {

        $acc_no = $_POST['acc_no'];
        $pin_code = md5($_POST['pin_code']);

        if (empty($acc_no) || empty($pin_code)) {
            header("Location: index.php");
            exit();
        } else {
            $stmt = $conn->prepare("SELECT * FROM users WHERE acc_no = ? AND pin_code = ?");
            $stmt->bind_param("ss", $acc_no, $pin_code);
            
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                $_SESSION['acc_no'] = $row['acc_no'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['balance'] = $row['balance'];
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['pin_code'] = $row['pin_code'];

                header("Location: menu.php");
                exit();
            } else {
                echo "Account not found";
                exit();
            }
        }
    
    }  else{
        header("Location: index.php");
        exit();
    }

     function findByAccNo($acc_no) {
        include "database.php";

        $stmt = $conn->prepare("SELECT * FROM users WHERE acc_no = ?");
        $stmt->bind_param('s', $acc_no);
        $stmt->execute();
    
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();  
        } else {
            return null;  
        }
    }

    

