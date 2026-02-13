/**
 * Header Scroll Effect
 * Adds transparent class to header on homepage when at top of page
 */

(function() {
    'use strict';
    
    // Only run on home page
    if (!document.body.classList.contains('home')) {
        return;
    }
    
    const header = document.querySelector('.site-header');
    if (!header) return;
    
    let ticking = false;
    
    function updateHeaderState() {
        const scrollPosition = window.scrollY || window.pageYOffset;
        const threshold = 50; // Distance from top before header becomes solid
        
        if (scrollPosition <= threshold) {
            header.classList.add('header-transparent');
        } else {
            header.classList.remove('header-transparent');
        }
        
        ticking = false;
    }
    
    function requestTick() {
        if (!ticking) {
            window.requestAnimationFrame(updateHeaderState);
            ticking = true;
        }
    }
    
    // Initial state
    updateHeaderState();
    
    // Listen to scroll events
    window.addEventListener('scroll', requestTick, { passive: true });
    
    // Update on resize (in case layout changes)
    window.addEventListener('resize', requestTick, { passive: true });
})();
