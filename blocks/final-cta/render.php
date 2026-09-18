<?php
/**
 * Final CTA Block Template
 *
 * Structurally a clone of the Page Heading block, minus the automatic
 * breadcrumb eyebrow mode, with its own .cta-heading-* class namespace so the
 * two blocks can be styled independently. The heading renders as an <h2>
 * rather than an <h1>, since this block sits inside a page that already has
 * its own top-level heading.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$custom_id = get_field('cta_custom_id');
$eyebrow = get_field('cta_eyebrow');
$heading_line_1 = get_field('cta_heading');
$heading_line_2 = get_field('cta_heading_line_2');
$heading_line_1_muted = get_field('cta_heading_line_1_muted');
$heading_size = get_field('cta_heading_size') ?: 'large';
$subheading = get_field('cta_text');
$body = get_field('cta_body');
$button_text = get_field('cta_button_text');
$button_link = get_field('cta_button_link');
$bg_color = get_field('background_color') ?: 'none';

// Legacy palette values (cream / terracotta / terracotta-dark) predate the
// current theme colours and have no matching CSS, so they already render as
// no background. Normalise them to 'none' to keep existing pages looking
// exactly as they do now.
if (!in_array($bg_color, ['none', 'light-gray', 'medium-gray', 'navy', 'dark-gray', 'black'], true)) {
    $bg_color = 'none';
}

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['navy', 'dark-gray', 'black'], true)) {
    $text_class = 'text-light';
}

$block_classes = 'final-cta-section';
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
        <div class="cta-heading-inner">
            <div class="cta-heading-header">
                <?php if ($eyebrow) : ?>
                    <p class="cta-heading-eyebrow text-center"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>
                <?php if ($heading_line_1 || $heading_line_2) : ?>
                <h2 class="cta-heading-heading<?php echo $heading_size === 'medium' ? ' cta-heading-heading--medium' : ''; ?> text-center">
                    <?php if ($heading_line_1) : ?>
                        <span class="cta-heading-heading-line-1<?php echo $heading_line_1_muted ? ' cta-heading-heading-muted' : ''; ?>"><?php echo esc_html($heading_line_1); ?></span>
                    <?php endif; ?>
                    <?php if ($heading_line_2) : ?>
                        <span class="cta-heading-heading-line-2"><?php echo esc_html($heading_line_2); ?></span>
                    <?php endif; ?>
                </h2>
                <?php endif; ?>
                <?php if ($subheading) : ?>
                    <p class="cta-heading-subheading text-center"><?php echo wp_kses_post($subheading); ?></p>
                <?php endif; ?>
                <?php if ($body) : ?>
                    <div class="cta-heading-body"><?php echo wp_kses_post($body); ?></div>
                <?php endif; ?>
            </div>

            <?php if (!empty($button_text) && !empty($button_link)) : ?>
            <div class="cta-heading-cta text-center mt-4">
                <a href="<?php echo esc_url($button_link); ?>" class="hero-alt-cta-btn">
                    <?php echo esc_html($button_text); ?>
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
