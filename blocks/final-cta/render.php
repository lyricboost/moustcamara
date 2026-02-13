<?php
/**
 * Final CTA Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$heading = get_field('cta_heading') ?: 'More information coming soon...';
$text = get_field('cta_text') ?: 'Sign up to the newsletter to stay up to date.';
$button_text = get_field('cta_button_text') ?: 'Sign Up Page';
$button_link = get_field('cta_button_link') ?: '#';
$bg_color = get_field('background_color') ?: 'none';

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['dark-gray', 'black'])) {
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

<section class="<?php echo esc_attr($block_classes); ?>">
    <div class="final-cta-inner">
        <h2 class="final-cta-heading"><?php echo esc_html($heading); ?></h2>
        <p class="final-cta-text"><?php echo esc_html($text); ?></p>
        <a href="<?php echo esc_url($button_link); ?>" class="final-cta-button">
            <?php echo esc_html($button_text); ?>
        </a>
    </div>
</section>
