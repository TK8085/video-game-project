<?php
session_start();
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (empty($username) || empty($password)) {
        $error_message = 'Both fields are required.';
    } else {
        // Load users from CSV
        $users = array_map('str_getcsv', file('users.csv'));
        $valid = false;

        foreach ($users as $user) {
            if ($user[0] === $username && password_verify($password, $user[1])) {
                $valid = true;
                break;
            }
        }

        if ($valid) {
            $_SESSION['username'] = $username; // Store username in session
            header('Location: games.php');
            exit;
        } else {
            $error_message = 'Invalid username or password.';
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<h1>Login to Video Store</h1>

<?php if ($error_message): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
<?php endif; ?>

<form method="POST" action="">
    <input type="text" name="username" placeholder="Username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" value="Login">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
</form>

<?php include 'includes/footer.php'; ?>
