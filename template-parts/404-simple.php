<?php
/**
 * 404 Template Part: Simple
 * Original minimal centered 404 layout.
 * To use: in 404.php, change get_template_part('template-parts/404-hero') to get_template_part('template-parts/404-simple')
 */
?>

<div class="site-main-inner">
    <section class="error-404-section">
        <div class="container">
            <div class="error-404-content text-center">
                <p class="page-heading-eyebrow">404 Not Found</p>
                <h1 class="page-heading-heading">Oops! Page Not Found</h1>
                <p class="page-heading-subheading">
                    The page you are looking for doesn&rsquo;t exist. Click the button below to go back to the homepage.
                </p>
                <div class="error-404-cta">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="hero-alt-cta-btn error-404-back-btn">
                        <svg class="hero-alt-cta-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 12H5"/>
                            <path d="m12 19-7-7 7-7"/>
                        </svg>
                        Back to Homepage
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
