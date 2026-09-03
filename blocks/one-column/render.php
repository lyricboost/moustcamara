<?php
/**
 * One Column Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$custom_id = get_field('one_column_custom_id');
$eyebrow = get_field('one_column_eyebrow');
$heading_line_1 = get_field('one_column_heading_line_1');
$heading_line_2 = get_field('one_column_heading_line_2');
$heading_line_1_muted = get_field('one_column_heading_line_1_muted');
$heading_size = get_field('one_column_heading_size') ?: 'large';
$subheading = get_field('one_column_subheading');
$description = get_field('one_column_description');
$cta_text = get_field('one_column_cta_text');
$cta_link = get_field('one_column_cta_link');
$bg_color = get_field('background_color') ?: 'none';

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['navy', 'dark-gray', 'black'])) {
    $text_class = 'text-light';
}

$block_classes = 'one-column-section';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $block_classes .= ' align' . $block['align'];
}
if ($bg_color !== 'none') {
    $block_classes .= ' bg-' . $bg_color;
}
if ($text_class) {
    $block_classes .= ' ' . $text_class;
}
?>

<section class="<?php echo esc_attr($block_classes); ?>"<?php echo $custom_id ? ' id="' . esc_attr($custom_id) . '"' : ''; ?>>
    <div class="container-fluid px-4">
        <div class="one-column-inner">
            <?php if ($eyebrow || $heading_line_1 || $heading_line_2 || $subheading) : ?>
            <div class="one-column-header">
                <?php if ($eyebrow) : ?>
                    <p class="one-column-eyebrow text-center"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>
                <?php if ($heading_line_1) : ?>
                <h2 class="one-column-heading<?php echo $heading_size === 'medium' ? ' one-column-heading--medium' : ''; ?> text-center">
                    <span class="one-column-heading-line-1<?php echo $heading_line_1_muted ? ' one-column-heading-muted' : ''; ?>"><?php echo esc_html($heading_line_1); ?></span>
                    <?php if ($heading_line_2) : ?>
                        <span class="one-column-heading-line-2"><?php echo esc_html($heading_line_2); ?></span>
                    <?php endif; ?>
                </h2>
                <?php endif; ?>
                <?php if ($subheading) : ?>
                    <p class="one-column-subheading text-center"><?php echo wp_kses_post($subheading); ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <?php if ($description) : ?>
                <div class="one-column-description">
                    <?php echo wp_kses_post($description); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($cta_text) && !empty($cta_link)) : ?>
            <div class="one-column-cta text-center mt-3">
                <a href="<?php echo esc_url($cta_link); ?>" class="hero-alt-cta-btn">
                    <?php echo esc_html($cta_text); ?>
                    <svg class="hero-alt-cta-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
