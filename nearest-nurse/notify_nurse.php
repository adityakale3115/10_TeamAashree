<?php
include 'connn.php'; // Include database connection
session_start(); // Start session to access logged-in patient's username

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'help') {
    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        echo json_encode(['error' => 'User not logged in.']);
        exit();
    }

    // Get patient's username from session
    $patient_username = $_SESSION['username'];
    
    // Example: Get patient's current location (latitude and longitude)
    // Assuming you have methods to capture location (this can come from a form, API, etc.)
    $latitude = 12.9716; // Static example of latitude
    $longitude = 77.5946; // Static example of longitude
    
    // Insert help request into the help_requests table
    $sql = "INSERT INTO help_requests (patient_username, patient_latitude, patient_longitude, status) 
            VALUES ('$patient_username', '$latitude', '$longitude', 'pending')";

    if (mysqli_query($con, $sql)) {
        echo json_encode(['success' => 'Help request sent successfully!']);
    } else {
        echo json_encode(['error' => 'Failed to send help request.']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <script>
        // On nurse side (nurse_dashboard.php)
setInterval(function() {
    // Poll the server every 5 seconds to check for new help requests
    $.ajax({
        url: 'fetch_help_requests.php',
        type: 'GET',
        success: function(response) {
            const requests = JSON.parse(response);
            if (requests.length > 0) {
                // Show pop-up if there's a new request
                const request = requests[0]; // Get the first request
                if (confirm('Help required! Accept or Decline?')) {
                    updateHelpRequestStatus(request.id, 'accepted');
                } else {
                    updateHelpRequestStatus(request.id, 'declined');
                }
            }
        }
    });
}, 5000); // Poll every 5 seconds

// Function to update help request status
function updateHelpRequestStatus(requestId, status) {
    $.ajax({
        url: 'update_request_status.php',
        type: 'POST',
        data: { id: requestId, status: status },
        success: function(response) {    
            alert('Request ' + status);
        },
        error: function() {
            alert('Failed to update status.');
        }
    });
}

    </script>
</body>
</html>