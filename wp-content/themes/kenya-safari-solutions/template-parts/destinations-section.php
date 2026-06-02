<?php
/**
 * Destinations Section - Uses CSS variables for dark mode
 */

global $post;
$eyebrow = get_post_meta(get_the_ID(), '_destinations_eyebrow', true);
$title = get_post_meta(get_the_ID(), '_destinations_title', true);
$description = get_post_meta(get_the_ID(), '_destinations_description', true);

if (!$eyebrow) $eyebrow = 'Featured destinations';
if (!$title) $title = 'Eight Kenyas, one journey.';
if (!$description) $description = 'From migration plains to coral coastlines — tap any tile for the inner brief, day-by-day cues, and what makes it unforgettable.';
?>

<section class="relative px-4 py-20 md:py-28" style="background-color: var(--section-destinations, #ffffff); transition: background-color 0.3s ease;">
    <div class="mx-auto max-w-7xl">
        <div class="max-w-2xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 text-[11px] uppercase tracking-[0.22em] text-amber-600 dark:text-amber-400 font-bold">
                <span class="h-px w-8 bg-amber-500"></span> <?php echo esc_html($eyebrow); ?>
            </div>
            <h2 class="mt-4 font-display text-4xl leading-[1.05] md:text-5xl font-bold" style="color: var(--foreground, #1a1a1a);">
                <?php echo esc_html($title); ?>
            </h2>
            <p class="mt-3 dark:text-white" style="color: var(--muted-foreground, #6b7280);">
                <?php echo esc_html($description); ?>
            </p>
        </div>

        <div class="mt-12 grid auto-rows-[240px] grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-4">
            <?php
            $destinations = get_posts(array(
                'post_type' => 'destination',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            
            if ($destinations):
                $i = 0;
                foreach ($destinations as $dest):
                    $image = get_the_post_thumbnail_url($dest->ID, 'large');
                    if (!$image) {
                        $image = get_template_directory_uri() . '/assets/images/destinations/' . $dest->post_name . '.jpg';
                    }
                    $tagline = get_post_meta($dest->ID, '_destination_tagline', true);
                    $duration = get_post_meta($dest->ID, '_destination_duration', true);
                    $span = get_post_meta($dest->ID, '_destination_span', true);
                    $blurb = get_post_meta($dest->ID, '_destination_blurb', true);
                    if (!$blurb) {
                        $blurb = $tagline;
                    }
            ?>
                <a href="<?php echo get_permalink($dest->ID); ?>" 
                   class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 <?php echo esc_attr($span); ?>"
                   style="animation: fade-up 0.7s <?php echo $i * 60; ?>ms both ease-out">
                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title($dest->ID)); ?>" class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>
                    <div class="relative flex h-full flex-col justify-end p-5 text-white">
                        <?php if ($duration): ?>
                            <div class="text-[10px] uppercase tracking-[0.2em] text-amber-400 font-semibold"><?php echo esc_html($duration); ?></div>
                        <?php endif; ?>
                        <div class="font-display text-2xl font-bold mt-1"><?php echo esc_html(get_the_title($dest->ID)); ?></div>
                        <div class="mt-1 text-sm text-white/80 line-clamp-2"><?php echo esc_html($blurb); ?></div>
                        <span class="mt-3 inline-flex items-center gap-1.5 text-xs font-medium text-amber-400 opacity-0 transition-all group-hover:opacity-100 group-hover:translate-x-1">
                            View details <i class="fas fa-arrow-right h-3 w-3"></i>
                        </span>
                    </div>
                </a>
            <?php 
                    $i++;
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>

<style>
@keyframes fade-up {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.md\:col-span-2 {
    grid-column: span 2 / span 2;
}
.md\:row-span-2 {
    grid-row: span 2 / span 2;
}
</style>
