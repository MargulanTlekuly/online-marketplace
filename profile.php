<?php
require_once 'includes/functions.php';
if (!isLoggedIn()) redirectTo('login.php');

$user = $_SESSION['user'];
$orders = loadData('orders.json');
$myOrders = array_filter($orders, fn($o) => $o['user_id'] === $user['id']);

include 'includes/header.php';
?>

<div class="container">
  <h2>My Profile</h2>
  <div class="card" style="padding:20px; max-width:500px;">
    <p><strong>Name:</strong> <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone'] ?? '-') ?></p>
  </div>

  <h3 style="margin-top:30px;">My Orders</h3>
  <?php if (empty($myOrders)): ?>
    <p>You have no orders yet.</p>
  <?php else: ?>
    <table>
      <tr><th>No.</th><th>Date</th><th>Total</th><th>Status</th></tr>
      <?php foreach ($myOrders as $o): ?>
        <tr>
          <td>#<?= $o['id'] ?></td>
          <td><?= $o['date'] ?></td>
          <td>$<?= $o['total'] ?></td>
          <td><?= $o['status'] ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>