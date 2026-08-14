/**
 * Contact Form Handler
 * Handles AJAX form submission without page reload
 */

document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.moust-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const messageDiv = form.querySelector('.form-message');
            const recipient = form.dataset.recipient;
            const successMsg = form.dataset.success;
            
            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';
            
            // Hide previous messages
            messageDiv.style.display = 'none';
            messageDiv.className = 'form-message mt-4';
            
            // Prepare form data
            const formData = new FormData(form);
            formData.append('action', 'submit_contact_form');
            formData.append('recipient_email', recipient);
            
            try {
                const response = await fetch(window.location.origin + '/wp-admin/admin-ajax.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Show success message
                    messageDiv.innerHTML = `
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i data-lucide="check-circle" class="me-2"></i>
                            <div>${successMsg}</div>
                        </div>
                    `;
                    messageDiv.style.display = 'block';
                    
                    // Reset form
                    form.reset();
                    
                    // Re-initialize Lucide icons
                    if (window.lucide) {
                        lucide.createIcons();
                    }
                } else {
                    // Show error message
                    messageDiv.innerHTML = `
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i data-lucide="alert-circle" class="me-2"></i>
                            <div>${result.data || 'Something went wrong. Please try again.'}</div>
                        </div>
                    `;
                    messageDiv.style.display = 'block';
                    
                    // Re-initialize Lucide icons
                    if (window.lucide) {
                        lucide.createIcons();
                    }
                }
            } catch (error) {
                // Show error message
                messageDiv.innerHTML = `
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i data-lucide="alert-circle" class="me-2"></i>
                        <div>Network error. Please try again.</div>
                    </div>
                `;
                messageDiv.style.display = 'block';
                
                // Re-initialize Lucide icons
                if (window.lucide) {
                    lucide.createIcons();
                }
            } finally {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.textContent = form.querySelector('button[type="submit"]').dataset.originalText || 'Send Message';
            }
        });
        
        // Store original button text
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn && !submitBtn.dataset.originalText) {
            submitBtn.dataset.originalText = submitBtn.textContent;
        }
    });
});
