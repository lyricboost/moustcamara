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
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid px-3 px-md-5 py-2">
            <a class="navbar-brand fw-bold fs-4 text-dark" href="<?php echo esc_url(home_url('/')); ?>">
                <span class="d-inline-block" style="letter-spacing: -0.5px;">Moust Camara</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Desktop Navigation -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'navbar-nav ms-auto gap-2',
                    'container' => false,
                    'fallback_cb' => false,
                    'walker' => new Bootstrap_Walker_Nav_Menu(),
                ));
                ?>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header border-bottom py-4">
            <h5 class="offcanvas-title fw-bold fs-5" id="mobileMenuLabel">Menu</h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body py-4">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'navbar-nav gap-2',
                'container' => false,
                'fallback_cb' => false,
                'walker' => new Bootstrap_Walker_Nav_Menu(),
            ));
            ?>
        </div>
    </div>
</header>

<main id="main-content" class="site-main">
