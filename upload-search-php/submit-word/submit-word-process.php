<?php
// Include your database connection configuration file here
include '../database/config.php';
// Check if the form is submitted and the words variable is set
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['words'])) {
    // Get the input string from the POST data
    $inputString = $_POST['words'];

    // Convert the input to a string if it's an array
    if (is_array($inputString)) {
        $inputString = implode(' ', $inputString);
    }

    // Remove any leading or trailing whitespace
    $inputString = trim($inputString);

    // Split the input string into words based on word boundaries and special characters
    $words = preg_split('/[\s.,;:!"\'()\[\]{}|`~@#$%^&*+=<>\/\\\_-]+/', $inputString, -1, PREG_SPLIT_NO_EMPTY);

    // Initialize an array to store unique words
    $uniqueWords = [];

    // Loop through each word
    foreach ($words as $word) {
        // Trim whitespace from each word
        $word = trim($word);

        // Check if the word is not empty
        if (!empty($word)) {
            // Check if the word already exists in the database
            $sql_check = "SELECT * FROM words WHERE word = ?";
            $stmt = $conn->prepare($sql_check);
            $stmt->bind_param("s", $word);
            $stmt->execute();
            $result_check = $stmt->get_result();

            if ($result_check->num_rows == 0) {
                // If the word does not exist in the database, add it to the unique words array
                $uniqueWords[] = $word;
            }
        }
    }

    // Insert the unique words into the database
    if (!empty($uniqueWords)) {
        // Construct and execute the INSERT query
        $sql_insert = "INSERT INTO words (word) VALUES (?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("s", $wordToAdd);

        foreach ($uniqueWords as $wordToAdd) {
            $stmt->execute();
        }

        // Words inserted successfully
        echo "Words added to the database successfully!";
    } else {
        // If all words already exist in the database, display a message
        echo "All words already exist in the database.";
    }

    // Close the prepared statement and the database connection
    $stmt->close();
    $conn->close();
} else {
    // If the form is not submitted or the words variable is not set, display an error message
    echo "Invalid request. Please enter words.";
}
?>
