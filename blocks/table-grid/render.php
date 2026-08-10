<?php
/**
 * Table Grid Block Template
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$custom_id = get_field('table_custom_id');
$heading = get_field('table_heading');
$subheading = get_field('table_subheading');
$heading_size = get_field('table_heading_size') ?: 'large';
$reduced_padding = get_field('table_reduced_padding');
$padding_class = $reduced_padding ? ' table-grid-section--reduced-padding' : '';
$columns = get_field('table_columns');
$feature_groups = get_field('table_feature_groups');
$bg_color = get_field('background_color') ?: 'none';

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['dark-gray', 'black'])) {
    $text_class = 'text-light';
}

// Fallback: pull button_variant from sub fields in case repeater array misses it
$column_variants = [];
if (have_rows('table_columns')) {
    $col_index = 0;
    while (have_rows('table_columns')) {
        the_row();
        $column_variants[$col_index] = get_sub_field('button_variant');
        $col_index++;
    }
}

if (!$columns || !$feature_groups) {
    return;
}

$block_classes = 'table-grid-section';
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
$block_classes .= $padding_class;

$heading_class = $heading_size === 'medium' ? ' table-grid-heading--medium' : '';
?>

<section class="<?php echo esc_attr($block_classes); ?>"<?php echo $custom_id ? ' id="' . esc_attr($custom_id) . '"' : ''; ?>>
    <div class="container-fluid px-4">
        <?php if ($heading || $subheading): ?>
            <div class="table-grid-header<?php echo esc_attr($heading_class); ?>">
                <?php if ($heading): ?>
                    <h2 class="table-grid-heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($subheading): ?>
                    <p class="table-grid-subheading"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="table-grid-wrapper">
            <table class="table-grid">
                <thead>
                    <tr>
                        <th class="table-grid__corner">
                            <?php 
                            // Show first feature group name in header
                            if (!empty($feature_groups[0]['group_name'])) {
                                echo esc_html($feature_groups[0]['group_name']);
                            }
                            ?>
                        </th>
                        <?php foreach ($columns as $col_index => $column): 
                            $highlight_class = $column['highlight'] ? ' table-grid__column--highlight' : '';
                        ?>
                            <th class="table-grid__column<?php echo esc_attr($highlight_class); ?>">
                                <?php echo esc_html($column['column_name']); ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feature_groups as $group_index => $group): ?>
                        <?php if ($group_index > 0): ?>
                            <tr class="table-grid__group-row">
                                <td colspan="<?php echo count($columns) + 1; ?>" class="table-grid__group-name">
                                    <?php echo esc_html($group['group_name']); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($group['features'])): ?>
                            <?php foreach ($group['features'] as $feature): ?>
                                <tr class="table-grid__feature-row">
                                    <td class="table-grid__feature-name">
                                        <span><?php echo esc_html($feature['feature_name']); ?></span>
                                        <?php if (!empty($feature['tooltip'])): ?>
                                            <span class="table-grid-tooltip-trigger" data-tooltip="<?php echo esc_attr($feature['tooltip']); ?>">
                                                <i data-lucide="help-circle" class="table-grid-tooltip-icon"></i>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <?php 
                                    $values = $feature['values'] ?: [];
                                    foreach ($columns as $index => $column): 
                                        $value = $values[$index] ?? ['type' => 'none'];
                                        $highlight_class = $column['highlight'] ? ' table-grid__cell--highlight' : '';
                                    ?>
                                        <td class="table-grid__cell<?php echo esc_attr($highlight_class); ?>">
                                            <?php if ($value['type'] === 'checkmark'): ?>
                                                <i data-lucide="check-circle-2" class="table-grid-checkmark"></i>
                                            <?php elseif ($value['type'] === 'text'): ?>
                                                <?php echo esc_html($value['text']); ?>
                                            <?php else: ?>
                                                <span class="table-grid-dash">—</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    
                    <!-- Button row -->
                    <tr class="table-grid__button-row">
                        <td></td>
                        <?php foreach ($columns as $col_index => $column): 
                            $highlight_class = $column['highlight'] ? ' table-grid__cell--highlight' : '';
                            $button_variant_raw = $column['button_variant'] ?? ($column['button_style'] ?? null);
                            if (empty($button_variant_raw) && isset($column_variants[$col_index])) {
                                $button_variant_raw = $column_variants[$col_index];
                            }
                            if (is_array($button_variant_raw)) {
                                $button_variant = $button_variant_raw['value'] ?? ($button_variant_raw['label'] ?? '');
                            } else {
                                $button_variant = $button_variant_raw;
                            }
                            $button_variant = is_string($button_variant) ? strtolower(trim($button_variant)) : $button_variant;
                            $button_secondary = $column['button_secondary'] ?? false;
                            $button_is_disabled = ($button_variant === 'disabled') || !empty($column['button_coming_soon']);
                            $button_class = ($button_variant === 'secondary' || $button_secondary) ? 'hero-alt-cta-btn hero-alt-cta-btn--secondary' : 'hero-alt-cta-btn';
                        ?>
                            <td class="table-grid__cell<?php echo esc_attr($highlight_class); ?>">
                                <?php if ($column['button_text']): ?>
                                    <?php if ($button_is_disabled): ?>
                                        <button class="hero-alt-cta-btn hero-alt-cta-btn--disabled" disabled>
                                            <?php echo esc_html($column['button_text']); ?>
                                        </button>
                                    <?php else: ?>
                                        <a href="<?php echo esc_url($column['button_link']); ?>" class="<?php echo esc_attr($button_class); ?>">
                                            <?php echo esc_html($column['button_text']); ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Mobile Accordion View -->
        <div class="table-grid-mobile">
            <?php foreach ($feature_groups as $group_index => $group): ?>
                <?php if ($group_index > 0): ?>
                    <div class="table-grid-mobile__group-name">
                        <?php echo esc_html($group['group_name']); ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($group['features'])): ?>
                    <?php foreach ($group['features'] as $feature): ?>
                        <div class="table-grid-mobile__feature">
                            <button class="table-grid-mobile__feature-header" aria-expanded="false">
                                <span class="table-grid-mobile__feature-name">
                                    <?php echo esc_html($feature['feature_name']); ?>
                                    <?php if (!empty($feature['tooltip'])): ?>
                                        <span class="table-grid-tooltip-trigger" data-tooltip="<?php echo esc_attr($feature['tooltip']); ?>">
                                            <i data-lucide="help-circle" class="table-grid-tooltip-icon"></i>
                                        </span>
                                    <?php endif; ?>
                                </span>
                                <i data-lucide="chevron-down" class="table-grid-mobile__chevron"></i>
                            </button>
                            <div class="table-grid-mobile__feature-content">
                                <div class="table-grid-mobile__columns">
                                    <?php 
                                    $values = $feature['values'] ?: [];
                                    foreach ($columns as $index => $column): 
                                        $value = $values[$index] ?? ['type' => 'none'];
                                    ?>
                                        <div class="table-grid-mobile__column">
                                            <div class="table-grid-mobile__column-name"><?php echo esc_html($column['column_name']); ?></div>
                                            <div class="table-grid-mobile__column-value">
                                                <?php if ($value['type'] === 'checkmark'): ?>
                                                    <i data-lucide="check-circle-2" class="table-grid-checkmark"></i>
                                                <?php elseif ($value['type'] === 'text'): ?>
                                                    <?php echo esc_html($value['text']); ?>
                                                <?php else: ?>
                                                    <span class="table-grid-dash">—</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            
            <!-- Mobile Buttons -->
            <div class="table-grid-mobile__buttons">
                <?php foreach ($columns as $col_index => $column): 
                    $button_variant_raw = $column['button_variant'] ?? ($column['button_style'] ?? null);
                    if (empty($button_variant_raw) && isset($column_variants[$col_index])) {
                        $button_variant_raw = $column_variants[$col_index];
                    }
                    if (is_array($button_variant_raw)) {
                        $button_variant = $button_variant_raw['value'] ?? ($button_variant_raw['label'] ?? '');
                    } else {
                        $button_variant = $button_variant_raw;
                    }
                    $button_variant = is_string($button_variant) ? strtolower(trim($button_variant)) : $button_variant;
                    $button_secondary = $column['button_secondary'] ?? false;
                    $button_is_disabled = ($button_variant === 'disabled') || !empty($column['button_coming_soon']);
                    $button_class = ($button_variant === 'secondary' || $button_secondary) ? 'hero-alt-cta-btn hero-alt-cta-btn--secondary' : 'hero-alt-cta-btn';
                ?>
                    <div class="table-grid-mobile__button-wrapper">
                        <div class="table-grid-mobile__button-label"><?php echo esc_html($column['column_name']); ?></div>
                        <?php if ($column['button_text']): ?>
                            <?php if ($button_is_disabled): ?>
                                <button class="hero-alt-cta-btn hero-alt-cta-btn--disabled" disabled>
                                    <?php echo esc_html($column['button_text']); ?>
                                </button>
                            <?php else: ?>
                                <a href="<?php echo esc_url($column['button_link']); ?>" class="<?php echo esc_attr($button_class); ?>">
                                    <?php echo esc_html($column['button_text']); ?>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tooltip container -->
        <div class="table-grid-tooltip" role="tooltip" style="display: none;"></div>
    </div>
</section>

<script>
  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }
</script>
