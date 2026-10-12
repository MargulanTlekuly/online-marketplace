<?php
$pageTitle = 'Create Account';
require_once 'includes/functions.php';

$errors = [];
$form = ['first_name'=>'', 'last_name'=>'', 'email'=>'', 'phone'=>'', 'address'=>''];

if (isLoggedIn()) redirectTo('index.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['first_name'] = trim($_POST['first_name'] ?? '');
    $form['last_name']  = trim($_POST['last_name'] ?? '');
    $form['email']      = trim($_POST['email'] ?? '');
    $form['phone']      = trim($_POST['phone'] ?? '');
    $form['address']    = trim($_POST['address'] ?? '');
    $password           = $_POST['password'] ?? '';
    $confirm            = $_POST['confirm_password'] ?? '';

    if ($form['first_name']==='' || $form['last_name']==='' || $form['email']==='' || $password==='' || $confirm==='') {
        $errors[] = "Please fill in all required fields (marked with *).";
    }
    if ($form['email'] !== '' && !filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }
    if ($password !== $confirm) {
        $errors[] = "Password confirmation does not match.";
    }
    $users = loadData('users.json');
    foreach ($users as $u) {
        if (strtolower($u['email']) === strtolower($form['email'])) {
            $errors[] = "An account with this email already exists.";
            break;
        }
    }
    if ($form['phone'] !== '' && !preg_match('/^[0-9+\-\s()]{7,20}$/', $form['phone'])) {
        $errors[] = "Please enter a valid phone number.";
    }

    if (empty($errors)) {
        $newUser = [
            'id'         => getNextId($users),
            'first_name' => $form['first_name'],
            'last_name'  => $form['last_name'],
            'email'      => $form['email'],
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'phone'      => $form['phone'],
            'address'    => $form['address'],
            'role'       => 'user',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $users[] = $newUser;
        saveData('users.json', $users);
        redirectTo('login.php?registered=1');
    }
}
include 'includes/header.php';
?>

<div class="container-tight">
    <div class="form-card">
        <h2>Create Your Account</h2>
        <p class="form-sub">Join today to start shopping and track your orders.</p>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <strong>Please fix the following errors:</strong>
                <ul><?php foreach ($errors as $err) echo '<li>'.e($err).'</li>'; ?></ul>
            </div>
        <?php endif; ?>

        <form method="post" action="register.php">
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name *</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" value="<?= e($form['first_name']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name *</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" value="<?= e($form['last_name']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= e($form['email']) ?>" placeholder="you@example.com" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Phone Number (optional)</label>
                    <input type="tel" id="phone" name="phone" class="form-control" value="<?= e($form['phone']) ?>" placeholder="+7 700 123 4567">
                </div>
                <div class="form-group">
                    <label for="address">Address (optional)</label>
                    <input type="text" id="address" name="address" class="form-control" value="<?= e($form['address']) ?>" placeholder="City, Street, Apt.">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" class="form-control" required minlength="6">
                    <div class="hint">At least 6 characters.</div>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password *</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required minlength="6">
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg">Create Account</button>
        </form>

        <div class="form-footer">
            Already have an account? <a href="login.php">Log in</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
