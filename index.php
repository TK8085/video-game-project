<?php
// Path to users.csv
$users_file_path = __DIR__ . '/users.csv';

// Check if the form was submitted
$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Validate form inputs
    if (empty($username) || empty($password)) {
        $error_message = 'Username and Password are required!';
    } else {
        // Check if users.csv exists
        if (!file_exists($users_file_path)) {
            die('Error: users.csv file not found.');
        }

        // Read and check credentials
        $users = array_map('str_getcsv', file($users_file_path));
        $is_valid = false;
        foreach ($users as $user) {
            if ($user[0] === $username && $user[1] === $password) {
                $is_valid = true;
                break;
            }
        }

        // If valid, redirect to games.php
        if ($is_valid) {
            header('Location: games.php');
            exit();
        } else {
            $error_message = 'Invalid username or password!';
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
