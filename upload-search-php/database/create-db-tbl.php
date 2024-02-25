<?php
$servername = "localhost";
$username = "root";
$password = "123";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql_create_db = "CREATE DATABASE IF NOT EXISTS word_db";

if ($conn->query($sql_create_db) === TRUE) {
    echo "Database created successfully<br>";

    // Select the database
    $conn->select_db("word_db");

    // Create table 'words'
    $sql_create_table = "CREATE TABLE IF NOT EXISTS words (
        id INT AUTO_INCREMENT PRIMARY KEY,
        word VARCHAR(255) NOT NULL,
        upload_count INT NOT NULL DEFAULT 1
    )";

    if ($conn->query($sql_create_table) === TRUE) {
        echo "Table 'words' created successfully<br>";
    } else {
        echo "Error creating table 'words': " . $conn->error . "<br>";
    }
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

$conn->close();
?>
