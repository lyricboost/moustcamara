<?php
/**
 * Split Layout Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$image = get_field('split_image');
$heading = get_field('split_heading') ?: 'I\'ve never believed in choosing just one path.';
$text = get_field('split_text') ?: 'From engineering high-scale systems to building a YouTube channel with over 180,000 subscribers, my journey has been anything but conventional.';
$secondary_text = get_field('split_secondary_text') ?: '';
$image_position = get_field('split_image_position') ?: 'left';
$bg_color = get_field('background_color') ?: 'none';

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['dark-gray', 'black'])) {
    $text_class = 'text-light';
}

$block_classes = 'split-section split-' . $image_position;
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
    <div class="split-inner">
        <?php if ($image_position === 'left') : ?>
            <div class="split-image">
                <div class="split-image-wrapper">
                    <?php if ($image) : ?>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $heading); ?>" />
                    <?php else : ?>
                        <img src="https://via.placeholder.com/600x600" alt="<?php echo esc_attr($heading); ?>" />
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="split-content">
            <h2 class="split-heading"><?php echo esc_html($heading); ?></h2>
            <p class="split-text"><?php echo wp_kses_post($text); ?></p>
            <?php if ($secondary_text) : ?>
                <p class="split-text-secondary"><?php echo wp_kses_post($secondary_text); ?></p>
            <?php endif; ?>
        </div>
        
        <?php if ($image_position === 'right') : ?>
            <div class="split-image">
                <div class="split-image-wrapper">
                    <?php if ($image) : ?>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $heading); ?>" />
                    <?php else : ?>
                        <img src="https://via.placeholder.com/600x600" alt="<?php echo esc_attr($heading); ?>" />
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
