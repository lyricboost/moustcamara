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

                    // Annual billed total
                    $annual_billing_total = is_numeric($annual_price) ? ($annual_price * 12) : null;
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
                                    if (is_numeric($price)) {
                                        echo '<span class="pricing-card-currency">$</span>' . esc_html($price);
                                    } else {
                                        echo esc_html($price);
                                    }
                                    ?><?php if ($price_period) : ?><span class="pricing-card-period"><?php echo esc_html($price_period); ?></span><?php endif; ?>
                                </div>

                                <?php if ($enable_annual_toggle && isset($annual_price) && $annual_price !== '') : ?>
                                    <div class="pricing-card-price" data-period="annual" style="display: none;">
                                        <?php
                                        if (is_numeric($annual_price)) {
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
                                <?php if ($button_coming_soon) : ?>
                                    <button type="button" class="pricing-card-btn pricing-card-btn--disabled" disabled>
                                        <?php echo esc_html($button_text); ?>
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
        </div>
    </div>
</section>
