<?php
$pageTitle = 'Product Form';
$basePath = '../';
require_once '../includes/functions.php';
if (!isAdmin()) redirectTo('../login.php');

$products = loadData('products.json');
$editId = (int)($_GET['id'] ?? 0);
$product = null;
foreach ($products as $p) { if ((int)$p['id'] === $editId) { $product = $p; break; } }

$errors = [];
$form = [
    'name' => '', 'category' => '', 'price' => '', 'stock' => '', 'rating' => '4.5',
    'description' => '', 'image' => '',
];
if ($product) {
    $form = array_merge($form, [
        'name'        => $product['name'] ?? '',
        'category'    => $product['category'] ?? '',
        'price'       => (string)$product['price'],
        'stock'       => (string)$product['stock'],
        'rating'      => (string)($product['rating'] ?? 4.5),
        'description' => $product['description'] ?? '',
        'image'       => $product['image'] ?? '',
    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['name']        = trim($_POST['name'] ?? '');
    $form['category']    = trim($_POST['category'] ?? '');
    $form['price']       = trim($_POST['price'] ?? '');
    $form['stock']       = trim($_POST['stock'] ?? '');
    $form['rating']      = trim($_POST['rating'] ?? '0');
    $form['description'] = trim($_POST['description'] ?? '');
    $form['image']       = trim($_POST['image'] ?? '');

    if ($form['name']==='' || $form['category']==='' || $form['price']==='') {
        $errors[] = "Please fill in all required fields (name, category, price).";
    }
    if (!is_numeric($form['price']) || (float)$form['price'] <= 0) {
        $errors[] = "Price must be a positive number.";
    }
    if (!is_numeric($form['stock']) || (int)$form['stock'] < 0) {
        $errors[] = "Stock must be a non-negative whole number.";
    }
    if (!is_numeric($form['rating']) || (float)$form['rating'] < 0 || (float)$form['rating'] > 5) {
        $errors[] = "Rating must be a number between 0 and 5.";
    }

    if (empty($errors)) {
        $data = [
            'name'        => $form['name'],
            'category'    => $form['category'],
            'price'       => (float)$form['price'],
            'stock'       => (int)$form['stock'],
            'rating'      => (float)$form['rating'],
            'description' => $form['description'],
            'image'       => $form['image'],
        ];
        if ($product) {
            foreach ($products as &$p) {
                if ((int)$p['id'] === $editId) {
                    $p = array_merge(['id' => $editId], $data);
                }
            }
            unset($p);
        } else {
            $products[] = array_merge(['id' => getNextId($products)], $data);
        }
        saveData('products.json', $products);
        redirectTo('products.php?saved=1');
    }
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
        <h1><?= $product ? 'Edit Product' : 'Add New Product' ?></h1>
        <p class="admin-sub"><?= $product ? 'Update product details below.' : 'Fill in the details to add a new product to the catalog.' ?></p>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error"><ul><?php foreach ($errors as $e) echo '<li>'.e($e).'</li>'; ?></ul></div>
        <?php endif; ?>

        <div class="admin-form">
            <form method="post" action="<?= $product ? 'product_form.php?id='.$editId : 'product_form.php' ?>">
                <div class="form-group">
                    <label for="name">Product Name *</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= e($form['name']) ?>" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Category *</label>
                        <input type="text" id="category" name="category" class="form-control" value="<?= e($form['category']) ?>" placeholder="Electronics / Clothing / Accessories / Home &amp; Kitchen" required>
                    </div>
                    <div class="form-group">
                        <label for="rating">Rating (0 - 5)</label>
                        <input type="text" id="rating" name="rating" class="form-control" value="<?= e($form['rating']) ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price (USD) *</label>
                        <input type="text" id="price" name="price" class="form-control" value="<?= e($form['price']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock (units)</label>
                        <input type="text" id="stock" name="stock" class="form-control" value="<?= e($form['stock']) ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="image">Image Path</label>
                    <input type="text" id="image" name="image" class="form-control" value="<?= e($form['image']) ?>" placeholder="images/items/1.jpg">
                    <div class="hint">Place your image file in <code>images/items/</code> and enter the path above. Leave empty to show a placeholder.</div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="5" placeholder="Describe the product..."><?= e($form['description']) ?></textarea>
                </div>
                <div style="display:flex; gap:10px;">
                    <button type="submit" class="btn btn-primary"><?= $product ? 'Save Changes' : 'Add Product' ?></button>
                    <a href="products.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </main>
</div>

<?php include '../includes/footer.php'; ?>
