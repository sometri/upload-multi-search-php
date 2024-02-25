<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "123";
$database = "word_db"; // Modify this with your database name if different

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['query'])) {
    $searchQuery = $conn->real_escape_string($_POST['query']);
    $searchResults = '';

    // Search for the word in the database
    $searchQuery = '%' . $searchQuery . '%';
    // $searchSql = "SELECT id, word FROM words WHERE word LIKE '$searchQuery'";
    $searchSql = "SELECT * FROM words WHERE word LIKE '$searchQuery'";

    $result = $conn->query($searchSql);

    if ($result && $result->num_rows > 0) {
        // Display search results
        while ($row = $result->fetch_assoc()) {
            // $searchResults .= "<p>Word ID: " . $row['id'] . ", Word: " . $row['word'] . "</p>";
            $searchResults .= "<p>Word ID: " . $row['id'] . ", Word: " . $row['word'] . ", Upload Count: " . $row['upload_count'] . ", Uploaded File ID: " . $row['uploaded_file_id'] . "</p>";
        }
    } else {
        $searchResults = "<p>No matching results found.</p>";
    }

    echo $searchResults;
} else {
    echo "Invalid request";
}

// Close the database connection
$conn->close();
?>
