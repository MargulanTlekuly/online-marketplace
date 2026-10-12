<?php
$pageTitle = 'Dashboard';
$basePath = '../';
require_once '../includes/functions.php';
if (!isAdmin()) redirectTo('../login.php');

$users    = loadData('users.json');
$products = loadData('products.json');
$orders   = loadData('orders.json');
$pending  = count(array_filter($orders, fn($o) => ($o['status'] ?? 'pending') === 'pending'));
$revenue  = array_sum(array_column($orders, 'total'));

include '../includes/header.php';
?>

<div class="admin-layout">
    <aside class="admin-sidebar">
        <a href="index.php" class="active">Dashboard</a>
        <a href="users.php">Users</a>
        <a href="products.php">Products</a>
        <a href="orders.php">Orders</a>
        <div class="admin-sep"></div>
        <a href="../index.php">View Site</a>
        <a href="../logout.php">Logout</a>
    </aside>

    <main class="admin-main">
        <h1>Dashboard</h1>
        <p class="admin-sub">Welcome back, <strong><?= e($_SESSION['user']['first_name']) ?></strong>. Here is an overview of your store.</p>

        <div class="stat-grid">
            <div class="stat-card accent">
                <div class="stat-lbl">Total Users</div>
                <div class="stat-val"><?= count($users) ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-lbl">Total Products</div>
                <div class="stat-val"><?= count($products) ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-lbl">Total Orders</div>
                <div class="stat-val"><?= count($orders) ?></div>
            </div>
            <div class="stat-card warning">
                <div class="stat-lbl">Pending Orders</div>
                <div class="stat-val"><?= $pending ?></div>
            </div>
            <div class="stat-card success">
                <div class="stat-lbl">Total Revenue</div>
                <div class="stat-val">$<?= number_format($revenue, 0) ?></div>
            </div>
        </div>

        <div>
            <h2 style="font-size:20px; margin-bottom:14px;">Quick Actions</h2>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <a href="product_form.php" class="btn btn-primary">Add New Product</a>
                <a href="products.php" class="btn btn-secondary">Manage Products</a>
                <a href="orders.php" class="btn btn-secondary">View Orders</a>
                <a href="users.php" class="btn btn-secondary">View Users</a>
            </div>
        </div>
    </main>
</div>

<?php include '../includes/footer.php'; ?>
