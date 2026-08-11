<?php
/**
 * Capability Cards Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$custom_id = get_field('capability_custom_id');
$eyebrow = get_field('capability_eyebrow');
$heading = get_field('capability_heading');
$subheading = get_field('capability_subheading');
$heading_size = get_field('capability_heading_size') ?: 'large';
$cards = get_field('capability_cards');
$columns = get_field('capability_columns') ?: '3';
$fine_print = get_field('capability_fine_print');
$cta_text = get_field('capability_cta_text');
$cta_link = get_field('capability_cta_link');
$bg_color = get_field('background_color') ?: 'none';

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['navy', 'dark-gray', 'black'])) {
    $text_class = 'text-light';
}

$block_classes = 'capability-cards-section';
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

$heading_class = $heading_size === 'medium' ? ' capability-cards-heading--medium' : '';
$col_class = $columns === '2' ? 'col-lg-6' : 'col-lg-4';
?>

<section class="<?php echo esc_attr($block_classes); ?>"<?php echo $custom_id ? ' id="' . esc_attr($custom_id) . '"' : ''; ?>>
    <div class="container-fluid px-4">
        <div class="capability-cards-inner">
            <?php if ($eyebrow || $heading || $subheading) : ?>
                <div class="capability-cards-header">
                    <?php if ($eyebrow) : ?>
                        <p class="capability-cards-eyebrow"><?php echo esc_html($eyebrow); ?></p>
                    <?php endif; ?>
                    <?php if ($heading) : ?>
                        <h2 class="capability-cards-heading<?php echo esc_attr($heading_class); ?>"><?php echo esc_html($heading); ?></h2>
                    <?php endif; ?>
                    <?php if ($subheading) : ?>
                        <p class="capability-cards-subheading"><?php echo esc_html($subheading); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($cards) : ?>
                <div class="row g-4">
                    <?php foreach ($cards as $card) : ?>
                        <div class="<?php echo esc_attr($col_class); ?>">
                            <div class="capability-card">
                                <?php if (!empty($card['card_icon'])) : ?>
                                    <div class="capability-card-icon-wrapper">
                                        <img src="<?php echo esc_url($card['card_icon']['url']); ?>" 
                                             alt="<?php echo esc_attr($card['card_icon']['alt'] ?: $card['card_title']); ?>" 
                                             class="capability-card-icon" />
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($card['card_category'])) : ?>
                                    <p class="capability-card-category"><?php echo esc_html($card['card_category']); ?></p>
                                <?php endif; ?>
                                
                                <?php if (!empty($card['card_title'])) : ?>
                                    <h3 class="capability-card-title"><?php echo esc_html($card['card_title']); ?></h3>
                                <?php endif; ?>
                                
                                <?php if (!empty($card['card_description'])) : ?>
                                    <p class="capability-card-description"><?php echo esc_html($card['card_description']); ?></p>
                                <?php endif; ?>
                                
                                <?php if (!empty($card['card_outcome'])) : ?>
                                    <p class="capability-card-outcome"><?php echo esc_html($card['card_outcome']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($fine_print)) : ?>
            <div class="capability-cards-fine-print">
                <?php echo wp_kses_post($fine_print); ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($cta_text) && !empty($cta_link)) : ?>
            <div class="capability-cards-cta text-center mt-3">
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
