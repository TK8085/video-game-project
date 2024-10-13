<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

// Load video games from CSV
$games = array_map('str_getcsv', file('games.csv'));

?>

<?php include 'includes/header.php'; ?>

<h1>Video Game List</h1>
<h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

<ul>
<?php foreach ($games as $game): ?>
    <li>
        <h3><?php echo htmlspecialchars($game[0]); ?></h3>
        <p>Genre: <?php echo htmlspecialchars($game[1]); ?></p>
        <p>Platform: <?php echo htmlspecialchars($game[2]); ?></p>
        <img src="<?php echo htmlspecialchars($game[3]); ?>" alt="<?php echo htmlspecialchars($game[0]); ?>" width="150">
    </li>
<?php endforeach; ?>
</ul>

<?php include 'includes/footer.php'; ?>
