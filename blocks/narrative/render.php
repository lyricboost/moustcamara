<?php
/**
 * Narrative Block Template (Moust Narrative)
 *
 * A full-viewport-height carousel of narrative items. Each item pairs a
 * two-image stack (a primary image with a smaller, overlapping secondary
 * image) against a text column. Either image can optionally be wired to a
 * YouTube video, in which case it gains a subtle play-button overlay and
 * opens the shared video modal on click.
 *
 * Every field is optional — nothing is rendered as a placeholder.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$custom_id  = get_field('narrative_custom_id');
$items      = get_field('narrative_items') ?: array();
$media_side = get_field('narrative_media_side') ?: 'left';
$autoplay   = (bool) get_field('narrative_autoplay');
$interval   = (int) (get_field('narrative_autoplay_interval') ?: 7);
$bg_color   = get_field('background_color') ?: 'none';

// Set text color based on background
$text_class = '';
if (in_array($bg_color, array('navy', 'dark-gray', 'black'), true)) {
    $text_class = 'text-light';
}

$block_classes = 'narrative-section narrative-media-' . $media_side;
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

// Nothing to show yet — nudge the editor, stay silent on the front end.
if (empty($items)) {
    if ($is_preview) {
        echo '<p class="text-center">Add narrative items to display this block.</p>';
    }
    return;
}

/**
 * Pull the 11-character video ID out of any common YouTube URL format.
 */
if (!function_exists('moust_narrative_youtube_id')) {
    function moust_narrative_youtube_id($url) {
        if (empty($url)) {
            return '';
        }
        if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/|live/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $url, $m)) {
            return $m[1];
        }
        return '';
    }
}

/**
 * Render one image in the stack — as a plain figure, or as a video
 * trigger button when a YouTube URL is attached.
 */
if (!function_exists('moust_narrative_render_image')) {
    function moust_narrative_render_image($image, $video_url, $variant, $size, $eager = false, $ratio = 'landscape') {
        if (empty($image)) {
            return;
        }

        $allowed_ratios = array('landscape', 'square', 'portrait', 'natural');
        if (!in_array($ratio, $allowed_ratios, true)) {
            $ratio = 'landscape';
        }

        $youtube_id = moust_narrative_youtube_id($video_url);
        $classes    = 'narrative-image narrative-image--' . $variant
            . ' narrative-image--ratio-' . $ratio;

        // Prefer wp_get_attachment_image so we get srcset/sizes/width/height.
        $img_html = '';
        if (!empty($image['ID'])) {
            $img_html = wp_get_attachment_image(
                $image['ID'],
                $size,
                false,
                array(
                    'class'   => 'narrative-image-media',
                    'loading' => $eager ? 'eager' : 'lazy',
                )
            );
        }
        if (!$img_html && !empty($image['url'])) {
            $img_html = sprintf(
                '<img src="%s" alt="%s" class="narrative-image-media" loading="%s" />',
                esc_url($image['url']),
                esc_attr($image['alt'] ?? ''),
                $eager ? 'eager' : 'lazy'
            );
        }
        if (!$img_html) {
            return;
        }

        if ($youtube_id) {
            $label = !empty($image['alt'])
                ? sprintf(__('Play video: %s', 'moustcamara'), $image['alt'])
                : __('Play video', 'moustcamara');
            ?>
            <button type="button"
                class="<?php echo esc_attr($classes); ?> narrative-image--video video-modal-trigger"
                data-youtube-id="<?php echo esc_attr($youtube_id); ?>"
                aria-label="<?php echo esc_attr($label); ?>">
                <?php echo $img_html; ?>
                <span class="narrative-play" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5.14v13.72L19 12 8 5.14z"/></svg>
                </span>
            </button>
            <?php
        } else {
            ?>
            <figure class="<?php echo esc_attr($classes); ?>">
                <?php echo $img_html; ?>
            </figure>
            <?php
        }
    }
}

$item_count   = count($items);
$has_carousel = $item_count > 1;
$instance_id  = 'narrative-' . uniqid();
?>

