jQuery(document).ready(function($) {
    // Mobile menu toggle
    $('#mobile-menu-btn').click(function() {
        $('#mobile-nav').toggleClass('hidden');
    });
    
    // Sticky header
    $(window).scroll(function() {
        if ($(window).scrollTop() > 50) {
            $('header').addClass('shadow-lg py-2');
        } else {
            $('header').removeClass('shadow-lg py-2');
        }
    });
    
    // Smooth scroll for anchor links
    $('a[href^="#"]').click(function(e) {
        e.preventDefault();
        var target = $(this.hash);
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 800);
        }
    });
});
