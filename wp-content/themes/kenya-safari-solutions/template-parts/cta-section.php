<?php
/**
 * CTA Section - Dynamic with Theme Options
 */

// Get CTA settings from WordPress options
$cta_badge = get_option('kenya_cta_badge', 'Ready when you are');
$cta_title = get_option('kenya_cta_title', 'Ready for your Kenya adventure?');
$cta_gradient_text = get_option('kenya_cta_gradient_text', 'Kenya adventure?');
$cta_description = get_option('kenya_cta_description', 'We\'ll design it around you. Reply in minutes — book in days.');
$cta_btn1_text = get_option('kenya_cta_btn1_text', 'Plan My Safari');
$cta_btn1_url = get_option('kenya_cta_btn1_url', '#destinations');
$cta_btn2_text = get_option('kenya_cta_btn2_text', 'Chat on WhatsApp');
$cta_bg_color = get_option('kenya_cta_bg_color', '#2a1f18');
$cta_bg_image = get_option('kenya_cta_bg_image', '');
$cta_bg_opacity = get_option('kenya_cta_bg_opacity', '20');

// Calculate opacity as decimal
$opacity_decimal = $cta_bg_opacity / 100;

// Build the title with gradient text
$gradient_display = $cta_gradient_text;

if (strpos($cta_title, $cta_gradient_text) !== false) {
    $title_before = trim(substr($cta_title, 0, strpos($cta_title, $cta_gradient_text)));
    $title_after = trim(substr($cta_title, strpos($cta_title, $cta_gradient_text) + strlen($cta_gradient_text)));
} else {
    $title_before = $cta_title;
    $title_after = '';
}
?>

<section class="relative isolate overflow-hidden px-4 py-24 md:py-32 transition-colors duration-300" 
         style="background-color: <?php echo esc_attr($cta_bg_color); ?>;">
    
    <!-- Background Image with dynamic opacity and gradient overlay -->
    <div class="absolute inset-0 -z-10">
        <?php if ($cta_bg_image): ?>
            <img src="<?php echo esc_url($cta_bg_image); ?>" alt="" class="h-full w-full object-cover" style="opacity: <?php echo esc_attr($opacity_decimal); ?>;">
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/70 to-black/60"></div>
    </div>
    
    <div class="mx-auto max-w-5xl text-center text-white">
        <!-- Badge -->
        <span class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 px-4 py-1.5 text-[11px] uppercase tracking-[0.22em] backdrop-blur-sm">
            <?php echo esc_html($cta_badge); ?>
        </span>
        
        <!-- Title with gradient text -->
        <h2 class="cta-heading mt-5 font-display text-center">
            <?php if ($title_before): ?>
                <span class="cta-text-before"><?php echo esc_html($title_before); ?> </span>
            <?php endif; ?>
            <span class="text-gradient-gold italic cta-gradient-text"><?php echo esc_html($gradient_display); ?></span>
            <?php if ($title_after): ?>
                <span class="cta-text-after"> <?php echo esc_html($title_after); ?></span>
            <?php endif; ?>
        </h2>
        
        <!-- Description -->
        <p class="mx-auto mt-5 max-w-xl text-white/90 text-sm sm:text-base">
            <?php echo esc_html($cta_description); ?>
        </p>
        
        <!-- Buttons -->
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
            <a href="<?php echo esc_url($cta_btn1_url); ?>" 
               class="group inline-flex items-center gap-2 rounded-full bg-white text-gray-900 px-5 py-2.5 sm:px-6 sm:py-3 text-xs sm:text-sm font-bold shadow-lg transition-all hover:scale-105 hover:shadow-2xl">
                <?php echo esc_html($cta_btn1_text); ?> 
                <i class="fas fa-arrow-right h-3 w-3 sm:h-4 sm:w-4 transition-transform group-hover:translate-x-1"></i>
            </a>
            <a href="#" id="cta-wa" 
               target="_blank" 
               rel="noreferrer"
               class="group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 px-5 py-2.5 sm:px-6 sm:py-3 text-xs sm:text-sm font-bold text-white shadow-lg transition-all hover:scale-105 hover:shadow-xl">
                <i class="fab fa-whatsapp h-3 w-3 sm:h-4 sm:w-4"></i> 
                <?php echo esc_html($cta_btn2_text); ?>
            </a>
        </div>
    </div>
</section>

<style>
.cta-heading {
    font-size: 2rem;
    line-height: 1.2;
}
@media (min-width: 640px) {
    .cta-heading { font-size: 2.5rem; }
}
@media (min-width: 768px) {
    .cta-heading { font-size: 3rem; }
}
@media (min-width: 1024px) {
    .cta-heading { font-size: 3.5rem; }
}
@media (min-width: 1280px) {
    .cta-heading { font-size: 4rem; }
}
.cta-text-before,
.cta-text-after,
.cta-gradient-text {
    display: inline;
}
</style>

<script>
const ctaWaMessage = "Hi, I'm ready to plan my Kenya safari!";
const ctaWaUrl = "https://wa.me/254700000000?text=" + encodeURIComponent(ctaWaMessage);
document.getElementById('cta-wa')?.setAttribute('href', ctaWaUrl);
</script>
