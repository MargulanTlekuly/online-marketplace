<?php
$pageTitle = 'About Us';
$basePath = '../';
require_once '../includes/functions.php';
include '../includes/header.php';
?>

<section class="page-hero">
    <div class="page-hero-inner">
        <h1>About Us</h1>
        <p>Learn more about our marketplace and why students and customers choose us for their everyday shopping.</p>
    </div>
</section>

<div class="container">
    <div class="prose">
        <h2>Who We Are</h2>
        <p>Welcome to <strong>Marketplace</strong>, a student-built online store created as a Web Programming course project. Our goal is to demonstrate real-world web development using only HTML, CSS, PHP and JSON file storage - no JavaScript frameworks, no external libraries beyond a web font.</p>
        <p>We curate a catalogue of 20 hand-picked products across four categories: Electronics, Clothing, Accessories and Home & Kitchen. The site supports full user authentication, product browsing with search and filters, a shopping cart, secure checkout, order history and a complete admin panel for managing products, users and orders.</p>

        <h2>Our Mission</h2>
        <p>We want online shopping to be simple, fast and transparent. That means fair prices, no hidden fees, reliable delivery and responsive support - all wrapped in a clean, accessible interface that works on desktop, tablet and mobile devices.</p>

        <div class="info-grid">
            <div class="info-card">
                <div class="ic-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><path d="M3 9h18M9 21V9"/></svg></div>
                <div class="ic-head">Products</div>
                <div class="ic-val">20+ hand-picked items</div>
            </div>
            <div class="info-card">
                <div class="ic-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg></div>
                <div class="ic-head">Categories</div>
                <div class="ic-val">4 product categories</div>
            </div>
            <div class="info-card">
                <div class="ic-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
                <div class="ic-head">Support</div>
                <div class="ic-val">24/7 customer care</div>
            </div>
            <div class="info-card">
                <div class="ic-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div>
                <div class="ic-head">Delivery</div>
                <div class="ic-val">1-3 day shipping</div>
            </div>
        </div>

        <h2>Technology</h2>
        <ul>
            <li><strong>HTML</strong> - semantic markup, forms, tables and accessible navigation.</li>
            <li><strong>CSS</strong> - custom properties, Flexbox, CSS Grid, responsive media queries, hover effects and smooth transitions.</li>
            <li><strong>PHP</strong> - session-based authentication, server-side form validation, password hashing, JSON storage and a complete CRUD admin panel.</li>
            <li><strong>JSON</strong> - lightweight file storage for users, products and orders.</li>
        </ul>

        <p style="margin-top:24px;">
            <a href="../catalog.php" class="btn btn-primary">Browse Catalog</a>
            <a href="contact.php" class="btn btn-secondary" style="margin-left:8px;">Contact Us</a>
        </p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
