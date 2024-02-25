<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm File Removal</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container" id="confirmation">
        <h2 class="mt-4">Are you sure you want to remove all files from the upload-storage folder?</h2>
        <form action="" method="post">
            <button type="submit" name="confirm" class="btn btn-danger" onclick="hideConfirmation()">Yes</button>
            <a href="../search/search.php" class="btn btn-secondary">Cancel</a>
            <a href="../search/another-search.php" class="btn btn-primary">Another Search Words</a>
            <a href="../uploadmanyfiles/view_words.php" class="btn btn-primary">View Words</a>

        </form>
    </div>
    <script>
        function hideConfirmation() {
            document.getElementById("confirmation").style.display = "none";
        }
    </script>
</body>
</html>

<?php
$target_dir = "../upload-storage/";

// Check if the directory exists
if (!is_dir($target_dir)) {
    die("Directory doesn't exist.");
}

// Get all files in the directory
$files = scandir($target_dir);

// Remove . and .. from the list
$files = array_diff($files, array('.', '..'));

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
    // Loop through each file and delete it
    foreach ($files as $file) {
        $file_path = $target_dir . $file;
        if (is_file($file_path)) {
            if (!unlink($file_path)) {
                echo "Error deleting $file.";
            }
        }
    }
    ?>
    <div class="container text-center">
        <h3>All files have been removed from the upload-storage folder.</h3>
    </div>
    <?php
}
?>
