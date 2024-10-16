<?php
// Path to games.csv
$games_file_path = __DIR__ . '/games.csv';

// Check if games.csv exists
if (!file_exists($games_file_path)) {
    die('Error: games.csv file not found.');
}

// Read and process the video games
$games = array_map('str_getcsv', file($games_file_path));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Video Game List</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
</head>
<body>
    <h1>Available Video Games</h1>

    <!-- Display the video game list -->
    <ul>
        <?php foreach ($games as $index => $game): ?>
            <?php if ($index === 0) continue; // Skip CSV header row ?>
            <li>
                <strong><?php echo htmlspecialchars($game[0]); ?></strong> <br>
                Genre: <?php echo htmlspecialchars($game[1]); ?> <br>
                Platform: <?php echo htmlspecialchars($game[2]); ?> <br>
                <img src="<?php echo htmlspecialchars($game[3]); ?>" alt="<?php echo htmlspecialchars($game[0]); ?>"><br>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
