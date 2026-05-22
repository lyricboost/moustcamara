</main>

<footer class="site-footer mt-auto">
    <div class="footer-main">
        <div class="container-fluid px-4 px-md-5 py-5">
            <div class="row g-4 g-md-5">
                <div class="col-md-4">
                    <div class="footer-brand">
                        <h2 class="footer-title">Moust Camara</h2>
                        <p class="footer-tagline">Engineering creative processes where small changes compound into outsized results.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="footer-column">
                        <h3 class="footer-heading">Quick Links</h3>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_class' => 'footer-menu',
                            'container' => false,
                            'fallback_cb' => false,
                        ));
                        ?>
                    </div>
                    
                    <div class="footer-column mt-4">
                        <h3 class="footer-heading">Location</h3>
                        <p class="footer-location">Plano, TX</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="footer-column">
                        <h3 class="footer-heading">Connect</h3>
                        <ul class="footer-menu">
                            <li><a href="mailto:contact@moustcamara.com" target="_blank" rel="noopener">Email</a></li>
                            <li><a href="https://linkedin.com/in/moustcamara" target="_blank" rel="noopener">LinkedIn</a></li>
                            <li><a href="https://twitter.com/moustcamara" target="_blank" rel="noopener">Twitter</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container-fluid px-4 px-md-5 py-4">
            <div class="row align-items-center g-3">
                <div class="col-md-6 text-center text-md-start">
                    <p class="footer-copyright">&copy; <?php echo date('Y'); ?> Moust Camara. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
