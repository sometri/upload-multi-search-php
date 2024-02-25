<?php
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '123';
    $dbName = 'word_db';

    $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        echo "Failed to connect to the database. Check the connection parameters.";
    } else {
        echo "Connected to the database successfully! <br/>";
    }
?>