<?php
/**
 * Featured Accommodations Section - Uses CSS variables for dark mode
 */
?>

<section class="relative px-4 py-24 md:py-32" style="background-color: var(--section-marine, #f7ebe3); transition: background-color 0.3s ease;">
    <div class="mx-auto max-w-7xl">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 text-[11px] uppercase tracking-[0.22em] text-amber-600 dark:text-amber-400 font-bold">
                <span class="h-px w-8 bg-amber-500"></span> Premium Stays
            </div>
            <h2 class="mt-4 font-display text-4xl leading-[1.05] md:text-5xl font-bold" style="color: var(--foreground, #1a1a1a);">
                Where Luxury Meets Adventure
            </h2>
            <p class="mt-3 dark:text-white" style="color: var(--muted-foreground, #6b7280);">
                Experience exceptional comfort at our hand-picked accommodations across Kenya's most spectacular destinations
            </p>
        </div>

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php
            $accommodations = get_posts(array(
                'post_type' => 'accommodation',
                'posts_per_page' => 6,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            
            if ($accommodations):
                $idx = 0;
                foreach ($accommodations as $acc):
                    $image = get_the_post_thumbnail_url($acc->ID, 'large');
                    if (!$image) {
                        $image = get_template_directory_uri() . '/assets/images/accommodations/' . $acc->post_name . '.jpg';
                    }
                    
                    $tagline = get_post_meta($acc->ID, '_accommodation_tagline', true);
                    $location = get_post_meta($acc->ID, '_accommodation_location', true);
                    $price_range = get_post_meta($acc->ID, '_accommodation_price_range', true);
                    $type = get_post_meta($acc->ID, '_accommodation_type', true);
                    $rating = get_post_meta($acc->ID, '_accommodation_rating', true);
            ?>
                <a href="<?php echo get_permalink($acc->ID); ?>" 
                   class="group rounded-2xl overflow-hidden bg-white dark:bg-[#241710] shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-200 dark:border-[#3f2c21]"
                   style="animation: fade-up 0.7s <?php echo $idx * 60; ?>ms both ease-out">
                    
                    <div class="relative h-56 overflow-hidden">
                        <img src="<?php echo esc_url($image); ?>" 
                             alt="<?php echo esc_attr(get_the_title($acc->ID)); ?>" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-lg text-xs font-semibold bg-amber-500/90 backdrop-blur-sm text-white">
                                <?php echo esc_html($type); ?>
                            </span>
                        </div>
                        
                        <div class="absolute top-4 right-4 flex gap-1">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= $rating): ?>
                                    <i class="fas fa-star h-3 w-3 text-amber-500"></i>
                                <?php else: ?>
                                    <i class="far fa-star h-3 w-3 text-amber-500"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <h3 class="font-display text-xl font-bold text-gray-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition">
                            <?php echo esc_html(get_the_title($acc->ID)); ?>
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1"><?php echo esc_html($location); ?></p>
                        <p class="text-xs text-amber-600 dark:text-amber-400 mt-2 font-semibold"><?php echo esc_html($price_range); ?> per night</p>
                        <p class="mt-3 text-sm text-gray-600 dark:text-gray-400 line-clamp-2"><?php echo esc_html($tagline); ?></p>
                        <div class="mt-4 text-amber-600 dark:text-amber-400 text-sm font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">
                            View Details <i class="fas fa-arrow-right h-3 w-3"></i>
                        </div>
                    </div>
                </a>
            <?php 
                    $idx++;
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
