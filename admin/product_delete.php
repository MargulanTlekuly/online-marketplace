<?php
$basePath = '../';
require_once '../includes/functions.php';
if (!isAdmin()) redirectTo('../login.php');

$id = (int)($_GET['id'] ?? 0);
$products = loadData('products.json');
$product = null;
foreach ($products as $p) { if ((int)$p['id'] === $id) { $product = $p; break; } }

if (!$product) redirectTo('products.php');

// If form was confirmed via POST -> delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) && (int)$_POST['confirm'] === $id) {
    $products = array_values(array_filter($products, fn($p) => (int)$p['id'] !== $id));
    saveData('products.json', $products);
    redirectTo('products.php?deleted=1');
}

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
        <h1>Delete Product</h1>
        <p class="admin-sub">Please confirm that you want to permanently remove this product.</p>

        <div class="admin-form">
            <div style="padding:20px; background:#fef2f2; border:1px solid #fecaca; border-radius:var(--r-md); margin-bottom:20px; color:var(--error);">
                <strong>Warning:</strong> This action cannot be undone. The product will be permanently removed from the catalog.
            </div>

            <table class="table" style="margin-bottom:20px;">
                <tr><th style="width:160px;">ID</th><td>#<?= (int)$product['id'] ?></td></tr>
                <tr><th>Name</th><td><strong><?= e($product['name']) ?></strong></td></tr>
                <tr><th>Category</th><td><?= e($product['category']) ?></td></tr>
                <tr><th>Price</th><td>$<?= number_format($product['price'], 2) ?></td></tr>
                <tr><th>Stock</th><td><?= (int)$product['stock'] ?> units</td></tr>
            </table>

            <form method="post" action="product_delete.php?id=<?= $id ?>" style="display:flex; gap:10px;">
                <input type="hidden" name="confirm" value="<?= $id ?>">
                <button type="submit" class="btn btn-danger">Yes, Delete This Product</button>
                <a href="products.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </main>
</div>

<?php include '../includes/footer.php'; ?>
