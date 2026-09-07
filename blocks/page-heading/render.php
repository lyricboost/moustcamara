<?php
/**
 * Page Heading Block Template
 *
 * Page heading section with eyebrow (manual text or automatic
 * breadcrumbs based on parent > sub page relationships), heading,
 * subheading, and optional CTA.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$custom_id = get_field('page_heading_custom_id');
$eyebrow_mode = get_field('page_heading_eyebrow_mode') ?: 'manual';
$eyebrow = get_field('page_heading_eyebrow');
$heading_line_1 = get_field('page_heading_heading_line_1');
$heading_line_2 = get_field('page_heading_heading_line_2');
$heading_line_1_muted = get_field('page_heading_heading_line_1_muted');
$heading_size = get_field('page_heading_heading_size') ?: 'large';
$subheading = get_field('page_heading_subheading');
$body = get_field('page_heading_body');
$cta_text = get_field('page_heading_cta_text');
$cta_link = get_field('page_heading_cta_link');
$bg_color = get_field('background_color') ?: 'none';

// Build breadcrumbs when eyebrow is set to automatic
$breadcrumbs = array();
if ($eyebrow_mode === 'breadcrumbs') {
    $current_id = is_numeric($post_id) ? (int) $post_id : get_the_ID();
    if ($current_id) {
        $ancestor_ids = array_reverse(get_post_ancestors($current_id));
        foreach ($ancestor_ids as $ancestor_id) {
            $breadcrumbs[] = array(
                'title' => get_the_title($ancestor_id),
                'url'   => get_permalink($ancestor_id),
            );
        }
        $breadcrumbs[] = array(
            'title' => get_the_title($current_id),
            'url'   => '', // Current page - no link
        );
    }
}

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['navy', 'dark-gray', 'black'])) {
    $text_class = 'text-light';
}

$block_classes = 'page-heading-section';
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
        <div class="page-heading-inner">
            <div class="page-heading-header">
                <?php if ($eyebrow_mode === 'breadcrumbs' && !empty($breadcrumbs)) : ?>
                    <nav class="page-heading-eyebrow page-heading-breadcrumbs text-center" aria-label="Breadcrumb">
                        <?php foreach ($breadcrumbs as $index => $crumb) : ?>
                            <?php if ($index > 0) : ?>
                                <span class="page-heading-breadcrumbs-separator" aria-hidden="true">&rsaquo;</span>
                            <?php endif; ?>
                            <?php if (!empty($crumb['url'])) : ?>
                                <a href="<?php echo esc_url($crumb['url']); ?>" class="page-heading-breadcrumbs-link"><?php echo esc_html($crumb['title']); ?></a>
                            <?php else : ?>
                                <span class="page-heading-breadcrumbs-current" aria-current="page"><?php echo esc_html($crumb['title']); ?></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </nav>
                <?php elseif ($eyebrow_mode === 'manual' && $eyebrow) : ?>
                    <p class="page-heading-eyebrow text-center"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>
                <?php if ($heading_line_1) : ?>
                <h1 class="page-heading-heading<?php echo $heading_size === 'medium' ? ' page-heading-heading--medium' : ''; ?> text-center">
                    <span class="page-heading-heading-line-1<?php echo $heading_line_1_muted ? ' page-heading-heading-muted' : ''; ?>"><?php echo esc_html($heading_line_1); ?></span>
                    <?php if ($heading_line_2) : ?>
                        <span class="page-heading-heading-line-2"><?php echo esc_html($heading_line_2); ?></span>
                    <?php endif; ?>
                </h1>
                <?php endif; ?>
                <?php if ($subheading) : ?>
                    <p class="page-heading-subheading text-center"><?php echo wp_kses_post($subheading); ?></p>
                <?php endif; ?>
                <?php if ($body) : ?>
                    <div class="page-heading-body"><?php echo wp_kses_post($body); ?></div>
                <?php endif; ?>
            </div>

            <?php if (!empty($cta_text) && !empty($cta_link)) : ?>
            <div class="page-heading-cta text-center mt-3">
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
