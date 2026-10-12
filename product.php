<?php
$pageTitle = 'Product';
require_once 'includes/functions.php';

$products = loadData('products.json');
$id = (int)($_GET['id'] ?? 0);
$product = null;
foreach ($products as $p) { if ((int)$p['id'] === $id) { $product = $p; break; } }
if (!$product) redirectTo('catalog.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $qty = max(1, (int)($_POST['quantity'] ?? 1));
    $stock = (int)($product['stock'] ?? 0);
    if ($qty > $stock) $qty = $stock;
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = min($_SESSION['cart'][$id] + $qty, $stock);
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
    redirectTo('cart.php?added=1');
}

$related = array_values(array_filter($products, fn($p) => $p['category'] === $product['category'] && $p['id'] !== $product['id']));
$related = array_slice($related, 0, 4);

include 'includes/header.php';
?>

<div class="container">
    <nav class="breadcrumb">
        <a href="index.php">Home</a> /
        <a href="catalog.php">Catalog</a> /
        <a href="catalog.php?category=<?= urlencode($product['category']) ?>"><?= e($product['category']) ?></a> /
        <span class="current"><?= e($product['name']) ?></span>
    </nav>

    <div class="product-detail">
        <div class="product-gallery">
            <?php if (!empty($product['image']) && file_exists(__DIR__.'/'.$product['image'])): ?>
                <img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>">
            <?php else: ?>
                <div class="image-placeholder" style="border-radius:0;">
                    <div class="ph-shape"><?= (int)$product['id'] ?></div>
                    <span>Replace with product photo<br><small><?= e(basename($product['image'])) ?></small></span>
                </div>
            <?php endif; ?>
        </div>

        <div class="product-info">
            <span class="badge badge-user" style="margin-bottom:10px;"><?= e($product['category']) ?></span>
            <h1><?= e($product['name']) ?></h1>
            <div><?= renderStars($product['rating'] ?? 0) ?></div>
            <div class="price-big">$<?= number_format($product['price'], 2) ?></div>
            <p class="desc"><?= e($product['description'] ?? 'No description available.') ?></p>

            <div class="product-meta">
                <div class="pm-item">
                    <div class="pm-lbl">Availability</div>
                    <div class="pm-val"><?= stockBadge($product['stock']) ?></div>
                </div>
                <div class="pm-item">
                    <div class="pm-lbl">Category</div>
                    <div class="pm-val"><?= e($product['category']) ?></div>
                </div>
                <div class="pm-item">
                    <div class="pm-lbl">Rating</div>
                    <div class="pm-val"><?= number_format($product['rating'] ?? 0, 1) ?> / 5.0</div>
                </div>
                <div class="pm-item">
                    <div class="pm-lbl">SKU</div>
                    <div class="pm-val">#<?= sprintf('%04d', $product['id']) ?></div>
                </div>
            </div>

            <?php if ((int)$product['stock'] > 0): ?>
                <form method="post" class="qty-row">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" class="qty-input" value="1" min="1" max="<?= (int)$product['stock'] ?>">
                    <button type="submit" name="add_to_cart" class="btn btn-primary btn-lg">Add to Cart</button>
                </form>
            <?php else: ?>
                <button type="button" class="btn btn-secondary btn-lg" disabled>Out of Stock</button>
            <?php endif; ?>

            <div style="margin-top:20px; padding-top:18px; border-top:1px solid var(--border); display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; font-size:13px; color:var(--text-muted);">
                <div>Free delivery $50+</div>
                <div>30-day returns</div>
                <div>Secure checkout</div>
            </div>
        </div>
    </div>

    <?php if (!empty($related)): ?>
        <div style="margin-top:50px;">
            <div class="section-head">
                <h2>Related Products</h2>
                <a href="catalog.php?category=<?= urlencode($product['category']) ?>" class="view-all">View more in <?= e($product['category']) ?> &rarr;</a>
            </div>
            <div class="grid">
                <?php foreach ($related as $r): ?>
                    <article class="card">
                        <a href="product.php?id=<?= (int)$r['id'] ?>" class="card-media">
                            <?php if (!empty($r['image']) && file_exists(__DIR__.'/'.$r['image'])): ?>
                                <img src="<?= e($r['image']) ?>" alt="<?= e($r['name']) ?>">
                            <?php else: ?>
                                <div class="image-placeholder">
                                    <div class="ph-shape"><?= (int)$r['id'] ?></div>
                                    <span>Photo</span>
                                </div>
                            <?php endif; ?>
                        </a>
                        <div class="card-body">
                            <span class="cat"><?= e($r['category']) ?></span>
                            <a href="product.php?id=<?= (int)$r['id'] ?>"><h3><?= e($r['name']) ?></h3></a>
                            <?= renderStars($r['rating'] ?? 0) ?>
                            <div class="card-foot">
                                <div class="price">$<?= number_format($r['price'], 2) ?></div>
                                <a href="product.php?id=<?= (int)$r['id'] ?>" class="btn btn-sm">View</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
