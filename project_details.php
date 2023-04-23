<?php
// Check if project id is set in the URL
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
} else {
    echo "Error: Project ID not specified.";
    exit;
}

// Connect to the database
require_once 'dbconnect.php';

try {
    // Prepare the SQL statement to fetch project details
    $sql = "SELECT * FROM projects WHERE pid = :pid";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':pid', $pid);

    // Bind parameters and execute the statement
    $stmt->execute();

    // Fetch the project details as an associative array
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    // Prepare the SQL statement to fetch user email
    $sql = "SELECT users.email FROM users JOIN projects ON users.uid = projects.uid WHERE projects.pid = :pid";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':pid', $pid);

    // Bind parameters and execute the statement
    $stmt->execute();

    // Fetch the user email as a string
    $email = $stmt->fetchColumn();

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// check if project exists
if (!$project) {
    echo "Error: Project not found.";
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Project Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4"><?php echo $project['title']; ?></h1>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Start Date:</strong> <?php echo $project['start_date']; ?></p>
                <p><strong>End Date:</strong> <?php echo $project['end_date']; ?></p>
                <p><strong>Phase:</strong> <?php echo $project['phase']; ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>User Email:</strong> <?php echo $email; ?></p>
            </div>
        </div>
        <hr>
        <div class="my-4">
            <h4>Description:</h4>
            <p><?php echo $project['description']; ?></p>
        </div>
        <a href="index.php" class="btn btn-primary">Go back home</a>
    </div>
</body>
</html>
