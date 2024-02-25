<?php
if(isset($_POST['column'], $_POST['order'])) {
    $column = $_POST['column'];
    $order = $_POST['order'];

    $servername = "localhost";
    $username = "root";
    $password = "123";
    $database = "word_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data from words table and sort
    $words = [];
    $sql_words = "SELECT * FROM words ORDER BY $column $order";
    $result_words = $conn->query($sql_words);
    if ($result_words->num_rows > 0) {
        while ($row = $result_words->fetch_assoc()) {
            $words[] = $row;
        }
    }

    $conn->close();

    // Generate HTML content for sorted table body
    foreach ($words as $word) {
        echo "<tr>";
        echo "<td>{$word['id']}</td>";
        echo "<td>{$word['word']}</td>";
        echo "<td>{$word['upload_count']}</td>";
        echo "<td>{$word['uploaded_file_id']}</td>";
        echo "</tr>";
    }
}
?>
