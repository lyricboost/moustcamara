<?php
/**
 * Grid Items Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$custom_id = get_field('grid_custom_id');
$eyebrow = get_field('grid_eyebrow');
$heading_line_1 = get_field('grid_heading_line_1') ?: 'Technology constantly changes.';
$heading_line_2 = get_field('grid_heading_line_2') ?: 'Fundamentals are forever.';
$heading_line_1_muted = get_field('grid_heading_line_1_muted');
$subheading = get_field('grid_subheading');
$items = get_field('grid_items');
$cta_text = get_field('grid_cta_text');
$cta_link = get_field('grid_cta_link');
$bg_color = get_field('background_color') ?: 'none';

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['dark-gray', 'black'])) {
    $text_class = 'text-light';
}

$block_classes = 'grid-items-section';
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
        <div class="grid-items-inner">
            <div class="grid-items-header">
                <?php if ($eyebrow) : ?>
                    <p class="grid-items-eyebrow text-center"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>
                <h2 class="grid-items-heading text-center">
                    <span class="grid-items-heading-line-1<?php echo $heading_line_1_muted ? ' grid-items-heading-muted' : ''; ?>"><?php echo esc_html($heading_line_1); ?></span>
                    <span class="grid-items-heading-line-2"><?php echo esc_html($heading_line_2); ?></span>
                </h2>
                <?php if ($subheading) : ?>
                    <p class="grid-items-subheading text-center"><?php echo wp_kses_post($subheading); ?></p>
                <?php endif; ?>
            </div>
            
            <?php if ($items) : ?>
                <div class="row g-4">
                    <?php foreach ($items as $item) : ?>
                        <div class="col-lg-4">
                            <div class="grid-item h-100 d-flex flex-column">
                                <?php if (!empty($item['item_image'])) : 
                                    $image_style = !empty($item['item_image_style']) ? $item['item_image_style'] : 'photo';
                                    $image_class = 'grid-item-image-wrapper grid-item-image-wrapper--' . $image_style;
                                ?>
                                    <div class="<?php echo esc_attr($image_class); ?>">
                                        <img src="<?php echo esc_url($item['item_image']['url']); ?>" alt="<?php echo esc_attr($item['item_image']['alt'] ?: $item['item_title']); ?>" class="grid-item-image" />
                                    </div>
                                <?php endif; ?>
                                <div class="grid-item-content flex-grow-1">
                                    <h3 class="grid-item-title"><?php echo esc_html($item['item_title']); ?></h3>
                                    <p class="grid-item-description"><?php echo esc_html($item['item_description']); ?></p>
                                    <?php if (!empty($item['item_link'])) : ?>
                                        <a href="<?php echo esc_url($item['item_link']); ?>" class="grid-item-button">
                                            <?php echo esc_html($item['item_button_text'] ?: 'Learn More'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="row g-4">
                    <!-- Default placeholder items for editor preview -->
                    <div class="col-lg-4">
                        <div class="grid-item h-100 d-flex flex-column">
                            <h3 class="grid-item-title">Keynotes & Workshops</h3>
                            <p class="grid-item-description flex-grow-1">Hosting an event or conference? I speak on a number of topics from leveraging multiple passions and skills in the AI era to building a powerful brand.</p>
                            <a href="#" class="grid-item-button">Enquire About Booking</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="grid-item h-100 d-flex flex-column">
                            <h3 class="grid-item-title">Resources & Structure</h3>
                            <p class="grid-item-description flex-grow-1">I help multi-passionate women create structure with their passions through a number of resources designed to create clarity and magnify opportunities.</p>
                            <a href="#" class="grid-item-button">Explore The Resources</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="grid-item h-100 d-flex flex-column">
                            <h3 class="grid-item-title">YouTube & Content</h3>
                            <p class="grid-item-description flex-grow-1">My YouTube channel of over 180,000 subs helps people with multiple passions develop through structure, inspiration and frameworks.</p>
                            <a href="#" class="grid-item-button">Watch Now On YouTube</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($cta_text) && !empty($cta_link)) : ?>
            <div class="grid-items-cta text-center mt-3">
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
