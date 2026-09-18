<?php
/**
 * Shared YouTube Video Modal
 *
 * Rendered at most once per page request. Any block can opt in by
 * outputting a trigger with the `video-modal-trigger` class and a
 * `data-youtube-id` attribute, then calling:
 *
 *     get_template_part('template-parts/video-modal');
 *
 * @package MoustCamara
 */

global $moustcamara_video_modal_rendered;

if (!empty($moustcamara_video_modal_rendered)) {
    return;
}

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
