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
$custom_id = get_field('split_custom_id');
$image = get_field('split_image');
$eyebrow = get_field('split_eyebrow');
$heading = get_field('split_heading');
$heading_size = get_field('split_heading_size') ?: 'section';
$subheading = get_field('split_subheading');
$body_text = get_field('split_body_text') ?: '';
$topics = get_field('split_topics') ?: array();
$image_position = get_field('split_image_position') ?: 'left';
$image_style = get_field('split_image_style') ?: 'square';
$image_focal_point = get_field('split_image_focal_point') ?: 'center';
$image_breakout = get_field('split_image_breakout');
$cta_text = get_field('split_cta_text');
$cta_link = get_field('split_cta_link');
$bg_color = get_field('background_color') ?: 'none';

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['navy', 'dark-gray', 'black'])) {
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
if ($image_breakout) {
    $block_classes .= ' split-section--breakout';
}
if ($image_focal_point !== 'center') {
    $block_classes .= ' split-section--focal-' . $image_focal_point;
}

$image_wrapper_class = 'split-image-wrapper';
if ($image_style === 'square') {
    $image_wrapper_class .= ' split-image-wrapper--square';
}
?>

<section class="<?php echo esc_attr($block_classes); ?>"<?php echo $custom_id ? ' id="' . esc_attr($custom_id) . '"' : ''; ?>>
    <div class="container-fluid px-4">
        <div class="split-inner">
            <div class="row align-items-center g-5">
                <?php if ($image_position === 'left') : ?>
                    <div class="col-lg-6 order-2 order-lg-1">
                        <div class="split-image d-flex justify-content-center justify-content-lg-start" <?php if ($image) : ?>style="background-image: url(<?php echo esc_url($image['url']); ?>);"<?php endif; ?>>
                            <div class="<?php echo esc_attr($image_wrapper_class); ?>">
                                <?php if ($image) : ?>
                                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $heading); ?>" />
                                <?php else : ?>
                                    <img src="https://via.placeholder.com/600x600" alt="<?php echo esc_attr($heading); ?>" />
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2">
                        <div class="split-content">
                            <?php if ($eyebrow) : ?>
                                <p class="split-eyebrow"><?php echo esc_html($eyebrow); ?></p>
                            <?php endif; ?>
                            <h2 class="split-heading"><?php echo esc_html($heading); ?></h2>
                            <p class="split-subheading"><?php echo esc_html($subheading); ?></p>
                            <?php if ($body_text) : ?>
                                <div class="split-body-text"><?php echo wp_kses_post($body_text); ?></div>
                            <?php endif; ?>
                            <?php if ($topics) : ?>
                                <ul class="split-topics-list">
                                    <?php foreach ($topics as $topic) : ?>
                                        <li class="split-topic-item">
                                            <i data-lucide="check" class="split-topic-icon"></i>
                                            <span><?php echo esc_html($topic['topic_text']); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <?php if ($cta_text && $cta_link) : ?>
                                <a href="<?php echo esc_url($cta_link); ?>" class="hero-alt-cta-btn">
                                    <?php echo esc_html($cta_text); ?>
                                    <svg class="hero-alt-cta-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-lg-6 order-1">
                        <div class="split-content">
                            <?php if ($eyebrow) : ?>
                                <p class="split-eyebrow"><?php echo esc_html($eyebrow); ?></p>
                            <?php endif; ?>
                            <?php 
                            $heading_tag = $heading_size === 'page' ? 'h1' : 'h2';
                            $heading_class = 'split-heading' . ($heading_size === 'page' ? ' split-heading--page' : '');
                            ?>
                            <<?php echo $heading_tag; ?> class="<?php echo esc_attr($heading_class); ?>"><?php echo esc_html($heading); ?></<?php echo $heading_tag; ?>>
                            <p class="split-subheading"><?php echo esc_html($subheading); ?></p>
                            <?php if ($body_text) : ?>
                                <div class="split-body-text"><?php echo wp_kses_post($body_text); ?></div>
                            <?php endif; ?>
                            <?php if ($topics) : ?>
                                <ul class="split-topics-list">
                                    <?php foreach ($topics as $topic) : ?>
                                        <li class="split-topic-item">
                                            <i data-lucide="check" class="split-topic-icon"></i>
                                            <span><?php echo esc_html($topic['topic_text']); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <?php if ($cta_text && $cta_link) : ?>
                                <a href="<?php echo esc_url($cta_link); ?>" class="hero-alt-cta-btn">
                                    <?php echo esc_html($cta_text); ?>
                                    <svg class="hero-alt-cta-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6 order-2">
                        <div class="split-image d-flex justify-content-center justify-content-lg-end" <?php if ($image) : ?>style="background-image: url(<?php echo esc_url($image['url']); ?>);"<?php endif; ?>>
                            <div class="<?php echo esc_attr($image_wrapper_class); ?>">
                                <?php if ($image) : ?>
                                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $heading); ?>" />
                                <?php else : ?>
                                    <img src="https://via.placeholder.com/600x600" alt="<?php echo esc_attr($heading); ?>" />
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
