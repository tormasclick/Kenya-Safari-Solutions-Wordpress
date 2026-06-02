<?php
/**
 * Transfers Section - Uses page meta for headers
 */

// Get the current page ID from the global post object
global $post;
$page_id = $post->ID;

$eyebrow = get_post_meta($page_id, '_transfers_eyebrow', true);
$title = get_post_meta($page_id, '_transfers_title', true);
$description = get_post_meta($page_id, '_transfers_description', true);

if (!$eyebrow) $eyebrow = 'Airport transfers';
if (!$title) $title = 'Land smoothly, leave gracefully.';
if (!$description) $description = 'Terminal-to-destination with premium vehicles and professional drivers.';
?>

<section class="relative px-4 py-24 md:py-32" style="background-color: var(--section-transfers, #ffffff); transition: background-color 0.3s ease;">
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
            $transfers = get_posts(array(
                'post_type' => 'transfer',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            
            if ($transfers):
                foreach ($transfers as $transfer):
                    $image = get_the_post_thumbnail_url($transfer->ID, 'large');
                    if (!$image) {
                        $image = get_template_directory_uri() . '/assets/images/transfers/' . $transfer->post_name . '.jpg';
                    }
                    $tagline = get_post_meta($transfer->ID, '_transfer_tagline', true);
                    $price = get_post_meta($transfer->ID, '_transfer_price', true);
                    $duration = get_post_meta($transfer->ID, '_transfer_duration', true);
            ?>
                <a href="<?php echo get_permalink($transfer->ID); ?>" 
                   class="group rounded-2xl overflow-hidden bg-white dark:bg-gray-900 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-200 dark:border-gray-800">
                    <div class="relative h-56 overflow-hidden">
                        <img src="<?php echo esc_url($image); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-lg text-xs font-semibold bg-amber-500/90 backdrop-blur-sm text-white">
                                $<?php echo esc_html($price); ?>
                            </span>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <h3 class="font-display text-xl font-bold text-gray-900 dark:text-white group-hover:text-amber-600 transition">
                                <?php echo esc_html(get_the_title($transfer->ID)); ?>
                            </h3>
                        </div>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 line-clamp-2"><?php echo esc_html($tagline); ?></p>
                        <?php if ($duration): ?>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1"><?php echo esc_html($duration); ?></p>
                        <?php endif; ?>
                        <div class="mt-4 text-amber-600 dark:text-amber-400 text-sm font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">
                            View details <i class="fas fa-arrow-right h-3 w-3"></i>
                        </div>
                    </div>
                </a>
            <?php 
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
