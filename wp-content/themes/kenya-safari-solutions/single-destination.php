<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); 
    // Get all meta data
    $tagline = get_post_meta(get_the_ID(), '_destination_tagline', true);
    $duration = get_post_meta(get_the_ID(), '_destination_duration', true);
    $best_time = get_post_meta(get_the_ID(), '_destination_best_time', true);
    $weather = get_post_meta(get_the_ID(), '_destination_weather', true);
    $highlights = get_post_meta(get_the_ID(), '_destination_highlights', true);
    $highlights_array = $highlights ? explode("\n", $highlights) : array();
    $wildlife = get_post_meta(get_the_ID(), '_destination_wildlife', true);
    $wildlife_array = $wildlife ? array_map('trim', explode(',', $wildlife)) : array();
    $activities = get_post_meta(get_the_ID(), '_destination_activities', true);
    $activities_array = $activities ? array_map('trim', explode(',', $activities)) : array();
    $faqs_json = get_post_meta(get_the_ID(), '_destination_faqs', true);
    $faqs = $faqs_json ? json_decode($faqs_json, true) : array();
    
    // Get gallery images
    $gallery_ids = get_post_meta(get_the_ID(), '_destination_gallery_ids', true);
    $gallery_images = $gallery_ids ? explode(',', $gallery_ids) : array();
    $main_image = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : '';
    
    // Get selected accommodations for this destination
    $selected_accommodations = get_post_meta(get_the_ID(), '_destination_accommodations', true);
    $accommodation_ids = $selected_accommodations ? explode(',', $selected_accommodations) : array();
    
    // Group accommodations by type
    $all_accommodations = array();
    
    foreach ($accommodation_ids as $acc_id) {
        $acc = get_post($acc_id);
        if ($acc) {
            $type = get_post_meta($acc->ID, '_accommodation_type', true);
            $acc_data = array(
                'id' => $acc->ID,
                'name' => $acc->post_title,
                'type' => $type,
                'tagline' => get_post_meta($acc->ID, '_accommodation_tagline', true),
                'price_range' => get_post_meta($acc->ID, '_accommodation_price_range', true),
                'rating' => get_post_meta($acc->ID, '_accommodation_rating', true),
                'image' => get_the_post_thumbnail_url($acc->ID, 'medium'),
                'permalink' => get_permalink($acc->ID)
            );
            $all_accommodations[] = $acc_data;
        }
    }
    
    // Get other destinations for "You May Like" section
    $other_destinations = get_posts(array(
        'post_type' => 'destination',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand'
    ));
    
    // Get CTA settings from backend
    $cta_title_template = get_option('kenya_destination_cta_title', 'Plan Your {destination_name} Safari Today');
    $cta_title = str_replace('{destination_name}', get_the_title(), $cta_title_template);
    $cta_description = get_option('kenya_destination_cta_description', 'Let our travel experts create a custom itinerary just for you');
    $cta_button_text = get_option('kenya_destination_cta_button_text', 'Inquire on WhatsApp');
    $whatsapp_number = get_option('kenya_whatsapp_number', '254700563754');
?>

