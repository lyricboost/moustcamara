<?php
/**
 * Pricing Block Template (Moust Pricing)
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$custom_id = get_field('pricing_custom_id');
$eyebrow = get_field('pricing_eyebrow');
$heading = get_field('pricing_heading');
$subheading = get_field('pricing_subheading');
$enable_annual_toggle = get_field('pricing_enable_annual_toggle');
$annual_savings_label = get_field('pricing_annual_savings_label');
$pricing_tiers = get_field('pricing_tiers');
$bg_color = get_field('background_color') ?: 'none';

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['navy', 'dark-gray', 'black'])) {
    $text_class = 'text-light';
}

$block_classes = 'pricing-section';
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

if (!$pricing_tiers) {
    if ($is_preview) {
        echo '<p class="text-center">Add pricing tiers to display this block.</p>';
    }
    return;
}

/**
 * Detect the CTA link experience from the URL itself.
 * Returns: 'typeform' | 'calendly' | 'url'
 */
if (!function_exists('moust_pricing_detect_link_type')) {
    function moust_pricing_detect_link_type($url) {
        if (empty($url)) {
            return 'url';
        }
        if (preg_match('/typeform\.com\/to\/([a-zA-Z0-9]+)/', $url)) {
            return 'typeform';
        }
        if (strpos($url, 'calendly.com') !== false) {
            return 'calendly';
        }
        return 'url';
    }
}

$needs_typeform = false;
$needs_calendly = false;
foreach ($pricing_tiers as $tier_check) {
    $detected = moust_pricing_detect_link_type($tier_check['button_link'] ?? '');
    if ($detected === 'typeform') {
        $needs_typeform = true;
    } elseif ($detected === 'calendly') {
        $needs_calendly = true;
    }
}

$tier_count = count($pricing_tiers);
?>

