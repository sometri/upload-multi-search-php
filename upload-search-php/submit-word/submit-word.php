<!-- link with file: submit-word-process.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word Upload Project</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Title -->
        <h1 class="mb-4">Word Upload Project</h1>

        <!-- Form to submit sentences -->
        <form id="uploadForm" action="submit-word-process.php" method="post">
            <div class="form-group">
                <label for="sentences">Enter your sentences:</label>
                <textarea class="form-control" id="sentences" name="sentences" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Words</button>
        </form>

        <!-- Success message container -->
        <div id="successMessage" class="mt-3"></div>
    </div>

    <!-- JavaScript for handling form submission -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to handle form submission
            $('#uploadForm').submit(function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Get the input sentences from the text area
                var sentences = $('#sentences').val();

                // Split the input text into words
                var wordsArray = sentences.split(/\s+/).filter(word => word.trim() !== '');

                // Send the words to the PHP script for processing
                $.ajax({
                    url: 'submit-word-process.php',
                    type: 'POST',
                    data: { words: wordsArray },
                    success: function(response) {
                        // Display response from server
                        $('#successMessage').html('<div class="alert alert-success" role="alert">' + response + '</div>');
                    },
                    error: function() {
                        alert('Error adding words.');
                    }
                });
            });
        });
    </script>
</body>
</html>
