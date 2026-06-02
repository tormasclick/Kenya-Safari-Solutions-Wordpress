<?php get_header(); ?>
<section class="py-24 md:py-32 px-4 bg-white dark:bg-[#0f0a08]">
    <div class="container mx-auto max-w-7xl">
        <h1 class="font-display text-4xl md:text-5xl font-bold text-center mb-12 text-foreground">All Destinations</h1>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <a href="<?php the_permalink(); ?>" class="group rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                    <?php if (has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url('large'); ?>" class="w-full h-64 object-cover" />
                    <?php endif; ?>
                    <div class="p-5 bg-white dark:bg-[#241710]">
                        <h2 class="font-display text-xl font-bold mb-2 group-hover:text-amber-600 transition"><?php the_title(); ?></h2>
                        <p class="text-muted-foreground"><?php echo get_the_excerpt(); ?></p>
                    </div>
                </a>
            <?php endwhile; endif; ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
