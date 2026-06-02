jQuery(document).ready(function($) {
    // Smooth scroll
    $('a[href^="#"]').not('[href="#"]').click(function(e) {
        e.preventDefault();
        var target = $(this.hash);
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 800);
        }
    });
    
    // Mobile menu
    $('#mobile-menu-btn').click(function() {
        $('#mobile-menu').toggleClass('hidden');
    });
});
// Check dark mode status
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dark mode enabled:', document.documentElement.classList.contains('dark'));
});
