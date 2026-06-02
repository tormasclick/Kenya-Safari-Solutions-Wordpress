<?php
/**
 * Archive template for Marine activities
 */

get_header(); ?>

<main class="pt-32 pb-16 px-4 bg-white dark:bg-[#0f0a08] transition-colors duration-300 min-h-screen">
    <div class="mx-auto max-w-7xl">
        <div class="text-center mb-12">
            <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent mb-4">
                Marine Experiences
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Discover the underwater wonders of Kenya's coast.
            </p>
        </div>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <?php if (have_posts()) : while (have_posts()) : the_post(); 
                $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $tagline = get_post_meta(get_the_ID(), '_marine_tagline', true);
                $price = get_post_meta(get_the_ID(), '_marine_price', true);
                $duration = get_post_meta(get_the_ID(), '_marine_duration', true);
            ?>
                <a href="<?php the_permalink(); ?>" class="group rounded-2xl overflow-hidden bg-white dark:bg-gray-900 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-200 dark:border-gray-800">
                    <div class="relative h-64 overflow-hidden">
                        <?php if ($image): ?>
                            <img src="<?php echo esc_url($image); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <?php else: ?>
                            <div class="w-full h-full bg-gradient-to-br from-cyan-500/20 to-blue-500/20 flex items-center justify-center">
                                <span class="text-gray-400">No image</span>
                            </div>
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                        <?php if ($price): ?>
                            <div class="absolute bottom-4 right-4">
                                <span class="px-3 py-1 bg-green-500/90 rounded-full text-xs font-semibold text-white">
                                    $<?php echo esc_html($price); ?>/person
                                </span>
                            </div>
                        <?php endif; ?>
                        <?php if ($duration): ?>
                            <div class="absolute bottom-4 left-4">
                                <span class="px-3 py-1 bg-amber-500/90 rounded-full text-xs font-semibold text-white">
                                    <?php echo esc_html($duration); ?>
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-5">
                        <h2 class="font-display text-xl font-bold group-hover:text-amber-600 transition"><?php the_title(); ?></h2>
                        <?php if ($tagline): ?>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2"><?php echo esc_html($tagline); ?></p>
                        <?php endif; ?>
                        <div class="mt-4 text-sm text-amber-600 font-medium flex items-center gap-1 group-hover:gap-2 transition-all">
                            View Details <i class="fas fa-arrow-right h-3 w-3"></i>
                        </div>
                    </div>
                </a>
            <?php endwhile; endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
