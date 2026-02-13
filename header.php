<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-container">
        <div class="header-logo">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <span class="logo-text">Moust Camara</span>
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="header-nav desktop-nav">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'header-menu',
                'container' => false,
                'fallback_cb' => false,
            ));
            ?>
        </nav>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" aria-label="Toggle menu" aria-expanded="false">
            <span class="hamburger">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </span>
        </button>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div class="mobile-drawer">
        <div class="mobile-drawer-inner">
            <nav class="mobile-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'mobile-menu',
                    'container' => false,
                    'fallback_cb' => false,
                ));
                ?>
            </nav>
        </div>
    </div>
    <div class="mobile-overlay"></div>
</header>

<main id="main-content" class="site-main">
