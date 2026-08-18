/**
 * Testimonials Carousel
 */

document.addEventListener('DOMContentLoaded', function() {
    const carousels = document.querySelectorAll('.testimonials-carousel');
    
    carousels.forEach(carousel => {
        const wrapper = carousel.closest('.testimonials-carousel-wrapper');
        const prevBtn = wrapper.querySelector('.carousel-prev');
        const nextBtn = wrapper.querySelector('.carousel-next');
        const itemsPerPage = parseInt(carousel.dataset.itemsPerPage) || 1;
        const items = carousel.querySelectorAll('.testimonial-item');
        const totalItems = items.length;
        let currentPage = 0;
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        
        if (totalPages <= 1) {
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
            return;
        }
        
        function showPage(pageIndex) {
            items.forEach((item, index) => {
                const startIndex = pageIndex * itemsPerPage;
                const endIndex = startIndex + itemsPerPage;
                
                if (index >= startIndex && index < endIndex) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            
            currentPage = pageIndex;
            
            // Update button states
            if (prevBtn) {
                prevBtn.disabled = currentPage === 0;
            }
            if (nextBtn) {
                nextBtn.disabled = currentPage >= totalPages - 1;
            }
        }
        
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                if (currentPage > 0) {
                    showPage(currentPage - 1);
                }
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                if (currentPage < totalPages - 1) {
                    showPage(currentPage + 1);
                }
            });
        }
        
        // Initialize
        showPage(0);
    });
    
    // Re-initialize Lucide icons
    if (window.lucide) {
        lucide.createIcons();
    }
});
