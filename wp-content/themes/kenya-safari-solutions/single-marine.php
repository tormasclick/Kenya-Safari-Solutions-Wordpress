<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); 
    // Get all meta data
    $tagline = get_post_meta(get_the_ID(), '_marine_tagline', true);
    $duration = get_post_meta(get_the_ID(), '_marine_duration', true);
    $best_time = get_post_meta(get_the_ID(), '_marine_best_time', true);
    $price = get_post_meta(get_the_ID(), '_marine_price', true);
    
    // Highlights - split by semicolon or new line
    $highlights = get_post_meta(get_the_ID(), '_marine_highlights', true);
    $highlights_array = array();
    if ($highlights) {
        if (strpos($highlights, ';') !== false) {
            $highlights_array = explode(';', $highlights);
        } else {
            $highlights_array = explode("\n", $highlights);
        }
    }
    
    // Activities - split by semicolon or new line
    $activities = get_post_meta(get_the_ID(), '_marine_activities', true);
    $activities_array = array();
    if ($activities) {
        if (strpos($activities, ';') !== false) {
            $activities_array = explode(';', $activities);
        } else {
            $activities_array = explode("\n", $activities);
        }
    }
    
    // What's Included - split by semicolon or new line
    $included = get_post_meta(get_the_ID(), '_marine_included', true);
    $included_array = array();
    if ($included) {
        if (strpos($included, ';') !== false) {
            $included_array = explode(';', $included);
        } else {
            $included_array = explode("\n", $included);
        }
    }
    
    $faqs_json = get_post_meta(get_the_ID(), '_marine_faqs', true);
    $faqs = $faqs_json ? json_decode($faqs_json, true) : array();
    
    // Get accommodations for this marine activity
    $selected_accommodations = get_post_meta(get_the_ID(), '_marine_accommodations', true);
    $accommodation_ids = $selected_accommodations ? explode(',', $selected_accommodations) : array();
    
    // Get accommodation data
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
    
    // Get gallery images
    $gallery_ids = get_post_meta(get_the_ID(), '_marine_gallery_ids', true);
    $gallery_images = $gallery_ids ? explode(',', $gallery_ids) : array();
    $main_image = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : '';
    
    // Get other marine activities for "You May Like" section
    $other_marine = get_posts(array(
        'post_type' => 'marine',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand'
    ));
    
    // Get CTA settings from backend
    $cta_title_template = get_option('kenya_marine_cta_title', 'Book Your {marine_name} Experience Today');
    $cta_title = str_replace('{marine_name}', get_the_title(), $cta_title_template);
    $cta_description = get_option('kenya_marine_cta_description', 'Let our marine experts create an unforgettable ocean adventure for you');
    $cta_button_text = get_option('kenya_marine_cta_button_text', 'Reserve via WhatsApp');
    $whatsapp_number = get_option('kenya_whatsapp_number', '254700563754');
?>