<section class="<?php echo esc_attr($block_classes); ?>"<?php echo $custom_id ? ' id="' . esc_attr($custom_id) . '"' : ''; ?>>
    <div class="container-fluid px-4">
        <div class="narrative-inner"
            id="<?php echo esc_attr($instance_id); ?>"
            data-narrative
            <?php if ($autoplay && $has_carousel) : ?>
                data-narrative-autoplay="<?php echo esc_attr(max(2, $interval) * 1000); ?>"
            <?php endif; ?>
        >
            <div class="narrative-viewport">
                <?php foreach ($items as $index => $item) :
                    $eyebrow    = $item['eyebrow'] ?? '';
                    $heading    = $item['heading'] ?? '';
                    $subheading = $item['subheading'] ?? '';
                    $body       = $item['body'] ?? '';
                    $image_1    = $item['image_1'] ?? null;
                    $image_2    = $item['image_2'] ?? null;
                    $video_1    = $item['image_1_video_url'] ?? '';
                    $video_2    = $item['image_2_video_url'] ?? '';
                    $ratio_1    = $item['image_1_ratio'] ?: 'landscape';
                    $ratio_2    = $item['image_2_ratio'] ?: 'landscape';

                    // Width of the overlapping image, as a % of the media column.
                    $width_2 = $item['image_2_width'] ?? '';
                    $width_2 = is_numeric($width_2) ? (float) $width_2 : 52;
                    $width_2 = max(20, min(80, $width_2));

                    $has_media = !empty($image_1) || !empty($image_2);
                    $has_text  = $eyebrow || $heading || $subheading || $body;

                    if (!$has_media && !$has_text) {
                        continue;
                    }

                    $slide_classes = 'narrative-slide';
                    if ($index === 0) {
                        $slide_classes .= ' is-active';
                    }
                    if (!$has_media) {
                        $slide_classes .= ' narrative-slide--no-media';
                    }
                    if (!$has_text) {
                        $slide_classes .= ' narrative-slide--no-text';
                    }
                ?>
                    <article class="<?php echo esc_attr($slide_classes); ?>"
                        data-narrative-slide="<?php echo esc_attr($index); ?>"
                        <?php echo $index === 0 ? '' : 'aria-hidden="true"'; ?>>

                        <?php if ($has_media) : ?>
                            <div class="narrative-media">
                                <div class="narrative-media-stack<?php echo (!empty($image_1) && !empty($image_2)) ? '' : ' narrative-media-stack--single'; ?> narrative-media-stack--sec-<?php echo esc_attr($ratio_2); ?>"
                                    style="--narrative-sec-width: <?php echo esc_attr($width_2); ?>%;">
                                    <?php
                                    // 'full' resolves to the attachment's current file, so
                                    // images edited/cropped in the media library render as
                                    // edited. Intermediate sizes can go stale after an edit.
                                    moust_narrative_render_image($image_1, $video_1, 'primary', 'full', $index === 0, $ratio_1);
                                    moust_narrative_render_image($image_2, $video_2, 'secondary', 'full', $index === 0, $ratio_2);
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($has_text) : ?>
                            <div class="narrative-content">
                                <?php if ($eyebrow) : ?>
                                    <p class="narrative-eyebrow"><?php echo esc_html($eyebrow); ?></p>
                                <?php endif; ?>
                                <?php if ($heading) : ?>
                                    <h2 class="narrative-heading"><?php echo esc_html($heading); ?></h2>
                                <?php endif; ?>
                                <?php if ($subheading) : ?>
                                    <p class="narrative-subheading"><?php echo esc_html($subheading); ?></p>
                                <?php endif; ?>
                                <?php if ($body) : ?>
                                    <div class="narrative-body"><?php echo wp_kses_post($body); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php if ($has_carousel) : ?>
                <nav class="narrative-nav" aria-label="<?php esc_attr_e('Narrative navigation', 'moustcamara'); ?>">
                    <?php foreach ($items as $index => $item) :
                        $nav_label = !empty($item['heading'])
                            ? $item['heading']
                            : sprintf(__('Slide %d', 'moustcamara'), $index + 1);
                    ?>
                        <button type="button"
                            class="narrative-nav-item<?php echo $index === 0 ? ' is-active' : ''; ?>"
                            data-narrative-goto="<?php echo esc_attr($index); ?>"
                            aria-label="<?php echo esc_attr($nav_label); ?>"
                            <?php echo $index === 0 ? 'aria-current="true"' : ''; ?>>
                            <span class="narrative-nav-bar" aria-hidden="true"></span>
                        </button>
                    <?php endforeach; ?>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
// Shared YouTube modal — only emitted once per page, and only if needed.
if (!$is_preview) {
    $needs_modal = false;
    foreach ($items as $item) {
        if (moust_narrative_youtube_id($item['image_1_video_url'] ?? '')
            || moust_narrative_youtube_id($item['image_2_video_url'] ?? '')) {
            $needs_modal = true;
            break;
        }
    }
    if ($needs_modal) {
        get_template_part('template-parts/video-modal');
    }
}
