<?php
/**
 * Packages Section - Using WordPress Featured Images
 */

global $post;
$eyebrow = get_post_meta(get_the_ID(), '_packages_eyebrow', true);
$title = get_post_meta(get_the_ID(), '_packages_title', true);
$description = get_post_meta(get_the_ID(), '_packages_description', true);

if (!$eyebrow) $eyebrow = 'Safari packages';
if (!$title) $title = 'Day-by-day journeys, ready to book.';
if (!$description) $description = 'Filter by style, open the itinerary, then book what\'s right for you.';
?>

<section class="relative px-4 py-24 md:py-32" style="background-color: var(--section-packages, #ffffff); transition: background-color 0.3s ease;">
    <div class="mx-auto max-w-7xl">
        <div class="flex flex-wrap items-end justify-between gap-6 mb-12">
            <div class="max-w-2xl">
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
            
            <!-- Filter Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <button data-filter="All" class="filter-btn rounded-full px-5 py-2 text-sm font-semibold transition-all duration-300 bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-lg shadow-amber-500/30 scale-105">
                    All
                </button>
                <button data-filter="Safari" class="filter-btn rounded-full px-5 py-2 text-sm font-semibold transition-all duration-300 bg-card text-muted-foreground border border-border hover:shadow-md hover:scale-105">
                    Safari
                </button>
                <button data-filter="Combo" class="filter-btn rounded-full px-5 py-2 text-sm font-semibold transition-all duration-300 bg-card text-muted-foreground border border-border hover:shadow-md hover:scale-105">
                    Combo
                </button>
                <button data-filter="City" class="filter-btn rounded-full px-5 py-2 text-sm font-semibold transition-all duration-300 bg-card text-muted-foreground border border-border hover:shadow-md hover:scale-105">
                    City
                </button>
            </div>
        </div>

        <!-- Packages Grid -->
        <div id="packages-grid" class="mt-8 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <?php
            $packages = get_posts(array(
                'post_type' => 'package',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            
            // Fallback images (only used if no featured image is set)
            $fallback_images = array(
                '3-days-maasai-mara' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=800&h=600&fit=crop',
                '2-days-amboseli' => 'https://images.pexels.com/photos/2351731/pexels-photo-2351731.jpeg?w=800&h=600&fit=crop',
                '1-day-nairobi-park' => 'https://images.unsplash.com/photo-1504208434309-cb69f4fe52b0?w=800&h=600&fit=crop',
                '5-days-kenya-explorer' => 'https://images.unsplash.com/photo-1534177616072-ef7dc120449d?w=800&h=600&fit=crop',
                '3-days-tsavo-safari' => 'https://images.pexels.com/photos/127147/pexels-photo-127147.jpeg?w=800&h=600&fit=crop',
            );
            
            if ($packages):
                foreach ($packages as $pkg):
                    $tag = get_post_meta($pkg->ID, '_package_tag', true);
                    $duration = get_post_meta($pkg->ID, '_package_duration', true);
                    $blurb = get_post_meta($pkg->ID, '_package_blurb', true);
                    $itinerary = get_post_meta($pkg->ID, '_package_itinerary', true);
                    $itinerary_data = json_decode($itinerary, true);
                    
                    // Get image from Featured Image first
                    $image = get_the_post_thumbnail_url($pkg->ID, 'large');
                    
                    // If no featured image, use fallback
                    if (!$image) {
                        $slug = $pkg->post_name;
                        $image = isset($fallback_images[$slug]) ? $fallback_images[$slug] : $fallback_images['3-days-maasai-mara'];
                    }
            ?>
                <article class="package-card group rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2" 
                         data-tag="<?php echo esc_attr($tag); ?>">
                    <div class="relative h-80 overflow-hidden">
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title($pkg->ID)); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/20 group-hover:from-black/80 transition-all duration-500"></div>
                        
                        <div class="absolute inset-0 flex flex-col justify-between p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex gap-2">
                                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase bg-amber-500/90 backdrop-blur-sm text-white shadow-md">
                                        <?php echo esc_html($tag); ?>
                                    </span>
                                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-black/60 backdrop-blur-sm text-white flex items-center gap-1">
                                        <i class="fas fa-clock"></i>
                                        <?php echo esc_html($duration); ?>
                                    </span>
                                </div>
                                <button class="toggle-itinerary px-3 py-1.5 rounded-lg text-xs font-semibold bg-white/20 backdrop-blur-sm text-white hover:bg-white/30 transition-all flex items-center gap-1">
                                    <i class="fas fa-eye"></i>
                                    <span class="toggle-text">View</span>
                                </button>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <h3 class="font-display text-2xl font-bold text-white group-hover:text-amber-400 transition-colors">
                                        <?php echo esc_html(get_the_title($pkg->ID)); ?>
                                    </h3>
                                    <p class="mt-2 text-sm text-white/80 line-clamp-2"><?php echo esc_html($blurb); ?></p>
                                </div>

                                <div class="itinerary-dropdown hidden mt-2 space-y-2 bg-black/60 backdrop-blur-md rounded-xl p-4 border border-white/20 max-h-60 overflow-y-auto">
                                    <?php if ($itinerary_data && is_array($itinerary_data)): ?>
                                        <?php foreach ($itinerary_data as $day): ?>
                                            <div class="relative border-l-2 border-amber-500 pl-3 py-1">
                                                <div class="text-xs font-bold text-amber-400 flex items-center gap-1">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <?php echo esc_html($day['day']); ?>
                                                </div>
                                                <div class="text-sm font-semibold text-white mt-1"><?php echo esc_html($day['title']); ?></div>
                                                <p class="mt-1 text-xs text-white/70 leading-relaxed"><?php echo esc_html($day['detail']); ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <a href="#" class="book-package w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 text-white font-bold text-sm shadow-lg shadow-amber-500/30 transition-all hover:scale-105 hover:shadow-xl">
                                    <i class="fab fa-whatsapp"></i> Book this trip
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            <?php 
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>

<script>
// Filter functionality
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const filter = this.getAttribute('data-filter');
        document.querySelectorAll('.filter-btn').forEach(b => {
            if (b.getAttribute('data-filter') === filter) {
                b.classList.remove('bg-card', 'text-muted-foreground', 'border', 'border-border');
                b.classList.add('bg-gradient-to-r', 'from-amber-500', 'to-orange-500', 'text-white', 'shadow-lg', 'shadow-amber-500/30', 'scale-105');
            } else {
                b.classList.remove('bg-gradient-to-r', 'from-amber-500', 'to-orange-500', 'text-white', 'shadow-lg', 'shadow-amber-500/30', 'scale-105');
                b.classList.add('bg-card', 'text-muted-foreground', 'border', 'border-border');
            }
        });
        
        document.querySelectorAll('.package-card').forEach(pkg => {
            const tag = pkg.getAttribute('data-tag');
            if (filter === 'All' || tag === filter) {
                pkg.style.display = 'block';
            } else {
                pkg.style.display = 'none';
            }
        });
    });
});

// Itinerary toggle
document.querySelectorAll('.toggle-itinerary').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const dropdown = this.closest('.absolute').querySelector('.itinerary-dropdown');
        const toggleText = this.querySelector('.toggle-text');
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            toggleText.textContent = 'Hide';
        } else {
            dropdown.classList.add('hidden');
            toggleText.textContent = 'View';
        }
    });
});

// WhatsApp booking
document.querySelectorAll('.book-package').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const title = this.closest('.package-card').querySelector('h3').textContent;
        window.open(`https://wa.me/254700563754?text=${encodeURIComponent(`Hi, I'd like to book the ${title} package.`)}`, '_blank');
    });
});
</script>
