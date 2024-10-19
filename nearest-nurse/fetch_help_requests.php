<?php
include 'connn.php'; // Include the database connection

// Fetch help requests with status 'pending'
$sql = "SELECT * FROM help_requests WHERE status = 'pending' ORDER BY request_time ASC";
$result = mysqli_query($con, $sql);
$requests = [];

// Check if there are any requests
while ($row = mysqli_fetch_assoc($result)) {
    $requests[] = $row;
}

// Return the requests in JSON format
header('Content-Type: application/json'); // Set the content type to JSON
echo json_encode($requests);
?>
