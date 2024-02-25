<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phrase Input</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Enter Your Phrase or Sentence</h5>
                        <!-- Phrase Input Form -->
                        <form id="phraseForm">
                            <div class="form-group">
                                <textarea class="form-control" id="phraseInput" rows="5" placeholder="Enter your phrase or sentence..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for handling form submission -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle form submission
            $('#phraseForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                // Get the input value
                var phrase = $('#phraseInput').val();

                // Do something with the phrase, for example, display an alert
                alert('You entered: ' + phrase);

                // You can also perform further processing such as sending the phrase to a server via AJAX
            });
        });
    </script>
</body>
</html>
