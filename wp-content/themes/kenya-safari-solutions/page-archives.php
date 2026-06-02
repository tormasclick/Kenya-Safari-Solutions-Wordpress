<?php
/**
 * Template Name: Archives Page
 */
get_header(); ?>

<section class="py-24 md:py-32 px-4 bg-white dark:bg-[#0f0a08]">
    <div class="container mx-auto max-w-7xl">
        <h1 class="font-display text-4xl md:text-5xl font-bold text-center mb-12 text-foreground"><?php the_title(); ?></h1>
        <?php the_content(); ?>
    </div>
</section>

<?php get_footer(); ?>
