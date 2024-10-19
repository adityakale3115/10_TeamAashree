<?php
include 'connn.php'; // Include the database connection
session_start(); // Start the session to access the logged-in nurse's information

if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nurse Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: sans-serif;
            background-color: #f7f7f7;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <div id="help-requests" class="mt-4"></div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Function to fetch help requests
        function fetchHelpRequests() {
            $.ajax({
                url: 'fetch_help_requests.php',
                type: 'GET',
                success: function(response) {
                    const requests = JSON.parse(response);
                    let html = '';

                    if (requests.length > 0) {
                        requests.forEach(request => {
                            html += `
                                <div class="alert alert-warning">
                                    <strong>Help Required!</strong> 
                                    Patient ID: ${request.patient_id} <br>
                                    Request Time: ${request.request_time} <br>
                                    <button class="btn btn-success" onclick="respondToRequest(${request.id}, 'accepted')">Accept</button>
                                    <button class="btn btn-danger" onclick="respondToRequest(${request.id}, 'declined')">Decline</button>
                                </div>
                            `;
                        });
                    } else {
                        html = '<div class="alert alert-info">No new help requests.</div>';
                    }

                    $('#help-requests').html(html);
                },
                error: function() {
                    console.log('Error fetching help requests.');
                }
            });
        }

        // Function to respond to a help request
        function respondToRequest(requestId, status) {
            $.ajax({
                url: 'update_request_status.php',
                type: 'POST',
                data: { id: requestId, status: status },
                success: function(response) {
                    alert('Request ' + status);
                    fetchHelpRequests(); // Refresh the list after responding
                },
                error: function() {
                    alert('Failed to update request status.');
                }
            });
        }

        // Poll for help requests every 5 seconds
        setInterval(fetchHelpRequests, 5000);
    </script>
</body>
</html>
