/**
 * Pricing Block - Monthly/Annual toggle
 */

document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.pricing-section');

    sections.forEach(section => {
        // Calendly popup CTAs
        section.querySelectorAll('.pricing-card-btn--calendly').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.dataset.calendlyUrl;
                if (window.Calendly && url) {
                    window.Calendly.initPopupWidget({ url: url });
                } else if (url) {
                    // Fallback if the Calendly widget hasn't loaded
                    window.open(url, '_blank', 'noopener');
                }
            });
        });

        const toggleButtons = section.querySelectorAll('.pricing-toggle-option');
        if (!toggleButtons.length) return;

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const period = this.dataset.period;

                toggleButtons.forEach(btn => btn.classList.remove('pricing-toggle-option--active'));
                this.classList.add('pricing-toggle-option--active');

                section.querySelectorAll('.pricing-card-price[data-period], .pricing-card-note[data-period]').forEach(el => {
                    el.style.display = (el.dataset.period === period) ? '' : 'none';
                });
            });
        });
    });
});
