<?php
$pageTitle = 'My Cart';
require_once 'includes/functions.php';

$products = loadData('products.json');
$cart = $_SESSION['cart'] ?? [];
$notice = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove'])) {
        unset($_SESSION['cart'][(int)$_POST['remove']]);
        redirectTo('cart.php?removed=1');
    }
    if (isset($_POST['update'])) {
        $pid = (int)$_POST['update'];
        $newQty = max(1, (int)($_POST['qty'] ?? 1));
        foreach ($products as $p) {
            if ((int)$p['id'] === $pid) { $newQty = min($newQty, (int)$p['stock']); break; }
        }
        $_SESSION['cart'][$pid] = $newQty;
        redirectTo('cart.php?updated=1');
    }
}

$cartItems = [];
$total = 0;
$totalQty = 0;
foreach ($cart as $pid => $qty) {
    foreach ($products as $p) {
        if ((int)$p['id'] === (int)$pid) {
            $subtotal = $p['price'] * $qty;
            $total += $subtotal;
            $totalQty += $qty;
            $cartItems[] = array_merge($p, ['qty' => $qty, 'subtotal' => $subtotal]);
        }
    }
}

include 'includes/header.php';
?>

<div class="container">
    <h1 class="page-title">Shopping Cart</h1>
    <p class="page-sub">Review the items in your cart before checkout.</p>

    <?php if (isset($_GET['added'])): ?>
        <div class="alert alert-success">Product added to your cart successfully.</div>
    <?php endif; ?>
    <?php if (isset($_GET['removed'])): ?>
        <div class="alert alert-success">Product removed from your cart.</div>
    <?php endif; ?>
    <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-success">Cart updated.</div>
    <?php endif; ?>

    <?php if (empty($cartItems)): ?>
        <div class="empty-state">
            <div class="es-shape">0</div>
            <h3>Your cart is empty</h3>
            <p>Looks like you haven't added anything to your cart yet.</p>
            <a href="catalog.php" class="btn">Start Shopping</a>
        </div>
    <?php else: ?>
        <div class="cart-table-wrap">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td data-label="Product" class="ci-cell">
                                <div class="cart-item">
                                    <?php if (!empty($item['image']) && file_exists(__DIR__.'/'.$item['image'])): ?>
                                        <img src="<?= e($item['image']) ?>" alt="">
                                    <?php else: ?>
                                        <span class="ci-ph"></span>
                                    <?php endif; ?>
                                    <div>
                                        <div class="ci-name"><?= e($item['name']) ?></div>
                                        <div class="ci-cat"><?= e($item['category']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Price">$<?= number_format($item['price'], 2) ?></td>
                            <td data-label="Qty">
                                <form method="post" style="display:flex; gap:6px; align-items:center;">
                                    <input type="hidden" name="update" value="<?= (int)$item['id'] ?>">
                                    <input type="number" name="qty" class="qty-num" value="<?= (int)$item['qty'] ?>" min="1" max="<?= (int)$item['stock'] ?>">
                                    <button type="submit" class="btn btn-secondary btn-sm">Update</button>
                                </form>
                            </td>
                            <td data-label="Subtotal"><strong>$<?= number_format($item['subtotal'], 2) ?></strong></td>
                            <td data-label="">
                                <form method="post">
                                    <button type="submit" name="remove" value="<?= (int)$item['id'] ?>" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="cart-summary">
            <h3>Order Summary</h3>
            <div class="summary-row"><span>Items (<?= $totalQty ?>):</span><span>$<?= number_format($total, 2) ?></span></div>
            <div class="summary-row"><span>Shipping:</span><span style="color:var(--success); font-weight:600;">FREE</span></div>
            <div class="summary-row total"><span>Total:</span><span>$<?= number_format($total, 2) ?></span></div>
            <?php if (isLoggedIn()): ?>
                <a href="checkout.php" class="btn btn-primary btn-block btn-lg" style="margin-top:14px;">Proceed to Checkout</a>
            <?php else: ?>
                <p style="font-size:13px; color:var(--text-muted); margin-top:14px;">Please <a href="login.php">log in</a> to complete your order.</p>
                <a href="login.php" class="btn btn-primary btn-block btn-lg" style="margin-top:8px;">Log In to Checkout</a>
            <?php endif; ?>
            <a href="catalog.php" style="display:block; text-align:center; margin-top:12px; color:var(--text-muted);">&larr; Continue Shopping</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