<main class="pt-32 pb-16 px-4 bg-white dark:bg-[#0f0a08] transition-colors duration-300">
    <div class="mx-auto max-w-6xl">
        <!-- Breadcrumbs -->
        <div class="text-sm text-gray-600 dark:text-gray-400 mb-4 flex items-center gap-2">
            <a href="<?php echo home_url(); ?>" class="hover:text-amber-600 transition">Home</a>
            <span>›</span>
            <a href="<?php echo home_url('/marine'); ?>" class="hover:text-amber-600 transition">Marine</a>
            <span>›</span>
            <span class="text-gray-900 dark:text-white"><?php the_title(); ?></span>
        </div>

        <!-- Hero Section - Two Columns -->
        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Left Column: Main Image + Gallery Thumbnails -->
            <div>
                <div class="rounded-2xl overflow-hidden shadow-2xl h-[400px] lg:h-[450px]">
                    <img id="main-marine-image" src="<?php echo esc_url($main_image); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover">
                </div>
                
                <!-- Gallery Thumbnails below main image -->
                <?php if (!empty($gallery_images)): ?>
                    <div class="flex gap-3 mt-4 flex-wrap">
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

            <!-- Right Column: Title, Duration, Price, Tagline, Best Time, Highlights, Activities, Included -->
            <div class="space-y-4">
                <h1 class="font-display text-4xl lg:text-5xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                    <?php the_title(); ?>
                </h1>
                
                <div class="flex flex-wrap gap-2">
                    <?php if ($duration): ?>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-100 dark:bg-amber-200 rounded-full">
                            <i class="far fa-clock h-4 w-4 text-amber-600 dark:text-amber-800"></i>
                            <span class="text-sm font-medium text-amber-700 dark:text-amber-900"><?php echo esc_html($duration); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($price): ?>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 dark:bg-green-200 rounded-full">
                            <i class="fas fa-tag h-4 w-4 text-green-600 dark:text-green-800"></i>
                            <span class="text-sm font-medium text-green-700 dark:text-green-900">$<?php echo esc_html($price); ?> per person</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($tagline): ?>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed"><?php echo esc_html($tagline); ?></p>
                <?php endif; ?>
                
                <!-- Best Time -->
                <?php if ($best_time): ?>
                    <div class="p-4 rounded-xl" style="background-color: #dbeafe;">
                        <div class="flex items-center gap-2">
                            <i class="far fa-calendar-alt h-5 w-5" style="color: #1e40af;"></i>
                            <span class="font-semibold" style="color: #000000;">Best Time: <?php echo esc_html($best_time); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Highlights Section - Fancy Tags with Checkmark -->
                <?php if (!empty($highlights_array)): ?>
                    <div>
                        <h2 class="font-display text-xl font-bold mb-3 text-gray-900 dark:text-white">✨ Highlights</h2>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($highlights_array as $highlight): ?>
                                <?php $highlight_clean = trim(str_replace(';', '', $highlight)); ?>
                                <?php if ($highlight_clean): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-100 dark:bg-amber-900/40 rounded-full text-sm text-amber-800 dark:text-amber-300 shadow-sm hover:shadow-md transition-all">
                                        <i class="fas fa-check-circle text-amber-600 dark:text-amber-400 text-xs"></i>
                                        <?php echo esc_html($highlight_clean); ?>
                                    </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Activities Section as Tags -->
                <?php if (!empty($activities_array)): ?>
                    <div>
                        <h2 class="font-display text-xl font-bold mb-3 text-gray-900 dark:text-white">🎯 Activities</h2>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($activities_array as $activity): ?>
                                <?php $activity_clean = trim(str_replace(';', '', $activity)); ?>
                                <?php if ($activity_clean): ?>
                                    <span class="px-4 py-2 bg-gray-100 dark:bg-gray-800 rounded-full text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:shadow-md transition-all">
                                        <?php echo esc_html($activity_clean); ?>
                                    </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- What's Included Section as Tags -->
                <?php if (!empty($included_array)): ?>
                    <div>
                        <h2 class="font-display text-xl font-bold mb-3 text-gray-900 dark:text-white">✓ What's Included</h2>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($included_array as $item): ?>
                                <?php $item_clean = trim(str_replace(';', '', $item)); ?>
                                <?php if ($item_clean): ?>
                                    <span class="px-4 py-2 bg-emerald-50 dark:bg-emerald-900/30 rounded-full text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:shadow-md transition-all">
                                        <?php echo esc_html($item_clean); ?>
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

        <!-- Accommodations Section (if any assigned) -->
        <?php if (!empty($all_accommodations)): ?>
            <div class="mt-12">
                <h2 class="font-display text-3xl font-bold mb-6 text-gray-900 dark:text-white">
                    Where to Stay During Your Marine Adventure
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($all_accommodations as $acc): ?>
                        <div class="bg-white dark:bg-gray-900 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-200 dark:border-gray-800 relative">
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

        <!-- FAQ Section -->
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

        <!-- CTA Section -->
        <div class="mt-8 p-6 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 text-center">
            <h2 class="font-display text-xl md:text-2xl font-bold text-white"><?php echo esc_html($cta_title); ?></h2>
            <p class="text-sm text-white/90 mt-2 max-w-md mx-auto"><?php echo esc_html($cta_description); ?></p>
            <a href="#" id="marine-wa" target="_blank" class="mt-4 inline-flex items-center justify-center gap-2 rounded-full bg-white text-amber-600 px-6 py-3 font-bold hover:scale-105 transition shadow-lg">
                <i class="fab fa-whatsapp h-5 w-5"></i> <?php echo esc_html($cta_button_text); ?>
            </a>
        </div>

        <!-- Other Marine Activities You May Like -->
        <?php if (!empty($other_marine)): ?>
            <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-800">
                <h2 class="font-display text-2xl font-bold text-center mb-8 text-gray-900 dark:text-white">
                    Other Marine Experiences You May Like
                </h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($other_marine as $marine): 
                        $marine_image = get_the_post_thumbnail_url($marine->ID, 'medium');
                        $marine_tagline = get_post_meta($marine->ID, '_marine_tagline', true);
                        $marine_price = get_post_meta($marine->ID, '_marine_price', true);
                    ?>
                        <a href="<?php echo get_permalink($marine->ID); ?>" class="group rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 overflow-hidden hover:shadow-xl transition hover:-translate-y-1">
                            <?php if ($marine_image): ?>
                                <img src="<?php echo esc_url($marine_image); ?>" alt="<?php echo esc_attr(get_the_title($marine->ID)); ?>" class="h-48 w-full object-cover">
                            <?php endif; ?>
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-display text-lg font-bold group-hover:text-amber-600 transition text-gray-900 dark:text-white">
                                        <?php echo esc_html(get_the_title($marine->ID)); ?>
                                    </h3>
                                    <?php if ($marine_price): ?>
                                        <span class="text-xs font-bold text-amber-600">$<?php echo esc_html($marine_price); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if ($marine_tagline): ?>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-2"><?php echo esc_html($marine_tagline); ?></p>
                                <?php endif; ?>
                                <div class="mt-3 text-sm text-amber-600 font-medium flex items-center gap-1 group-hover:gap-2 transition-all">
                                    View Details <i class="fas fa-arrow-right h-3 w-3"></i>
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
    const mainImage = document.getElementById('main-marine-image');
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
const mainImage = document.getElementById('main-marine-image');
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

// WhatsApp link
const whatsappNumber = "<?php echo esc_js($whatsapp_number); ?>";
const waMessage = "Hi, I'm interested in booking the <?php echo addslashes(get_the_title()); ?> marine experience. Can you share more details about availability and pricing?";
const waUrl = "https://wa.me/" + whatsappNumber + "?text=" + encodeURIComponent(waMessage);
document.getElementById('marine-wa')?.setAttribute('href', waUrl);
</script>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
