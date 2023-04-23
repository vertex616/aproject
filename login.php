
<?php
    // Include the dbconnect.php file to establish database connection
    require_once 'dbconnect.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Sanitize user input to prevent SQL injection
        $username = filter_var($username, FILTER_SANITIZE_STRING);

        // Retrieve the hashed password from the database based on the provided username
        $stmt = $db->prepare('SELECT uid, password FROM users WHERE username = :username');
        $stmt->execute([':username' => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // If a matching user was found, verify the password
        if ($result) {
            if (password_verify($password, $result['password'])) {
                // Start a session and redirect the user to the home page
                session_start();
                $_SESSION['user'] = ['uid' => $result['uid'], 'username' => $username];

                // Set a cookie to store the session ID and prevent session hijacking
                setcookie('PHPSESSID', session_id(), time() + 3600, '/', '', false, true);

                // Set a CSRF token to prevent cross-site request forgery attacks
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                header('Location: index.php');
                exit;
            }
            else {
                // If the password is incorrect, display an error message
                $errorMessage = 'Invalid password';
            }
        } 
        else {
            // Display an error message if the user does not exist
            $errorMessage = 'Invalid username. Please try again.';
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
        <h1>Login</h1>
        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
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
            <!-- Add a CSRF token field to the form -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <br>
        <a href="register.php">Register</a>
        <br><br>
        <a href="index.php">Go to Home Page</a>
    </div>
</body>
</html>
