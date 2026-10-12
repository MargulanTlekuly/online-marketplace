<?php
$pageTitle = 'Order Confirmed';
require_once 'includes/functions.php';

$orderId = (int)($_GET['order_id'] ?? 0);
$orders = loadData('orders.json');
$order = null;
foreach ($orders as $o) { if ((int)$o['id'] === $orderId) { $order = $o; break; } }
if (!$order) redirectTo('index.php');

if (!isLoggedIn() || (!isAdmin() && (int)$_SESSION['user']['id'] !== (int)$order['user_id'])) {
    redirectTo('login.php');
}

$itemCount = array_sum(array_column($order['items'] ?? [], 'qty'));

include 'includes/header.php';
?>

<div class="container-tight">
    <div class="confirm-card">
        <div class="confirm-check">&#10003;</div>
        <h1>Order Confirmed</h1>
        <p class="lead">Thank you for your purchase. Your order has been placed successfully.</p>

        <div class="confirm-details">
            <div class="cd-row"><span class="cd-lbl">Order Number:</span><span class="cd-val">#<?= (int)$order['id'] ?></span></div>
            <div class="cd-row"><span class="cd-lbl">Date:</span><span class="cd-val"><?= e($order['date']) ?></span></div>
            <div class="cd-row"><span class="cd-lbl">Items:</span><span class="cd-val"><?= $itemCount ?></span></div>
            <div class="cd-row"><span class="cd-lbl">Payment:</span><span class="cd-val"><?= e(ucfirst($order['payment'] ?? '-')) ?></span></div>
            <div class="cd-row"><span class="cd-lbl">Status:</span><span class="cd-val"><?= statusBadge($order['status'] ?? 'pending') ?></span></div>
            <hr>
            <div class="cd-row total"><span class="cd-lbl">Total:</span><span class="cd-val">$<?= number_format($order['total'], 2) ?></span></div>
        </div>

        <div style="display:flex; gap:10px; justify-content:center; flex-wrap:wrap;">
            <a href="profile.php" class="btn btn-primary">View My Orders</a>
            <a href="catalog.php" class="btn btn-secondary">Continue Shopping</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
