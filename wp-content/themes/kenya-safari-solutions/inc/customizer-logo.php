<?php
/**
 * Logo Resize Setting in Customizer
 */

function kenya_safari_customize_logo($wp_customize) {
    // Add logo width setting
    $wp_customize->add_setting('kenya_logo_width', array(
        'default' => 40,
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('kenya_logo_width', array(
        'label' => __('Logo Width (px)', 'kenya-safari'),
        'section' => 'title_tagline',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 20,
            'max' => 200,
            'step' => 5,
        ),
    ));
    
    // Add logo height setting
    $wp_customize->add_setting('kenya_logo_height', array(
        'default' => 40,
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('kenya_logo_height', array(
        'label' => __('Logo Height (px)', 'kenya-safari'),
        'section' => 'title_tagline',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 20,
            'max' => 200,
            'step' => 5,
        ),
    ));
}

add_action('customize_register', 'kenya_safari_customize_logo');

// Apply logo size to custom logo
function kenya_safari_logo_size() {
    $logo_width = get_theme_mod('kenya_logo_width', 40);
    $logo_height = get_theme_mod('kenya_logo_height', 40);
    ?>
    <style>
        .custom-logo {
            width: <?php echo esc_attr($logo_width); ?>px !important;
            height: <?php echo esc_attr($logo_height); ?>px !important;
            object-fit: contain;
        }
    </style>
    <?php
}
add_action('wp_head', 'kenya_safari_logo_size');
