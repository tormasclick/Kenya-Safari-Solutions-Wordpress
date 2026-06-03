<?php
/**
 * Testimonials Section - EXACT match to Next.js Testimonials.tsx
 */
?>

<section class="relative px-4 py-24 md:py-32" style="background-color: var(--section-testimonials, #f7ebe3); transition: background-color 0.3s ease;">
    <div class="mx-auto max-w-7xl">
        <!-- Section Header -->
        <div class="max-w-2xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 text-[11px] uppercase tracking-[0.22em] text-amber-600 dark:text-amber-400 font-bold">
                <span class="h-px w-8 bg-amber-500"></span> Travelers
            </div>
            <h2 class="mt-4 font-display text-4xl leading-[1.05] md:text-5xl font-bold text-foreground">
                What guests carry home.
            </h2>
        </div>

        <!-- Horizontal Scrollable Testimonials -->
        <div id="testimonials-scroller" 
             class="mt-12 flex snap-x snap-mandatory cursor-grab gap-5 overflow-x-auto pb-6 active:cursor-grabbing"
             style="scrollbar-width: none;">
            <?php
            $testimonials = get_posts(array(
                'post_type' => 'testimonial',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            
            if ($testimonials):
                $i = 0;
                foreach ($testimonials as $testimonial):
                    $client_name = get_post_meta($testimonial->ID, '_testimonial_client_name', true);
                    if (!$client_name) $client_name = $testimonial->post_title;
                    $client_origin = get_post_meta($testimonial->ID, '_testimonial_client_origin', true);
                    $rating = get_post_meta($testimonial->ID, '_testimonial_rating', true);
                    if (!$rating) $rating = 5;
                    $text = get_post_meta($testimonial->ID, '_testimonial_text', true);
                    if (!$text) $text = $testimonial->post_content;
            ?>
                <article class="hover-lift relative testimonial-card w-[88%] shrink-0 snap-center rounded-3xl border border-gray-200 dark:border-[#3f2c21] bg-white dark:bg-[#241710] p-7 sm:w-[420px]"
                         style="animation: fade-up 0.7s <?php echo $i * 70; ?>ms both ease-out">
                    <div class="flex gap-0.5 text-amber-500">
                        <?php for ($s = 1; $s <= 5; $s++): ?>
                            <?php if ($s <= $rating): ?>
                                <i class="fas fa-star h-4 w-4"></i>
                            <?php else: ?>
                                <i class="far fa-star h-4 w-4"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <p class="mt-4 font-display text-xl leading-snug text-gray-900 dark:text-white">"<?php echo esc_html($text); ?>"</p>
                    <div class="mt-5 text-sm">
                        <div class="font-medium text-gray-900 dark:text-white"><?php echo esc_html($client_name); ?></div>
                        <div class="text-gray-600 dark:text-gray-400"><?php echo esc_html($client_origin); ?></div>
                    </div>
                </article>
            <?php 
                    $i++;
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>

<script>
// Drag-to-scroll functionality - EXACT match to Next.js
document.addEventListener('DOMContentLoaded', function() {
    const scroller = document.getElementById('testimonials-scroller');
    
    if (scroller) {
        let isDown = false;
        let startX;
        let startScroll;
        
        scroller.addEventListener('mousedown', (e) => {
            isDown = true;
            startX = e.pageX;
            startScroll = scroller.scrollLeft;
            scroller.style.cursor = 'grabbing';
        });
        
        scroller.addEventListener('mouseleave', () => {
            isDown = false;
            scroller.style.cursor = 'grab';
        });
        
        scroller.addEventListener('mouseup', () => {
            isDown = false;
            scroller.style.cursor = 'grab';
        });
        
        scroller.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX;
            const walk = (x - startX) * 1.5;
            scroller.scrollLeft = startScroll - walk;
        });
        
        scroller.style.cursor = 'grab';
    }
});
</script>

<style>
.hover-lift {
    transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.4s;
}
.hover-lift:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1);
}
</style>
