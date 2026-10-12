<?php
require_once __DIR__ . '/functions.php';
$b = isset($basePath) ? $basePath : '';
$current = basename($_SERVER['PHP_SELF']);
$isAdmin = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' - ' : '' ?>Online Marketplace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $b ?>css/style.css">
</head>
<body>

<header class="site-header">
    <div class="header-inner">

        <?php if ($isAdmin): ?>
            <a href="<?= $b ?>admin/index.php" class="brand brand-admin">
                <span class="brand-mark brand-logo-img">A</span><span class="brand-text">Admin Panel</span>
            </a>
        <?php else: ?>
            <a href="<?= $b ?>index.php" class="brand">
                <img src="<?= $b ?>images/logo.png" alt="Marketplace" class="brand-logo">
            </a>
        <?php endif; ?>

        <nav class="main-nav">
            <?php if ($isAdmin): ?>
                <a href="<?= $b ?>admin/index.php"    class="<?= $current==='index.php' ? 'active':'' ?>">Dashboard</a>
                <a href="<?= $b ?>admin/users.php"    class="<?= $current==='users.php' ? 'active':'' ?>">Users</a>
                <a href="<?= $b ?>admin/products.php" class="<?= in_array($current,['products.php','product_form.php']) ? 'active':'' ?>">Products</a>
                <a href="<?= $b ?>admin/orders.php"   class="<?= $current==='orders.php' ? 'active':'' ?>">Orders</a>
                <a href="<?= $b ?>index.php">View Site</a>
                <a href="<?= $b ?>logout.php">Logout</a>
            <?php else: ?>
                <a href="<?= $b ?>index.php"       class="<?= $current==='index.php' ? 'active':'' ?>">Home</a>
                <a href="<?= $b ?>pages/about.php" class="<?= $current==='about.php' ? 'active':'' ?>">About</a>
                <a href="<?= $b ?>catalog.php"     class="<?= in_array($current,['catalog.php','product.php']) ? 'active':'' ?>">Catalog</a>
                <?php $cartQty = 0; if (!empty($_SESSION['cart'])) $cartQty = array_sum($_SESSION['cart']); ?>
                <a href="<?= $b ?>cart.php"        class="<?= $current==='cart.php' ? 'active':'' ?>">
                    Cart<?php if ($cartQty>0): ?><span class="cart-count"><?= $cartQty ?></span><?php endif; ?>
                </a>
                <a href="<?= $b ?>pages/contact.php" class="<?= $current==='contact.php' ? 'active':'' ?>">Contact</a>

                <?php if (isLoggedIn()): $u = $_SESSION['user']; ?>
                    <a href="<?= $b ?>profile.php" class="nav-user <?= $current==='profile.php' ? 'active':'' ?>">
                        <?= avatar($u['first_name'].' '.($u['last_name']??''), 30) ?>
                        <span><?= e($u['first_name']) ?></span>
                    </a>
                    <?php if (isAdmin()): ?>
                        <a href="<?= $b ?>admin/index.php" class="<?= $isAdmin?'active':'' ?>">Admin</a>
                    <?php endif; ?>
                    <a href="<?= $b ?>logout.php">Logout</a>
                <?php else: ?>
                    <a href="<?= $b ?>login.php"    class="<?= $current==='login.php' ? 'active':'' ?>">Login</a>
                    <a href="<?= $b ?>register.php" class="<?= $current==='register.php' ? 'active':'' ?> btn btn-sm btn-primary" style="margin-left:6px; color:#fff;">Sign up</a>
                <?php endif; ?>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="site-main">
