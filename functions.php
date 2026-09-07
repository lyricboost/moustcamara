<?php
/**
 * Moust Camara Theme Functions
 */

/* ============================================
   FONT CONFIGURATION
   Easy font switching - just update these values
   ============================================ */
define('THEME_FONT_FAMILY', 'Poppins');
define('THEME_FONT_WEIGHTS', '400;500;600;700');
define('THEME_FONT_URL', 'https://fonts.googleapis.com/css2?family=' . THEME_FONT_FAMILY . ':wght@' . THEME_FONT_WEIGHTS . '&display=swap');

// Theme Support
function moustcamara_theme_support() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    
    // Add custom logo support - constrained size
    add_theme_support('custom-logo', array(
        'height'      => 40,
        'width'       => 200,
        'flex-height' => false,
        'flex-width'  => false,
    ));
    
    // Add editor stylesheet
    add_editor_style('style.css');
    
    // Add custom image sizes
    add_image_size('hero-image', 800, 800, true);
    add_image_size('split-image', 600, 600, true);
    add_image_size('site-logo', 200, 40, false);
}
add_action('after_setup_theme', 'moustcamara_theme_support');

// Register Navigation Menus
function moustcamara_register_menus() {
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'moustcamara'),
        'footer' => __('Footer Menu', 'moustcamara'),
    ));
}
add_action('after_setup_theme', 'moustcamara_register_menus');

