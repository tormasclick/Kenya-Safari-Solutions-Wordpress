<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); 
    // Get all meta data
    $tagline = get_post_meta(get_the_ID(), '_transfer_tagline', true);
    $price = get_post_meta(get_the_ID(), '_transfer_price', true);
    $duration = get_post_meta(get_the_ID(), '_transfer_duration', true);
    $vehicle_type = get_post_meta(get_the_ID(), '_transfer_vehicle_type', true);
    $capacity = get_post_meta(get_the_ID(), '_transfer_capacity', true);
    $luggage = get_post_meta(get_the_ID(), '_transfer_luggage', true);
    $features = get_post_meta(get_the_ID(), '_transfer_features', true);
    $features_array = $features ? explode(',', $features) : array();
    $includes = get_post_meta(get_the_ID(), '_transfer_includes', true);
    $includes_array = $includes ? explode(',', $includes) : array();
    $best_for = get_post_meta(get_the_ID(), '_transfer_best_for', true);
    $best_for_array = $best_for ? explode(',', $best_for) : array();
    $faqs_json = get_post_meta(get_the_ID(), '_transfer_faqs', true);
    $faqs = $faqs_json ? json_decode($faqs_json, true) : array();
    
    // Get gallery images
    $gallery_ids = get_post_meta(get_the_ID(), '_transfer_gallery_ids', true);
    $gallery_images = $gallery_ids ? explode(',', $gallery_ids) : array();
    $main_image = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : '';
    
    // Get other transfers for "You May Like" section
    $other_transfers = get_posts(array(
        'post_type' => 'transfer',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand'
    ));
    
    // Get Transfer CTA settings
    $cta_title_template = get_option('kenya_transfer_cta_title', 'Book {transfer_name}');
    $cta_title = str_replace('{transfer_name}', get_the_title(), $cta_title_template);
    $cta_description = get_option('kenya_transfer_cta_description', 'Professional driver • Flight monitoring • Free waiting time');
    $cta_button_text = get_option('kenya_transfer_cta_button_text', 'Book via WhatsApp');
    $cta_footer_text = get_option('kenya_transfer_cta_footer_text', 'Free cancellation up to 24 hours before pickup');
    
    // Get global WhatsApp number
    $whatsapp_number = get_option('kenya_whatsapp_number', '254700563754');
?>

