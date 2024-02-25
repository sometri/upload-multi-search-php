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

// Fetch data from words table
$words = [];
$sql_words = "SELECT * FROM words";
$result_words = $conn->query($sql_words);
if ($result_words->num_rows > 0) {
    while($row = $result_words->fetch_assoc()) {
        $words[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Words Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        th, td {
            white-space: nowrap;
        }
        .sort-btn {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Words Table</h2>       
        
        <div class="mb-3">
            <a href="upload_files.php" class="btn btn-primary">Upload Files</a>
            <a href="../search/search.php" class="btn btn-primary">Search Words</a>
            <a href="../search/another-search.php" class="btn btn-primary">Another Search Words</a>

        </div>
    
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="sort-btn" data-sort="id">ID</th>
                    <th class="sort-btn" data-sort="word">Word</th>
                    <th class="sort-btn" data-sort="upload_count">Upload Count</th>
                    <th class="sort-btn" data-sort="uploaded_file_id">Uploaded File ID</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php foreach ($words as $word): ?>
                    <tr>
                        <td><?php echo $word['id']; ?></td>
                        <td><?php echo $word['word']; ?></td>
                        <td><?php echo $word['upload_count']; ?></td>
                        <td><?php echo $word['uploaded_file_id']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.sort-btn').click(function(){
                var column = $(this).data('sort');
                var order = $(this).hasClass('asc') ? 'desc' : 'asc';
                
                // Remove sorting classes from all columns
                $('.sort-btn').removeClass('asc desc');
                
                // Add sorting class to the clicked column
                $(this).addClass(order);
                
                // Send AJAX request to sort data
                $.ajax({
                    url: 'sort.php',
                    type: 'post',
                    data: {column: column, order: order},
                    success: function(response){
                        $('#table-body').html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>