// Enqueue Styles and Scripts
function moustcamara_enqueue_styles() {
    // Bootstrap CSS from CDN
    wp_enqueue_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
        array(),
        '5.3.0'
    );
    
    // Google Fonts
    wp_enqueue_style(
        'google-fonts-' . strtolower(THEME_FONT_FAMILY),
        THEME_FONT_URL,
        array(),
        null
    );
    
    // Theme stylesheet (will override Bootstrap) - MUST load AFTER Bootstrap
    wp_enqueue_style('moustcamara-style', get_stylesheet_uri(), array('bootstrap'), '0.6.4');
    
    // Inject font family CSS variable dynamically
    $custom_css = ":root { --font-family-base: '" . THEME_FONT_FAMILY . "', system-ui, -apple-system, sans-serif; }";
    wp_add_inline_style('moustcamara-style', $custom_css);
    
    // Bootstrap JS Bundle (includes Popper)
    wp_enqueue_script(
        'bootstrap-bundle',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js',
        array(),
        '5.3.0',
        true
    );
    
    // Lucide Icons
    wp_enqueue_script(
        'lucide-icons',
        'https://unpkg.com/lucide@latest',
        array(),
        null,
        false
    );
    
    // Initialize Lucide Icons
    wp_enqueue_script(
        'moustcamara-lucide-init',
        get_template_directory_uri() . '/js/lucide-init.js',
        array('lucide-icons'),
        '0.5.3',
        true
    );
    
    // Enqueue header scroll script
    wp_enqueue_script(
        'moustcamara-header-scroll',
        get_template_directory_uri() . '/js/header-scroll.js',
        array('bootstrap-bundle'),
        '0.4.3',
        true
    );
    
    // External links script
    wp_enqueue_script(
        'moustcamara-external-links',
        get_template_directory_uri() . '/js/external-links.js',
        array(),
        '1.0',
        true
    );
    
    // Table Grid script
    wp_enqueue_script(
        'moustcamara-table-grid',
        get_template_directory_uri() . '/js/table-grid.js',
        array('lucide-icons'),
        '1.0',
        true
    );
    
    // Program Steps script
    wp_enqueue_script(
        'moustcamara-program-steps',
        get_template_directory_uri() . '/js/program-steps.js',
        array('lucide-icons'),
        '1.0',
        true
    );
    
    // Contact Form script
    wp_enqueue_script(
        'moustcamara-contact-form',
        get_template_directory_uri() . '/js/contact-form.js',
        array('lucide-icons'),
        '1.0',
        true
    );
    
    // Testimonials script
    wp_enqueue_script(
        'moustcamara-testimonials',
        get_template_directory_uri() . '/js/testimonials.js',
        array('lucide-icons'),
        '1.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'moustcamara_enqueue_styles');

// Enqueue Editor Styles
function moustcamara_enqueue_editor_styles() {
    wp_enqueue_style('moustcamara-editor-style', get_stylesheet_uri(), array(), '0.2');
    
    // Add Google Fonts for editor
    wp_enqueue_style('moustcamara-google-fonts', THEME_FONT_URL, array(), null);
    
    // Add custom editor styles for full-width
    $custom_css = '
        .editor-styles-wrapper {
            max-width: 100% !important;
            padding: 0 !important;
        }
        .editor-styles-wrapper .block-editor-block-list__layout {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        .wp-block {
            max-width: 100% !important;
        }
        .wp-block[data-align="full"] {
            max-width: none !important;
        }
    ';
    wp_add_inline_style('moustcamara-editor-style', $custom_css);
}
add_action('enqueue_block_editor_assets', 'moustcamara_enqueue_editor_styles');

// ACF JSON Save Point
function moustcamara_acf_json_save_point($path) {
    return get_stylesheet_directory() . '/acf-json';
}
add_filter('acf/settings/save_json', 'moustcamara_acf_json_save_point');

// ACF JSON Load Point
function moustcamara_acf_json_load_point($paths) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}
add_filter('acf/settings/load_json', 'moustcamara_acf_json_load_point');

// Register ACF Blocks
function moustcamara_register_acf_blocks() {
    if (function_exists('acf_register_block_type')) {
        
        // Hero Block
        acf_register_block_type(array(
            'name'              => 'hero',
            'title'             => __('Moust Hero'),
            'description'       => __('Hero section with image and content'),
            'render_template'   => 'blocks/hero-acf/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'admin-home',
            'keywords'          => array('hero', 'banner', 'header', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // Hero Alt Block
        acf_register_block_type(array(
            'name'              => 'hero-alt',
            'title'             => __('Moust Hero (Alt)'),
            'description'       => __('Alternative hero section with image, heading, subheading, CTA and credibility strip'),
            'render_template'   => 'blocks/hero-alt/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'admin-home',
            'keywords'          => array('hero', 'banner', 'header', 'alternative', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // Lead-in Text Block
        acf_register_block_type(array(
            'name'              => 'lead-in',
            'title'             => __('Moust Lead-in Text'),
            'description'       => __('Large formatted text for taglines and statements'),
            'render_template'   => 'blocks/lead-in/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'editor-textcolor',
            'keywords'          => array('text', 'tagline', 'lead', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // Split Layout Block
        acf_register_block_type(array(
            'name'              => 'split',
            'title'             => __('Moust Split Layout'),
            'description'       => __('Two column layout with image and text'),
            'render_template'   => 'blocks/split/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'columns',
            'keywords'          => array('split', 'two-column', 'image', 'text', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));

        // Split Text (two-column text) Block
        acf_register_block_type(array(
            'name'              => 'split-text',
            'title'             => __('Moust Split Text'),
            'description'       => __('Two column text layout with features list'),
            'render_template'   => 'blocks/split-text/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'columns',
            'keywords'          => array('split', 'text', 'features', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // Grid Items Block
        acf_register_block_type(array(
            'name'              => 'grid-items',
            'title'             => __('Moust Grid Items'),
            'description'       => __('Three column grid of services/offerings'),
            'render_template'   => 'blocks/grid-items/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'grid-view',
            'keywords'          => array('grid', 'services', 'offerings', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // Page Heading Block
        acf_register_block_type(array(
            'name'              => 'page-heading',
            'title'             => __('Moust Page Heading'),
            'description'       => __('Page heading with eyebrow (manual text or automatic breadcrumbs), heading, and subheading'),
            'render_template'   => 'blocks/page-heading/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'heading',
            'keywords'          => array('page', 'heading', 'title', 'breadcrumbs', 'eyebrow', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // Gallery Block
        acf_register_block_type(array(
            'name'              => 'gallery',
            'title'             => __('Moust Gallery'),
            'description'       => __('Grid of large images, 2 or 3 per row, with optional per-image heading and description'),
            'render_template'   => 'blocks/gallery/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'format-gallery',
            'keywords'          => array('gallery', 'images', 'grid', 'photos', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // Table Grid Block
        acf_register_block_type(array(
            'name'              => 'table-grid',
            'title'             => __('Moust Table Grid'),
            'description'       => __('Comparison table with features and plans'),
            'render_template'   => 'blocks/table-grid/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'grid-view',
            'keywords'          => array('table', 'comparison', 'grid', 'features', 'plans', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // Program Steps Block
        acf_register_block_type(array(
            'name'              => 'program-steps',
            'title'             => __('Moust Program Steps'),
            'description'       => __('Vertical timeline/roadmap for program phases with nested sub-items'),
            'render_template'   => 'blocks/program-steps/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'list-view',
            'keywords'          => array('program', 'steps', 'timeline', 'roadmap', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // FAQ Block
        acf_register_block_type(array(
            'name'              => 'faq',
            'title'             => __('Moust FAQ'),
            'description'       => __('FAQ accordion with optional image'),
            'render_template'   => 'blocks/faq/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'editor-help',
            'keywords'          => array('faq', 'accordion', 'questions', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // Product Card Block
        acf_register_block_type(array(
            'name'              => 'product-card',
            'title'             => __('Moust Product Card'),
            'description'       => __('Single product/pricing card with features and CTA'),
            'render_template'   => 'blocks/product-card/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'tag',
            'keywords'          => array('product', 'pricing', 'card', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // Capability Cards Block
        acf_register_block_type(array(
            'name'              => 'capability-cards',
            'title'             => __('Moust Capability Cards'),
            'description'       => __('Display capabilities/solutions in card format'),
            'render_template'   => 'blocks/capability-cards/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'grid-view',
            'keywords'          => array('capability', 'cards', 'solutions', 'grid', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // Contact Form Block
        acf_register_block_type(array(
            'name'              => 'contact-form',
            'title'             => __('Moust Contact Form'),
            'description'       => __('Branded contact form with dynamic fields'),
            'render_template'   => 'blocks/contact-form/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'email',
            'keywords'          => array('contact', 'form', 'email', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // Final CTA Block
        acf_register_block_type(array(
            'name'              => 'final-cta',
            'title'             => __('Moust Final CTA'),
            'description'       => __('Final call-to-action section'),
            'render_template'   => 'blocks/final-cta/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'megaphone',
            'keywords'          => array('cta', 'call-to-action', 'newsletter', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // Typeform Embed Block
        acf_register_block_type(array(
            'name'              => 'typeform-embed',
            'title'             => __('Moust Typeform Embed'),
            'description'       => __('Embed Typeform surveys and forms with various display options'),
            'render_template'   => 'blocks/typeform-embed/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'feedback',
            'keywords'          => array('typeform', 'form', 'survey', 'embed', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // Mailing List Block
        acf_register_block_type(array(
            'name'              => 'mailing-list',
            'title'             => __('Moust Mailing List'),
            'description'       => __('Mailing list signup form with Mailchimp integration'),
            'render_template'   => 'blocks/mailing-list/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'email-alt',
            'keywords'          => array('mailing', 'list', 'newsletter', 'signup', 'mailchimp', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // Testimonials Grid Block
        acf_register_block_type(array(
            'name'              => 'testimonials-grid',
            'title'             => __('Moust Testimonials Grid'),
            'description'       => __('Grid layout for testimonials with faint divider lines'),
            'render_template'   => 'blocks/testimonials-grid/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'grid-view',
            'keywords'          => array('testimonials', 'grid', 'reviews', 'quotes', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
        
        // One Column Block
        acf_register_block_type(array(
            'name'              => 'one-column',
            'title'             => __('Moust One Column'),
            'description'       => __('Single column content section with heading, description, and CTA'),
            'render_template'   => 'blocks/one-column/render.php',
            'category'          => 'moustcamara',
            'icon'              => 'align-center',
            'keywords'          => array('one-column', 'content', 'section', 'moust'),
            'mode'              => 'preview',
            'supports'          => array(
                'align' => array('wide', 'full'),
                'mode' => true,
                'jsx' => true,
            ),
        ));
    }
}

// Show admin notice if ACF is not active
function moustcamara_acf_notice() {
    if (!function_exists('acf_register_block_type')) {
        echo '<div class="notice notice-error"><p><strong>Moust Camara Theme:</strong> Advanced Custom Fields PRO must be installed and activated for blocks to work.</p></div>';
    }
}
add_action('admin_notices', 'moustcamara_acf_notice');
add_action('acf/init', 'moustcamara_register_acf_blocks');

// Register Custom Block Category
function moustcamara_block_categories($categories) {
    return array_merge(
        array(
            array(
                'slug'  => 'moustcamara',
                'title' => __('Moust Camara Blocks', 'moustcamara'),
                'icon'  => 'star-filled',
            ),
        ),
        $categories
    );
}
add_filter('block_categories_all', 'moustcamara_block_categories', 10, 1);

// Bootstrap 5 Nav Walker
class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';
        
        if ($args->walker->has_children) {
            $classes[] = 'dropdown';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = ' class="' . esc_attr($class_names) . '"';
        
        $output .= $indent . '<li' . $class_names . '>';
        
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        $link_class = 'nav-link';
        if ($args->walker->has_children) {
            $link_class .= ' dropdown-toggle';
            $attributes .= ' data-bs-toggle="dropdown" aria-expanded="false"';
        }
        if (in_array('current-menu-item', $classes) || in_array('current_page_item', $classes)) {
            $link_class .= ' active';
        }
        
        $attributes .= ' class="' . $link_class . '"';
        
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

// Add Plausible Analytics
function plausible_analytics() {
    ?>
    <!-- Privacy-friendly analytics by Plausible -->
    <script async src="https://plausible.io/js/pa--lY-gX7gcsgA1Rb5xl0ER.js"></script>
    <script>
      window.plausible=window.plausible||function(){(plausible.q=plausible.q||[]).push(arguments)},plausible.init=plausible.init||function(i){plausible.o=i||{}};
      plausible.init()
    </script>
    <?php
}
add_action('wp_head', 'plausible_analytics');
// Contact Form AJAX Handler
function handle_contact_form_submission() {
    // Verify nonce
    if (!isset($_POST['moust_contact_nonce']) || !wp_verify_nonce($_POST['moust_contact_nonce'], 'moust_contact_form')) {
        wp_send_json_error('Security check failed.');
        return;
    }
    
    // Get recipient email
    $recipient = isset($_POST['recipient_email']) ? sanitize_email($_POST['recipient_email']) : get_option('admin_email');
    
    if (!is_email($recipient)) {
        wp_send_json_error('Invalid recipient email.');
        return;
    }
    
    // Extract user email for reply-to
    $user_email = '';
    $user_name = '';
    
    // Build email content and extract key fields
    $subject = 'New Contact Form Submission from ' . get_bloginfo('name');
    $message = "<p>New contact form submission:</p><br>";
    
    // Process all form fields
    foreach ($_POST as $key => $value) {
        // Skip WordPress and internal fields
        if (in_array($key, array('action', 'moust_contact_nonce', 'recipient_email', '_wp_http_referer'))) {
            continue;
        }
        
        // Handle arrays (checkboxes)
        if (is_array($value)) {
            $value = implode(', ', array_map('sanitize_text_field', $value));
        } else {
            $value = sanitize_text_field($value);
        }
        
        // Extract email for reply-to
        if (strtolower($key) === 'email' && is_email($value)) {
            $user_email = $value;
        }
        
        // Extract name
        if (strtolower($key) === 'name') {
            $user_name = $value;
        }
        
        // Format field name
        $field_name = ucwords(str_replace(array('-', '_'), ' ', $key));
        
        $message .= "<p><strong>" . $field_name . ":</strong> " . $value . "</p>";
    }
    
    $message .= "<br><hr>";
    $message .= "<p><small>Sent from: " . home_url() . "<br>";
    $message .= "Time: " . current_time('mysql') . "</small></p>";
    
    // Set email headers
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
    );
    
    // Add reply-to if user provided email
    if (!empty($user_email)) {
        $reply_to_name = !empty($user_name) ? $user_name : $user_email;
        $headers[] = 'Reply-To: ' . $reply_to_name . ' <' . $user_email . '>';
    }
    
    // Send email
    $sent = wp_mail($recipient, $subject, $message, $headers);
    
    if ($sent) {
        wp_send_json_success('Message sent successfully!');
    } else {
        wp_send_json_error('Failed to send message. Please try again.');
    }
}
add_action('wp_ajax_submit_contact_form', 'handle_contact_form_submission');
add_action('wp_ajax_nopriv_submit_contact_form', 'handle_contact_form_submission');

// ============================================
// Mailing List Anti-Bot Helpers
// ============================================

/**
 * Get the visitor's IP address.
 */
function moustcamara_get_client_ip() {
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        return sanitize_text_field($_SERVER['HTTP_CF_CONNECTING_IP']);
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return sanitize_text_field(trim($ips[0]));
    }
    return isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field($_SERVER['REMOTE_ADDR']) : '';
}

/**
 * Generate a signed timestamp for form render time.
 * Returns array with 'ts' and 'sig'.
 */
function moustcamara_signed_form_timestamp() {
    $ts = time();
    return array(
        'ts'  => $ts,
        'sig' => hash_hmac('sha256', (string) $ts, wp_salt('nonce')),
    );
}

// Handle Mailing List Signup
function handle_mailing_list_signup() {
    // Verify nonce
    if (!isset($_POST['mailing_list_nonce']) || !wp_verify_nonce($_POST['mailing_list_nonce'], 'mailing_list_signup')) {
        wp_send_json_error(array('message' => 'Security verification failed.'));
        return;
    }
    
    // 1. Honeypot check - silently return fake success so bots don't learn
    if (!empty($_POST['company_website'])) {
        wp_send_json_success(array('message' => 'Thank you for subscribing!'));
        return;
    }
    
    // 2. Minimum completion time check (signed server-generated timestamp)
    $form_ts  = isset($_POST['form_ts']) ? sanitize_text_field($_POST['form_ts']) : '';
    $form_sig = isset($_POST['form_sig']) ? sanitize_text_field($_POST['form_sig']) : '';
    $expected_sig = hash_hmac('sha256', (string) $form_ts, wp_salt('nonce'));
    
    if (empty($form_ts) || empty($form_sig) || !hash_equals($expected_sig, $form_sig)) {
        // Tampered or missing timestamp - fake success
        wp_send_json_success(array('message' => 'Thank you for subscribing!'));
        return;
    }
    
    $elapsed = time() - (int) $form_ts;
    if ($elapsed < 3) {
        // Submitted implausibly fast - fake success
        wp_send_json_success(array('message' => 'Thank you for subscribing!'));
        return;
    }
    if ($elapsed > DAY_IN_SECONDS) {
        wp_send_json_error(array('message' => 'This form has expired. Please refresh the page and try again.'));
        return;
    }
    
    // 3. Rate limit per IP: max 3 attempts per 15 minutes
    $client_ip = moustcamara_get_client_ip();
    if (!empty($client_ip)) {
        $ip_key = 'ml_rate_ip_' . md5($client_ip);
        $ip_attempts = (int) get_transient($ip_key);
        if ($ip_attempts >= 3) {
            wp_send_json_error(array('message' => 'Too many attempts. Please try again later.'));
            return;
        }
        set_transient($ip_key, $ip_attempts + 1, 15 * MINUTE_IN_SECONDS);
    }
    
    // Get form data
    $list_id = isset($_POST['list_id']) ? sanitize_text_field($_POST['list_id']) : '';
    
    // Collect subscriber data
    $subscriber_data = array();
    foreach ($_POST as $key => $value) {
        if (in_array($key, array('action', 'mailing_list_nonce', 'list_id', 'mailchimp_api_key', 'company_website', 'form_ts', 'form_sig', 'cf-turnstile-response', '_wp_http_referer'))) {
            continue;
        }
        
        $subscriber_data[$key] = sanitize_text_field($value);
    }
    
    // Validate email exists
    $email = '';
    foreach ($subscriber_data as $key => $value) {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $email = $value;
            break;
        }
    }
    
    if (empty($email)) {
        wp_send_json_error(array('message' => 'Please provide a valid email address.'));
        return;
    }
    
    // 3b. Rate limit per email: max 5 attempts per day
    $email_key = 'ml_rate_email_' . md5(strtolower($email));
    $email_attempts = (int) get_transient($email_key);
    if ($email_attempts >= 5) {
        wp_send_json_error(array('message' => 'Too many attempts for this email. Please try again tomorrow.'));
        return;
    }
    set_transient($email_key, $email_attempts + 1, DAY_IN_SECONDS);
    
    // 4. Cloudflare Turnstile verification (if configured)
    if (defined('MOUSTCAMARA_TURNSTILE_SECRET_KEY') && MOUSTCAMARA_TURNSTILE_SECRET_KEY) {
        $turnstile_token = isset($_POST['cf-turnstile-response']) ? sanitize_text_field($_POST['cf-turnstile-response']) : '';
        
        if (empty($turnstile_token)) {
            wp_send_json_error(array('message' => 'Verification failed. Please refresh the page and try again.'));
            return;
        }
        
        $verify_response = wp_remote_post('https://challenges.cloudflare.com/turnstile/v0/siteverify', array(
            'body' => array(
                'secret'   => MOUSTCAMARA_TURNSTILE_SECRET_KEY,
                'response' => $turnstile_token,
                'remoteip' => $client_ip,
            ),
            'timeout' => 10,
        ));
        
        $verify_body = is_wp_error($verify_response) ? array() : json_decode(wp_remote_retrieve_body($verify_response), true);
        if (empty($verify_body['success'])) {
            error_log('Turnstile verification failed: ' . print_r($verify_body, true));
            wp_send_json_error(array('message' => 'Verification failed. Please refresh the page and try again.'));
            return;
        }
    }
    
    // Get Mailchimp API key from the block (if provided)
    $api_key = isset($_POST['mailchimp_api_key']) ? sanitize_text_field($_POST['mailchimp_api_key']) : '';
    
    // Integrate with Mailchimp API
    $mailchimp_success = false;
    if (!empty($api_key) && !empty($list_id)) {
        // Extract datacenter from API key (last part after dash)
        preg_match('/\-([a-z0-9]+)$/', $api_key, $matches);
        $datacenter = isset($matches[1]) ? $matches[1] : 'us1';
        
        // Build merge fields for Mailchimp
        $merge_fields = array();
        foreach ($subscriber_data as $key => $value) {
            // Skip email, we handle it separately
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                continue;
            }
            
            // Map to Mailchimp merge field (uppercase)
            $merge_key = strtoupper($key);
            $merge_fields[$merge_key] = $value;
        }
        
        // Prepare Mailchimp API request
        $mailchimp_data = array(
            'email_address' => $email,
            'status' => 'subscribed', // Single opt-in - subscribers added immediately
            'merge_fields' => $merge_fields
        );
        
        // Make API request to Mailchimp
        $response = wp_remote_post(
            "https://{$datacenter}.api.mailchimp.com/3.0/lists/{$list_id}/members",
            array(
                'headers' => array(
                    'Authorization' => 'Basic ' . base64_encode('user:' . $api_key),
                    'Content-Type' => 'application/json'
                ),
                'body' => json_encode($mailchimp_data),
                'timeout' => 15
            )
        );
        
        // Check response
        if (!is_wp_error($response)) {
            $response_code = wp_remote_retrieve_response_code($response);
            if ($response_code === 200 || $response_code === 201) {
                $mailchimp_success = true;
            } else {
                // Log error for debugging
                $response_body = json_decode(wp_remote_retrieve_body($response), true);
                error_log('Mailchimp API Error: ' . print_r($response_body, true));
                
                // Check for specific error: already subscribed
                if (isset($response_body['title']) && $response_body['title'] === 'Member Exists') {
                    $mailchimp_success = true; // Treat as success
                }
            }
        }
    }
    
    // Store subscriber in WordPress options as backup
    $subscribers = get_option('mailing_list_subscribers', array());
    $subscribers[] = array(
        'email' => $email,
        'data' => $subscriber_data,
        'list_id' => $list_id,
        'mailchimp_synced' => $mailchimp_success,
        'timestamp' => current_time('mysql')
    );
    update_option('mailing_list_subscribers', $subscribers);
    
    // Send notification email to admin
    $admin_email = get_option('admin_email');
    $subject = 'New Mailing List Signup - ' . get_bloginfo('name');
    $message = '<h2>New Mailing List Subscriber</h2>';
    $message .= '<p><strong>Email:</strong> ' . $email . '</p>';
    
    foreach ($subscriber_data as $key => $value) {
        if ($value !== $email) {
            $field_name = ucwords(str_replace(array('-', '_'), ' ', $key));
            $message .= '<p><strong>' . $field_name . ':</strong> ' . $value . '</p>';
        }
    }
    
    $message .= '<br><hr>';
    $message .= '<p><small>List ID: ' . $list_id . '<br>';
    $message .= 'Subscribed: ' . current_time('mysql') . '</small></p>';
    
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
    );
    
    wp_mail($admin_email, $subject, $message, $headers);
    
    wp_send_json_success(array('message' => 'Thank you for subscribing!'));
}
add_action('wp_ajax_mailing_list_signup', 'handle_mailing_list_signup');
add_action('wp_ajax_nopriv_mailing_list_signup', 'handle_mailing_list_signup');
