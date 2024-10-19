<?php
include 'connn.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // Get the request ID
    $status = $_POST['status']; // Get the new status (accepted or declined)

    // Prepare the SQL query to update the status of the help request
    $sql = "UPDATE help_requests SET status = '$status' WHERE id = '$id'";

    // Execute the query and check for success
    if (mysqli_query($con, $sql)) {
        echo 'Status updated successfully';
    } else {
        echo 'Failed to update status: ' . mysqli_error($con); // Provide error details
    }
} else {
    echo 'Invalid request method'; // Handle invalid requests
}
?>
