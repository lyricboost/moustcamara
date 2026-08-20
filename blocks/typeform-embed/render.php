<?php
/**
 * Typeform Embed Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$typeform_url = get_field('typeform_url');
$display_mode = get_field('display_mode') ?: 'embed';
$embed_height = get_field('embed_height') ?: '500';
$button_text = get_field('button_text') ?: 'Open Form';
$heading = get_field('heading');
$description = get_field('description');
$background_color = get_field('background_color') ?: 'none';

// Set text color based on background
$text_class = '';
if (in_array($background_color, ['navy', 'dark-gray', 'black'])) {
    $text_class = 'text-light';
}

// Build block classes
$block_classes = 'typeform-embed-section';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $block_classes .= ' align' . $block['align'];
}
if ($background_color !== 'none') {
    $block_classes .= ' bg-' . $background_color;
}
if ($text_class) {
    $block_classes .= ' ' . $text_class;
}

// Extract Typeform ID from URL
$typeform_id = '';
if (!empty($typeform_url)) {
    // Handle various Typeform URL formats
    preg_match('/typeform\.com\/to\/([a-zA-Z0-9]+)/', $typeform_url, $matches);
    if (!empty($matches[1])) {
        $typeform_id = $matches[1];
    }
}

// Show error in preview if URL is missing or invalid
if (empty($typeform_id) && $is_preview) {
    echo '<div class="notice notice-warning" style="padding: 20px; margin: 20px; background: #fff3cd; border-left: 4px solid #ffc107;">';
    echo '<p><strong>Typeform Embed Block:</strong> Please enter a valid Typeform URL (e.g., https://form.typeform.com/to/YOUR_FORM_ID)</p>';
    echo '</div>';
    return;
}

// Don't render if no valid Typeform ID
if (empty($typeform_id)) {
    return;
}
?>

<section class="<?php echo esc_attr($block_classes); ?>">
    <div class="container-fluid px-4">
        <div class="typeform-embed-inner">
            <?php if ($heading || $description): ?>
            <div class="typeform-header text-center mb-4">
                <?php if ($heading): ?>
                    <h2 class="mb-3"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($description): ?>
                    <div class="typeform-description"><?php echo wp_kses_post($description); ?></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ($display_mode === 'embed'): ?>
                <!-- Standard Embed -->
                <div class="typeform-embed-container" style="height: <?php echo esc_attr($embed_height); ?>px;">
                    <div 
                        data-tf-widget="<?php echo esc_attr($typeform_id); ?>" 
                        data-tf-opacity="100" 
                        data-tf-iframe-props="title=Typeform"
                        data-tf-transitive-search-params 
                        data-tf-medium="snippet"
                        style="width:100%;height:100%;">
                    </div>
                </div>

            <?php elseif ($display_mode === 'popup'): ?>
                <!-- Popup Button -->
                <div class="typeform-popup-container text-center">
                    <button 
                        data-tf-popup="<?php echo esc_attr($typeform_id); ?>" 
                        data-tf-opacity="100" 
                        data-tf-size="100"
                        data-tf-iframe-props="title=Typeform"
                        data-tf-transitive-search-params
                        data-tf-medium="snippet"
                        class="btn btn-primary btn-lg">
                        <?php echo esc_html($button_text); ?>
                    </button>
                </div>

            <?php elseif ($display_mode === 'slider'): ?>
                <!-- Slider (side panel) -->
                <div class="typeform-slider-container text-center">
                    <button 
                        data-tf-slider="<?php echo esc_attr($typeform_id); ?>" 
                        data-tf-position="right"
                        data-tf-opacity="100"
                        data-tf-iframe-props="title=Typeform"
                        data-tf-transitive-search-params
                        data-tf-medium="snippet"
                        class="btn btn-primary btn-lg">
                        <?php echo esc_html($button_text); ?>
                    </button>
                </div>

            <?php elseif ($display_mode === 'popover'): ?>
                <!-- Popover -->
                <div class="typeform-popover-container text-center">
                    <button 
                        data-tf-popover="<?php echo esc_attr($typeform_id); ?>" 
                        data-tf-opacity="100"
                        data-tf-size="70"
                        data-tf-iframe-props="title=Typeform"
                        data-tf-transitive-search-params
                        data-tf-medium="snippet"
                        class="btn btn-primary btn-lg">
                        <?php echo esc_html($button_text); ?>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if (!wp_script_is('typeform-embed', 'enqueued')): ?>
<script src="//embed.typeform.com/next/embed.js"></script>
<?php endif; ?>
