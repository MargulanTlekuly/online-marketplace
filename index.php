<?php
$pageTitle = 'Home';
require_once 'includes/functions.php';

$products   = loadData('products.json');
$featured   = array_slice($products, 0, 8);
$categories = [];
foreach ($products as $p) {
    $cat = $p['category'];
    if (!isset($categories[$cat])) $categories[$cat] = 0;
    $categories[$cat]++;
}

// Category display info: short code shown inside a coloured tile (no images required).
$catMeta = [
    'Electronics'    => ['code' => 'EL', 'count' => 0],
    'Clothing'       => ['code' => 'CL', 'count' => 0],
    'Accessories'    => ['code' => 'AC', 'count' => 0],
    'Home & Kitchen' => ['code' => 'HK', 'count' => 0],
];
foreach ($categories as $name => $c) {
    if (isset($catMeta[$name])) $catMeta[$name]['count'] = $c;
}

include 'includes/header.php';
?>

<section class="hero">
    <div class="hero-inner">
        <div>
            <h1>Everything you need,<br>delivered to your door.</h1>
            <p class="lead">Shop a curated selection of electronics, clothing, accessories and home goods at fair prices, with fast delivery and a simple, secure checkout.</p>
            <div class="hero-actions">
                <a href="catalog.php" class="btn btn-white btn-lg">Start Shopping</a>
                <a href="pages/about.php" class="btn btn-ghost btn-lg">Learn More</a>
            </div>
        </div>
        <div class="hero-stats">
            <div class="hero-stat"><span class="num"><?= count($products) ?>+</span><span class="lbl">Products</span></div>
            <div class="hero-stat"><span class="num"><?= count($categories) ?></span><span class="lbl">Categories</span></div>
            <div class="hero-stat"><span class="num">24/7</span><span class="lbl">Support</span></div>
            <div class="hero-stat"><span class="num">1-3d</span><span class="lbl">Delivery</span></div>
        </div>
    </div>
</section>

<section class="features-strip">
    <div class="features-strip-inner">
        <div class="feature-item">
            <div class="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            </div>
            <div class="feature-txt">
                <h4>Free Delivery</h4>
                <p>On all orders over $50</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <div class="feature-txt">
                <h4>Secure Payment</h4>
                <p>Encrypted checkout</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div class="feature-txt">
                <h4>Quality Guarantee</h4>
                <p>Verified products only</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="feature-txt">
                <h4>24/7 Support</h4>
                <p>We reply within hours</p>
            </div>
        </div>
    </div>
</section>

<div class="container">

    <?php if (isLoggedIn()): ?>
        <div class="alert alert-info">
            Welcome back, <strong><?= e($_SESSION['user']['first_name']) ?></strong>. Continue exploring our catalog.
        </div>
    <?php endif; ?>

    <div class="section-head">
        <h2>Shop by Category</h2>
    </div>

    <div class="categories-grid">
        <?php foreach ($catMeta as $catName => $meta): ?>
            <?php if ($meta['count'] <= 0) continue; ?>
            <?php
                // Inline SVG icons per category (no emoji, no external files)
                $catIcons = [
                    'Electronics'    => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
                    'Clothing'       => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>',
                    'Accessories'    => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>',
                    'Home & Kitchen' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
                ];
            ?>
            <a href="catalog.php?category=<?= urlencode($catName) ?>" class="category-card">
                <div class="cat-shape"><?= $catIcons[$catName] ?? '' ?></div>
                <h4><?= e($catName) ?></h4>
                <div class="cat-count"><?= $meta['count'] ?> products</div>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="section-head">
        <h2>Featured Products</h2>
        <a href="catalog.php" class="view-all">View all products &rarr;</a>
    </div>

    <div class="grid">
        <?php foreach ($featured as $p): ?>
            <article class="card">
                <a href="product.php?id=<?= (int)$p['id'] ?>" class="card-media">
                    <?php if (!empty($p['image']) && file_exists(__DIR__.'/'.$p['image'])): ?>
                        <img src="<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>">
                    <?php else: ?>
                        <div class="image-placeholder">
                            <div class="ph-shape"><?= (int)$p['id'] ?></div>
                            <span>Add photo<br><small><?= e(basename($p['image'])) ?></small></span>
                        </div>
                    <?php endif; ?>
                </a>
                <div class="card-body">
                    <span class="cat"><?= e($p['category']) ?></span>
                    <a href="product.php?id=<?= (int)$p['id'] ?>"><h3><?= e($p['name']) ?></h3></a>
                    <?= renderStars($p['rating'] ?? 0) ?>
                    <div class="card-foot">
                        <div class="price">$<?= number_format($p['price'], 2) ?></div>
                        <a href="product.php?id=<?= (int)$p['id'] ?>" class="btn btn-sm">View</a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <div style="text-align:center; margin-top:40px;">
        <a href="catalog.php" class="btn btn-lg">Browse All Products</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
