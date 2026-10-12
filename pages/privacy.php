<?php
$pageTitle = 'Privacy Policy';
$basePath = '../';
require_once '../includes/functions.php';
include '../includes/header.php';
?>
<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Privacy Policy</h1>
        <p>How we collect, use and protect your personal information.</p>
    </div>
</section>
<div class="container"><div class="prose">
    <p><em>Last updated: 2026</em></p>

    <h2>1. Information We Collect</h2>
    <p>When you register an account we collect your name, email address, a securely hashed password and optionally your phone number and delivery address. When you place an order we additionally collect your delivery address, phone number and payment method.</p>

    <h2>2. How We Use Your Information</h2>
    <ul>
        <li>To create and manage your account.</li>
        <li>To process your orders and communicate order status.</li>
        <li>To improve our website and product selection.</li>
    </ul>
    <p>We do not sell, rent or share your personal information with third parties for marketing purposes.</p>

    <h2>3. Security</h2>
    <p>Passwords are stored using strong one-way bcrypt hashing. All server-side form inputs are validated before being processed. While this is a student project and should not be used for real transactions, the code follows common best-practice security patterns.</p>

    <h2>4. Cookies and Sessions</h2>
    <p>We use PHP sessions to keep you logged in and to remember the contents of your shopping cart between pages. You can log out at any time using the Logout button.</p>

    <h2>5. Your Rights</h2>
    <p>You can access and update your personal information at any time on your Profile page, or by contacting support.</p>

    <h2>6. Contact</h2>
    <p>If you have questions about this policy, please <a href="contact.php">contact us</a>.</p>

    <p style="margin-top:24px;"><a href="../index.php" class="btn btn-secondary">&larr; Back to Home</a></p>
</div></div>
<?php include '../includes/footer.php'; ?>
