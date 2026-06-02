<?php
/**
 * Contact Page Settings Meta Box
 */

// Add meta box to Contact page only
function kenya_safari_contact_page_metabox() {
    add_meta_box(
        'contact_page_settings',
        'Contact Page Settings',
        'kenya_safari_contact_page_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kenya_safari_contact_page_metabox');

function kenya_safari_contact_page_callback($post) {
    // Only show on contact page
    if ($post->post_name !== 'contact') return;
    
    wp_nonce_field('contact_page_settings', 'contact_page_settings_nonce');
    
    // Get saved values
    $hero_title = get_post_meta($post->ID, '_contact_hero_title', true);
    $hero_subtitle = get_post_meta($post->ID, '_contact_hero_subtitle', true);
    $hero_description = get_post_meta($post->ID, '_contact_hero_description', true);
    $contact_form_shortcode = get_post_meta($post->ID, '_contact_form_shortcode', true);
    $phone_number = get_post_meta($post->ID, '_contact_phone_number', true);
    $email_address = get_post_meta($post->ID, '_contact_email_address', true);
    $office_location = get_post_meta($post->ID, '_contact_office_location', true);
    $office_hours = get_post_meta($post->ID, '_contact_office_hours', true);
    ?>
    <style>
        .contact-settings-field { margin-bottom: 20px; }
        .contact-settings-field label { display: block; font-weight: bold; margin-bottom: 8px; }
        .contact-settings-field input[type="text"],
        .contact-settings-field textarea,
        .contact-settings-field input[type="email"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .contact-settings-field textarea { min-height: 100px; }
        .settings-divider { border-top: 1px solid #ddd; margin: 20px 0; padding-top: 10px; }
    </style>
    
    <div class="contact-settings-field">
        <label>Hero Eyebrow:</label>
        <input type="text" name="contact_hero_eyebrow" value="<?php echo esc_attr(get_post_meta($post->ID, '_contact_hero_eyebrow', true) ?: 'Get in Touch'); ?>" class="widefat" />
    </div>
    
    <div class="contact-settings-field">
        <label>Hero Title:</label>
        <input type="text" name="contact_hero_title" value="<?php echo esc_attr($hero_title ?: "Let's Start a Conversation"); ?>" class="widefat" />
        <p class="description">Use {gradient} to highlight a word with gradient color. Example: "Let's Start a {gradient}Conversation{/gradient}"</p>
    </div>
    
    <div class="contact-settings-field">
        <label>Hero Description:</label>
        <textarea name="contact_hero_description"><?php echo esc_textarea($hero_description ?: "Whether you're planning your dream safari or have questions about our services, our team is here to help."); ?></textarea>
    </div>
    
    <div class="settings-divider"></div>
    
    <h3>Contact Information</h3>
    
    <div class="contact-settings-field">
        <label>Phone Number:</label>
        <input type="text" name="contact_phone_number" value="<?php echo esc_attr($phone_number ?: '+254 700 563 754'); ?>" class="widefat" />
    </div>
    
    <div class="contact-settings-field">
        <label>Email Address:</label>
        <input type="email" name="contact_email_address" value="<?php echo esc_attr($email_address ?: 'info@kenyasafarisolutions.com'); ?>" class="widefat" />
    </div>
    
    <div class="contact-settings-field">
        <label>Office Location:</label>
        <input type="text" name="contact_office_location" value="<?php echo esc_attr($office_location ?: 'Nairobi & Watamu, Kenya'); ?>" class="widefat" />
    </div>
    
    <div class="contact-settings-field">
        <label>Office Hours:</label>
        <input type="text" name="contact_office_hours" value="<?php echo esc_attr($office_hours ?: 'Monday - Friday: 9am - 6pm'); ?>" class="widefat" />
    </div>
    
    <div class="settings-divider"></div>
    
    <h3>Contact Form</h3>
    
    <div class="contact-settings-field">
        <label>Contact Form 7 Shortcode:</label>
        <input type="text" name="contact_form_shortcode" value="<?php echo esc_attr($contact_form_shortcode ?: '[contact-form-7 id="229" title="Contact form"]'); ?>" class="widefat" />
        <p class="description">Enter your Contact Form 7 shortcode. Example: <code>[contact-form-7 id="229" title="Contact form"]</code></p>
    </div>
    
    <div class="contact-settings-field">
        <label>Form Title:</label>
        <input type="text" name="contact_form_title" value="<?php echo esc_attr(get_post_meta($post->ID, '_contact_form_title', true) ?: 'Send Us a Message'); ?>" class="widefat" />
    </div>
    
    <div class="contact-settings-field">
        <label>Form Description:</label>
        <input type="text" name="contact_form_description" value="<?php echo esc_attr(get_post_meta($post->ID, '_contact_form_description', true) ?: 'Fill out the form and we\'ll get back to you shortly'); ?>" class="widefat" />
    </div>
    <?php
}

// Save contact page settings
function kenya_safari_save_contact_page_settings($post_id) {
    if (isset($_POST['contact_page_settings_nonce']) && wp_verify_nonce($_POST['contact_page_settings_nonce'], 'contact_page_settings')) {
        $fields = array(
            'contact_hero_eyebrow', 'contact_hero_title', 'contact_hero_description',
            'contact_phone_number', 'contact_email_address', 'contact_office_location',
            'contact_office_hours', 'contact_form_shortcode', 'contact_form_title',
            'contact_form_description'
        );
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}
add_action('save_post', 'kenya_safari_save_contact_page_settings');
