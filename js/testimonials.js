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
    
    // Testimonials Block Carousel (Moust Testimonials - carousel mode)
    const gridCarousels = document.querySelectorAll('.testimonials-grid-carousel');

    gridCarousels.forEach(carousel => {
        const section = carousel.closest('.testimonials-grid-section');
        const prevBtn = section ? section.querySelector('.testimonials-carousel-prev') : null;
        const nextBtn = section ? section.querySelector('.testimonials-carousel-next') : null;
        const itemsPerSlide = parseInt(carousel.dataset.itemsPerSlide) || 1;
        const items = carousel.querySelectorAll('.testimonial-grid-item');
        const totalSlides = Math.ceil(items.length / itemsPerSlide);
        let currentSlide = 0;

        if (totalSlides <= 1) {
            // Show all items when there's nothing to paginate
            items.forEach(item => {
                item.style.display = 'flex';
            });
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
            return;
        }

        function showSlide(slideIndex) {
            const start = slideIndex * itemsPerSlide;
            const end = start + itemsPerSlide;

            items.forEach((item, index) => {
                item.style.display = (index >= start && index < end) ? 'flex' : 'none';
            });

            currentSlide = slideIndex;

            if (prevBtn) prevBtn.disabled = currentSlide === 0;
            if (nextBtn) nextBtn.disabled = currentSlide >= totalSlides - 1;
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                if (currentSlide > 0) showSlide(currentSlide - 1);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                if (currentSlide < totalSlides - 1) showSlide(currentSlide + 1);
            });
        }

        showSlide(0);
    });

    // Re-initialize Lucide icons
    if (window.lucide) {
        lucide.createIcons();
    }
});
