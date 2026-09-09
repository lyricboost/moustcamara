<?php
/**
 * Stats Block Template
 *
 * Cloned from the Grid Items block. Displays a clean grid of large
 * statistics with optional prefix/suffix (Lucide icon or manual text)
 * and a description label under each stat.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$custom_id = get_field('stats_custom_id');
$eyebrow = get_field('stats_eyebrow');
$heading_line_1 = get_field('stats_heading_line_1');
$heading_line_2 = get_field('stats_heading_line_2');
$heading_line_1_muted = get_field('stats_heading_line_1_muted');
$heading_size = get_field('stats_heading_size') ?: 'large';
$subheading = get_field('stats_subheading');
$columns_desktop = get_field('stats_columns_desktop') ?: '4';
$columns_mobile = get_field('stats_columns_mobile') ?: '2';
$items = get_field('stats_items');
$bg_color = get_field('background_color') ?: 'none';

// Map affix icon choices to Lucide icon names
$lucide_icon_map = array(
    'dollar'     => 'dollar-sign',
    'percent'    => 'percent',
    'plus'       => 'plus',
    'minus'      => 'minus',
    'x'          => 'x',
    'arrow-down' => 'arrow-down',
    'arrow-up'   => 'arrow-up',
);

/**
 * Render a stat affix (prefix or suffix): a Lucide icon or manual text.
 */
$render_affix = function ($type, $text, $position) use ($lucide_icon_map) {
    if (empty($type) || $type === 'none') {
        return '';
    }
    if ($type === 'text') {
        if ($text === '' || $text === null) {
            return '';
        }
        return '<span class="stats-item-affix stats-item-affix--' . esc_attr($position) . '">' . esc_html($text) . '</span>';
    }
    if (isset($lucide_icon_map[$type])) {
        return '<span class="stats-item-affix stats-item-affix--' . esc_attr($position) . '"><i data-lucide="' . esc_attr($lucide_icon_map[$type]) . '" class="stats-item-affix-icon"></i></span>';
    }
    return '';
};

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['navy', 'dark-gray', 'black'])) {
    $text_class = 'text-light';
}

$block_classes = 'stats-section';
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
$block_classes .= ' stats--desktop-' . $columns_desktop;
$block_classes .= ' stats--mobile-' . $columns_mobile;

// Column classes: mobile (default) + desktop (lg)
$col_class = ($columns_mobile === '1' ? 'col-12' : 'col-6');
if ($columns_desktop === '2') {
    $col_class .= ' col-lg-6';
} elseif ($columns_desktop === '3') {
    $col_class .= ' col-lg-4';
} else {
    $col_class .= ' col-lg-3';
}
?>

<section class="<?php echo esc_attr($block_classes); ?>"<?php echo $custom_id ? ' id="' . esc_attr($custom_id) . '"' : ''; ?>>
    <div class="container-fluid px-4">
        <div class="stats-inner">
            <?php if ($eyebrow || $heading_line_1 || $heading_line_2 || $subheading) : ?>
            <div class="stats-header">
                <?php if ($eyebrow) : ?>
                    <p class="stats-eyebrow text-center"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>
                <?php if ($heading_line_1) : ?>
                <h2 class="stats-heading<?php echo $heading_size === 'medium' ? ' stats-heading--medium' : ''; ?> text-center">
                    <span class="stats-heading-line-1<?php echo $heading_line_1_muted ? ' stats-heading-muted' : ''; ?>"><?php echo esc_html($heading_line_1); ?></span>
                    <?php if ($heading_line_2) : ?>
                        <span class="stats-heading-line-2"><?php echo esc_html($heading_line_2); ?></span>
                    <?php endif; ?>
                </h2>
                <?php endif; ?>
                <?php if ($subheading) : ?>
                    <p class="stats-subheading text-center"><?php echo wp_kses_post($subheading); ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ($items) : ?>
                <div class="row gy-5 gx-4">
                    <?php foreach ($items as $item) :
                        $stat_value = $item['stat_value'] ?? '';
                        $prefix_type = $item['prefix_type'] ?? 'none';
                        $prefix_text = $item['prefix_text'] ?? '';
                        $suffix_type = $item['suffix_type'] ?? 'none';
                        $suffix_text = $item['suffix_text'] ?? '';
                        $stat_label = $item['stat_label'] ?? '';
                    ?>
                        <div class="<?php echo esc_attr($col_class); ?>">
                            <div class="stats-item">
                                <div class="stats-item-value-row">
                                    <?php echo $render_affix($prefix_type, $prefix_text, 'prefix'); ?>
                                    <span class="stats-item-value"><?php echo esc_html($stat_value); ?></span>
                                    <?php echo $render_affix($suffix_type, $suffix_text, 'suffix'); ?>
                                </div>
                                <?php if ($stat_label) : ?>
                                    <p class="stats-item-label"><?php echo esc_html($stat_label); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
