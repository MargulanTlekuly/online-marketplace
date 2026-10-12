<?php
$pageTitle = 'Manage Orders';
$basePath = '../';
require_once '../includes/functions.php';
if (!isAdmin()) redirectTo('../login.php');

$orders = loadData('orders.json');
$users  = loadData('users.json');
$userMap = [];
foreach ($users as $u) $userMap[(int)$u['id']] = $u;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $oid    = (int)$_POST['order_id'];
    $status = $_POST['status'] ?? 'pending';
    $allowed = ['pending', 'confirmed', 'cancelled'];
    if (in_array($status, $allowed)) {
        foreach ($orders as &$o) {
            if ((int)$o['id'] === $oid) $o['status'] = $status;
        }
        unset($o);
        saveData('orders.json', $orders);
    }
    redirectTo('orders.php?updated=1');
}

$orders = array_reverse($orders);

include '../includes/header.php';
?>

<div class="admin-layout">
    <aside class="admin-sidebar">
        <a href="index.php">Dashboard</a>
        <a href="users.php">Users</a>
        <a href="products.php">Products</a>
        <a href="orders.php" class="active">Orders</a>
        <div class="admin-sep"></div>
        <a href="../index.php">View Site</a>
        <a href="../logout.php">Logout</a>
    </aside>

    <main class="admin-main">
        <div class="admin-toolbar">
            <div>
                <h1>Orders (<?= count($orders) ?>)</h1>
                <p class="admin-sub">View orders and update their status.</p>
            </div>
        </div>

        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-success">Order status updated.</div>
        <?php endif; ?>

        <?php if (empty($orders)): ?>
            <div class="empty-state">
                <div class="es-shape">0</div>
                <h3>No orders yet</h3>
                <p>Orders placed by customers will appear here.</p>
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Change Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $o):
                            $cust = $userMap[(int)$o['user_id']] ?? null;
                            $custName = $cust ? ($cust['first_name'].' '.$cust['last_name']) : 'User #'.(int)$o['user_id'];
                            $custEmail = $cust['email'] ?? '';
                            $count = array_sum(array_column($o['items'] ?? [], 'qty'));
                        ?>
                            <tr>
                                <td><strong>#<?= (int)$o['id'] ?></strong></td>
                                <td>
                                    <div style="font-weight:600;"><?= e($custName) ?></div>
                                    <div style="font-size:12px; color:var(--text-muted);"><?= e($custEmail) ?></div>
                                </td>
                                <td><?= (int)$count ?> item<?= $count!==1?'s':'' ?></td>
                                <td><strong>$<?= number_format($o['total'], 2) ?></strong></td>
                                <td style="font-size:13px;"><?= e($o['date']) ?></td>
                                <td><?= statusBadge($o['status'] ?? 'pending') ?></td>
                                <td>
                                    <form method="post" action="orders.php" style="display:flex; gap:6px; align-items:center;">
                                        <input type="hidden" name="order_id" value="<?= (int)$o['id'] ?>">
                                        <select name="status" class="form-control" style="padding:7px 10px; font-size:13px; width:auto; min-width:120px;">
                                            <option value="pending"   <?= ($o['status']??'pending')==='pending'?'selected':'' ?>>Pending</option>
                                            <option value="confirmed" <?= ($o['status']??'')==='confirmed'?'selected':'' ?>>Confirmed</option>
                                            <option value="cancelled" <?= ($o['status']??'')==='cancelled'?'selected':'' ?>>Cancelled</option>
                                        </select>
                                        <button type="submit" name="update_status" class="btn btn-sm">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php include '../includes/footer.php'; ?>
