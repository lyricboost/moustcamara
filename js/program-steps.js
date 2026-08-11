/**
 * Program Steps Block - Mobile Accordion Functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize mobile accordion
    const mobileSteps = document.querySelectorAll('.program-step-mobile-header');
    
    mobileSteps.forEach(function(header) {
        header.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            // Toggle aria-expanded
            this.setAttribute('aria-expanded', !isExpanded);
            
            // Toggle content visibility
            if (isExpanded) {
                content.classList.remove('is-expanded');
            } else {
                content.classList.add('is-expanded');
            }
        });
    });
    
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
