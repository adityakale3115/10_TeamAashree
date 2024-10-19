<?php
    include 'connn.php';
    if (isset($_POST['done'])) {
        // Sanitize and validate the input
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Check if all fields are filled
        if (!empty($username) && !empty($email) && !empty($password)) {
            // Insert query
            $q = "INSERT INTO login_info(username,email,password) VALUES ('$username','$email','$password')";
            $query = mysqli_query($con, $q);

            // Redirect to the same page after successful insertion
            if ($query) {
                header("Location: " . $_SERVER['PHP_SELF']); // Redirect to clear POST data
                exit();
            }
        } else {
            echo "<p style='color:red; text-align:center;'>All fields are required!</p>";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    
    <!-- Custom CSS to center the form -->
    <style>
        body {
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            margin-bottom: 1rem;
        }
        .card-header {
            background-color: #343a40;
        }
    </style>
</head>
<body>
    <div class="col-lg-4 col-md-6 col-sm-8 m-auto">
        <form method="post">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-white text-center">Registration</h2>
                </div>
                <div class="card-body">
                    <label for="username">Username:</label>
                    <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                    
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                    
                    <button class="btn btn-success btn-block" type="submit" name="done">Register</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>