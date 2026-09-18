/**
 * Narrative Block Carousel
 *
 * Handles slide switching for the Moust Narrative block:
 *  - perforated nav buttons (horizontal on desktop, vertical on mobile)
 *  - keyboard arrow navigation within the nav
 *  - touch swipe on the slide viewport
 *  - optional auto-advance, which pauses on hover/focus and is
 *    disabled entirely for prefers-reduced-motion users
 */
(function () {
    'use strict';

    var prefersReducedMotion = window.matchMedia
        ? window.matchMedia('(prefers-reduced-motion: reduce)')
        : { matches: false };

    function initNarrative(root) {
        if (root.dataset.narrativeReady === 'true') return;
        root.dataset.narrativeReady = 'true';

        var slides = Array.prototype.slice.call(
            root.querySelectorAll('[data-narrative-slide]')
        );
        var navItems = Array.prototype.slice.call(
            root.querySelectorAll('[data-narrative-goto]')
        );

        if (slides.length <= 1) return;

        var current = 0;
        var timer = null;
        var autoplayDelay = parseInt(root.dataset.narrativeAutoplay, 10) || 0;

        function goTo(index) {
            if (index < 0) index = slides.length - 1;
            if (index >= slides.length) index = 0;
            if (index === current) return;

            slides.forEach(function (slide, i) {
                var active = i === index;
                slide.classList.toggle('is-active', active);
                if (active) {
                    slide.removeAttribute('aria-hidden');
                } else {
                    slide.setAttribute('aria-hidden', 'true');
                }
            });

            navItems.forEach(function (item, i) {
                var active = i === index;
                item.classList.toggle('is-active', active);
                if (active) {
                    item.setAttribute('aria-current', 'true');
                } else {
                    item.removeAttribute('aria-current');
                }
            });

            current = index;
        }

        function next() {
            goTo(current + 1);
        }

        function startAuto() {
            if (!autoplayDelay || prefersReducedMotion.matches) return;
            stopAuto();
            timer = window.setInterval(next, autoplayDelay);
        }

        function stopAuto() {
            if (timer) {
                window.clearInterval(timer);
                timer = null;
            }
        }

        // Nav clicks
        navItems.forEach(function (item, index) {
            item.addEventListener('click', function () {
                goTo(index);
                stopAuto();
                startAuto();
            });
        });

        // Keyboard: arrow keys move between items when the nav has focus
        root.addEventListener('keydown', function (e) {
            if (!e.target.closest('[data-narrative-goto]')) return;

            var delta = 0;
            if (e.key === 'ArrowRight' || e.key === 'ArrowDown') delta = 1;
            if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') delta = -1;
            if (!delta) return;

            e.preventDefault();
            var target = current + delta;
            if (target < 0) target = slides.length - 1;
            if (target >= slides.length) target = 0;

            goTo(target);
            if (navItems[target]) navItems[target].focus();
            stopAuto();
            startAuto();
        });

        // Touch swipe
        var touchStartX = 0;
        var touchStartY = 0;
        var viewport = root.querySelector('.narrative-viewport') || root;

        viewport.addEventListener(
            'touchstart',
            function (e) {
                touchStartX = e.changedTouches[0].clientX;
                touchStartY = e.changedTouches[0].clientY;
            },
            { passive: true }
        );

        viewport.addEventListener(
            'touchend',
            function (e) {
                var dx = e.changedTouches[0].clientX - touchStartX;
                var dy = e.changedTouches[0].clientY - touchStartY;

                // Only treat as a swipe if it is clearly horizontal
                if (Math.abs(dx) < 50 || Math.abs(dx) < Math.abs(dy)) return;

                goTo(dx < 0 ? current + 1 : current - 1);
                stopAuto();
                startAuto();
            },
            { passive: true }
        );

        // Pause auto-advance while the user is engaging with the block
        root.addEventListener('mouseenter', stopAuto);
        root.addEventListener('mouseleave', startAuto);
        root.addEventListener('focusin', stopAuto);
        root.addEventListener('focusout', function (e) {
            if (!root.contains(e.relatedTarget)) startAuto();
        });

        // Don't run the timer while the tab is hidden
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                stopAuto();
            } else {
                startAuto();
            }
        });

        startAuto();
    }

    function initAll() {
        document.querySelectorAll('[data-narrative]').forEach(initNarrative);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }

    // Re-initialise inside the block editor preview
    if (window.acf && typeof window.acf.addAction === 'function') {
        window.acf.addAction('render_block_preview/type=narrative', function ($el) {
            var node = $el && $el[0] ? $el[0] : null;
            if (!node) return;
            node.querySelectorAll('[data-narrative]').forEach(initNarrative);
        });
    }
})();
