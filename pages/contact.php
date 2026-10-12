<?php
$pageTitle = 'Contact Us';
$basePath = '../';
require_once '../includes/functions.php';

$errors = [];
$sent = false;
$form = ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['name']    = trim($_POST['name'] ?? '');
    $form['email']   = trim($_POST['email'] ?? '');
    $form['subject'] = trim($_POST['subject'] ?? '');
    $form['message'] = trim($_POST['message'] ?? '');

    if ($form['name']==='' || $form['email']==='' || $form['subject']==='' || $form['message']==='') {
        $errors[] = "All fields are required.";
    }
    if ($form['email'] !== '' && !filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if (empty($errors)) {
        $sent = true;
    }
}

include '../includes/header.php';
?>

<section class="page-hero">
    <div class="page-hero-inner">
        <h1>Contact Us</h1>
        <p>Have a question about your order, a product, or anything else? We would love to hear from you.</p>
    </div>
</section>

<div class="container" style="max-width:800px;">
    <?php if ($sent): ?>
        <div class="alert alert-success">
            Thank you, <strong><?= e($form['name']) ?></strong>! Your message has been received. We will reply to <strong><?= e($form['email']) ?></strong> as soon as possible.
        </div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error"><ul><?php foreach ($errors as $e) echo '<li>'.e($e).'</li>'; ?></ul></div>
    <?php endif; ?>

    <div class="form-card">
        <h2 style="text-align:left; font-size:22px;">Send a Message</h2>
        <p class="form-sub" style="text-align:left;">Fill out the form below and we will get back to you within one business day.</p>
        <form method="post" action="contact.php">
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= e($form['name']) ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= e($form['email']) ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" class="form-control" value="<?= e($form['subject']) ?>">
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" class="form-control" rows="6" placeholder="Write your message here..."><?= e($form['message']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
        </form>
    </div>

    <div class="info-grid" style="margin-top:30px;">
        <div class="info-card">
            <div class="ic-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
            <div class="ic-head">Email</div>
            <div class="ic-val">support@marketplace.test</div>
        </div>
        <div class="info-card">
            <div class="ic-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
            <div class="ic-head">Phone</div>
            <div class="ic-val">+7 (700) 123-4567</div>
        </div>
        <div class="info-card">
            <div class="ic-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
            <div class="ic-head">Address</div>
            <div class="ic-val">Almaty, Kazakhstan</div>
        </div>
        <div class="info-card">
            <div class="ic-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
            <div class="ic-head">Hours</div>
            <div class="ic-val">Mon-Fri 9:00 - 18:00</div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
