<?php
/**
 * Hero Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$name = get_field('hero_name') ?: 'Your Name';
$tagline = get_field('hero_tagline') ?: 'Your tagline goes here';
$description = get_field('hero_description') ?: 'I engineer creative processes where small changes compound into outsized results.';
$company = get_field('hero_company') ?: 'Your Company';
$company_link = get_field('hero_company_link') ?: '#';
$role = get_field('hero_role') ?: 'Systems Builder';
$location = get_field('hero_location') ?: 'City, State';
$email_link = get_field('hero_email_link') ?: 'mailto:email@example.com';
$linkedin_link = get_field('hero_linkedin_link') ?: '#';
$image = get_field('hero_image');
$bg_color = get_field('background_color') ?: 'none';

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['dark-gray', 'black'])) {
    $text_class = 'text-light';
}

$block_classes = 'hero-section';
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
        <div class="hero-section-inner">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <div class="hero-location">
                            <i data-lucide="map-pin" class="hero-icon"></i>
                            <span><?php echo esc_html($location); ?></span>
                        </div>
                        
                        <h1 class="hero-name"><?php echo esc_html($name); ?></h1>
                        
                        <p class="hero-about">
                            <?php echo esc_html($description); ?>
                        </p>
                        
                        <div class="hero-founder">
                            Founder, <a href="<?php echo esc_url($company_link); ?>" target="_blank" rel="noopener"><?php echo esc_html($company); ?></a> · <?php echo esc_html($role); ?>
                        </div>
                        
                        <div class="hero-links">
                            <a href="<?php echo esc_url($email_link); ?>" class="hero-link">
                                <i data-lucide="mail" class="hero-icon"></i>
                                <span>Email</span>
                            </a>
                            <a href="<?php echo esc_url($linkedin_link); ?>" target="_blank" rel="noopener" class="hero-link">
                                <i data-lucide="linkedin" class="hero-icon"></i>
                                <span>LinkedIn</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="hero-image d-flex justify-content-center justify-content-lg-end">
                        <div class="hero-image-circle">
                            <?php if ($image) : ?>
                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $name); ?>" />
                            <?php else : ?>
                                <img src="https://via.placeholder.com/550x550" alt="<?php echo esc_attr($name); ?>" />
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Initialize Lucide icons for this block
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>
</section>
