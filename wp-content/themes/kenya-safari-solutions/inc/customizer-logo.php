<?php
function kenya_safari_customize_logo($wp_customize) {
    $wp_customize->add_setting('kenya_logo_width', array(
        'default' => 40,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('kenya_logo_width', array(
        'label' => __('Logo Width (px)', 'kenya-safari'),
        'section' => 'title_tagline',
        'type' => 'number',
    ));
    
    $wp_customize->add_setting('kenya_logo_height', array(
        'default' => 40,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('kenya_logo_height', array(
        'label' => __('Logo Height (px)', 'kenya-safari'),
        'section' => 'title_tagline',
        'type' => 'number',
    ));
    
    // Dark Mode Logo - add this setting
    $wp_customize->add_setting('kenya_dark_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'kenya_dark_logo', array(
        'label' => __('Dark Mode Logo', 'kenya-safari'),
        'section' => 'title_tagline',
        'settings' => 'kenya_dark_logo',
    )));
}
add_action('customize_register', 'kenya_safari_customize_logo');

function kenya_safari_logo_size() {
    $width = get_theme_mod('kenya_logo_width', 40);
    $height = get_theme_mod('kenya_logo_height', 40);
    echo '<style>.custom-logo,.dark-mode-logo{width:' . $width . 'px!important;height:' . $height . 'px!important;object-fit:contain}</style>';
}
add_action('wp_head', 'kenya_safari_logo_size');

// Dark mode logo switcher
function kenya_safari_dark_logo_css() {
    $dark_logo = get_theme_mod('kenya_dark_logo', '');
    if ($dark_logo) {
        echo '<style>.custom-logo{display:block}.dark-mode-logo{display:none}.dark .custom-logo{display:none!important}.dark .dark-mode-logo{display:block!important}</style>';
    }
}
add_action('wp_head', 'kenya_safari_dark_logo_css');
