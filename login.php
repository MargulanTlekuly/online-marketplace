<?php
$pageTitle = 'Log In';
require_once 'includes/functions.php';

$errors = [];
$email = '';

if (isLoggedIn()) redirectTo('index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($email === '' || $password === '') {
        $errors[] = "Please fill in both email and password.";
    } else {
        $users = loadData('users.json');
        $found = null;
        foreach ($users as $u) {
            if (strtolower($u['email']) === strtolower($email)) { $found = $u; break; }
        }
        if (!$found) {
            $errors[] = "No account found with that email address.";
        } elseif (!password_verify($password, $found['password'])) {
            $errors[] = "Incorrect password. Please try again.";
        } else {
            unset($found['password']);
            $_SESSION['user'] = $found;
            redirectTo('index.php');
        }
    }
}
include 'includes/header.php';
?>

<div class="container-tight">
    <div class="form-card">
        <h2>Welcome Back</h2>
        <p class="form-sub">Log in to access your account, orders and cart.</p>

        <?php if (isset($_GET['registered'])): ?>
            <div class="alert alert-success">Account created successfully. You can now log in.</div>
        <?php endif; ?>
        <?php if (isset($_GET['loggedout'])): ?>
            <div class="alert alert-info">You have been logged out successfully.</div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error"><ul><?php foreach ($errors as $e) echo '<li>'.e($e).'</li>'; ?></ul></div>
        <?php endif; ?>

        <form method="post" action="login.php">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="you@example.com" value="<?= e($email) ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Log In</button>
        </form>

        <div class="form-footer">
            Don't have an account? <a href="register.php">Create one</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
