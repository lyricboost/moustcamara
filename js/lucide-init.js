/**
 * Lucide Icons Initialization
 * Initialize all Lucide icons on page load and after AJAX updates
 */

(function() {
    'use strict';
    
    function initializeLucideIcons() {
        if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
            lucide.createIcons();
        }
    }
    
    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeLucideIcons);
    } else {
        initializeLucideIcons();
    }
    
    // Re-initialize after ACF block updates in editor
    if (typeof acf !== 'undefined') {
        acf.addAction('render_block_preview', initializeLucideIcons);
    }
})();
