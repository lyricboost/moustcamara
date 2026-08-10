/**
 * Table Grid Block - Mobile Accordion & Tooltips
 */
(function() {
  'use strict';

  // Mobile accordion functionality
  function initMobileAccordion() {
    const featureHeaders = document.querySelectorAll('.table-grid-mobile__feature-header');
    
    featureHeaders.forEach(header => {
      header.addEventListener('click', function() {
        const isExpanded = this.getAttribute('aria-expanded') === 'true';
        const content = this.nextElementSibling;
        
        // Toggle this accordion
        this.setAttribute('aria-expanded', !isExpanded);
        
        if (!isExpanded) {
          content.classList.add('is-expanded');
        } else {
          content.classList.remove('is-expanded');
        }
      });
    });
  }

  // Tooltip functionality
  function initTooltips() {
    const tooltipTriggers = document.querySelectorAll('.table-grid-tooltip-trigger');
    const tooltip = document.querySelector('.table-grid-tooltip');
    
    if (!tooltip) return;
    
    let currentTrigger = null;
    
    tooltipTriggers.forEach(trigger => {
      trigger.addEventListener('mouseenter', function(e) {
        const text = this.getAttribute('data-tooltip');
        if (!text) return;
        
        currentTrigger = this;
        tooltip.textContent = text;
        tooltip.style.display = 'block';
        
        positionTooltip(e, this);
      });
      
      trigger.addEventListener('mouseleave', function() {
        tooltip.style.display = 'none';
        currentTrigger = null;
      });
      
      trigger.addEventListener('mousemove', function(e) {
        if (currentTrigger === this) {
          positionTooltip(e, this);
        }
      });
    });
    
    function positionTooltip(e, trigger) {
      const tooltipRect = tooltip.getBoundingClientRect();
      const triggerRect = trigger.getBoundingClientRect();
      
      // Position above the trigger by default
      let top = triggerRect.top - tooltipRect.height - 8;
      let left = triggerRect.left + (triggerRect.width / 2) - (tooltipRect.width / 2);
      
      // Adjust if tooltip goes off screen
      if (left < 8) {
        left = 8;
      } else if (left + tooltipRect.width > window.innerWidth - 8) {
        left = window.innerWidth - tooltipRect.width - 8;
      }
      
      // If tooltip goes above viewport, position below instead
      if (top < 8) {
        top = triggerRect.bottom + 8;
      }
      
      tooltip.style.top = top + window.scrollY + 'px';
      tooltip.style.left = left + 'px';
    }
  }

  // Initialize on DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
      initMobileAccordion();
      initTooltips();
    });
  } else {
    initMobileAccordion();
    initTooltips();
  }

  // Reinitialize on dynamic content load (for ACF preview)
  if (window.acf) {
    window.acf.addAction('render_block_preview/type=acf/table-grid', function() {
      setTimeout(function() {
        initMobileAccordion();
        initTooltips();
      }, 100);
    });
  }
})();
