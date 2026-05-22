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
$heading = get_field('grid_heading') ?: 'Here\'s How We Can Work Together';
$items = get_field('grid_items');
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

<section class="<?php echo esc_attr($block_classes); ?>">
    <div class="container-fluid px-4">
        <div class="grid-items-inner">
            <h2 class="grid-items-heading text-center"><?php echo esc_html($heading); ?></h2>
            
            <?php if ($items) : ?>
                <div class="row g-4">
                    <?php foreach ($items as $item) : ?>
                        <div class="col-lg-4">
                            <div class="grid-item h-100 d-flex flex-column">
                                <h3 class="grid-item-title"><?php echo esc_html($item['item_title']); ?></h3>
                                <p class="grid-item-description flex-grow-1"><?php echo esc_html($item['item_description']); ?></p>
                                <a href="<?php echo esc_url($item['item_link']); ?>" class="grid-item-button">
                                    <?php echo esc_html($item['item_button_text'] ?: 'Learn More'); ?>
                                </a>
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
        </div>
    </div>
</section>
