<?php
/**
 * Testimonials Grid Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$custom_id = get_field('testimonials_grid_custom_id');
$eyebrow = get_field('testimonials_grid_eyebrow');
$heading = get_field('testimonials_grid_heading');
$subheading = get_field('testimonials_grid_subheading');
$testimonials = get_field('testimonials_grid_items');
$grid_columns = get_field('testimonials_grid_columns') ?: '2';
$cta_text = get_field('testimonials_grid_cta_text');
$cta_link = get_field('testimonials_grid_cta_link');
$bg_color = get_field('background_color') ?: 'none';

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['navy', 'dark-gray', 'black'])) {
    $text_class = 'text-light';
}

$block_classes = 'testimonials-grid-section';
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
        <div class="testimonials-grid-inner">
            <?php if ($eyebrow || $heading || $subheading) : ?>
                <div class="testimonials-grid-header">
                    <?php if ($eyebrow) : ?>
                        <p class="testimonials-grid-eyebrow"><?php echo esc_html($eyebrow); ?></p>
                    <?php endif; ?>
                    <?php if ($heading) : ?>
                        <h2 class="testimonials-grid-heading"><?php echo esc_html($heading); ?></h2>
                    <?php endif; ?>
                    <?php if ($subheading) : ?>
                        <p class="testimonials-grid-subheading"><?php echo wp_kses_post($subheading); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($testimonials) : ?>
                <div class="testimonials-grid-container testimonials-grid-cols-<?php echo esc_attr($grid_columns); ?>">
                    <?php foreach ($testimonials as $index => $item) : ?>
                        <div class="testimonial-grid-item">
                            <?php if (!empty($item['testimonial_text'])) : ?>
                                <div class="testimonial-grid-quote">
                                    <p><?php echo esc_html($item['testimonial_text']); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($item['name']) || !empty($item['byline']) || !empty($item['image'])) : ?>
                                <div class="testimonial-grid-author">
                                    <?php if (!empty($item['image'])) : ?>
                                        <div class="testimonial-grid-image">
                                            <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['name'] ?: ''); ?>" />
                                        </div>
                                    <?php endif; ?>
                                    <div class="testimonial-grid-details">
                                        <?php if (!empty($item['name'])) : ?>
                                            <p class="testimonial-grid-name"><?php echo esc_html($item['name']); ?></p>
                                        <?php endif; ?>
                                        <?php if (!empty($item['byline'])) : ?>
                                            <p class="testimonial-grid-byline"><?php echo esc_html($item['byline']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p class="text-center">No testimonials added yet.</p>
            <?php endif; ?>

            <?php if (!empty($cta_text) && !empty($cta_link)) : ?>
            <div class="testimonials-grid-cta text-center mt-5">
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
