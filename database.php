<?php

    $serverName= "localhost";
    $userName= "root";
    $password = "";

    $dbName = "atm";

    $conn = mysqli_connect($serverName, $userName, $password, $dbName);

    if (!$conn) {
        echo "Connection failed!";
    }