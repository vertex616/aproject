

<?php
    // Include the dbconnect.php file to establish database connection
    require_once 'dbconnect.php';

    $username = $password = $email = "";
    $message = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve user input from the form
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        // Prepare and execute the SQL query to insert the user details into the users table
        $sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
        $params = [
            ':username' => $username,
            ':password' => password_hash($password, PASSWORD_DEFAULT), // Hash the password before storing it in the database
            ':email' => $email,
        ];

        $stmt = $db->prepare($sql);
        if ($stmt->execute($params)) {
            // If the query was successful, display a success message and show the ID number of the user that was just registered
            $message = "Registration successful! Your ID number is: " . $db->lastInsertId();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Home</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>User Registration</h1>
        <?php if ($message !== ""): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        <br>
        <a href="login.php">Login</a>
        <br><br>
        <a href="index.php">Go to Home Page</a>
    </div>
</body>
</html>

