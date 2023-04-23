<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Edit Project</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Get the project ID from the URL
$pid = $_GET['pid'];

// Connect to the database
require_once 'dbconnect.php';

// Retrieve the project details from the database
$query = 'SELECT pid, title, description, start_date, end_date, phase FROM projects WHERE pid = ? AND uid = ?';
$stmt = $db->prepare($query);
$stmt->execute([$pid, $_SESSION['user']['uid']]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

// If the project doesn't exist or doesn't belong to the user, redirect to the index page
if (!$project) {
    header('Location: index.php');
    exit;
}

// If the form has been submitted, update the project in the database
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

	$query = 'UPDATE projects SET title = ?, description = ?, start_date = ?, end_date = ?, phase = ? WHERE pid = ?';

    $stmt = $db->prepare($query);
	$phase = $_POST['phase'];
	$stmt->execute([$title, $description, $start_date, $end_date, $phase, $pid]);



    header('Location: index.php');
    exit;
}
?>

<div class="container mt-5">
	<h2>Edit Project</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?pid=' . $pid; ?>" method="post">
		<div class="form-group">
			<label for="title">Title:</label>
			<input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($project['title'], ENT_QUOTES | ENT_HTML5); ?>" required>
		</div>
		<div class="form-group">
			<label for="description">Description:</label>
			<textarea class="form-control" id="description" name="description" rows="5" required><?php echo htmlspecialchars($project['description'], ENT_QUOTES | ENT_HTML5); ?></textarea>
		</div>
		<div class="form-group">
			<label for="start_date">Starting Date:</label>
			<input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo htmlspecialchars($project['start_date'], ENT_QUOTES | ENT_HTML5); ?>" required>
		</div>
		<div class="form-group">
			<label for="end_date">Ending Date:</label>
			<input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo htmlspecialchars($project['end_date'], ENT_QUOTES | ENT_HTML5); ?>" required>
		</div>
		<div class="form-group">
			<label for="phase">Phase:</label>
			<select class="form-control" id="phase" name="phase" required>
				<option value="Design" <?php if ($project['phase'] == 'Design') echo 'selected'; ?>>Design</option>
				<option value="Development" <?php if ($project['phase'] == 'Development') echo 'selected'; ?>>Development</option>
				<option value="Testing" <?php if ($project['phase'] == 'Testing') echo 'selected'; ?>>Testing</option>
				<option value="Deployment" <?php if ($project['phase'] == 'Deployment') echo 'selected'; ?>>Deployment</option>
				<option value="Complete" <?php if ($project['phase'] == 'Complete') echo 'selected'; ?>>Complete</option>
			</select>
		</div>
		
		<button type="submit" class="btn btn-primary" name="submit">Save Changes</button>
	</form>
</div>
</body>
</html>
