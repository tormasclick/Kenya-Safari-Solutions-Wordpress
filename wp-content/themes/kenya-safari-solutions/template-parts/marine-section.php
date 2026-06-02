<?php
/**
 * Marine Section - Uses page meta for headers
 */

global $post;
$eyebrow = get_post_meta(get_the_ID(), '_marine_eyebrow', true);
$title = get_post_meta(get_the_ID(), '_marine_title', true);
$description = get_post_meta(get_the_ID(), '_marine_description', true);

if (!$eyebrow) $eyebrow = 'Marine experiences';
if (!$title) $title = 'The Indian Ocean, on your terms.';
if (!$description) $description = 'Coral gardens, wild dolphins, and dhows under a melting sun. Explore Watamu\'s protected marine park with our expert guides.';
?>

<section class="relative overflow-hidden px-4 py-24 md:py-32 transition-colors duration-300" 
         style="background-color: var(--section-marine, #f7ebe3); transition: background-color 0.3s ease;">
    <div class="mx-auto max-w-7xl">
        <div class="max-w-2xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 text-[11px] uppercase tracking-[0.22em] text-amber-600 dark:text-amber-400 font-bold">
                <span class="h-px w-8 bg-amber-500"></span> <?php echo esc_html($eyebrow); ?>
            </div>
            <h2 class="mt-4 font-display text-4xl leading-[1.05] md:text-5xl font-bold text-foreground">
                <?php echo esc_html($title); ?>
            </h2>
            <p class="mt-3 text-muted-foreground">
                <?php echo esc_html($description); ?>
            </p>
        </div>

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <?php
            $marine_activities = get_posts(array(
                'post_type' => 'marine',
                'posts_per_page' => 4,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            
            if ($marine_activities):
                foreach ($marine_activities as $activity):
                    $image = get_the_post_thumbnail_url($activity->ID, 'large');
                    if (!$image) {
                        $image = get_template_directory_uri() . '/assets/images/marine/' . $activity->post_name . '.jpg';
                    }
                    $tagline = get_post_meta($activity->ID, '_marine_tagline', true);
                    $price = get_post_meta($activity->ID, '_marine_price', true);
            ?>
                <a href="<?php echo get_permalink($activity->ID); ?>" 
                   class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                    <img src="<?php echo esc_url($image); ?>" class="h-72 w-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-6 text-white">
                        <div class="font-display text-2xl font-bold"><?php echo esc_html(get_the_title($activity->ID)); ?></div>
                        <p class="mt-1 text-sm text-white/80 line-clamp-2"><?php echo esc_html($tagline); ?></p>
                        <div class="mt-2 flex items-center gap-2">
                            <span class="text-xs font-bold text-amber-400">$<?php echo esc_html($price); ?></span>
                            <span class="text-xs text-white/60">per person</span>
                        </div>
                        <span class="mt-3 inline-flex items-center gap-1.5 text-xs font-medium text-amber-400">
                            View Details <i class="fas fa-arrow-right h-3 w-3"></i>
                        </span>
                    </div>
                </a>
            <?php 
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
