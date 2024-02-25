<!-- Drop table then drop database -->
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

    // Drop the 'words' table
    $sqlDropTable = "DROP TABLE IF EXISTS word_db.words";
    if ($conn->query($sqlDropTable) === TRUE) {
        echo "Table 'words' dropped successfully<br>";
    } else {
        echo "Error dropping table: " . $conn->error . "<br>";
    }

    // Drop the 'word_db' database
    $sqlDropDatabase = "DROP DATABASE IF EXISTS word_db";
    if ($conn->query($sqlDropDatabase) === TRUE) {
        echo "Database 'word_db' dropped successfully<br>";
    } else {
        echo "Error dropping database: " . $conn->error . "<br>";
    }

    // Close connection
    $conn->close();
?>
