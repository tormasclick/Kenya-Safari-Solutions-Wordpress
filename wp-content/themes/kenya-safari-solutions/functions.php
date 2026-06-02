<?php
/**
 * Kenya Safari Solutions Theme Functions
 * Modular approach - each feature in its own file
 */

// Theme Setup
function kenya_safari_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    
    register_nav_menus(array(
        'primary' => 'Primary Menu',
        'footer' => 'Footer Menu',
    ));
    
    add_image_size('destination-card', 600, 450, true);
    add_image_size('destination-grid', 800, 600, true);
}
add_action('after_setup_theme', 'kenya_safari_setup');

// Enqueue assets
function kenya_safari_assets() {
    wp_enqueue_style('kenya-custom', get_template_directory_uri() . '/assets/css/custom.css', array(), '1.0');
    wp_enqueue_script('kenya-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'kenya_safari_assets');

// Load modular files
require_once get_template_directory() . '/inc/destinations-cpt.php';
require_once get_template_directory() . '/inc/accommodations-cpt.php';
require_once get_template_directory() . '/inc/marine-cpt.php';
require_once get_template_directory() . '/inc/packages-cpt.php';
require_once get_template_directory() . '/inc/transfers-cpt.php';
require_once get_template_directory() . '/inc/rentals-cpt.php';
require_once get_template_directory() . '/inc/testimonials-cpt.php';
require_once get_template_directory() . '/inc/theme-options.php';
require_once get_template_directory() . '/inc/destination-cta-settings.php';
require_once get_template_directory() . '/inc/marine-cta-settings.php';
require_once get_template_directory() . '/inc/accommodation-cta-settings.php';
require_once get_template_directory() . '/inc/accommodation-faqs-fixed.php';

// Make custom post types visible in menus
function kenya_safari_enable_cpts_in_menus() {
    $cpts = array('destination', 'accommodation', 'marine', 'package', 'transfer', 'rental');
    foreach ($cpts as $cpt) {
        $post_type = get_post_type_object($cpt);
        if ($post_type) {
            $post_type->show_in_nav_menus = true;
            $post_type->public = true;
            $post_type->publicly_queryable = true;
        }
    }
}
add_action('init', 'kenya_safari_enable_cpts_in_menus', 40);
require_once get_template_directory() . '/inc/accommodation-faqs-simple.php';
require_once get_template_directory() . '/inc/accommodation-faqs-working.php';

// Load Global Settings
require_once get_template_directory() . '/inc/global-settings.php';

// Load Rental CTA Settings
require_once get_template_directory() . '/inc/rental-cta-settings.php';

// Load Transfer CTA Settings
require_once get_template_directory() . '/inc/transfer-cta-settings.php';
require_once get_template_directory() . '/inc/page-settings.php';
require_once get_template_directory() . '/inc/customizer-logo.php';
require_once get_template_directory() . '/inc/contact-page-settings.php';

// Enqueue mobile menu script
function kenya_safari_mobile_menu_script() {
    wp_enqueue_script('kenya-mobile-menu', get_template_directory_uri() . '/assets/js/mobile-menu.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'kenya_safari_mobile_menu_script');
