<?php
/**
 * Product Card Block
 * 
 * @package MoustCamara
 */

$custom_id = get_field('custom_id');
$badge = get_field('badge');
$product_name = get_field('product_name');
$heading_size = get_field('heading_size') ?: 'medium';
$description = get_field('description');
$price_primary = get_field('price_primary');
$price_secondary = get_field('price_secondary');
$features = get_field('features') ?: [];
$fine_print = get_field('fine_print');
$cta_text = get_field('cta_text');
$cta_link = get_field('cta_link');
$image = get_field('image');
$image_position = get_field('image_position') ?: 'left';
$image_style = get_field('image_style') ?: 'square';
$image_focal_point = get_field('image_focal_point') ?: 'center';
$image_breakout = get_field('image_breakout');
$layout = get_field('layout') ?: 'split';
$background = get_field('background_color') ?: 'none';

// Build CSS classes
$classes = ['product-card-section'];

if ($background !== 'none') {
    $classes[] = 'bg-' . $background;
}

// Add text-light class for dark backgrounds
if (in_array($background, ['navy', 'dark-gray', 'black'])) {
    $classes[] = 'text-light';
}

if ($layout === 'centered') {
    $classes[] = 'product-card--centered';
} else {
    $classes[] = 'product-card--split';
    $classes[] = 'product-card--image-' . $image_position;
}

if ($heading_size === 'large') {
    $classes[] = 'product-card--heading-large';
}

if ($image_focal_point !== 'center') {
    $classes[] = 'product-card--focal-' . $image_focal_point;
}

if ($image_breakout && $layout === 'split') {
    $classes[] = 'product-card--breakout';
}

$image_wrapper_class = 'product-card-image-wrapper';
if ($image_style === 'square') {
    $image_wrapper_class .= ' product-card-image-wrapper--square';
}

$section_class = implode(' ', $classes);
?>

<section class="<?php echo esc_attr($section_class); ?>"<?php echo $custom_id ? ' id="' . esc_attr($custom_id) . '"' : ''; ?>>
    <div class="container-fluid px-4">
        <?php if ($layout === 'centered'): ?>
            <!-- Centered Layout (no image) -->
            <div class="product-card-wrapper product-card-wrapper--centered">
                <div class="product-card-content">
                    <?php if ($badge): ?>
                        <div class="product-card-badge"><?php echo esc_html($badge); ?></div>
                    <?php endif; ?>
                    
                    <?php if ($product_name): ?>
                        <h2 class="product-card-name"><?php echo esc_html($product_name); ?></h2>
                    <?php endif; ?>
                    
                    <?php if ($description): ?>
                        <div class="product-card-description"><?php echo wp_kses_post($description); ?></div>
                    <?php endif; ?>
                    
                    <?php if ($price_primary || $price_secondary): ?>
                        <div class="product-card-pricing">
                            <?php if ($price_primary): ?>
                                <div class="product-card-price-primary"><?php echo esc_html($price_primary); ?></div>
                            <?php endif; ?>
                            <?php if ($price_secondary): ?>
                                <div class="product-card-price-secondary"><?php echo esc_html($price_secondary); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($features)): ?>
                        <ul class="product-card-features">
                            <?php foreach ($features as $feature): 
                                $text = $feature['feature_text'] ?? '';
                                if (empty($text)) continue;
                            ?>
                                <li class="product-card-feature">
                                    <i data-lucide="check" class="product-card-feature-icon"></i>
                                    <span><?php echo esc_html($text); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    
                    <?php if ($cta_text && $cta_link): ?>
                        <a href="<?php echo esc_url($cta_link); ?>" class="product-card-cta">
                            <?php echo esc_html($cta_text); ?>
                            <svg class="product-card-cta-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($fine_print): ?>
                        <div class="product-card-fine-print"><?php echo wp_kses_post($fine_print); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            
        <?php else: ?>
            <!-- Split Layout (with image) -->
            <div class="product-card-wrapper product-card-wrapper--split">
                <div class="row align-items-center g-5">
                    <?php if ($image_position === 'left'): ?>
                        <!-- Image Left -->
                        <div class="col-lg-6 order-2 order-lg-1">
                            <div class="product-card-image d-flex justify-content-center justify-content-lg-start" <?php if ($image) : ?>style="background-image: url(<?php echo esc_url($image['url']); ?>);"<?php endif; ?>>
                                <div class="<?php echo esc_attr($image_wrapper_class); ?>">
                                    <?php if ($image): ?>
                                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $product_name); ?>" class="product-card-image-element" />
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/600x600" alt="<?php echo esc_attr($product_name); ?>" class="product-card-image-element" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 order-1 order-lg-2">
                    <?php else: ?>
                        <!-- Image Right -->
                        <div class="col-lg-6 order-1 order-lg-1">
                    <?php endif; ?>
                    
                            <div class="product-card-content">
                                <?php if ($badge): ?>
                                    <div class="product-card-badge"><?php echo esc_html($badge); ?></div>
                                <?php endif; ?>
                                
                                <?php if ($product_name): ?>
                                    <h2 class="product-card-name"><?php echo esc_html($product_name); ?></h2>
                                <?php endif; ?>
                                
                                <?php if ($description): ?>
                                    <div class="product-card-description"><?php echo wp_kses_post($description); ?></div>
                                <?php endif; ?>
                                
                                <?php if ($price_primary || $price_secondary): ?>
                                    <div class="product-card-pricing">
                                        <?php if ($price_primary): ?>
                                            <div class="product-card-price-primary"><?php echo esc_html($price_primary); ?></div>
                                        <?php endif; ?>
                                        <?php if ($price_secondary): ?>
                                            <div class="product-card-price-secondary"><?php echo esc_html($price_secondary); ?></div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($features)): ?>
                                    <ul class="product-card-features">
                                        <?php foreach ($features as $feature): 
                                            $text = $feature['feature_text'] ?? '';
                                            if (empty($text)) continue;
                                        ?>
                                            <li class="product-card-feature">
                                                <i data-lucide="check" class="product-card-feature-icon"></i>
                                                <span><?php echo esc_html($text); ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                
                                <?php if ($cta_text && $cta_link): ?>
                                    <a href="<?php echo esc_url($cta_link); ?>" class="product-card-cta">
                                        <?php echo esc_html($cta_text); ?>
                                        <svg class="product-card-cta-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($fine_print): ?>
                                    <div class="product-card-fine-print"><?php echo wp_kses_post($fine_print); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                    <?php if ($image_position === 'right'): ?>
                        <div class="col-lg-6 order-2 order-lg-2">
                            <div class="product-card-image d-flex justify-content-center justify-content-lg-end" <?php if ($image) : ?>style="background-image: url(<?php echo esc_url($image['url']); ?>);"<?php endif; ?>>
                                <div class="<?php echo esc_attr($image_wrapper_class); ?>">
                                    <?php if ($image): ?>
                                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $product_name); ?>" class="product-card-image-element" />
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/600x600" alt="<?php echo esc_attr($product_name); ?>" class="product-card-image-element" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }
</script>
