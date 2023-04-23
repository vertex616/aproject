<?php
    // Include the dbconnect.php file to establish database connection
    require_once 'dbconnect.php';
    require_once 'search.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $searchTerm = $_POST['searchTerm'];
        $startDate = $_POST['startDate'];

        // Build the SQL query to search projects by title and/or start date
        $sql = "SELECT * FROM projects WHERE title LIKE :searchTerm";
        $params = [':searchTerm' => "%$searchTerm%"];
        
        if (!empty($startDate)) {
            $sql .= " AND start_date = :startDate";
            $params[':startDate'] = $startDate;
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Projects</title>
</head>
<body>
    <h1>Search Projects</h1>
    <form method="POST">
        <label for="searchTerm">Search by Title:</label>
        <input type="text" name="searchTerm">
        <br><br>
        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate">
        <br><br>
        <button type="submit">Search</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($results)): ?>
        <h2>Search Results:</h2>
        <?php foreach ($results as $result): ?>
            <div>
                <h3><?php echo $result['title']; ?></h3>
                <p><?php echo $result['start_date']; ?></p>
                <p><?php echo $result['description']; ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
<?php
    // Include the dbconnect.php file to establish database connection
    require_once 'dbconnect.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $searchTerm = $_POST['searchTerm'];
        $startDate = $_POST['startDate'];

        // Build the SQL query to search projects by title and/or start date
        $sql = "SELECT * FROM projects WHERE title LIKE :searchTerm";
        $params = [':searchTerm' => "%$searchTerm%"];
        
        if (!empty($startDate)) {
            $sql .= " AND start_date = :startDate";
            $params[':startDate'] = $startDate;
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Projects</title>
</head>
<body>
    <h1>Search Projects</h1>
    <form method="POST">
        <label for="searchTerm">Search by Title:</label>
        <input type="text" name="searchTerm">
        <br><br>
        <label for="startDate">Start Date:</label>
        <input type="date" name="startDate">
        <br><br>
        <button type="submit">Search</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($results)): ?>
        <h2>Search Results:</h2>
        <?php foreach ($results as $result): ?>
            <div>
                <h3><?php echo $result['title']; ?></h3>
                <p><?php echo $result['start_date']; ?></p>
                <p><?php echo $result['description']; ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
