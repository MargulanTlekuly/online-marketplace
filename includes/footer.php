</main>

<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-grid">
            <div class="footer-col">
                <a href="<?= isset($basePath) ? $basePath : '' ?>index.php" class="brand brand-footer">
                    <img src="<?= isset($basePath) ? $basePath : '' ?>images/logo.png" alt="Marketplace" class="brand-logo">
                </a>
                <p class="footer-desc" style="margin-top:16px;">Student-built online marketplace offering a curated selection of electronics, clothing, accessories and home goods with simple, secure shopping.</p>
            </div>
            <div class="footer-col">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="<?= isset($basePath) ? $basePath : '' ?>index.php">Home</a></li>
                    <li><a href="<?= isset($basePath) ? $basePath : '' ?>catalog.php">Catalog</a></li>
                    <li><a href="<?= isset($basePath) ? $basePath : '' ?>pages/about.php">About</a></li>
                    <li><a href="<?= isset($basePath) ? $basePath : '' ?>pages/contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Information</h4>
                <ul>
                    <li><a href="<?= isset($basePath) ? $basePath : '' ?>pages/privacy.php">Privacy Policy</a></li>
                    <li><a href="<?= isset($basePath) ? $basePath : '' ?>pages/terms.php">Terms of Service</a></li>
                    <li><a href="<?= isset($basePath) ? $basePath : '' ?>pages/faq.php">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Follow Us</h4>
                <ul class="social-list">
                    <li><a href="#">IG</a></li>
                    <li><a href="#">FB</a></li>
                    <li><a href="#">TG</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Online Marketplace — Student Web Programming Project.</p>
        </div>
    </div>
</footer>

</body>
</html>