<main class="pt-32 pb-16 px-4 bg-white dark:bg-[#0f0a08] transition-colors duration-300">
    <div class="mx-auto max-w-6xl">
        <!-- Back Link -->
        <a href="<?php echo home_url('/transfers'); ?>" class="inline-flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-amber-600 transition mb-6 group">
            <i class="fas fa-arrow-left h-4 w-4"></i>
            <span>Back to Transfers</span>
        </a>

        <!-- Hero Section - Two Columns -->
        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Left Column: Main Image + Gallery Thumbnails -->
            <div>
                <div class="rounded-2xl overflow-hidden shadow-2xl h-[400px] lg:h-[450px]">
                    <img id="main-transfer-image" src="<?php echo esc_url($main_image); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover">
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

            <!-- Right Column: Title, Tagline, Price, Duration, Features, Includes, Best For -->
            <div class="space-y-4">
                <h1 class="font-display text-4xl lg:text-5xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                    <?php the_title(); ?>
                </h1>
                
                <?php if ($tagline): ?>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed"><?php echo esc_html($tagline); ?></p>
                <?php endif; ?>
                
                <div class="flex flex-wrap gap-2">
                    <?php if ($duration): ?>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-100 dark:bg-amber-200 rounded-full">
                            <i class="far fa-clock h-4 w-4 text-amber-600 dark:text-amber-800"></i>
                            <span class="text-sm font-medium text-amber-700 dark:text-amber-900"><?php echo esc_html($duration); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($price): ?>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 dark:bg-green-200 rounded-full">
                            <i class="fas fa-dollar-sign h-4 w-4 text-green-600 dark:text-green-800"></i>
                            <span class="text-sm font-medium text-green-700 dark:text-green-900">$<?php echo esc_html($price); ?> per transfer</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Vehicle Details -->
                <?php if ($vehicle_type || $capacity || $luggage): ?>
                    <div>
                        <h2 class="font-display text-xl font-bold mb-3 text-gray-900 dark:text-white">🚗 Vehicle Details</h2>
                        <div class="flex flex-wrap gap-2">
                            <?php if ($vehicle_type): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/40 rounded-full text-sm text-blue-800 dark:text-blue-300">
                                    <i class="fas fa-car"></i> <?php echo esc_html($vehicle_type); ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($capacity): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/40 rounded-full text-sm text-blue-800 dark:text-blue-300">
                                    <i class="fas fa-users"></i> <?php echo esc_html($capacity); ?> passengers
                                </span>
                            <?php endif; ?>
                            <?php if ($luggage): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/40 rounded-full text-sm text-blue-800 dark:text-blue-300">
                                    <i class="fas fa-suitcase"></i> <?php echo esc_html($luggage); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Features as fancy tags -->
                <?php if (!empty($features_array)): ?>
                    <div>
                        <h2 class="font-display text-xl font-bold mb-3 text-gray-900 dark:text-white">✨ Features</h2>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($features_array as $feature): ?>
                                <?php $feature_clean = trim($feature); ?>
                                <?php if ($feature_clean): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-100 dark:bg-amber-900/40 rounded-full text-sm text-amber-800 dark:text-amber-300">
                                        <i class="fas fa-check-circle text-amber-600 dark:text-amber-400 text-xs"></i>
                                        <?php echo esc_html($feature_clean); ?>
                                    </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- What's Included section -->
                <?php if (!empty($includes_array)): ?>
                    <div>
                        <h2 class="font-display text-xl font-bold mb-3 text-gray-900 dark:text-white">✓ What's Included</h2>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($includes_array as $item): ?>
                                <?php $item_clean = trim($item); ?>
                                <?php if ($item_clean): ?>
                                    <span class="px-3 py-1.5 bg-emerald-50 dark:bg-emerald-900/30 rounded-full text-sm text-gray-700 dark:text-gray-300">
                                        <?php echo esc_html($item_clean); ?>
                                    </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Best For section -->
                <?php if (!empty($best_for_array)): ?>
                    <div>
                        <h2 class="font-display text-xl font-bold mb-3 text-gray-900 dark:text-white">👥 Best For</h2>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($best_for_array as $item): ?>
                                <?php $item_clean = trim($item); ?>
                                <?php if ($item_clean): ?>
                                    <span class="px-3 py-1.5 bg-purple-100 dark:bg-purple-900/30 rounded-full text-sm text-purple-700 dark:text-purple-300">
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
            <a href="#" id="transfer-wa" target="_blank" class="mt-4 inline-flex items-center justify-center gap-2 rounded-full bg-white text-amber-600 px-6 py-3 font-bold hover:scale-105 transition shadow-lg">
                <i class="fab fa-whatsapp h-5 w-5"></i> <?php echo esc_html($cta_button_text); ?>
            </a>
            <p class="text-xs text-center mt-3 text-white/80"><?php echo esc_html($cta_footer_text); ?></p>
        </div>

        <!-- Other Transfers You May Like -->
        <?php if (!empty($other_transfers)): ?>
            <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-800">
                <h2 class="font-display text-2xl font-bold text-center mb-8 text-gray-900 dark:text-white">
                    Other Transfer Options
                </h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($other_transfers as $transfer): 
                        $transfer_image = get_the_post_thumbnail_url($transfer->ID, 'medium');
                        $transfer_tagline = get_post_meta($transfer->ID, '_transfer_tagline', true);
                        $transfer_price = get_post_meta($transfer->ID, '_transfer_price', true);
                        $transfer_duration = get_post_meta($transfer->ID, '_transfer_duration', true);
                    ?>
                        <a href="<?php echo get_permalink($transfer->ID); ?>" class="group rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 overflow-hidden hover:shadow-xl transition hover:-translate-y-1">
                            <?php if ($transfer_image): ?>
                                <img src="<?php echo esc_url($transfer_image); ?>" alt="<?php echo esc_attr(get_the_title($transfer->ID)); ?>" class="h-48 w-full object-cover">
                            <?php endif; ?>
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-display text-lg font-bold group-hover:text-amber-600 transition text-gray-900 dark:text-white">
                                        <?php echo esc_html(get_the_title($transfer->ID)); ?>
                                    </h3>
                                    <?php if ($transfer_price): ?>
                                        <span class="text-xs font-bold text-amber-600">$<?php echo esc_html($transfer_price); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if ($transfer_tagline): ?>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-2"><?php echo esc_html($transfer_tagline); ?></p>
                                <?php endif; ?>
                                <?php if ($transfer_duration): ?>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1"><?php echo esc_html($transfer_duration); ?></p>
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
    const mainImage = document.getElementById('main-transfer-image');
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
const mainImage = document.getElementById('main-transfer-image');
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
const waMessage = "Hi, I'm interested in booking the <?php echo addslashes(get_the_title()); ?> transfer. Can you share more details?";
const waUrl = "https://wa.me/" + whatsappNumber + "?text=" + encodeURIComponent(waMessage);
document.getElementById('transfer-wa')?.setAttribute('href', waUrl);
</script>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
