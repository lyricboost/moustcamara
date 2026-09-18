<?php
/**
 * 404 Template Part: Hero
 * Hero-alt style 404 — text left-middle, Moust peeking in from the right
 * via the background image.
 * To switch back to the simple version: in 404.php, change
 * get_template_part('template-parts/404-hero') to get_template_part('template-parts/404-simple')
 */

$bg_image = home_url('/wp-content/uploads/2026/09/Moust-hmm-photo-scaled.jpg');
?>

<div class="site-main-inner">
    <section class="hero-alt-section error-404-hero" style="background-image: url('<?php echo esc_url($bg_image); ?>');">
        <div class="container-fluid px-0">
            <div class="hero-alt-inner">
                <div class="error-404-hero-content">
                    <p class="page-heading-eyebrow">404 Not Found</p>
                    <h1 class="hero-alt-heading">That page doesn&rsquo;t exist.</h1>
                    <p class="hero-alt-subheading">
                        Let&rsquo;s get you back on track.
                    </p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="hero-alt-cta-btn error-404-back-btn">
                        <svg class="hero-alt-cta-arrow" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
