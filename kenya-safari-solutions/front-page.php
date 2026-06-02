<?php get_header(); ?>

<?php
$hero_title = get_post_meta(get_the_ID(), '_kenya_hero_title', true);
$hero_subtitle = get_post_meta(get_the_ID(), '_kenya_hero_subtitle', true);
$hero_cta_text = get_post_meta(get_the_ID(), '_kenya_hero_cta_text', true);
$hero_cta_url = get_post_meta(get_the_ID(), '_kenya_hero_cta_url', true);
$hero_video = get_post_meta(get_the_ID(), '_kenya_hero_video', true);
$destinations = get_post_meta(get_the_ID(), '_kenya_destinations', true);
?>

<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <?php if ($hero_video): ?>
        <video autoplay loop muted playsinline class="absolute w-full h-full object-cover">
            <source src="<?php echo esc_url($hero_video); ?>" type="video/mp4">
        </video>
    <?php elseif (has_post_thumbnail()): ?>
        <?php echo get_the_post_thumbnail(get_the_ID(), 'hero-bg', ['class' => 'absolute w-full h-full object-cover']); ?>
    <?php endif; ?>
    
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    
    <div class="container mx-auto px-4 text-center text-white relative z-10">
        <h1 class="font-display text-5xl md:text-7xl font-bold mb-6 animate-fade-in">
            <?php echo esc_html($hero_title ?: 'Discover Kenya Safari Solutions'); ?>
        </h1>
        <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
            <?php echo esc_html($hero_subtitle ?: 'Experience the best safaris in Kenya with expert guides'); ?>
        </p>
        <?php if ($hero_cta_text && $hero_cta_url): ?>
            <a href="<?php echo esc_url($hero_cta_url); ?>" class="inline-block bg-amber-500 hover:bg-amber-600 text-white font-semibold px-8 py-4 rounded-full transition transform hover:scale-105">
                <?php echo esc_html($hero_cta_text); ?>
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        <?php endif; ?>
    </div>
</section>

<!-- Destinations Section -->
<?php if (!empty($destinations)): ?>
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="font-display text-4xl md:text-5xl font-bold text-gray-900 mb-4">Popular Destinations</h2>
            <p class="text-xl text-gray-600">Explore Kenya's most breathtaking locations</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($destinations as $dest): ?>
                <div class="group relative overflow-hidden rounded-2xl shadow-lg">
                    <img src="<?php echo esc_url($dest['image']); ?>" alt="<?php echo esc_attr($dest['name']); ?>" class="w-full h-80 object-cover transition duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-70"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-2xl font-bold mb-2"><?php echo esc_html($dest['name']); ?></h3>
                        <p class="text-gray-200"><?php echo esc_html($dest['desc']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Main Content -->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php if (get_the_content()): ?>
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="prose prose-lg max-w-none">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endwhile; endif; ?>

<!-- CTA Section -->
<section class="py-20 bg-amber-500 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="font-display text-4xl md:text-5xl font-bold mb-6">Ready for Your Safari Adventure?</h2>
        <p class="text-xl mb-8">Contact us today to start planning your dream Kenyan safari</p>
        <a href="/contact" class="inline-block bg-white text-amber-600 hover:bg-gray-100 font-semibold px-8 py-4 rounded-full transition">
            Book Your Safari Now
            <i class="fas fa-calendar-check ml-2"></i>
        </a>
    </div>
</section>

<?php get_footer(); ?>
