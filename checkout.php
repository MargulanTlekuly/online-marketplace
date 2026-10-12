<?php
$pageTitle = 'Checkout';
require_once 'includes/functions.php';

if (!isLoggedIn()) redirectTo('login.php');

$products = loadData('products.json');
$cart = $_SESSION['cart'] ?? [];
$errors = [];

if (empty($cart)) redirectTo('cart.php');

$form = ['address' => '', 'phone' => '', 'payment' => 'card', 'notes' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['address'] = trim($_POST['address'] ?? '');
    $form['phone']   = trim($_POST['phone'] ?? '');
    $form['payment'] = $_POST['payment'] ?? 'card';
    $form['notes']   = trim($_POST['notes'] ?? '');

    if ($form['address'] === '' || $form['phone'] === '' || $form['payment'] === '') {
        $errors[] = "Please fill in all required fields.";
    }
    if ($form['phone'] !== '' && !preg_match('/^[0-9+\-\s()]{7,20}$/', $form['phone'])) {
        $errors[] = "Please enter a valid phone number.";
    }

    if (empty($errors)) {
        $orders = loadData('orders.json');
        $items = [];
        $total = 0;
        foreach ($cart as $pid => $qty) {
            foreach ($products as $p) {
                if ((int)$p['id'] === (int)$pid) {
                    $items[] = [
                        'product_id' => (int)$p['id'],
                        'name'       => $p['name'],
                        'price'      => (float)$p['price'],
                        'qty'        => (int)$qty,
                    ];
                    $total += $p['price'] * $qty;
                }
            }
        }
        $newOrder = [
            'id'            => getNextId($orders),
            'user_id'       => (int)$_SESSION['user']['id'],
            'items'         => $items,
            'total'         => round($total, 2),
            'address'       => $form['address'],
            'phone'         => $form['phone'],
            'payment'       => $form['payment'],
            'notes'         => $form['notes'],
            'status'        => 'pending',
            'date'          => date('d.m.Y H:i'),
        ];
        $orders[] = $newOrder;
        saveData('orders.json', $orders);
        $_SESSION['cart'] = [];
        redirectTo('confirmation.php?order_id=' . $newOrder['id']);
    }
}

// Order preview
$cartItems = [];
$total = 0;
foreach ($cart as $pid => $qty) {
    foreach ($products as $p) {
        if ((int)$p['id'] === (int)$pid) {
            $subtotal = $p['price'] * $qty;
            $total += $subtotal;
            $cartItems[] = array_merge($p, ['qty' => $qty, 'subtotal' => $subtotal]);
        }
    }
}

include 'includes/header.php';
?>

<div class="container" style="max-width:900px;">
    <h1 class="page-title">Checkout</h1>
    <p class="page-sub">Please enter your delivery details to complete the order.</p>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul><?php foreach ($errors as $e) echo '<li>'.e($e).'</li>'; ?></ul>
        </div>
    <?php endif; ?>

    <div style="display:grid; grid-template-columns:1fr 320px; gap:24px; align-items:start;">
        <div class="form-card" style="padding:26px;">
            <h2 style="text-align:left; font-size:20px; margin-bottom:18px;">Delivery Details</h2>
            <form method="post" action="checkout.php">
                <div class="form-group">
                    <label for="address">Delivery Address *</label>
                    <textarea id="address" name="address" class="form-control" rows="3" placeholder="City, Street, House, Apartment"><?= e($form['address']) ?></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" class="form-control" value="<?= e($form['phone']) ?>" placeholder="+7 700 123 4567">
                    </div>
                    <div class="form-group">
                        <label for="payment">Payment Method *</label>
                        <select id="payment" name="payment" class="form-control">
                            <option value="card" <?= $form['payment']==='card'?'selected':'' ?>>Bank Card</option>
                            <option value="cash" <?= $form['payment']==='cash'?'selected':'' ?>>Cash on Delivery</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="notes">Additional Notes (optional)</label>
                    <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Any special delivery instructions..."><?= e($form['notes']) ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-lg">Place Order</button>
            </form>
        </div>

        <div class="cart-summary" style="margin-top:0; max-width:none; margin-left:0;">
            <h3>Order Summary</h3>
            <?php foreach ($cartItems as $item): ?>
                <div class="summary-row">
                    <span><?= e($item['name']) ?> x<?= $item['qty'] ?></span>
                    <span>$<?= number_format($item['subtotal'], 2) ?></span>
                </div>
            <?php endforeach; ?>
            <div class="summary-row"><span>Shipping:</span><span style="color:var(--success); font-weight:600;">FREE</span></div>
            <div class="summary-row total"><span>Total:</span><span>$<?= number_format($total, 2) ?></span></div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
