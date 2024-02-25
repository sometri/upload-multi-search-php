<?php
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

// Create uploaded_files table if it doesn't exist
$create_table_query = "CREATE TABLE IF NOT EXISTS uploaded_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL
)";
if (!$conn->query($create_table_query)) {
    die("Error creating table 'uploaded_files': " . $conn->error);
}

// Alter words table to add uploaded_file_id column if it doesn't exist
$alter_table_query = "ALTER TABLE words ADD COLUMN IF NOT EXISTS uploaded_file_id INT";
if (!$conn->query($alter_table_query)) {
    die("Error altering table 'words': " . $conn->error);
}

// Initialize arrays to store uploaded files, words, and their IDs
$uploadedFiles = [];
$uploadedWords = [];
$fileIDs = [];
$errors = [];

// Check if files are uploaded
if(isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {
    foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
        $file_name = $conn->real_escape_string($_FILES['files']['name'][$key]);
        $target_dir = "../upload-storage/";
        $target_file = $target_dir . basename($_FILES["files"]["name"][$key]);
        
        // Check if file already exists in the database
        $check_file_query = "SELECT * FROM uploaded_files WHERE file_name = '$file_name'";
        $result = $conn->query($check_file_query);
        if ($result->num_rows > 0) {
            $errors[] = 'File already exists in the database: ' . $file_name . '. ';
            continue; // Skip to the next file
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $errors[] = 'File already exists: ' . $file_name . '. ';
        } else {
            // Move uploaded file to upload storage folder
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$key], $target_file)) {
                // Insert file info into database
                $insert_file_query = "INSERT INTO uploaded_files (file_name) VALUES ('$file_name')";
                if ($conn->query($insert_file_query)) {
                    $fileID = $conn->insert_id;
                    $fileIDs[] = $fileID;
                } else {
                    $errors[] = 'Error inserting file: ' . $file_name . ' ' . $conn->error . '; ';
                }
                
                // Read file content
                $file_content = file_get_contents($target_file);
                // Split content into words
                $words = preg_split('/\s+/', $file_content, -1, PREG_SPLIT_NO_EMPTY);
                
                // Insert each word into database
                foreach ($words as $word) {
                    $escaped_word = $conn->real_escape_string($word);
                    
                    // Check if word already exists
                    $check_query = "SELECT * FROM words WHERE word = '$escaped_word'";
                    $result = $conn->query($check_query);
                    if ($result->num_rows == 0) {
                        // Word doesn't exist, insert it
                        $insert_query = "INSERT INTO words (word, upload_count, uploaded_file_id) VALUES ('$escaped_word', 1, $fileID)";
                        if ($conn->query($insert_query)) {
                            $uploadedWords[] = $escaped_word;
                        } else {
                            $errors[] = 'Error inserting word: ' . $escaped_word . ' ' . $conn->error . '; ';
                        }
                    }
                }
                $uploadedFiles[] = $file_name;
            } else {
                $errors[] = 'Error uploading file: ' . $file_name . '; ';
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
    <title>Upload Files</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
    <?php if (!empty($errors)): ?>
        <div class="container mt-4">
            <h3>Errors:</h3>
            <?php
                foreach ($errors as $error) {
                    echo '<div class="text-center">' . $error . '</div>';
                }
            ?>
        </div>
    <?php endif; ?>

    <div class="container mt-4">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="files[]" multiple class="form-control-file">
            <button type="submit" class="btn btn-primary mt-3">Upload Files</button>        
            
            <a href="../search/search.php" class="btn btn-primary mt-3">Search Words</a>
            <a href="../search/another-search.php" class="btn btn-primary mt-3">Another Search Words</a>
            <a href="../uploadmanyfiles/view_words.php" class="btn btn-primary mt-3">View Words</a>
        </form>
    </div>

    <?php if (!empty($uploadedFiles)): ?>
        <div class="container mt-4">
            <h3>Uploaded Files:</h3>
            <ul class="list-group">
                <?php foreach ($uploadedFiles as $key => $file): ?>
                    <li class="list-group-item text-primary"><?php echo $file; ?> (ID: <?php echo $fileIDs[$key]; ?>)</li>
                    <?php // Fetch words uploaded with this file
                        $fileID = $fileIDs[$key];
                        $words_query = "SELECT word, id FROM words WHERE uploaded_file_id = $fileID";
                        $result = $conn->query($words_query);
                        if ($result->num_rows > 0) {
                            echo "<ul class='list-group'>";
                            while($row = $result->fetch_assoc()) {
                                echo "<li class='list-group-item'>" . $row["word"] . " (ID: " . $row["id"] . ")</li>";
                            }
                            echo "</ul>";
                        }
                    ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

<?php
// Close the database connection
$conn->close();
?>
</body>
</html>
