<?php
/**
 * Testimonials Block Template
 */

$heading = get_field('heading');
$format = get_field('format') ?: 'carousel';
$items_per_row = get_field('items_per_row') ?: 3;
$items_per_carousel = get_field('items_per_carousel') ?: 1;
$testimonials = get_field('testimonials');
$background_color = get_field('background_color') ?: 'white';

// Set text color based on background
$text_class = '';
if (in_array($background_color, ['navy', 'dark-gray', 'black'])) {
    $text_class = 'text-light';
}

$block_classes = 'testimonials-section testimonials-' . $format;
if ($background_color !== 'white') {
    $block_classes .= ' bg-' . $background_color;
}
if ($text_class) {
    $block_classes .= ' ' . $text_class;
}

$testimonial_count = $testimonials ? count($testimonials) : 0;
?>

<section class="<?php echo esc_attr($block_classes); ?>">
    <div class="container-fluid px-4">
        <div class="testimonials-inner">
            
            <?php if ($heading): ?>
            <div class="testimonials-header text-center mb-5">
                <h2><?php echo esc_html($heading); ?></h2>
            </div>
            <?php endif; ?>
            
            <?php if ($testimonials && $testimonial_count > 0): ?>
                
                <?php if ($format === 'carousel'): ?>
                    <div class="testimonials-carousel-wrapper">
                        <div class="testimonials-carousel" data-items-per-page="<?php echo esc_attr($items_per_carousel); ?>">
                            <?php foreach ($testimonials as $testimonial): ?>
                                <div class="testimonial-item">
                                    <div class="testimonial-content">
                                        <div class="testimonial-quote">
                                            <p><?php echo esc_html($testimonial['testimonial_text']); ?></p>
                                        </div>
                                        <div class="testimonial-author">
                                            <?php if ($testimonial['image']): ?>
                                                <div class="testimonial-image">
                                                    <img src="<?php echo esc_url($testimonial['image']['url']); ?>" alt="<?php echo esc_attr($testimonial['name']); ?>" />
                                                </div>
                                            <?php endif; ?>
                                            <div class="testimonial-details">
                                                <p class="testimonial-name"><?php echo esc_html($testimonial['name']); ?></p>
                                                <?php if ($testimonial['byline']): ?>
                                                    <p class="testimonial-byline"><?php echo esc_html($testimonial['byline']); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <?php if ($testimonial_count > $items_per_carousel): ?>
                        <div class="testimonials-carousel-nav">
                            <button class="carousel-nav-btn carousel-prev" aria-label="Previous">
                                <i data-lucide="chevron-left"></i>
                            </button>
                            <button class="carousel-nav-btn carousel-next" aria-label="Next">
                                <i data-lucide="chevron-right"></i>
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                
                <?php else: // Grid format ?>
                    <div class="testimonials-grid testimonials-grid--<?php echo esc_attr($items_per_row); ?>-col">
                        <?php foreach ($testimonials as $testimonial): ?>
                            <div class="testimonial-item">
                                <div class="testimonial-content">
                                    <div class="testimonial-quote">
                                        <p><?php echo esc_html($testimonial['testimonial_text']); ?></p>
                                    </div>
                                    <div class="testimonial-author">
                                        <?php if ($testimonial['image']): ?>
                                            <div class="testimonial-image">
                                                <img src="<?php echo esc_url($testimonial['image']['url']); ?>" alt="<?php echo esc_attr($testimonial['name']); ?>" />
                                            </div>
                                        <?php endif; ?>
                                        <div class="testimonial-details">
                                            <p class="testimonial-name"><?php echo esc_html($testimonial['name']); ?></p>
                                            <?php if ($testimonial['byline']): ?>
                                                <p class="testimonial-byline"><?php echo esc_html($testimonial['byline']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
            <?php else: ?>
                <p class="text-center">No testimonials added yet.</p>
            <?php endif; ?>
            
        </div>
    </div>
</section>
