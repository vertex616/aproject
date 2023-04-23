<?php
require_once 'dbconnect.php';

// Check if the user is logged in, redirect to login page if not
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Check if a project ID was passed in the query string
if (!isset($_GET['pid'])) {
    header("Location: index.php");
    exit;
}

// Retrieve the project details from the database
$pid = $_GET['pid'];
$query = 'SELECT * FROM projects WHERE pid = :pid';
$stmt = $db->prepare($query);
$stmt->execute([':pid' => $pid]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

// If the project does not exist or does not belong to the current user, redirect to index.php
if (!$project || $project['uid'] !== $_SESSION['user']['uid']) {
    header("Location: index.php");
    exit;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $phase = $_POST['phase'];
    $description = $_POST['description'];

    // Build the SQL query to update the project in the database
    $sql = "UPDATE projects SET title = :title, start_date = :startDate, end_date = :endDate, phase = :phase, description = :description WHERE pid = :pid";
    $params = [':title' => $title, ':startDate' => $startDate, ':endDate' => $endDate, ':phase' => $phase, ':description' => $description, ':pid' => $pid];

    $stmt = $db->prepare($sql);
    $result = $stmt->execute($params);

    // Display a message to the user indicating whether the project was updated successfully or not
    if ($result) {
        $message = "Project updated successfully!";
    } else {
        $message = "Failed to update project.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Project</title>
</head>
<body>
    <h1>Update Project</h1>
    <form method="POST">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($project['title'], ENT_QUOTES | ENT_HTML5); ?>">
        <br><br>
        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate" value="<?php echo htmlspecialchars($project['start_date'], ENT_QUOTES | ENT_HTML5); ?>">
        <br><br>
        <label for="endDate">End Date:</label>
        <input type="date" name="endDate" value="<?php echo htmlspecialchars($project['end_date'], ENT_QUOTES | ENT_HTML5); ?>">
        <br><br>
        <label for="phase">Phase:</label>
        <select name="phase">
            <option value="Complete"<?php if ($project['phase'] === 'Complete') echo ' selected'; ?>>Complete</option>
            <option value="Implementation"<?php if ($project['phase'] === 'Implementation') echo ' selected'; ?>>Implementation</option>
            <option value="Testing"<?php if ($project['phase'] === 'Testing') echo ' selected'; ?>>Testing</option>
            <option value="Deployment"<?php if ($project['phase'] === 'Deployment') echo ' selected'; ?>>Deployment</option>
        </select>
        <br><br>
        <label for="description">Description:</label>
        <textarea name="description"><?php echo htmlspecialchars($project['description'], ENT_QUOTES | ENT_HTML5); ?></textarea>
        <br><br>
            <input type="submit" value="Update Project">
    </form>

        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </body>
</html>

