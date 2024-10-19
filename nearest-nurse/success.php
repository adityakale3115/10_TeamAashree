<?php
    include 'connn.php'; // Include the database connection
    session_start(); // Start the session to access the stored username

    if (!isset($_SESSION['username'])) {
        header('Location: login.php'); // Redirect to login page if not logged in
        exit();
    }

    // Check if the form is submitted for workdays
    if (isset($_GET['done'])) {
        // Get the number of workdays from the form
        $workDays = $_GET['workdays'];
        $username = $_SESSION['username'];

        // Prepare an SQL query to update the 'days_worked' column in the 'employee' table
        $sql = "UPDATE employee SET days_worked = '" . $workDays . "' WHERE name = '" . $username ."'" ;

        $query = mysqli_query($con, $sql);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            background-color: #f7f7f7;
        }
        .form-container {
            width: 100%;
            max-width: 400px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        
        <button type="button" id="helpBtn" class="btn btn-danger btn-block mt-3">Help</button>
    </div>

    <!-- AJAX Script to handle Help Button -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script>
  $(document).ready(function() {
    $(".btn-danger").click(function() {
        // Assign values to patient_username, patient_longitude, and patient_latitude
        var patient_username = "test_user"; // Replace with actual username or retrieve dynamically
        var patient_longitude = 72.8777; // Replace with actual longitude or retrieve dynamically
        var patient_latitude = 19.0760; // Replace with actual latitude or retrieve dynamically

        $.ajax({
            url: 'http://localhost/nearest-nurse/notify_nurse.php',
            type: 'POST',
            data: {
                patient_username: patient_username,
                patient_longitude: patient_longitude,
                patient_latitude: patient_latitude
            },
            success: function(response) {
                alert(response); // Show success or error message from PHP
            },
            error: function(xhr, status, error) {
                console.error("Status: " + status);
                console.error("Error: " + error);
                console.error("Response Text: " + xhr.responseText);
                alert("AJAX error: " + xhr.responseText); // Show any AJAX errors
            }
        });
    });
});


    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
