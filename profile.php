<?php
$pageTitle = 'My Profile';
require_once 'includes/functions.php';
if (!isLoggedIn()) redirectTo('login.php');

$user = $_SESSION['user'];
$users = loadData('users.json');
$orders = loadData('orders.json');
$errors = [];
$success = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $address    = trim($_POST['address'] ?? '');

    if ($first_name === '' || $last_name === '' || $email === '') {
        $errors[] = "First name, last name and email are required.";
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if ($phone !== '' && !preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) {
        $errors[] = "Please enter a valid phone number.";
    }
    foreach ($users as $u) {
        if ((int)$u['id'] !== (int)$user['id'] && strtolower($u['email']) === strtolower($email)) {
            $errors[] = "This email is already used by another account.";
            break;
        }
    }

    if (empty($errors)) {
        foreach ($users as &$u) {
            if ((int)$u['id'] === (int)$user['id']) {
                $u['first_name'] = $first_name;
                $u['last_name']  = $last_name;
                $u['email']      = $email;
                $u['phone']      = $phone;
                $u['address']    = $address;
                $_SESSION['user'] = $u;
                $user = $u;
                break;
            }
        }
        unset($u);
        saveData('users.json', $users);
        $success = "Your profile has been updated successfully.";
    }
}

$myOrders = array_values(array_filter($orders, fn($o) => (int)($o['user_id'] ?? 0) === (int)$user['id']));
$myOrders = array_reverse($myOrders);

include 'includes/header.php';
?>

<div class="container">
    <h1 class="page-title">My Profile</h1>
    <p class="page-sub">Manage your account and view your order history.</p>

    <div class="profile-layout">
        <aside class="profile-card">
            <?= avatar($user['first_name'].' '.($user['last_name']??''), 80) ?>
            <h3><?= e($user['first_name'] . ' ' . $user['last_name']) ?></h3>
            <p class="p-email"><?= e($user['email']) ?></p>
            <p class="p-phone"><?= e($user['phone'] ?? 'Not provided') ?></p>
            <p class="p-role"><?= statusBadge($user['role'] ?? 'user') ?></p>
            <ul class="profile-menu">
                <li><a href="#edit">Edit Profile</a></li>
                <li><a href="#orders">My Orders</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </aside>

        <div>
            <?php if ($success): ?>
                <div class="alert alert-success"><?= e($success) ?></div>
            <?php endif; ?>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error"><ul><?php foreach ($errors as $e) echo '<li>'.e($e).'</li>'; ?></ul></div>
            <?php endif; ?>

            <section class="profile-content" id="edit">
                <h2>Edit Profile</h2>
                <form method="post" action="profile.php">
                    <input type="hidden" name="update_profile" value="1">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" value="<?= e($user['first_name']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" value="<?= e($user['last_name'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= e($user['email']) ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" class="form-control" value="<?= e($user['phone'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" class="form-control" value="<?= e($user['address'] ?? '') ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="logout.php" class="btn btn-secondary">Logout</a>
                </form>
            </section>

            <section class="profile-content" id="orders" style="margin-top:22px;">
                <h2>My Orders</h2>
                <?php if (empty($myOrders)): ?>
                    <div class="empty-state">
                        <div class="es-shape">N</div>
                        <h3>No orders yet</h3>
                        <p>You haven't placed any orders.</p>
                        <a href="catalog.php" class="btn">Browse Catalog</a>
                    </div>
                <?php else: ?>
                    <div class="table-wrap">
                        <table class="table orders-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($myOrders as $o):
                                    $c = array_sum(array_column($o['items'] ?? [], 'qty'));
                                ?>
                                    <tr>
                                        <td><strong>#<?= (int)$o['id'] ?></strong></td>
                                        <td><?= e($o['date'] ?? '-') ?></td>
                                        <td><?= (int)$c ?> item<?= $c!==1?'s':'' ?></td>
                                        <td><strong>$<?= number_format($o['total'] ?? 0, 2) ?></strong></td>
                                        <td><?= statusBadge($o['status'] ?? 'pending') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
