<!-- link with file: upload-process.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word upload Project</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Title -->
        <h1 class="mb-4">Word Upload Project</h1>

        <!-- File Upload Form -->
        <form id="uploadForm" action="upload-process.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">Choose File:</label>
                <input type="file" class="form-control-file" name="file" id="file" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="uploadFile()">Upload File</button>
            
            <!-- <a href="upload_files.php" class="btn btn-primary">Upload Files</a> -->
            <a href="../search/search.php" class="btn btn-primary">Search Words</a>
                      
        </form>   

        <!-- Success message container -->
        <div id="successMessage" class="mt-3"></div>
    </div>

    <!-- JavaScript for handling file upload -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to handle file upload and handle data
        function uploadFile() {
            $.ajax({
                url: 'upload-process.php',
                type: 'POST',
                data: new FormData($('#uploadForm')[0]),
                contentType: false,
                processData: false,
                success: function(response) {
                    // Display response from server
                    $('#successMessage').html('<div class="alert alert-success" role="alert">' + response + '</div>');
                },
                error: function() {
                    alert('Error uploading file.');
                }
            });
        }
    </script>
</body>
</html>
