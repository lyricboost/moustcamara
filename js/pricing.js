/**
 * Pricing Block - Monthly/Annual toggle
 */

document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.pricing-section');

    sections.forEach(section => {
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
