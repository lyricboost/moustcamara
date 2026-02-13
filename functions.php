<?php
/**
 * Moust Camara Theme Functions
 */

// Theme Support
function moustcamara_theme_support() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    
    // Add editor stylesheet
    add_editor_style('style.css');
    
    // Add custom image sizes
    add_image_size('hero-image', 800, 800, true);
    add_image_size('split-image', 600, 600, true);
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
    wp_enqueue_style('moustcamara-style', get_stylesheet_uri(), array(), '0.2');
    
    // Enqueue header scroll script
    wp_enqueue_script(
        'moustcamara-header-scroll',
        get_template_directory_uri() . '/js/header-scroll.js',
        array(),
        '0.2',
        true // Load in footer
    );
}
add_action('wp_enqueue_scripts', 'moustcamara_enqueue_styles');

// Enqueue Editor Styles
function moustcamara_enqueue_editor_styles() {
    wp_enqueue_style('moustcamara-editor-style', get_stylesheet_uri(), array(), '0.2');
    
    // Add Google Fonts for editor
    wp_enqueue_style('moustcamara-google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap', array(), null);
    
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
