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

// Loop through each file and delete it
foreach ($files as $file) {
    $file_path = $target_dir . $file;
    if (is_file($file_path)) {
        if (!unlink($file_path)) {
            echo "Error deleting $file.";
        }
    }
}

echo "All files have been removed from the upload-storage folder.";
?>
