</main>

<?php
// Footer settings (ACF Options Page: Footer Settings)
$brand_text = get_field('footer_brand_text', 'option') ?: 'Moust Camara';
$logo = get_field('footer_logo', 'option');
$newsletter_enable = get_field('footer_newsletter_enable', 'option');
$newsletter_heading = get_field('footer_newsletter_heading', 'option');
$newsletter_text = get_field('footer_newsletter_text', 'option');
$newsletter_placeholder = get_field('footer_newsletter_placeholder', 'option') ?: 'Your email address';
$newsletter_button_text = get_field('footer_newsletter_button_text', 'option') ?: 'Subscribe';
// Note: Mailchimp list ID + API key are read server-side in the AJAX handler — never printed in markup
$social_links = get_field('footer_social_links', 'option');
$col1_title = get_field('footer_col1_title', 'option') ?: 'Explore';
$col2_title = get_field('footer_col2_title', 'option') ?: 'Work with me';
$col3_title = get_field('footer_col3_title', 'option') ?: 'Resources';
$copyright_text = get_field('footer_copyright_text', 'option') ?: 'Moust Camara';

// Anti-bot fields for newsletter form (same system as mailing list block)
$footer_form_stamp = function_exists('moustcamara_signed_form_timestamp') ? moustcamara_signed_form_timestamp() : null;
?>

<footer class="site-footer mt-auto">
    <div class="footer-main">
        <div class="container-fluid px-4 px-md-5">
            <div class="row g-4">
                <!-- Brand + Newsletter -->
                <div class="col-lg-5">
                    <div class="footer-brand">
                        <?php if ($logo && !empty($logo['url'])) : ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo-link">
                                <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($brand_text); ?>" class="footer-logo" />
                            </a>
                        <?php else : ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-brand-text"><?php echo esc_html($brand_text); ?></a>
                        <?php endif; ?>
                    </div>

                    <?php if ($newsletter_enable) : ?>
                        <div class="footer-newsletter">
                            <?php if ($newsletter_heading) : ?>
                                <p class="footer-newsletter-heading"><?php echo esc_html($newsletter_heading); ?></p>
                            <?php endif; ?>
                            <?php if ($newsletter_text) : ?>
                                <p class="footer-newsletter-text"><?php echo esc_html($newsletter_text); ?></p>
                            <?php endif; ?>
                            <form class="footer-newsletter-form" id="footer-newsletter-form">
                                <?php wp_nonce_field('mailing_list_signup', 'mailing_list_nonce'); ?>
                                <input type="hidden" name="footer_newsletter" value="1">
                                <?php if ($footer_form_stamp) : ?>
                                    <input type="hidden" name="form_ts" value="<?php echo esc_attr($footer_form_stamp['ts']); ?>">
                                    <input type="hidden" name="form_sig" value="<?php echo esc_attr($footer_form_stamp['sig']); ?>">
                                <?php endif; ?>
                                <div class="footer-newsletter-hp" aria-hidden="true">
                                    <input type="text" name="company_website" tabindex="-1" autocomplete="off">
                                </div>
                                <div class="footer-newsletter-row">
                                    <input
                                        type="email"
                                        class="footer-newsletter-input"
                                        name="email"
                                        placeholder="<?php echo esc_attr($newsletter_placeholder); ?>"
                                        aria-label="<?php echo esc_attr($newsletter_placeholder); ?>"
                                        required
                                    >
                                    <button type="submit" class="footer-newsletter-submit">
                                        <?php echo esc_html($newsletter_button_text); ?>
                                        <svg class="hero-alt-cta-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </button>
                                </div>
                                <div class="footer-newsletter-message" style="display: none;"></div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if ($social_links) : ?>
                        <?php
                        // Inline SVGs (Lucide-style) — brand icons were removed from
                        // recent Lucide releases, so data-lucide can't render them.
                        $footer_social_svgs = array(
                            'linkedin'  => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle>',
                            'youtube'   => '<path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19.54c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>',
                            'instagram' => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>',
                            'twitter'   => '<path d="M4 4l16 16M20 4L4 20"></path>',
                            'facebook'  => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>',
                            'github'    => '<path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>',
                            'music'     => '<path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle>',
                            'mail'      => '<rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>',
                            'globe'     => '<circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>',
                            'rss'       => '<path d="M4 11a9 9 0 0 1 9 9"></path><path d="M4 4a16 16 0 0 1 16 16"></path><circle cx="5" cy="19" r="1"></circle>',
                        );
                        ?>
                        <ul class="footer-social-links">
                            <?php foreach ($social_links as $social) :
                                if (empty($social['url'])) continue;
                                $icon = $social['icon'] ?: 'globe';
                                $label = $social['label'] ?: ucfirst($icon);
                                $svg_paths = $footer_social_svgs[$icon] ?? $footer_social_svgs['globe'];
                            ?>
                                <li>
                                    <a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($label); ?>" title="<?php echo esc_attr($label); ?>">
                                        <svg class="footer-social-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo $svg_paths; ?></svg>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Link Columns (managed in Appearance > Menus) -->
                <div class="col-lg-7">
                    <div class="footer-columns">
                        <?php
                        $footer_columns = array(
                            array('title' => $col1_title, 'location' => 'footer-col-1'),
                            array('title' => $col2_title, 'location' => 'footer-col-2'),
                            array('title' => $col3_title, 'location' => 'footer-col-3'),
                        );
                        foreach ($footer_columns as $col) :
                            if (!has_nav_menu($col['location'])) continue;
                        ?>
                            <details class="footer-col" open>
                                <summary class="footer-col-title">
                                    <span><?php echo esc_html($col['title']); ?></span>
                                    <span class="footer-col-icon">
                                        <i data-lucide="plus" class="icon-plus"></i>
                                        <i data-lucide="minus" class="icon-minus"></i>
                                    </span>
                                </summary>
                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => $col['location'],
                                    'container'      => false,
                                    'menu_class'     => 'footer-col-links',
                                    'depth'          => 1,
                                    'fallback_cb'    => false,
                                ));
                                ?>
                            </details>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container-fluid px-4 px-md-5">
            <div class="footer-bottom-inner">
                <p class="footer-copyright">&copy; <?php echo date('Y'); ?> <?php echo esc_html($copyright_text); ?></p>
                <?php
                if (has_nav_menu('footer-bottom')) {
                    wp_nav_menu(array(
                        'theme_location' => 'footer-bottom',
                        'container'      => false,
                        'menu_class'     => 'footer-bottom-links',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ));
                }
                ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
