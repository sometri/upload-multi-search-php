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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $filePath = '../upload-storage/' . $fileName;

    // Move the uploaded file to the server
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        // Extract words from the file
        $content = file_get_contents($filePath);
        $words = preg_split('/\s+/', $content, -1, PREG_SPLIT_NO_EMPTY);

        // Filter out duplicate words
        $uniqueWords = array_unique($words);

        // Insert new unique words into the database
        $insertedWordsCount = 0;
        foreach ($uniqueWords as $word) {
            $word = $conn->real_escape_string(strtolower($word));
            $checkDuplicateQuery = "SELECT id FROM words WHERE word = '$word'";
            $result = $conn->query($checkDuplicateQuery);
            if ($result && $result->num_rows == 0) {
                $insertQuery = "INSERT INTO words (word) VALUES ('$word')";
                if ($conn->query($insertQuery)) {
                    $insertedWordsCount++;
                } else {
                    echo "Error inserting word: " . $conn->error;
                }
            }
        }

        // Echo success message
        echo "$insertedWordsCount unique words inserted successfully!";
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "Invalid request";
}

// Close the database connection
$conn->close();
?>
