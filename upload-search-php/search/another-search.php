<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Another Word Search</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Search Box -->
        <div class="mt-3">
            <h1>Another Word Search</h1>
            <!-- Input field for searching -->
            <input type="text" id="searchInput" class="form-control" placeholder="Search word...">
            <br />
            <div class="mb-3">
                <a href="../uploadmanyfiles/upload_files.php" class="btn btn-primary">Upload Files</a>
                <a href="../uploadmanyfiles/view_words.php" class="btn btn-primary">View Words</a>
                <a href="../search/search.php" class="btn btn-primary">Search Words</a>
            </div>
        </div>

        <!-- Search Results Section -->
        <div id="searchResults" class="mt-3"></div>
    </div>

    <!-- JavaScript for handling search -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to handle search
        $('#searchInput').on('input', function() {
            var searchQuery = $(this).val();
            if (searchQuery.length > 0) {
                $.ajax({
                    url: 'another-search-process.php',
                    type: 'POST',
                    data: { query: searchQuery },
                    success: function(data) {
                        $('#searchResults').html(data);
                    },
                    error: function() {
                        $('#searchResults').html('<p>Error fetching search results.</p>');
                    }
                });
            } else {
                $('#searchResults').empty();
            }
        });
    </script>
</body>
</html>
