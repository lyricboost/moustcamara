<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header fixed-top shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid px-3 px-md-5 py-2">
            <div class="logo-wrapper">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        echo '<a class="navbar-brand fs-4" href="' . esc_url(home_url('/')) . '"><span class="d-inline-block">Moust Camara</span></a>';
                    }
                    ?>
            </div>

            <?php if (has_nav_menu('primary')) : ?>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <?php endif; ?>

            <!-- Desktop Navigation -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto gap-5 align-items-center">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class' => 'navbar-nav-custom d-flex gap-5',
                        'container' => false,
                        'fallback_cb' => false,
                        'walker' => new Bootstrap_Walker_Nav_Menu(),
                        'depth' => 1,
                    ));
                    ?>
                    <a href="https://calendly.com/moustcamara/30min" target="new" class="cta-btn cta-btn--small">
                        Book a Strategy Call
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header py-4">
            <h5 class="offcanvas-title fw-bold fs-5" id="mobileMenuLabel"></h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body py-4">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'navbar-nav-custom d-flex flex-column gap-3',
                'container' => false,
                'fallback_cb' => false,
                'walker' => new Bootstrap_Walker_Nav_Menu(),
            ));
            ?>
            <a href="https://calendly.com/moustcamara/30min" target="new" class="cta-btn cta-btn--medium mt-3">
                Book a Strategy Call
            </a>
        </div>
    </div>
</header>

<script>
  // Header scroll effect - add white background when scrolling down
  const siteHeader = document.querySelector('.site-header');
  const scrollThreshold = 80; // pixels to scroll before applying background

  window.addEventListener('scroll', function() {
    if (window.scrollY > scrollThreshold) {
      siteHeader.classList.add('scrolled');
    } else {
      siteHeader.classList.remove('scrolled');
    }
  });
</script>

<main id="main-content" class="site-main">
