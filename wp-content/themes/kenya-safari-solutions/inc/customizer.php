<?php
/**
 * Theme Customizer for CTA Section
 */

function kenya_safari_customize_register($wp_customize) {
    
    // Add CTA Section
    $wp_customize->add_section('kenya_cta_section', array(
        'title'    => __('CTA Section', 'kenya-safari'),
        'priority' => 130,
    ));
    
    // CTA Badge
    $wp_customize->add_setting('kenya_cta_badge', array(
        'default'           => 'Ready when you are',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('kenya_cta_badge', array(
        'label'       => __('Badge Text', 'kenya-safari'),
        'section'     => 'kenya_cta_section',
        'type'        => 'text',
    ));
    
    // CTA Title
    $wp_customize->add_setting('kenya_cta_title', array(
        'default'           => 'Ready for your Kenya adventure?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('kenya_cta_title', array(
        'label'       => __('Title', 'kenya-safari'),
        'section'     => 'kenya_cta_section',
        'type'        => 'text',
    ));
    
    // CTA Gradient Text
    $wp_customize->add_setting('kenya_cta_gradient_text', array(
        'default'           => 'Kenya adventure?',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('kenya_cta_gradient_text', array(
        'label'       => __('Gradient Highlight Text', 'kenya-safari'),
        'description' => __('Text that will have gold gradient (include punctuation)', 'kenya-safari'),
        'section'     => 'kenya_cta_section',
        'type'        => 'text',
    ));
    
    // CTA Description
    $wp_customize->add_setting('kenya_cta_description', array(
        'default'           => 'We\'ll design it around you. Reply in minutes — book in days.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('kenya_cta_description', array(
        'label'       => __('Description', 'kenya-safari'),
        'section'     => 'kenya_cta_section',
        'type'        => 'textarea',
    ));
    
    // CTA Button 1 Text
    $wp_customize->add_setting('kenya_cta_btn1_text', array(
        'default'           => 'Plan My Safari',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('kenya_cta_btn1_text', array(
        'label'       => __('Button 1 Text', 'kenya-safari'),
        'section'     => 'kenya_cta_section',
        'type'        => 'text',
    ));
    
    // CTA Button 1 URL
    $wp_customize->add_setting('kenya_cta_btn1_url', array(
        'default'           => '#destinations',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('kenya_cta_btn1_url', array(
        'label'       => __('Button 1 URL', 'kenya-safari'),
        'section'     => 'kenya_cta_section',
        'type'        => 'url',
    ));
    
    // CTA Button 2 Text
    $wp_customize->add_setting('kenya_cta_btn2_text', array(
        'default'           => 'Chat on WhatsApp',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('kenya_cta_btn2_text', array(
        'label'       => __('Button 2 Text', 'kenya-safari'),
        'section'     => 'kenya_cta_section',
        'type'        => 'text',
    ));
    
    // CTA Background Image
    $wp_customize->add_setting('kenya_cta_bg_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'kenya_cta_bg_image', array(
        'label'       => __('Background Image', 'kenya-safari'),
        'description' => __('Image will have 20% opacity and gradient overlay', 'kenya-safari'),
        'section'     => 'kenya_cta_section',
        'settings'    => 'kenya_cta_bg_image',
    )));
    
    // CTA Background Color
    $wp_customize->add_setting('kenya_cta_bg_color', array(
        'default'           => '#2a1f18',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'kenya_cta_bg_color', array(
        'label'       => __('Background Color', 'kenya-safari'),
        'section'     => 'kenya_cta_section',
        'settings'    => 'kenya_cta_bg_color',
    )));
}
add_action('customize_register', 'kenya_safari_customize_register');