<main class="pt-32 pb-16 px-4 bg-white dark:bg-[#0f0a08] transition-colors duration-300">
    <div class="mx-auto max-w-6xl">
        <!-- Breadcrumbs -->
        <div class="text-sm text-gray-600 dark:text-gray-400 mb-4 flex items-center gap-2">
            <a href="<?php echo home_url(); ?>" class="hover:text-amber-600 transition">Home</a>
            <span>›</span>
            <a href="<?php echo home_url('/safaris'); ?>" class="hover:text-amber-600 transition">Safaris</a>
            <span>›</span>
            <span class="text-gray-900 dark:text-white"><?php the_title(); ?></span>
        </div>

        <!-- Hero Section - Two Columns -->
        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Left Column: Main Image + Gallery Thumbnails -->
            <div>
                <div class="rounded-2xl overflow-hidden shadow-2xl h-[400px] lg:h-[450px]">
                    <img id="main-destination-image" src="<?php echo esc_url($main_image); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover">
                </div>
                
                <!-- Gallery Thumbnails below main image -->
                <?php if (!empty($gallery_images)): ?>
                    <div class="flex gap-3 mt-4">
                        <?php foreach ($gallery_images as $image_id): 
                            $thumb_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                            $full_url = wp_get_attachment_image_url($image_id, 'large');
                            if ($thumb_url):
                        ?>
                            <div class="gallery-thumb w-20 h-20 rounded-lg overflow-hidden cursor-pointer border-2 border-transparent hover:border-amber-500 transition-all" 
                                 data-image="<?php echo esc_url($full_url); ?>"
                                 onclick="changeMainImage(this)">
                                <img src="<?php echo esc_url($thumb_url); ?>" class="w-full h-full object-cover">
                            </div>
                        <?php endif; endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column: Title, Duration, Tagline, Highlights, Wildlife, Activities -->
            <div class="space-y-4">
                <h1 class="font-display text-4xl lg:text-5xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                    <?php the_title(); ?>
                </h1>
                
                <?php if ($duration): ?>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-100 dark:bg-amber-200 rounded-full">
                        <i class="far fa-clock h-4 w-4 text-amber-600 dark:text-amber-800"></i>
                        <span class="text-sm font-medium text-amber-700 dark:text-amber-900">Recommended: <?php echo esc_html($duration); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($tagline): ?>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed"><?php echo esc_html($tagline); ?></p>
                <?php endif; ?>
                
                <!-- Best Time & Weather -->
                <div class="p-4 bg-amber-50 dark:bg-amber-100 rounded-xl">
                    <?php if ($best_time): ?>
                        <div class="flex items-center gap-2">
                            <i class="far fa-calendar-alt h-5 w-5 text-amber-500 dark:text-amber-700"></i>
                            <span class="font-semibold text-gray-900 dark:text-gray-900">Best Time: <?php echo esc_html($best_time); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($weather): ?>
                        <div class="flex items-center gap-2 mt-2">
                            <i class="fas fa-sun h-5 w-5 text-amber-500 dark:text-amber-700"></i>
                            <span class="font-semibold text-gray-900 dark:text-gray-900">Weather: <?php echo esc_html($weather); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Highlights Section - Right column -->
                <?php if (!empty($highlights_array)): ?>
                    <div>
                        <h2 class="font-display text-xl font-bold mb-3 text-gray-900 dark:text-white">✨ Highlights</h2>
                        <ul class="list-disc list-inside space-y-1 text-gray-700 dark:text-gray-300">
                            <?php foreach ($highlights_array as $highlight): ?>
                                <?php if (trim($highlight)): ?>
                                    <li class="text-sm"><?php echo esc_html(trim($highlight)); ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <!-- Wildlife Section -->
                <?php if (!empty($wildlife_array)): ?>
                    <div>
                        <h2 class="font-display text-xl font-bold mb-3 text-gray-900 dark:text-white">🦁 Wildlife</h2>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($wildlife_array as $animal): ?>
                                <?php if ($animal): ?>
                                    <span class="px-3 py-1.5 bg-gray-100 dark:bg-gray-300 rounded-full text-sm text-gray-700 dark:text-gray-900">
                                        <?php echo esc_html($animal); ?>
                                    </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Activities Section -->
                <?php if (!empty($activities_array)): ?>
                    <div>
                        <h2 class="font-display text-xl font-bold mb-3 text-gray-900 dark:text-white">🎯 Activities</h2>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($activities_array as $activity): ?>
                                <?php if ($activity): ?>
                                    <span class="px-3 py-1.5 bg-gray-100 dark:bg-gray-300 rounded-full text-sm text-gray-700 dark:text-gray-900">
                                        <?php echo esc_html($activity); ?>
                                    </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Full Description -->
        <div id="full-description" class="mt-12">
            <div class="prose prose-amber dark:prose-invert max-w-none">
                <?php the_content(); ?>
            </div>
        </div>

        <!-- ACCOMMODATIONS SECTION - All cards together -->
        <?php if (!empty($all_accommodations)): ?>
            <div class="mt-12">
                <h2 class="font-display text-3xl font-bold mb-6 text-gray-900 dark:text-white">
                    Where to Stay in <?php the_title(); ?>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($all_accommodations as $acc): ?>
                        <div class="bg-white dark:bg-gray-900 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-200 dark:border-gray-800 relative">
                            <!-- Type Tag -->
                            <div class="absolute top-3 right-3 z-10">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase <?php 
                                    echo $acc['type'] == 'LUXURY' ? 'bg-amber-500 text-white' : ($acc['type'] == 'MIDRANGE' ? 'bg-blue-500 text-white' : 'bg-green-500 text-white'); 
                                ?>">
                                    <?php echo esc_html($acc['type']); ?>
                                </span>
                            </div>
                            <?php if ($acc['image']): ?>
                                <img src="<?php echo esc_url($acc['image']); ?>" class="w-full h-48 object-cover">
                            <?php endif; ?>
                            <div class="p-5">
                                <h4 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-1"><?php echo esc_html($acc['name']); ?></h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2"><?php echo esc_html($acc['tagline']); ?></p>
                                <?php if ($acc['rating']): ?>
                                    <div class="flex gap-0.5 mb-2">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star text-xs <?php echo $i <= $acc['rating'] ? 'text-amber-500' : 'text-gray-300'; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($acc['price_range']): ?>
                                    <p class="text-amber-600 dark:text-amber-400 font-semibold text-sm"><?php echo esc_html($acc['price_range']); ?></p>
                                <?php endif; ?>
                                <a href="<?php echo esc_url($acc['permalink']); ?>" class="mt-3 inline-block text-sm text-amber-600 dark:text-amber-400 hover:underline">View Details →</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- FAQ Section - Dynamic from backend -->
        <?php if (!empty($faqs)): ?>
            <div class="mt-12">
                <h2 class="font-display text-3xl font-bold mb-6 text-gray-900 dark:text-white">
                    Frequently Asked Questions
                </h2>
                <div class="space-y-3">
                    <?php foreach ($faqs as $index => $faq): ?>
                        <div class="border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden">
                            <button class="faq-toggle w-full px-5 py-4 text-left font-semibold flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                                <span class="text-gray-900 dark:text-white"><?php echo esc_html($faq['question']); ?></span>
                                <i class="fas fa-chevron-right h-4 w-4 text-gray-500 transition-transform duration-300"></i>
                            </button>
                            <div class="faq-answer hidden px-5 pb-4 border-t border-gray-200 dark:border-gray-800">
                                <p class="pt-3 text-gray-700 dark:text-gray-300"><?php echo esc_html($faq['answer']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- CTA Section - Centered -->
        <div class="mt-8 p-6 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 text-center">
            <h2 class="font-display text-xl md:text-2xl font-bold text-white"><?php echo esc_html($cta_title); ?></h2>
            <p class="text-sm text-white/90 mt-2 max-w-md mx-auto"><?php echo esc_html($cta_description); ?></p>
            <a href="#" id="destination-wa" target="_blank" class="mt-4 inline-flex items-center justify-center gap-2 rounded-full bg-white text-amber-600 px-6 py-3 font-bold hover:scale-105 transition shadow-lg">
                <i class="fab fa-whatsapp h-5 w-5"></i> <?php echo esc_html($cta_button_text); ?>
            </a>
        </div>

        <!-- Other Destinations You May Like -->
        <?php if (!empty($other_destinations)): ?>
            <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-800">
                <h2 class="font-display text-2xl font-bold text-center mb-8 text-gray-900 dark:text-white">
                    Other Destinations You May Like
                </h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($other_destinations as $dest): 
                        $dest_image = get_the_post_thumbnail_url($dest->ID, 'medium');
                        $dest_tagline = get_post_meta($dest->ID, '_destination_tagline', true);
                    ?>
                        <a href="<?php echo get_permalink($dest->ID); ?>" class="group rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 overflow-hidden hover:shadow-xl transition hover:-translate-y-1">
                            <?php if ($dest_image): ?>
                                <img src="<?php echo esc_url($dest_image); ?>" alt="<?php echo esc_attr(get_the_title($dest->ID)); ?>" class="h-48 w-full object-cover">
                            <?php endif; ?>
                            <div class="p-4">
                                <h3 class="font-display text-lg font-bold group-hover:text-amber-600 transition text-gray-900 dark:text-white">
                                    <?php echo esc_html(get_the_title($dest->ID)); ?>
                                </h3>
                                <?php if ($dest_tagline): ?>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1"><?php echo esc_html($dest_tagline); ?></p>
                                <?php endif; ?>
                                <div class="mt-3 text-sm text-amber-600 font-medium flex items-center gap-1 group-hover:gap-2 transition-all">
                                    Explore <i class="fas fa-arrow-right h-3 w-3"></i>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
// Gallery thumbnail click to change main image
function changeMainImage(element) {
    const newImageUrl = element.getAttribute('data-image');
    const mainImage = document.getElementById('main-destination-image');
    if (mainImage && newImageUrl) {
        mainImage.src = newImageUrl;
    }
}

// Double click on thumbnails to open full image in lightbox
document.querySelectorAll('.gallery-thumb').forEach(thumb => {
    thumb.addEventListener('dblclick', function() {
        const fullImageUrl = this.getAttribute('data-image');
        const lightbox = document.createElement('div');
        lightbox.style.position = 'fixed';
        lightbox.style.top = '0';
        lightbox.style.left = '0';
        lightbox.style.width = '100%';
        lightbox.style.height = '100%';
        lightbox.style.backgroundColor = 'rgba(0,0,0,0.9)';
        lightbox.style.zIndex = '9999';
        lightbox.style.display = 'flex';
        lightbox.style.alignItems = 'center';
        lightbox.style.justifyContent = 'center';
        lightbox.style.cursor = 'pointer';
        lightbox.innerHTML = '<img src="' + fullImageUrl + '" style="max-width: 90%; max-height: 90%; object-fit: contain;">';
        lightbox.onclick = function() { this.remove(); };
        document.body.appendChild(lightbox);
    });
});

// Double click on main image to open lightbox
const mainImage = document.getElementById('main-destination-image');
if (mainImage) {
    mainImage.addEventListener('dblclick', function() {
        const lightbox = document.createElement('div');
        lightbox.style.position = 'fixed';
        lightbox.style.top = '0';
        lightbox.style.left = '0';
        lightbox.style.width = '100%';
        lightbox.style.height = '100%';
        lightbox.style.backgroundColor = 'rgba(0,0,0,0.9)';
        lightbox.style.zIndex = '9999';
        lightbox.style.display = 'flex';
        lightbox.style.alignItems = 'center';
        lightbox.style.justifyContent = 'center';
        lightbox.style.cursor = 'pointer';
        lightbox.innerHTML = '<img src="' + mainImage.src + '" style="max-width: 90%; max-height: 90%; object-fit: contain;">';
        lightbox.onclick = function() { this.remove(); };
        document.body.appendChild(lightbox);
    });
}

// FAQ Toggle functionality
document.querySelectorAll('.faq-toggle').forEach(button => {
    button.addEventListener('click', () => {
        const answer = button.nextElementSibling;
        const icon = button.querySelector('.fa-chevron-right');
        answer.classList.toggle('hidden');
        if (icon) {
            if (answer.classList.contains('hidden')) {
                icon.style.transform = 'rotate(0deg)';
            } else {
                icon.style.transform = 'rotate(90deg)';
            }
        }
    });
});

// WhatsApp link with dynamic number from backend
const whatsappNumber = "<?php echo esc_js($whatsapp_number); ?>";
const waMessage = "Hi, I'm interested in booking <?php echo addslashes(get_the_title()); ?>. Can you share more details?";
const waUrl = "https://wa.me/" + whatsappNumber + "?text=" + encodeURIComponent(waMessage);
document.getElementById('destination-wa')?.setAttribute('href', waUrl);
</script>

<?php endwhile; endif; ?>

<?php get_footer(); ?>

<script>
// Single script for all functionality - no duplicates
(function() {
    // Gallery functions
    window.changeMainImage = function(element) {
        const newImageUrl = element.getAttribute('data-image');
        const mainImage = document.getElementById('main-destination-image');
        if (mainImage && newImageUrl) {
            mainImage.src = newImageUrl;
        }
    };
    
    document.addEventListener('DOMContentLoaded', function() {
        // FAQ Accordion
        document.querySelectorAll('.faq-toggle').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const answer = this.nextElementSibling;
                const icon = this.querySelector('.fa-chevron-right');
                if (answer) {
                    answer.classList.toggle('hidden');
                    if (icon) {
                        icon.style.transform = answer.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(90deg)';
                    }
                }
            });
        });
        
        // Gallery double click lightbox
        document.querySelectorAll('.gallery-thumb').forEach(function(thumb) {
            thumb.addEventListener('dblclick', function() {
                const imgUrl = this.getAttribute('data-image');
                const lightbox = document.createElement('div');
                lightbox.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.9);z-index:9999;display:flex;align-items:center;justify-content:center;cursor:pointer';
                lightbox.innerHTML = '<img src="' + imgUrl + '" style="max-width:90%;max-height:90%;object-fit:contain">';
                lightbox.onclick = function() { this.remove(); };
                document.body.appendChild(lightbox);
            });
        });
        
        // Main image double click
        const mainImg = document.getElementById('main-destination-image');
        if (mainImg) {
            mainImg.addEventListener('dblclick', function() {
                const lightbox = document.createElement('div');
                lightbox.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.9);z-index:9999;display:flex;align-items:center;justify-content:center;cursor:pointer';
                lightbox.innerHTML = '<img src="' + mainImg.src + '" style="max-width:90%;max-height:90%;object-fit:contain">';
                lightbox.onclick = function() { this.remove(); };
                document.body.appendChild(lightbox);
            });
        }
    });
})();

// WhatsApp link - single declaration
document.addEventListener('DOMContentLoaded', function() {
    const waBtn = document.getElementById('destination-wa');
    if (waBtn) {
        const waNumber = "<?php echo esc_js($whatsapp_number); ?>";
        const waMsg = "Hi, I'm interested in booking <?php echo addslashes(get_the_title()); ?>. Can you share more details?";
        waBtn.href = "https://wa.me/" + waNumber + "?text=" + encodeURIComponent(waMsg);
    }
});
</script>
