/**
 * Customizer preview for CTA section
 */
wp.customize('kenya_cta_badge', function(value) {
    value.bind(function(newval) {
        document.querySelector('.cta-badge').textContent = newval;
    });
});
