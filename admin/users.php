<?php
$pageTitle = 'Manage Users';
$basePath = '../';
require_once '../includes/functions.php';
if (!isAdmin()) redirectTo('../login.php');

$users = loadData('users.json');
$orders = loadData('orders.json');
$orderCount = [];
foreach ($orders as $o) {
    $uid = (int)($o['user_id'] ?? 0);
    $orderCount[$uid] = ($orderCount[$uid] ?? 0) + 1;
}

include '../includes/header.php';
?>

<div class="admin-layout">
    <aside class="admin-sidebar">
        <a href="index.php">Dashboard</a>
        <a href="users.php" class="active">Users</a>
        <a href="products.php">Products</a>
        <a href="orders.php">Orders</a>
        <div class="admin-sep"></div>
        <a href="../index.php">View Site</a>
        <a href="../logout.php">Logout</a>
    </aside>

    <main class="admin-main">
        <div class="admin-toolbar">
            <div>
                <h1>Users (<?= count($users) ?>)</h1>
                <p class="admin-sub">Registered customers and administrators.</p>
            </div>
        </div>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Orders</th>
                        <th>Registered</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><strong>#<?= (int)$u['id'] ?></strong></td>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <?= avatar($u['first_name'].' '.($u['last_name']??''), 32) ?>
                                    <div>
                                        <div style="font-weight:600;"><?= e($u['first_name'].' '.$u['last_name']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><?= e($u['email']) ?></td>
                            <td><?= e($u['phone'] ?? '-') ?></td>
                            <td><?= statusBadge($u['role'] ?? 'user') ?></td>
                            <td><strong><?= (int)($orderCount[(int)$u['id']] ?? 0) ?></strong></td>
                            <td style="font-size:13px; color:var(--text-muted);"><?= e($u['created_at'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php include '../includes/footer.php'; ?>