<section class="<?php echo esc_attr($block_classes); ?>"<?php echo $custom_id ? ' id="' . esc_attr($custom_id) . '"' : ''; ?>>
    <div class="container-fluid px-4">
        <div class="pricing-inner">
            <?php if ($eyebrow || $heading || $subheading) : ?>
                <div class="pricing-header">
                    <?php if ($eyebrow) : ?>
                        <p class="pricing-eyebrow"><?php echo esc_html($eyebrow); ?></p>
                    <?php endif; ?>
                    <?php if ($heading) : ?>
                        <h2 class="pricing-heading"><?php echo esc_html($heading); ?></h2>
                    <?php endif; ?>
                    <?php if ($subheading) : ?>
                        <p class="pricing-subheading"><?php echo wp_kses_post($subheading); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($enable_annual_toggle) : ?>
                <div class="pricing-toggle-wrapper">
                    <div class="pricing-toggle">
                        <button type="button" class="pricing-toggle-option pricing-toggle-option--active" data-period="monthly">Monthly</button>
                        <button type="button" class="pricing-toggle-option" data-period="annual">Annually</button>
                    </div>
                    <?php if ($annual_savings_label) : ?>
                        <p class="pricing-toggle-savings"><?php echo esc_html($annual_savings_label); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="pricing-grid pricing-grid--<?php echo esc_attr(min($tier_count, 3)); ?>">
                <?php foreach ($pricing_tiers as $tier) :
                    $plan_name = $tier['plan_name'];
                    $tier_eyebrow = $tier['tier_eyebrow'];
                    $description = $tier['description'];
                    $badge_text = $tier['badge_text'];
                    $price = $tier['price'];
                    $annual_price = $tier['annual_price'];
                    $price_period = $tier['price_period'];
                    $price_note = $tier['price_note'];
                    $button_text = $tier['button_text'];
                    $button_link = $tier['button_link'];
                    $button_coming_soon = !empty($tier['button_coming_soon']);
                    $highlight = !empty($tier['highlight']);
                    $features = $tier['features'];

                    $card_classes = 'pricing-card';
                    if ($highlight) {
                        $card_classes .= ' pricing-card--highlight';
                    }

                    // Treat comma-formatted values (e.g., "2,000") as numeric
                    $price_numeric = is_numeric(str_replace(',', '', (string) $price));
                    $annual_price_numeric = is_numeric(str_replace(',', '', (string) $annual_price));

                    // Annual billed total
                    $annual_billing_total = $annual_price_numeric ? ((float) str_replace(',', '', $annual_price) * 12) : null;
                ?>
                    <div class="<?php echo esc_attr($card_classes); ?>">
                        <?php if ($badge_text) : ?>
                            <span class="pricing-card-badge"><?php echo esc_html($badge_text); ?></span>
                        <?php endif; ?>

                        <div class="pricing-card-header">
                            <?php if ($tier_eyebrow) : ?>
                                <p class="pricing-card-eyebrow"><?php echo esc_html($tier_eyebrow); ?></p>
                            <?php endif; ?>
                            <?php if ($plan_name) : ?>
                                <h3 class="pricing-card-title"><?php echo esc_html($plan_name); ?></h3>
                            <?php endif; ?>

                            <div class="pricing-card-price-wrapper">
                                <div class="pricing-card-price" data-period="monthly">
                                    <?php
                                    if ($price_numeric) {
                                        echo '<span class="pricing-card-currency">$</span>' . esc_html($price);
                                    } else {
                                        echo esc_html($price);
                                    }
                                    ?><?php if ($price_period) : ?><span class="pricing-card-period"><?php echo esc_html($price_period); ?></span><?php endif; ?>
                                </div>

                                <?php if ($enable_annual_toggle && isset($annual_price) && $annual_price !== '') : ?>
                                    <div class="pricing-card-price" data-period="annual" style="display: none;">
                                        <?php
                                        if ($annual_price_numeric) {
                                            echo '<span class="pricing-card-currency">$</span>' . esc_html($annual_price);
                                        } else {
                                            echo esc_html($annual_price);
                                        }
                                        ?><?php if ($price_period) : ?><span class="pricing-card-period"><?php echo esc_html($price_period); ?></span><?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($price_note) : ?>
                                    <p class="pricing-card-note" data-period="monthly"><?php echo esc_html($price_note); ?></p>
                                <?php endif; ?>

                                <?php if ($enable_annual_toggle && isset($annual_price) && $annual_price !== '') : ?>
                                    <p class="pricing-card-note" data-period="annual" style="display: none;">
                                        <?php if ($price_note) : ?><?php echo esc_html($price_note); ?><?php endif; ?>
                                        <?php if ($annual_billing_total !== null && $annual_billing_total > 0) : ?>
                                            <?php if ($price_note) : ?><span class="pricing-card-note-separator">•</span><?php endif; ?>
                                            $<?php echo esc_html(number_format($annual_billing_total, 0)); ?> billed annually
                                        <?php endif; ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <?php if ($description) : ?>
                                <p class="pricing-card-description"><?php echo esc_html($description); ?></p>
                            <?php endif; ?>
                        </div>

                        <?php if ($features) : ?>
                            <div class="pricing-card-features">
                                <ul class="pricing-features-list">
                                    <?php foreach ($features as $feature) : ?>
                                        <li class="pricing-feature">
                                            <span class="pricing-feature-icon">
                                                <svg viewBox="0 0 20 20" fill="none">
                                                    <path d="M16.6667 5L7.50004 14.1667L3.33337 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                            <span class="pricing-feature-content">
                                                <span class="pricing-feature-text"><?php echo esc_html($feature['feature_text']); ?></span>
                                                <?php if (!empty($feature['feature_note'])) : ?>
                                                    <span class="pricing-feature-note"><?php echo esc_html($feature['feature_note']); ?></span>
                                                <?php endif; ?>
                                            </span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if ($button_text) : ?>
                            <div class="pricing-card-cta">
                                <?php
                                $link_type = moust_pricing_detect_link_type($button_link);
                                $typeform_id = '';
                                if ($link_type === 'typeform') {
                                    preg_match('/typeform\.com\/to\/([a-zA-Z0-9]+)/', $button_link, $tf_matches);
                                    $typeform_id = $tf_matches[1] ?? '';
                                }
                                ?>
                                <?php if ($button_coming_soon) : ?>
                                    <button type="button" class="pricing-card-btn pricing-card-btn--disabled" disabled>
                                        <?php echo esc_html($button_text); ?>
                                    </button>
                                <?php elseif ($link_type === 'typeform' && $typeform_id) : ?>
                                    <button type="button"
                                        data-tf-popup="<?php echo esc_attr($typeform_id); ?>"
                                        data-tf-opacity="100"
                                        data-tf-size="100"
                                        data-tf-iframe-props="title=Typeform"
                                        data-tf-transitive-search-params
                                        data-tf-medium="snippet"
                                        class="hero-alt-cta-btn pricing-card-btn">
                                        <?php echo esc_html($button_text); ?>
                                        <svg class="hero-alt-cta-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </button>
                                <?php elseif ($link_type === 'calendly' && $button_link) : ?>
                                    <button type="button"
                                        class="hero-alt-cta-btn pricing-card-btn pricing-card-btn--calendly"
                                        data-calendly-url="<?php echo esc_url($button_link); ?>">
                                        <?php echo esc_html($button_text); ?>
                                        <svg class="hero-alt-cta-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </button>
                                <?php elseif ($button_link) : ?>
                                    <a href="<?php echo esc_url($button_link); ?>" class="hero-alt-cta-btn pricing-card-btn">
                                        <?php echo esc_html($button_text); ?>
                                        <svg class="hero-alt-cta-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($tier['footnote'])) : ?>
                            <p class="pricing-card-footnote"><?php echo esc_html($tier['footnote']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
            $after_content = get_field('pricing_after_content');
            if ($after_content) : ?>
                <div class="pricing-after-content">
                    <?php echo wp_kses_post($after_content); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if ($needs_typeform && !$is_preview) : ?>
<script src="//embed.typeform.com/next/embed.js"></script>
<?php endif; ?>

<?php if ($needs_calendly && !$is_preview) : ?>
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<script src="https://assets.calendly.com/assets/external/widget.js" async></script>
<?php endif; ?>
