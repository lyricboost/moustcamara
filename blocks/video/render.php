<?php
/**
 * Video Block Template
 *
 * Cloned from the Split block. The image side is a 16:9 clickable
 * video cover (custom cover image or automatic YouTube thumbnail)
 * with a play button overlay. Clicking opens the YouTube video in
 * a modal.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Get ACF fields
$custom_id = get_field('video_custom_id');
$youtube_url = get_field('video_youtube_url');
$cover_image = get_field('video_cover_image');
$eyebrow = get_field('video_eyebrow');
$heading = get_field('video_heading');
$heading_size = get_field('video_heading_size') ?: 'section';
$subheading = get_field('video_subheading');
$body_text = get_field('video_body_text') ?: '';
$topics = get_field('video_topics') ?: array();
$video_position = get_field('video_position') ?: 'left';
$video_breakout = get_field('video_breakout');
$cta_text = get_field('video_cta_text');
$cta_link = get_field('video_cta_link');
$bg_color = get_field('background_color') ?: 'none';

// Extract the YouTube video ID from any common URL format
$youtube_id = '';
if ($youtube_url) {
    if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/|live/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $youtube_url, $m)) {
        $youtube_id = $m[1];
    }
}

// Cover: custom image, or fall back to the YouTube thumbnail
$cover_url = '';
$cover_alt = '';
if ($cover_image) {
    $cover_url = $cover_image['url'];
    $cover_alt = $cover_image['alt'] ?: $heading;
} elseif ($youtube_id) {
    $cover_url = 'https://i.ytimg.com/vi/' . $youtube_id . '/maxresdefault.jpg';
    $cover_alt = $heading;
}

// Set text color based on background
$text_class = '';
if (in_array($bg_color, ['navy', 'dark-gray', 'black'])) {
    $text_class = 'text-light';
}

$block_classes = 'video-section split-section split-' . $video_position;
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
if ($video_breakout) {
    $block_classes .= ' split-section--breakout';
}

// The clickable 16:9 video cover
ob_start();
?>
<div class="video-cover-col d-flex justify-content-center justify-content-lg-<?php echo $video_position === 'left' ? 'start' : 'end'; ?>">
    <button
        type="button"
        class="video-cover video-modal-trigger"
        data-youtube-id="<?php echo esc_attr($youtube_id); ?>"
        aria-label="<?php echo esc_attr(sprintf(__('Play video: %s'), $heading ?: __('Video'))); ?>"
        <?php echo $youtube_id ? '' : 'disabled'; ?>
    >
        <?php if ($cover_url) : ?>
            <img src="<?php echo esc_url($cover_url); ?>" alt="<?php echo esc_attr($cover_alt); ?>" class="video-cover-image" loading="lazy" />
        <?php endif; ?>
        <span class="video-cover-play" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5.14v13.72L19 12 8 5.14z"/></svg>
        </span>
    </button>
</div>
<?php
$video_cover_html = ob_get_clean();
?>

<section class="<?php echo esc_attr($block_classes); ?>"<?php echo $custom_id ? ' id="' . esc_attr($custom_id) . '"' : ''; ?>>
    <div class="container-fluid px-4">
        <div class="split-inner">
            <div class="row g-5 <?php echo $video_breakout ? 'align-items-center align-items-lg-start' : 'align-items-center'; ?>">
                <?php if ($video_position === 'left') : ?>
                    <div class="col-lg-6 order-2 order-lg-1">
                        <?php echo $video_cover_html; ?>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2">
                <?php else : ?>
                    <div class="col-lg-6 order-1">
                <?php endif; ?>
                        <div class="split-content">
                            <?php if ($eyebrow) : ?>
                                <p class="split-eyebrow"><?php echo esc_html($eyebrow); ?></p>
                            <?php endif; ?>
                            <?php
                            $heading_tag = $heading_size === 'page' ? 'h1' : 'h2';
                            $heading_class = 'split-heading' . ($heading_size === 'page' ? ' split-heading--page' : '');
                            ?>
                            <?php if ($heading) : ?>
                                <<?php echo $heading_tag; ?> class="<?php echo esc_attr($heading_class); ?>"><?php echo esc_html($heading); ?></<?php echo $heading_tag; ?>>
                            <?php endif; ?>
                            <?php if ($subheading) : ?>
                                <p class="split-subheading"><?php echo esc_html($subheading); ?></p>
                            <?php endif; ?>
                            <?php if ($body_text) : ?>
                                <div class="split-body-text"><?php echo wp_kses_post($body_text); ?></div>
                            <?php endif; ?>
                            <?php if ($topics) : ?>
                                <ul class="split-topics-list">
                                    <?php foreach ($topics as $topic) : ?>
                                        <li class="split-topic-item">
                                            <i data-lucide="check" class="split-topic-icon"></i>
                                            <span><?php echo esc_html($topic['topic_text']); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <?php if ($cta_text && $cta_link) : ?>
                                <a href="<?php echo esc_url($cta_link); ?>" class="hero-alt-cta-btn">
                                    <?php echo esc_html($cta_text); ?>
                                    <svg class="hero-alt-cta-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php if ($video_position === 'right') : ?>
                    <div class="col-lg-6 order-2">
                        <?php echo $video_cover_html; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
// Output the shared video modal markup + script only once per page
global $moustcamara_video_modal_rendered;
if (empty($moustcamara_video_modal_rendered) && !$is_preview) :
    $moustcamara_video_modal_rendered = true;
?>
<div class="video-modal" id="video-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Video player">
    <div class="video-modal-backdrop"></div>
    <div class="video-modal-dialog">
        <button type="button" class="video-modal-close" data-video-modal-close aria-label="Close video">&times;</button>
        <div class="video-modal-frame-wrapper">
            <iframe
                class="video-modal-iframe"
                src=""
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
            ></iframe>
        </div>
    </div>
</div>

<script>
(function() {
    if (window.moustVideoModalInit) return;
    window.moustVideoModalInit = true;

    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('video-modal');
        if (!modal) return;

        var iframe = modal.querySelector('.video-modal-iframe');
        var backdrop = modal.querySelector('.video-modal-backdrop');
        var closeBtn = modal.querySelector('[data-video-modal-close]');
        var lastTrigger = null;

        function openModal(youtubeId, trigger) {
            if (!youtubeId) return;
            lastTrigger = trigger || null;
            iframe.src = 'https://www.youtube-nocookie.com/embed/' + encodeURIComponent(youtubeId) + '?autoplay=1&rel=0';
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            closeBtn.focus();
        }

        function closeModal() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            iframe.src = ''; // Stop playback
            if (lastTrigger) { lastTrigger.focus(); lastTrigger = null; }
        }

        document.addEventListener('click', function(e) {
            var trigger = e.target.closest('.video-modal-trigger');
            if (!trigger) return;
            e.preventDefault();
            openModal(trigger.getAttribute('data-youtube-id'), trigger);
        });

        closeBtn.addEventListener('click', closeModal);
        backdrop.addEventListener('click', closeModal);
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
        });
    });
})();
</script>
<?php endif; ?>
