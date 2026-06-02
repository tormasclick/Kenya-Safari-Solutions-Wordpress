<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); 
    // Get all meta data
    $tagline = get_post_meta(get_the_ID(), '_accommodation_tagline', true);
    $location = get_post_meta(get_the_ID(), '_accommodation_location', true);
    $price_range = get_post_meta(get_the_ID(), '_accommodation_price_range', true);
    $type = get_post_meta(get_the_ID(), '_accommodation_type', true);
    $rating = get_post_meta(get_the_ID(), '_accommodation_rating', true);
    $amenities = get_post_meta(get_the_ID(), '_accommodation_amenities', true);
    $amenities_array = $amenities ? explode(',', $amenities) : array();
    $best_for = get_post_meta(get_the_ID(), '_accommodation_best_for', true);
    $best_for_array = $best_for ? explode(',', $best_for) : array();
    $faqs_json = get_post_meta(get_the_ID(), '_accommodation_faqs', true);
    $faqs = $faqs_json ? json_decode($faqs_json, true) : array();
    
    // Get gallery images
    $gallery_ids = get_post_meta(get_the_ID(), '_accommodation_gallery_ids', true);
    $gallery_images = $gallery_ids ? explode(',', $gallery_ids) : array();
    $main_image = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : '';
    
    // Get other accommodations for "You May Like" section
    $other_accommodations = get_posts(array(
        'post_type' => 'accommodation',
        'posts_per_page' => 4,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand'
    ));
    
    // Get CTA settings
    $cta_title_template = get_option('kenya_accommodation_cta_title', 'Book {accommodation_name}');
    $cta_title = str_replace('{accommodation_name}', get_the_title(), $cta_title_template);
    $cta_description = get_option('kenya_accommodation_cta_description', 'Check availability and get the best rates');
    $cta_button_text = get_option('kenya_accommodation_cta_button_text', 'Inquire on WhatsApp');
    $whatsapp_number = get_option('kenya_whatsapp_number', '254700563754');
?>

<main class="pt-32 pb-16 px-4 bg-white dark:bg-[#0f0a08] transition-colors duration-300">
    <div class="mx-auto max-w-6xl">
        <!-- Breadcrumbs -->
        <div class="text-sm text-gray-600 dark:text-gray-400 mb-4 flex items-center gap-2 flex-wrap">
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
                    <img id="main-accommodation-image" src="<?php echo esc_url($main_image); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover">
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

            <!-- Right Column: Title, Type, Rating, Location, Price, Tagline, Amenities, Best For -->
            <div class="space-y-4">
                <h1 class="font-display text-4xl lg:text-5xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                    <?php the_title(); ?>
                </h1>
                
                <div class="flex flex-wrap gap-2">
                    <?php if ($type): ?>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-100 dark:bg-amber-200 rounded-full">
                            <i class="fas fa-tag h-4 w-4 text-amber-600 dark:text-amber-800"></i>
                            <span class="text-sm font-medium text-amber-700 dark:text-amber-900"><?php echo esc_html($type); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($rating): ?>
                        <div class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 dark:bg-yellow-200 rounded-full">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star text-xs <?php echo $i <= $rating ? 'text-yellow-500' : 'text-gray-300'; ?>"></i>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($location): ?>
                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                        <i class="fas fa-map-marker-alt text-amber-500"></i>
                        <span><?php echo esc_html($location); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($price_range): ?>
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 dark:bg-green-200 rounded-full">
                        <i class="fas fa-dollar-sign h-4 w-4 text-green-600 dark:text-green-800"></i>
                        <span class="text-sm font-medium text-green-700 dark:text-green-900"><?php echo esc_html($price_range); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($tagline): ?>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed"><?php echo esc_html($tagline); ?></p>
                <?php endif; ?>
                
                <!-- Amenities as fancy tags -->
                <?php if (!empty($amenities_array)): ?>
                    <div>
                        <h2 class="font-display text-xl font-bold mb-3 text-gray-900 dark:text-white">✨ Amenities</h2>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($amenities_array as $amenity): ?>
                                <?php $amenity_clean = trim($amenity); ?>
                                <?php if ($amenity_clean): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-100 dark:bg-amber-900/40 rounded-full text-sm text-amber-800 dark:text-amber-300 shadow-sm hover:shadow-md transition-all">
                                        <i class="fas fa-check-circle text-amber-600 dark:text-amber-400 text-xs"></i>
                                        <?php echo esc_html($amenity_clean); ?>
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

        <!-- Full Description - Full width below the two columns (like Marine) -->
        <div id="full-description" class="mt-12">
            <div class="prose prose-amber dark:prose-invert max-w-none">
                <?php the_content(); ?>
            </div>
        </div>

        <!-- FAQ Section - Below Full Description, Above CTA -->
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
            <a href="#" id="accommodation-wa" target="_blank" class="mt-4 inline-flex items-center justify-center gap-2 rounded-full bg-white text-amber-600 px-6 py-3 font-bold hover:scale-105 transition shadow-lg">
                <i class="fab fa-whatsapp h-5 w-5"></i> <?php echo esc_html($cta_button_text); ?>
            </a>
            <p class="text-xs text-center mt-3 text-white/80">Best price guaranteed</p>
        </div>

        <!-- You May Also Like Section -->
        <?php if (!empty($other_accommodations)): ?>
            <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-800">
                <h2 class="font-display text-2xl font-bold text-center mb-8 text-gray-900 dark:text-white">
                    You May Also Like
                </h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <?php foreach ($other_accommodations as $acc): 
                        $acc_image = get_the_post_thumbnail_url($acc->ID, 'medium');
                        $acc_location = get_post_meta($acc->ID, '_accommodation_location', true);
                        $acc_price = get_post_meta($acc->ID, '_accommodation_price_range', true);
                        $acc_type = get_post_meta($acc->ID, '_accommodation_type', true);
                    ?>
                        <a href="<?php echo get_permalink($acc->ID); ?>" class="group rounded-2xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 overflow-hidden hover:shadow-xl transition hover:-translate-y-1">
                            <div class="relative h-48 overflow-hidden">
                                <?php if ($acc_image): ?>
                                    <img src="<?php echo esc_url($acc_image); ?>" alt="<?php echo esc_attr(get_the_title($acc->ID)); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                <?php endif; ?>
                                <div class="absolute top-2 left-2">
                                    <span class="px-2 py-0.5 rounded text-xs font-semibold bg-amber-500/90 text-white">
                                        <?php echo esc_html($acc_type); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-display text-base font-bold group-hover:text-amber-600 transition text-gray-900 dark:text-white line-clamp-1">
                                    <?php echo esc_html(get_the_title($acc->ID)); ?>
                                </h3>
                                <?php if ($acc_location): ?>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1"><?php echo esc_html($acc_location); ?></p>
                                <?php endif; ?>
                                <?php if ($acc_price): ?>
                                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-2 font-semibold"><?php echo esc_html($acc_price); ?></p>
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
    const mainImage = document.getElementById('main-accommodation-image');
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
const mainImage = document.getElementById('main-accommodation-image');
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
const waMessage = "Hi, I'm interested in booking <?php echo addslashes(get_the_title()); ?>. Can you share more details about availability and pricing?";
const waUrl = "https://wa.me/" + whatsappNumber + "?text=" + encodeURIComponent(waMessage);
document.getElementById('accommodation-wa')?.setAttribute('href', waUrl);
</script>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
