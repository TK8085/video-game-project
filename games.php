<?php
// Database connection
$host = 'localhost'; 
$db = 'videogame_store'; 
$user = 'root'; 
$pass = ''; 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Retrieve all games to display
$sql = "SELECT * FROM games";
$games = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Video Game List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Available Video Games</h1>

    <!-- Link to Add Game Form -->
    <p><a href="add_game.php">Add a New Video Game</a></p>

    <!-- Display the video game list -->
    <ul>
        <?php foreach ($games as $game): ?>
            <li>
                <strong><?php echo htmlspecialchars($game['title']); ?></strong><br>
                Genre: <?php echo htmlspecialchars($game['genre']); ?><br>
                Platform: <?php echo htmlspecialchars($game['platform']); ?><br>
                <img src="images/<?php echo htmlspecialchars($game['image']); ?>" alt="<?php echo htmlspecialchars($game['title']); ?>"><br>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
