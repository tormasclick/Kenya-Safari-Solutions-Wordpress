<?php
/**
 * Kenya Safari Solutions Theme Functions
 */

// Theme Setup
function kenya_safari_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo', [
        'height' => 80,
        'width' => 200,
        'flex-height' => true,
        'flex-width' => true,
    ]);
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    
    // Register menus
    register_nav_menus([
        'primary' => 'Primary Navigation',
        'footer' => 'Footer Navigation',
    ]);
    
    // Image sizes
    add_image_size('hero-bg', 1920, 1080, true);
    add_image_size('card-image', 600, 400, true);
    add_image_size('gallery', 800, 800, true);
}
add_action('after_setup_theme', 'kenya_safari_setup');

// Enqueue assets
function kenya_safari_assets() {
    // Google Fonts
    wp_enqueue_style('kenya-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Fraunces:wght@400;500;600;700;800;900&display=swap', [], null);
    
    // FontAwesome
    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', [], '6.4.0');
    
    // Tailwind CSS
    wp_enqueue_style('kenya-tailwind', get_template_directory_uri() . '/assets/css/tailwind.css', [], '1.0.0');
    
    // Custom CSS
    wp_enqueue_style('kenya-custom', get_template_directory_uri() . '/assets/css/custom.css', [], '1.0.0');
    
    // jQuery
    wp_enqueue_script('jquery');
    
    // Main JS
    wp_enqueue_script('kenya-main', get_template_directory_uri() . '/assets/js/main.js', ['jquery'], '1.0.0', true);
    
    // Carousel JS
    wp_enqueue_script('kenya-carousel', get_template_directory_uri() . '/assets/js/carousel.js', [], '1.0.0', true);
    
    // Localize
    wp_localize_script('kenya-main', 'kenyaData', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('kenya_nonce'),
        'siteUrl' => home_url(),
    ]);
}
add_action('wp_enqueue_scripts', 'kenya_safari_assets');

// Include metaboxes
require_once get_template_directory() . '/inc/metaboxes.php';

// Remove unnecessary head links
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
