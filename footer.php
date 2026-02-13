</main>

<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-brand">
                <h3 class="footer-logo">Moust Camara</h3>
                <p class="footer-tagline">Engineering creative processes where small changes compound into outsized results.</p>
            </div>

            <div class="footer-links">
                <div class="footer-column">
                    <h4>Quick Links</h4>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class' => 'footer-menu',
                        'container' => false,
                        'fallback_cb' => false,
                    ));
                    ?>
                </div>

                <div class="footer-column">
                    <h4>Connect</h4>
                    <ul class="footer-social">
                        <li><a href="mailto:contact@moustcamara.com" target="_blank" rel="noopener">Email</a></li>
                        <li><a href="https://linkedin.com/in/moustcamara" target="_blank" rel="noopener">LinkedIn</a></li>
                        <li><a href="https://twitter.com/moustcamara" target="_blank" rel="noopener">Twitter</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4>Location</h4>
                    <p>Plano, TX</p>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Moust Camara. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.querySelector('.mobile-menu-toggle');
    const drawer = document.querySelector('.mobile-drawer');
    const overlay = document.querySelector('.mobile-overlay');
    const body = document.body;

    if (!toggle || !drawer || !overlay) return;

    function openMenu() {
        drawer.classList.add('active');
        overlay.classList.add('active');
        body.classList.add('menu-open');
        toggle.setAttribute('aria-expanded', 'true');
    }

    function closeMenu() {
        drawer.classList.remove('active');
        overlay.classList.remove('active');
        body.classList.remove('menu-open');
        toggle.setAttribute('aria-expanded', 'false');
    }

    toggle.addEventListener('click', function() {
        if (drawer.classList.contains('active')) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    overlay.addEventListener('click', closeMenu);

    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && drawer.classList.contains('active')) {
            closeMenu();
        }
    });
});
</script>
</body>
</html>
