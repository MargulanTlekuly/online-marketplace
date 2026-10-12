<?php
$pageTitle = 'Product Catalog';
require_once 'includes/functions.php';

$products = loadData('products.json');
$search   = trim($_GET['search'] ?? '');
$category = $_GET['category'] ?? 'all';
$sort     = $_GET['sort'] ?? 'default';

$cats = array_values(array_unique(array_column($products, 'category')));
sort($cats);

$filtered = array_filter($products, function($p) use ($search, $category) {
    $ms = ($search === '')
        || stripos($p['name'], $search) !== false
        || stripos($p['description'] ?? '', $search) !== false;
    $mc = ($category === 'all') || ($p['category'] === $category);
    return $ms && $mc;
});
$filtered = array_values($filtered);

if ($sort === 'price_asc')      { usort($filtered, fn($a,$b) => $a['price'] <=> $b['price']); }
elseif ($sort === 'price_desc') { usort($filtered, fn($a,$b) => $b['price'] <=> $a['price']); }
elseif ($sort === 'rating')     { usort($filtered, fn($a,$b) => ($b['rating']??0) <=> ($a['rating']??0)); }
elseif ($sort === 'name')       { usort($filtered, fn($a,$b) => strcasecmp($a['name'], $b['name'])); }

include 'includes/header.php';
?>

<div class="container">
    <h1 class="page-title">Product Catalog</h1>
    <p class="page-sub">
        Browse all <?= count($products) ?> products
        <?php if ($category !== 'all'): ?> in <strong><?= e($category) ?></strong><?php endif; ?>
        <?php if ($search !== ''): ?> matching &quot;<strong><?= e($search) ?></strong>&quot;<?php endif; ?>.
    </p>

    <form method="get" action="catalog.php" class="catalog-toolbar">
        <div class="search-box">
            <input type="text" name="search" placeholder="Search products..." value="<?= e($search) ?>">
        </div>
        <select name="category" class="form-control" style="width:auto; min-width:180px;">
            <option value="all">All Categories</option>
            <?php foreach ($cats as $c): ?>
                <option value="<?= e($c) ?>" <?= $category === $c ? 'selected' : '' ?>><?= e($c) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="sort" class="form-control" style="width:auto; min-width:170px;">
            <option value="default"    <?= $sort==='default'?'selected':'' ?>>Sort: Featured</option>
            <option value="price_asc"  <?= $sort==='price_asc'?'selected':'' ?>>Price: Low to High</option>
            <option value="price_desc" <?= $sort==='price_desc'?'selected':'' ?>>Price: High to Low</option>
            <option value="rating"     <?= $sort==='rating'?'selected':'' ?>>Highest Rated</option>
            <option value="name"       <?= $sort==='name'?'selected':'' ?>>Name A-Z</option>
        </select>
        <button type="submit" class="btn btn-primary">Apply</button>
        <?php if ($search !== '' || $category !== 'all' || $sort !== 'default'): ?>
            <a href="catalog.php" class="btn btn-secondary">Reset</a>
        <?php endif; ?>
    </form>

    <div class="catalog-stats">Showing <strong><?= count($filtered) ?></strong> product<?= count($filtered)!==1?'s':'' ?>.</div>

    <?php if (empty($filtered)): ?>
        <div class="empty-state">
            <div class="es-shape">?</div>
            <h3>No products found</h3>
            <p>Try adjusting your search or filter criteria.</p>
            <a href="catalog.php" class="btn">Show all products</a>
        </div>
    <?php else: ?>
        <div class="grid">
            <?php foreach ($filtered as $p): ?>
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
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
