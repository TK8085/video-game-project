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

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $genre = filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_STRING);
    $platform = filter_input(INPUT_POST, 'platform', FILTER_SANITIZE_STRING);
    
    // Check and move image if provided
    if (!empty($_FILES['image']['name'])) {
        $target_directory = 'images/';
        $image_name = uniqid() . '_' . basename($_FILES['image']['name']);
        $target_file = $target_directory . $image_name;

        // Move the file to the images directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Insert game data into database
            $sql = "INSERT INTO games (title, genre, platform, image) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$title, $genre, $platform, $target_file])) {
                $message = "Game added successfully!";
            } else {
                $message = "Failed to add the game to the database.";
            }
        } else {
            $message = "Failed to upload the image.";
        }
    } else {
        $message = "Please select an image to upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add a Video Game</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Add a Video Game</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>

        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre" required><br>

        <label for="platform">Platform:</label>
        <input type="text" id="platform" name="platform" required><br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br>

        <button type="submit">Add Game</button>
    </form>

    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <h2>All Video Games</h2>
    <ul>
        <?php
        // Retrieve all games to display
        $sql = "SELECT * FROM games";
        foreach ($pdo->query($sql) as $game) {
            echo "<li>";
            echo "<strong>" . htmlspecialchars($game['title']) . "</strong><br>";
            echo "Genre: " . htmlspecialchars($game['genre']) . "<br>";
            echo "Platform: " . htmlspecialchars($game['platform']) . "<br>";
            echo '<img src="images/' . htmlspecialchars($game['image']) . '" alt="Game Image" style="width:100px;height:auto;"><br>';
            echo "</li>";
        }
        ?>
    </ul>
</body>
</html>
