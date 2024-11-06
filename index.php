<?php
// Database connection settings
$host = 'localhost';
$dbname = 'videogame_store';
$dbuser = 'root';
$dbpass = '';

// Check if the form was submitted
$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Validate form inputs
    if (empty($username) || empty($password)) {
        $error_message = 'Username and Password are required!';
    } else {
        try {
            // Create a new PDO instance
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare and execute the SQL query
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            // Check if a matching user is found
            if ($stmt->rowCount() > 0) {
                header('Location: games.php');
                exit();
            } else {
                $error_message = 'Invalid username or password!';
            }

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Video Store Login</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
</head>
<body>
    <h1>Login to Video Store</h1>

    <!-- Display error message if exists -->
    <?php if (!empty($error_message)) : ?>
        <p style="color:red;"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>"><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>
