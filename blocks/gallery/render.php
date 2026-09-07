<?php
/**
 * Gallery Block Template
 *
 * Grid of large images (2 or 3 per row) restricted by width, with
 * natural height. Images can be displayed in a box (rounded corners
 * + shadow, like the Split block) or free (no styling). Each image
 * has an optional heading and rich text description.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$custom_id = get_field('gallery_custom_id');
$eyebrow = get_field('gallery_eyebrow');
$heading = get_field('gallery_heading');
$subheading = get_field('gallery_subheading');
$columns = get_field('gallery_columns') ?: '2';
$image_style = get_field('gallery_image_style') ?: 'box';
$images = get_field('gallery_images');
$bg_color = get_field('background_color') ?: 'none';

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['navy', 'dark-gray', 'black'])) {
    $text_class = 'text-light';
}

$block_classes = 'gallery-section';
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
$block_classes .= ' gallery--' . ($image_style === 'box' ? 'box' : 'free');

$col_class = $columns === '3' ? 'col-md-6 col-lg-4' : 'col-md-6';
?>

<section class="<?php echo esc_attr($block_classes); ?>"<?php echo $custom_id ? ' id="' . esc_attr($custom_id) . '"' : ''; ?>>
    <div class="container-fluid px-4">
        <div class="gallery-inner">
            <?php if ($eyebrow || $heading || $subheading) : ?>
            <div class="gallery-header">
                <?php if ($eyebrow) : ?>
                    <p class="gallery-eyebrow text-center"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2 class="gallery-heading text-center"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($subheading) : ?>
                    <p class="gallery-subheading text-center"><?php echo wp_kses_post($subheading); ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ($images) : ?>
                <div class="row g-4 g-lg-5">
                    <?php foreach ($images as $item) :
                        $image = $item['image'] ?? null;
                        $item_heading = $item['heading'] ?? '';
                        $item_description = $item['description'] ?? '';
                        if (!$image) {
                            continue;
                        }
                    ?>
                        <div class="<?php echo esc_attr($col_class); ?>">
                            <figure class="gallery-item">
                                <button
                                    type="button"
                                    class="gallery-item-image-wrapper gallery-lightbox-trigger"
                                    data-full-src="<?php echo esc_url($image['url']); ?>"
                                    data-alt="<?php echo esc_attr($image['alt'] ?: $item_heading); ?>"
                                    aria-label="<?php echo esc_attr(sprintf(__('View larger image: %s'), $image['alt'] ?: $item_heading ?: __('Gallery image'))); ?>"
                                >
                                    <img
                                        src="<?php echo esc_url($image['url']); ?>"
                                        alt="<?php echo esc_attr($image['alt'] ?: $item_heading); ?>"
                                        class="gallery-item-image"
                                        loading="lazy"
                                    />
                                </button>
                                <?php if ($item_heading || $item_description) : ?>
                                    <figcaption class="gallery-item-content">
                                        <?php if ($item_heading) : ?>
                                            <h3 class="gallery-item-title"><?php echo esc_html($item_heading); ?></h3>
                                        <?php endif; ?>
                                        <?php if ($item_description) : ?>
                                            <div class="gallery-item-description"><?php echo wp_kses_post($item_description); ?></div>
                                        <?php endif; ?>
                                    </figcaption>
                                <?php endif; ?>
                            </figure>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
// Output the shared lightbox markup + script only once per page
global $moustcamara_gallery_lightbox_rendered;
if (empty($moustcamara_gallery_lightbox_rendered) && !$is_preview) :
    $moustcamara_gallery_lightbox_rendered = true;
?>
<div class="gallery-lightbox" id="gallery-lightbox" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Image viewer">
    <div class="gallery-lightbox-backdrop"></div>
    <div class="gallery-lightbox-stage">
        <img class="gallery-lightbox-image" src="" alt="" draggable="false" />
    </div>
    <div class="gallery-lightbox-controls">
        <button type="button" class="gallery-lightbox-btn" data-lightbox-zoom-out aria-label="Zoom out">&minus;</button>
        <button type="button" class="gallery-lightbox-btn" data-lightbox-zoom-in aria-label="Zoom in">+</button>
        <button type="button" class="gallery-lightbox-btn gallery-lightbox-close" data-lightbox-close aria-label="Close image viewer">&times;</button>
    </div>
</div>

<script>
(function() {
    if (window.moustGalleryLightboxInit) return;
    window.moustGalleryLightboxInit = true;

    document.addEventListener('DOMContentLoaded', function() {
        var lightbox = document.getElementById('gallery-lightbox');
        if (!lightbox) return;

        var img = lightbox.querySelector('.gallery-lightbox-image');
        var stage = lightbox.querySelector('.gallery-lightbox-stage');
        var backdrop = lightbox.querySelector('.gallery-lightbox-backdrop');

        var scale = 1, tx = 0, ty = 0;
        var dragging = false, startX = 0, startY = 0, lastTrigger = null;
        var MIN_SCALE = 1, MAX_SCALE = 5;

        function applyTransform() {
            img.style.transform = 'translate(' + tx + 'px, ' + ty + 'px) scale(' + scale + ')';
            img.classList.toggle('is-zoomed', scale > 1);
        }

        function resetView() {
            scale = 1; tx = 0; ty = 0;
            applyTransform();
        }

        function openLightbox(src, alt, trigger) {
            img.src = src;
            img.alt = alt || '';
            lastTrigger = trigger || null;
            resetView();
            lightbox.classList.add('is-open');
            lightbox.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            lightbox.querySelector('.gallery-lightbox-close').focus();
        }

        function closeLightbox() {
            lightbox.classList.remove('is-open');
            lightbox.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            img.src = '';
            if (lastTrigger) { lastTrigger.focus(); lastTrigger = null; }
        }

        function zoom(delta, originX, originY) {
            var prevScale = scale;
            scale = Math.min(MAX_SCALE, Math.max(MIN_SCALE, scale + delta));
            if (scale === prevScale) return;
            if (typeof originX === 'number') {
                // Zoom toward the pointer position
                var rect = stage.getBoundingClientRect();
                var cx = originX - rect.left - rect.width / 2;
                var cy = originY - rect.top - rect.height / 2;
                var ratio = scale / prevScale;
                tx = cx - (cx - tx) * ratio;
                ty = cy - (cy - ty) * ratio;
            }
            if (scale === 1) { tx = 0; ty = 0; }
            applyTransform();
        }

        // Open triggers
        document.addEventListener('click', function(e) {
            var trigger = e.target.closest('.gallery-lightbox-trigger');
            if (!trigger) return;
            e.preventDefault();
            openLightbox(trigger.getAttribute('data-full-src'), trigger.getAttribute('data-alt'), trigger);
        });

        // Close: button, backdrop, Escape
        lightbox.querySelector('[data-lightbox-close]').addEventListener('click', closeLightbox);
        backdrop.addEventListener('click', closeLightbox);
        document.addEventListener('keydown', function(e) {
            if (!lightbox.classList.contains('is-open')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === '+' || e.key === '=') zoom(0.5);
            if (e.key === '-') zoom(-0.5);
        });

        // Zoom controls
        lightbox.querySelector('[data-lightbox-zoom-in]').addEventListener('click', function() { zoom(0.5); });
        lightbox.querySelector('[data-lightbox-zoom-out]').addEventListener('click', function() { zoom(-0.5); });

        // Double-click to toggle zoom
        img.addEventListener('dblclick', function(e) {
            e.preventDefault();
            if (scale > 1) { resetView(); } else { zoom(1.5, e.clientX, e.clientY); }
        });

        // Scroll wheel zoom
        stage.addEventListener('wheel', function(e) {
            e.preventDefault();
            zoom(e.deltaY < 0 ? 0.25 : -0.25, e.clientX, e.clientY);
        }, { passive: false });

        // Drag to pan (pointer events cover mouse + touch)
        img.addEventListener('pointerdown', function(e) {
            e.preventDefault();
            dragging = true;
            startX = e.clientX - tx;
            startY = e.clientY - ty;
            img.setPointerCapture(e.pointerId);
            img.classList.add('is-dragging');
        });
        img.addEventListener('pointermove', function(e) {
            if (!dragging) return;
            tx = e.clientX - startX;
            ty = e.clientY - startY;
            applyTransform();
        });
        function endDrag() {
            dragging = false;
            img.classList.remove('is-dragging');
        }
        img.addEventListener('pointerup', endDrag);
        img.addEventListener('pointercancel', endDrag);

        // Clicking empty stage area (not the image) closes too
        stage.addEventListener('click', function(e) {
            if (e.target === stage) closeLightbox();
        });
    });
})();
</script>
<?php endif; ?>
