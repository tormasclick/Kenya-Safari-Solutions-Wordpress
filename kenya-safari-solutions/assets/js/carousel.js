// Simple carousel functionality
jQuery(document).ready(function($) {
    $('.carousel').each(function() {
        var carousel = $(this);
        var slides = carousel.find('.carousel-slide');
        var current = 0;
        var total = slides.length;
        
        if (total > 1) {
            setInterval(function() {
                slides.removeClass('active').eq(current).addClass('active');
                current = (current + 1) % total;
            }, 5000);
        }
    });
});
