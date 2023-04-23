<?php
// Include the dbconnect.php file to establish database connection
require_once 'dbconnect.php';

// Check if the user is logged in, redirect to login page if not
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Define variables and initialize with empty values
$title = $startDate = $endDate = $phase = $description = "";
$title_err = $startDate_err = $endDate_err = $phase_err = "";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate title
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a project title.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validate start date
    if (empty(trim($_POST["startDate"]))) {
        $startDate_err = "Please enter a start date.";
    } else {
        $startDate = trim($_POST["startDate"]);
        if (strtotime($startDate) < strtotime('today')) {
            $startDate_err = "Start date cannot be before today's date.";
        }
    }

    // Validate end date
    if (empty(trim($_POST["endDate"]))) {
        $endDate_err = "Please enter an end date.";
    } else {
        $endDate = trim($_POST["endDate"]);
        if (strtotime($endDate) < strtotime('today') || strtotime($endDate) < strtotime($startDate)) {
            $endDate_err = "End date cannot be before today's date or before the start date.";
        }
    }

    // Validate phase
    $allowed_phases = array('design', 'development', 'testing', 'deployment', 'complete');
    if (empty(trim($_POST["phase"]))) {
        $phase_err = "Please select a project phase.";
    } elseif (!in_array(trim($_POST["phase"]), $allowed_phases)) {
        $phase_err = "Invalid project phase selected.";
    } else {
        $phase = trim($_POST["phase"]);
    }

    // Validate description
    if (empty(trim($_POST["description"]))) {
        $description = "";
    } else {
        $description = trim($_POST["description"]);
    }

    // Check if all validations passed
    if (empty($title_err) && empty($startDate_err) && empty($endDate_err) && empty($phase_err)) {

        // Build the SQL query to add a new project to the database
        $sql = "INSERT INTO projects (title, start_date, end_date, phase, description, uid) VALUES (:title, :startDate, :endDate, :phase, :description, :uid)";
        $params = [':title' => $title, ':startDate' => $startDate, ':endDate' => $endDate, ':phase' => $phase, ':description' => $description, ':uid' => $_SESSION['user']['uid']];

        $stmt = $db->prepare($sql);
        if (!$stmt) {
             echo "\nPDO::errorInfo():\n";
            print_r($db->errorInfo());
        }
        $result = $stmt->execute($params);
        if (!$result) {
            echo "\nPDO::errorInfo():\n";
            print_r($stmt->errorInfo());
        }

        // Display a message to the user indicating whether the project was added successfully or not
        if ($result) {
            // Redirect the user back to index.php after adding the project
            header("Location: index.php");
            exit;
        } else {
            $message;
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Project</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Add Project</h2>
    <p>Please fill this form to add a new project.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
            <label>Project Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
            <span class="help-block"><?php echo $title_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($startDate_err)) ? 'has-error' : ''; ?>">
            <label>Start Date</label>
            <input type="date" name="startDate" class="form-control" value="<?php echo $startDate; ?>">
            <span class="help-block"><?php echo $startDate_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($endDate_err)) ? 'has-error' : ''; ?>">
            <label>End Date</label>
            <input type="date" name="endDate" class="form-control" value="<?php echo $endDate; ?>">
            <span class="help-block"><?php echo $endDate_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($phase_err)) ? 'has-error' : ''; ?>">
            <label>Project Phase</label>
            <select name="phase" class="form-control">
                <option value="">Please select a phase</option>
                <option value="design" <?php echo ($phase == 'design') ? 'selected' : ''; ?>>Design</option>
                <option value="development" <?php echo ($phase == 'development') ? 'selected' : ''; ?>>Development</option>
                <option value="testing" <?php echo ($phase == 'testing') ? 'selected' : ''; ?>>Testing</option>
                <option value="deployment" <?php echo ($phase == 'deployment') ? 'selected' : ''; ?>>Deployment</option>
                <option value="complete" <?php echo ($phase == 'complete') ? 'selected' : ''; ?>>Complete</option>
            </select>
            <span class="help-block"><?php echo $phase_err; ?></span>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Add Project">
            <a href="index.php" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>








