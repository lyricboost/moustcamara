/**
 * External Links Handler
 * Automatically opens external links in new tab
 */
(function() {
    'use strict';
    
    function handleExternalLinks() {
        // Get current domain
        const currentDomain = window.location.hostname;
        
        // Get all links on the page
        const links = document.querySelectorAll('a[href]');
        
        links.forEach(link => {
            // Get the href attribute
            const href = link.getAttribute('href');
            
            // Skip if href is empty, a hash, or starts with mailto/tel
            if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:')) {
                return;
            }
            
            // Check if it's an external link
            try {
                const linkUrl = new URL(href, window.location.origin);
                
                // If hostname is different and not empty, it's external
                if (linkUrl.hostname && linkUrl.hostname !== currentDomain) {
                    link.setAttribute('target', '_blank');
                    link.setAttribute('rel', 'noopener noreferrer');
                }
            } catch (e) {
                // If URL parsing fails, it's likely a relative link, so skip it
                return;
            }
        });
    }
    
    // Run on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', handleExternalLinks);
    } else {
        handleExternalLinks();
    }
    
    // Re-run when ACF blocks are updated in editor
    if (window.acf) {
        window.acf.addAction('render_block_preview', handleExternalLinks);
    }
})();
