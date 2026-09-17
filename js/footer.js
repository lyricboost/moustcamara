/**
 * Footer - Newsletter signup + mobile accordion columns
 */

document.addEventListener('DOMContentLoaded', function() {
    // --- Newsletter signup (uses the mailing_list_signup AJAX handler) ---
    const form = document.getElementById('footer-newsletter-form');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitButton = form.querySelector('.footer-newsletter-submit');
            const messageDiv = form.querySelector('.footer-newsletter-message');
            const originalHtml = submitButton.innerHTML;

            submitButton.disabled = true;
            submitButton.textContent = 'Subscribing...';
            messageDiv.style.display = 'none';

            const formData = new FormData(form);
            formData.append('action', 'mailing_list_signup');

            try {
                const response = await fetch((window.moustFooter && moustFooter.ajaxUrl) || '/wp-admin/admin-ajax.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                messageDiv.className = 'footer-newsletter-message footer-newsletter-message--' + (result.success ? 'success' : 'error');
                messageDiv.textContent = (result.data && result.data.message) || (result.success ? 'Thank you for subscribing!' : 'Something went wrong. Please try again.');
                messageDiv.style.display = 'block';
                if (result.success) form.reset();
            } catch (error) {
                messageDiv.className = 'footer-newsletter-message footer-newsletter-message--error';
                messageDiv.textContent = 'Network error. Please try again.';
                messageDiv.style.display = 'block';
            } finally {
                submitButton.disabled = false;
                submitButton.innerHTML = originalHtml;
            }
        });
    }

    // --- Link columns: open on desktop, accordion on mobile ---
    const footerCols = document.querySelectorAll('.footer-col');
    const mq = window.matchMedia('(max-width: 767px)');

    function syncFooterCols() {
        footerCols.forEach(col => {
            if (mq.matches) {
                col.removeAttribute('open');
            } else {
                col.setAttribute('open', '');
            }
        });
    }

    if (footerCols.length) {
        syncFooterCols();
        mq.addEventListener('change', syncFooterCols);

        // Prevent toggling on desktop
        footerCols.forEach(col => {
            const summary = col.querySelector('.footer-col-title');
            if (summary) {
                summary.addEventListener('click', function(e) {
                    if (!mq.matches) {
                        e.preventDefault();
                    }
                });
            }
        });
    }

    // Render Lucide icons in footer
    if (window.lucide) {
        lucide.createIcons();
    }
});
