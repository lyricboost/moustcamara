<?php
// Fields for Split Text block
$custom_id = get_field('split_text_custom_id');
$eyebrow = get_field('split_text_eyebrow');
$heading = get_field('split_text_heading');
$heading_size = get_field('split_text_heading_size') ?: 'section';
$subheading = get_field('split_text_subheading');
$body_text = get_field('split_text_body') ?: '';
$cta_text = get_field('split_text_cta_text');
$cta_link = get_field('split_text_cta_link');
$features = get_field('split_text_features') ?: array();
$layout = get_field('split_text_layout') ?: 'text_left';
$bg_color = get_field('background_color') ?: 'none';

$text_class = '';
if (in_array($bg_color, ['navy', 'dark-gray', 'black'])) {
  $text_class = 'text-light';
}

// Heading class for size (matches other blocks)
$heading_class = $heading_size === 'page' ? ' split-heading--page' : '';

$block_classes = 'split-section split-text ' . ($layout === 'text_left' ? 'split--text-left' : 'split--text-right');
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

<section class="<?php echo esc_attr($block_classes); ?>" <?php echo $custom_id ? 'id="' . esc_attr($custom_id) . '"' : ''; ?>>
  <div class="container-fluid px-4">
    <div class="split-inner">
      <div class="row align-items-start g-5">
        <div class="col-lg-6 order-1">
          <div class="split-content<?php echo esc_attr($heading_class); ?>">
            <?php if ($eyebrow) : ?><p class="split-eyebrow"><?php echo esc_html($eyebrow); ?></p><?php endif; ?>
            <?php $heading_tag = $heading_size === 'page' ? 'h1' : 'h2'; ?>
            <<?php echo $heading_tag; ?> class="split-heading<?php echo esc_attr($heading_class); ?>"><?php echo esc_html($heading); ?></<?php echo $heading_tag; ?>>
            <?php if ($subheading) : ?><p class="split-subheading"><?php echo esc_html($subheading); ?></p><?php endif; ?>
            <?php if ($body_text) : ?><div class="split-body-text"><?php echo wp_kses_post($body_text); ?></div><?php endif; ?>
            <?php if ($cta_text && $cta_link) : ?>
              <a href="<?php echo esc_url($cta_link); ?>" class="btn btn-primary split-cta"><?php echo esc_html($cta_text); ?></a>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-lg-6 order-2">
          <div class="split-features">
            <?php if ($features) : ?>
              <ul class="product-card-features">
              <?php foreach ($features as $feature) : 
                  $title = $feature['feature_title'] ?? '';
                  $desc = $feature['feature_description'] ?? '';
                  if (empty($title) && empty($desc)) continue;
              ?>
                <li class="product-card-feature">
                  <i data-lucide="check" class="product-card-feature-icon"></i>
                  <div class="product-card-feature-inner">
                    <?php if ($title): ?><div class="feature-title"><?php echo esc_html($title); ?></div><?php endif; ?>
                    <?php if ($desc): ?><div class="feature-desc"><?php echo wp_kses_post($desc); ?></div><?php endif; ?>
                  </div>
                </li>
              <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</section>
