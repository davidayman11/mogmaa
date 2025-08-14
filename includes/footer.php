    </div> <!-- End Main Content Wrapper -->

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-info">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.</p>
                    <p>Version <?php echo APP_VERSION; ?></p>
                </div>
                
                <div class="footer-links">
                    <a href="#" onclick="showPrivacyPolicy()">Privacy Policy</a>
                    <a href="#" onclick="showTermsOfService()">Terms of Service</a>
                    <a href="#" onclick="showContact()">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>
    
    <!-- Additional JavaScript -->
    <?php if (isset($additionalJS)): ?>
        <?php foreach ($additionalJS as $js): ?>
            <script src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Inline JavaScript -->
    <?php if (isset($inlineJS)): ?>
        <script>
            <?php echo $inlineJS; ?>
        </script>
    <?php endif; ?>

    <script>
        // Flash message auto-hide
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessage = document.querySelector('.flash-message');
            if (flashMessage) {
                setTimeout(function() {
                    flashMessage.style.opacity = '0';
                    setTimeout(function() {
                        flashMessage.style.display = 'none';
                    }, 300);
                }, 5000);
            }
        });

        // Modal functions
        function showPrivacyPolicy() {
            alert('Privacy Policy: We protect your personal information and use it only for registration purposes.');
        }

        function showTermsOfService() {
            alert('Terms of Service: By using this system, you agree to our terms and conditions.');
        }

        function showContact() {
            alert('Contact: For support, please contact the MOGMAA team.');
        }
    </script>

</body>
</html>

