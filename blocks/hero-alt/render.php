<?php
/**
 * Hero Alt Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$image = get_field('hero_alt_image');
$mobile_image = get_field('hero_alt_mobile_image');
$heading = get_field('hero_alt_heading') ?: 'Build with clarity';
$subheading = get_field('hero_alt_subheading') ?: 'Helping ambitious people turn potential into execution.';
$cta_text = get_field('hero_alt_cta_text') ?: 'Find out how';
$cta_link = get_field('hero_alt_cta_link') ?: '#';
$credibility_items = get_field('hero_alt_credibility_items') ?: array();
$bg_color = get_field('hero_alt_background_color') ?: 'none';

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['dark-gray', 'black'])) {
    $text_class = 'text-light';
}

// Build block classes
$block_classes = 'hero-alt-section';
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

// Build inline style for background image (desktop)
$hero_style = '';
if ($image) {
    $hero_style = 'background-image: url(' . esc_url($image['url']) . ');';
}

// Build mobile image CSS variable if available
$mobile_image_attr = '';
$mobile_css_var = '';
if ($mobile_image) {
    $mobile_image_attr = ' data-mobile-image="1"';
    $mobile_css_var = '--mobile-bg-image: url(' . esc_url($mobile_image['url']) . ');';
    if ($hero_style) {
        $hero_style .= ' ' . $mobile_css_var;
    } else {
        $hero_style = $mobile_css_var;
    }
}
?>

<section class="<?php echo esc_attr($block_classes); ?>"<?php echo $mobile_image_attr; ?> style="<?php echo esc_attr($hero_style); ?>">
    <!-- Background fade overlay -->
    <div class="hero-alt-fade-overlay"></div>
    
    <div class="container-fluid px-4">
        <div class="hero-alt-inner">
            <div class="hero-alt-content-wrapper">
                <div class="hero-alt-content">
                    <h1 class="hero-alt-heading"><?php echo esc_html($heading); ?></h1>

                    <p class="hero-alt-subheading">
                        <?php echo esc_html($subheading); ?>
                    </p>

                    <!-- CTA Button -->
                    <a href="<?php echo esc_url($cta_link); ?>" class="hero-alt-cta-btn">
                        <?php echo esc_html($cta_text); ?>
                        <svg class="hero-alt-cta-arrow" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>

                <!-- Credibility Strip -->
                <?php if (!empty($credibility_items)) : ?>
                    <div class="hero-alt-credibility">
                        <div class="hero-alt-credibility-items">
                            <?php foreach ($credibility_items as $item) : ?>
                                <div class="hero-alt-credibility-item">
                                    <?php if (!empty($item['cred_image'])) : ?>
                                        <img 
                                            src="<?php echo esc_url($item['cred_image']['url']); ?>" 
                                            alt="<?php echo esc_attr($item['cred_name']); ?>"
                                            class="hero-alt-credibility-logo"
                                            title="<?php echo esc_attr($item['cred_name']); ?>"
                                        />
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>


