<?php
require_once 'dbconnect.php';

session_start();

// Check if user is logged in and redirect to login page if not
if (isset($_SESSION['user'])) {
    $uid = $_SESSION['user']['uid'];
} else {
    $uid = null;
}

// Process search query if submitted
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $search = filter_var($search, FILTER_SANITIZE_STRING);

    // Retrieve projects that match the search query
    $query = "SELECT projects.pid, projects.title, projects.start_date, projects.end_date, projects.description, users.email, projects.uid FROM projects JOIN users ON projects.uid = users.uid WHERE projects.title LIKE :search OR projects.start_date LIKE :search";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    // Retrieve all projects from the database
    $query = 'SELECT projects.pid, projects.title, projects.start_date, projects.end_date, projects.description, users.email, projects.uid FROM projects JOIN users ON projects.uid = users.uid';
    $stmt = $db->prepare($query);
    $stmt->execute();
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Projects</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">APROJECT</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php
                if ($uid) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="add_project.php">Add a Project</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                <?php
                } else {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">


        <h1 class="mb-4">List of Projects</h1>

        <?php
        if ($uid) {
        ?>

        <div class="mb-3">
            <a href="add_project.php" class="btn btn-primary">Add a Project</a>
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </div>

        <?php
        } else {
        ?>

        <div class="mb-3">
            <a href="login.php" class="btn btn-primary">Login</a>
            <a href="register.php" class="btn btn-secondary">Register</a>
        </div>

        <?php
        }
        ?>
    
        <div class="mb-3">
            <form method="get">
                <div class="form-group">
                    <label for="search">Search by title or start date:</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Enter search query" value="<?php if(isset($_GET['search'])) { echo htmlspecialchars($_GET['search'], ENT_QUOTES | ENT_HTML5); } ?>">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <div class="list-group">

            <?php
            // Display the list of projects with links to their details
            foreach ($projects as $project) {
                echo '<a href="project_details.php?pid=' . htmlspecialchars($project['pid'], ENT_QUOTES | ENT_HTML5) . '" class="list-group-item list-group-item-action">';
                echo '<div class="d-flex w-100 justify-content-between">';
                echo '<h5 class="mb-1">' . htmlspecialchars($project['title'], ENT_QUOTES | ENT_HTML5) . '</h5>';
                echo '<small>User Email: ' . htmlspecialchars($project['email'], ENT_QUOTES | ENT_HTML5) . '</small>';
                echo '</div>';
                echo '<p class="mb-1">Starting Date: ' . htmlspecialchars($project['start_date'], ENT_QUOTES | ENT_HTML5) . '</p>';
                echo '<p class="mb-1">Ending Date: ' . htmlspecialchars($project['end_date'], ENT_QUOTES | ENT_HTML5) . '</p>';
                echo '<p class="mb-1">Description: ' . htmlspecialchars($project['description'], ENT_QUOTES | ENT_HTML5) . '</p>';
                if($project['uid'] == $uid){
                    echo '<p class="mb-1"><a href="edit_project.php?pid=' . htmlspecialchars($project['pid'], ENT_QUOTES | ENT_HTML5) . '">Edit</a></p>';
                }
                echo '</a>';
            }
            ?>

        </div>


    </div>

    <footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <span class="text-muted">&copy;<?php echo date('Y'); ?> Y Bazaz | 220000253@aston.ac.uk </span>
    </div>
</footer>
    <!-- Bootstrap JS -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

