<?php
$pageTitle = 'Manage Products';
$basePath = '../';
require_once '../includes/functions.php';
if (!isAdmin()) redirectTo('../login.php');

$products = loadData('products.json');
$msg = '';
if (isset($_GET['saved']))   $msg = 'Product saved successfully.';
if (isset($_GET['deleted'])) $msg = 'Product deleted successfully.';

include '../includes/header.php';
?>

<div class="admin-layout">
    <aside class="admin-sidebar">
        <a href="index.php">Dashboard</a>
        <a href="users.php">Users</a>
        <a href="products.php" class="active">Products</a>
        <a href="orders.php">Orders</a>
        <div class="admin-sep"></div>
        <a href="../index.php">View Site</a>
        <a href="../logout.php">Logout</a>
    </aside>

    <main class="admin-main">
        <div class="admin-toolbar">
            <div>
                <h1>Products (<?= count($products) ?>)</h1>
                <p class="admin-sub">Create, edit and delete products in your store.</p>
            </div>
            <a href="product_form.php" class="btn btn-primary">Add New Product</a>
        </div>

        <?php if ($msg): ?>
            <div class="alert alert-success"><?= e($msg) ?></div>
        <?php endif; ?>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td>
                                <?php if (!empty($p['image']) && file_exists(__DIR__.'/../'.$p['image'])): ?>
                                    <span class="thumb-box"><img src="../<?= e($p['image']) ?>" alt=""></span>
                                <?php else: ?>
                                    <span class="thumb-box"></span>
                                <?php endif; ?>
                            </td>
                            <td><strong><?= e($p['name']) ?></strong><div style="font-size:12px; color:var(--text-muted);">ID: #<?= (int)$p['id'] ?></div></td>
                            <td><?= e($p['category']) ?></td>
                            <td><strong>$<?= number_format($p['price'], 2) ?></strong></td>
                            <td><?= stockBadge($p['stock']) ?></td>
                            <td><?= renderStars($p['rating'] ?? 0) ?></td>
                            <td>
                                <a href="product_form.php?id=<?= (int)$p['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
                                <a href="product_delete.php?id=<?= (int)$p['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php include '../includes/footer.php'; ?>
