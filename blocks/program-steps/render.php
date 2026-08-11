<?php
/**
 * Program Steps Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$custom_id = get_field('program_custom_id');
$eyebrow = get_field('program_eyebrow');
$heading = get_field('program_heading');
$subheading = get_field('program_subheading');
$heading_size = get_field('program_heading_size') ?: 'large';
$steps = get_field('program_steps');
$cta_text = get_field('program_cta_text');
$cta_link = get_field('program_cta_link');
$bg_color = get_field('background_color') ?: 'none';

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['navy', 'dark-gray', 'black'])) {
    $text_class = 'text-light';
}

$block_classes = 'program-steps-section';
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

$heading_class = $heading_size === 'medium' ? ' program-steps-heading--medium' : '';
?>

<section class="<?php echo esc_attr($block_classes); ?>"<?php echo $custom_id ? ' id="' . esc_attr($custom_id) . '"' : ''; ?>>
    <div class="container-fluid px-4">
        <div class="program-steps-inner">
            <?php if ($eyebrow || $heading || $subheading) : ?>
                <div class="program-steps-header">
                    <?php if ($eyebrow) : ?>
                        <p class="program-steps-eyebrow"><?php echo esc_html($eyebrow); ?></p>
                    <?php endif; ?>
                    <?php if ($heading) : ?>
                        <h2 class="program-steps-heading<?php echo esc_attr($heading_class); ?>"><?php echo esc_html($heading); ?></h2>
                    <?php endif; ?>
                    <?php if ($subheading) : ?>
                        <p class="program-steps-subheading"><?php echo esc_html($subheading); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($steps) : ?>
                <!-- Desktop View -->
                <div class="program-steps-list program-steps-desktop">
                    <?php foreach ($steps as $index => $step) : ?>
                        <div class="program-step">
                            <div class="program-step-visual">
                                <?php if (!empty($step['step_image'])) : ?>
                                    <div class="program-step-image-wrapper">
                                        <img src="<?php echo esc_url($step['step_image']['url']); ?>" 
                                             alt="<?php echo esc_attr($step['step_image']['alt'] ?: $step['step_title']); ?>" 
                                             class="program-step-image" />
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="program-step-content">
                                <div class="program-step-main">
                                    <?php if (!empty($step['step_eyebrow'])) : ?>
                                        <p class="program-step-eyebrow"><?php echo esc_html($step['step_eyebrow']); ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($step['step_title'])) : ?>
                                        <h3 class="program-step-title"><?php echo esc_html($step['step_title']); ?></h3>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($step['step_description'])) : ?>
                                        <p class="program-step-description"><?php echo esc_html($step['step_description']); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if (!empty($step['step_sub_items'])) : ?>
                                    <div class="program-step-sub-items">
                                        <?php foreach ($step['step_sub_items'] as $sub_item) : ?>
                                            <div class="program-sub-item">
                                                <?php if (!empty($sub_item['sub_item_eyebrow'])) : ?>
                                                    <p class="program-sub-item-eyebrow"><?php echo esc_html($sub_item['sub_item_eyebrow']); ?></p>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($sub_item['sub_item_title'])) : ?>
                                                    <h4 class="program-sub-item-title"><?php echo esc_html($sub_item['sub_item_title']); ?></h4>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($sub_item['sub_item_description'])) : ?>
                                                    <p class="program-sub-item-description"><?php echo esc_html($sub_item['sub_item_description']); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Mobile View (Collapsible) -->
                <div class="program-steps-list program-steps-mobile">
                    <?php foreach ($steps as $index => $step) : ?>
                        <div class="program-step-mobile">
                            <button class="program-step-mobile-header" aria-expanded="false">
                                <div class="program-step-mobile-left">
                                    <?php if (!empty($step['step_image'])) : ?>
                                        <div class="program-step-mobile-image">
                                            <img src="<?php echo esc_url($step['step_image']['url']); ?>" 
                                                 alt="<?php echo esc_attr($step['step_image']['alt'] ?: $step['step_title']); ?>" />
                                        </div>
                                    <?php endif; ?>
                                    <div class="program-step-mobile-title-wrap">
                                        <?php if (!empty($step['step_eyebrow'])) : ?>
                                            <p class="program-step-eyebrow"><?php echo esc_html($step['step_eyebrow']); ?></p>
                                        <?php endif; ?>
                                        <?php if (!empty($step['step_title'])) : ?>
                                            <h3 class="program-step-title"><?php echo esc_html($step['step_title']); ?></h3>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <i data-lucide="chevron-down" class="program-step-mobile-chevron"></i>
                            </button>
                            
                            <div class="program-step-mobile-content">
                                <?php if (!empty($step['step_description'])) : ?>
                                    <p class="program-step-description"><?php echo esc_html($step['step_description']); ?></p>
                                <?php endif; ?>
                                
                                <?php if (!empty($step['step_sub_items'])) : ?>
                                    <div class="program-step-sub-items">
                                        <?php foreach ($step['step_sub_items'] as $sub_item) : ?>
                                            <div class="program-sub-item">
                                                <?php if (!empty($sub_item['sub_item_eyebrow'])) : ?>
                                                    <p class="program-sub-item-eyebrow"><?php echo esc_html($sub_item['sub_item_eyebrow']); ?></p>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($sub_item['sub_item_title'])) : ?>
                                                    <h4 class="program-sub-item-title"><?php echo esc_html($sub_item['sub_item_title']); ?></h4>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($sub_item['sub_item_description'])) : ?>
                                                    <p class="program-sub-item-description"><?php echo esc_html($sub_item['sub_item_description']); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($cta_text) && !empty($cta_link)) : ?>
            <div class="program-steps-cta text-center">
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

<script>
  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }
</script>
