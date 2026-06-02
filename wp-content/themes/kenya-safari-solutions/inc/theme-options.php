<?php
/**
 * Theme Options Page for CTA and Footer Settings
 */

// Add admin menu
function kenya_safari_admin_menu() {
    add_theme_page(
        'Theme Settings',
        'Theme Settings',
        'manage_options',
        'kenya-safari-settings',
        'kenya_safari_settings_page'
    );
}
add_action('admin_menu', 'kenya_safari_admin_menu');

// Custom sanitize for URL that allows #
function kenya_safari_sanitize_url_or_hash($input) {
    if ($input === '#' || strpos($input, '#') === 0) {
        return $input;
    }
    if (strpos($input, '/') === 0) {
        return $input;
    }
    return esc_url_raw($input);
}

// Register settings
function kenya_safari_register_settings() {
    // CTA Settings
    register_setting('kenya_safari_settings', 'kenya_cta_badge');
    register_setting('kenya_safari_settings', 'kenya_cta_title');
    register_setting('kenya_safari_settings', 'kenya_cta_gradient_text');
    register_setting('kenya_safari_settings', 'kenya_cta_description');
    register_setting('kenya_safari_settings', 'kenya_cta_btn1_text');
    register_setting('kenya_safari_settings', 'kenya_cta_btn1_url', array('sanitize_callback' => 'kenya_safari_sanitize_url_or_hash'));
    register_setting('kenya_safari_settings', 'kenya_cta_btn2_text');
    register_setting('kenya_safari_settings', 'kenya_cta_bg_color');
    register_setting('kenya_safari_settings', 'kenya_cta_bg_image');
    register_setting('kenya_safari_settings', 'kenya_cta_bg_opacity');
    
    // Footer Settings
    register_setting('kenya_safari_settings', 'kenya_footer_name');
    register_setting('kenya_safari_settings', 'kenya_footer_logo');
    register_setting('kenya_safari_settings', 'kenya_footer_tagline');
    register_setting('kenya_safari_settings', 'kenya_footer_description');
    register_setting('kenya_safari_settings', 'kenya_footer_phone');
    register_setting('kenya_safari_settings', 'kenya_footer_email');
    register_setting('kenya_safari_settings', 'kenya_footer_copyright');
    register_setting('kenya_safari_settings', 'kenya_footer_facebook');
    register_setting('kenya_safari_settings', 'kenya_footer_instagram');
    register_setting('kenya_safari_settings', 'kenya_footer_twitter');
    register_setting('kenya_safari_settings', 'kenya_footer_youtube');
}
add_action('admin_init', 'kenya_safari_register_settings');

// Enqueue media uploader
function kenya_safari_admin_scripts($hook) {
    if ($hook != 'appearance_page_kenya-safari-settings') {
        return;
    }
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'kenya_safari_admin_scripts');

// Settings Page
function kenya_safari_settings_page() {
    $cta_bg_image = get_option('kenya_cta_bg_image', '');
    $cta_bg_opacity = get_option('kenya_cta_bg_opacity', '20');
    ?>
    <div class="wrap">
        <h1>Theme Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('kenya_safari_settings'); ?>
            
            <h2 style="margin-top: 20px; padding: 10px; background: #f0f0f0;">CTA Section</h2>
            <table class="form-table">
                <tr><th>Badge Text</th><td><input type="text" name="kenya_cta_badge" value="<?php echo esc_attr(get_option('kenya_cta_badge', 'Ready when you are')); ?>" class="regular-text" /></td></tr>
                <tr><th>Main Title</th><td><input type="text" name="kenya_cta_title" value="<?php echo esc_attr(get_option('kenya_cta_title', 'Ready for your Kenya adventure?')); ?>" class="regular-text" /></td></tr>
                <tr><th>Gradient Text</th><td><input type="text" name="kenya_cta_gradient_text" value="<?php echo esc_attr(get_option('kenya_cta_gradient_text', 'Kenya adventure?')); ?>" class="regular-text" /></td></tr>
                <tr><th>Description</th><td><textarea name="kenya_cta_description" rows="3" class="large-text"><?php echo esc_textarea(get_option('kenya_cta_description', 'We\'ll design it around you. Reply in minutes — book in days.')); ?></textarea></td></tr>
                <tr><th>Button 1 Text</th><td><input type="text" name="kenya_cta_btn1_text" value="<?php echo esc_attr(get_option('kenya_cta_btn1_text', 'Plan My Safari')); ?>" class="regular-text" /></td></tr>
                <tr><th>Button 1 URL</th><td><input type="text" name="kenya_cta_btn1_url" value="<?php echo esc_attr(get_option('kenya_cta_btn1_url', '#destinations')); ?>" class="regular-text" /></td></tr>
                <tr><th>Button 2 Text</th><td><input type="text" name="kenya_cta_btn2_text" value="<?php echo esc_attr(get_option('kenya_cta_btn2_text', 'Chat on WhatsApp')); ?>" class="regular-text" /></td></tr>
                <tr><th>Background Color</th><td><input type="color" name="kenya_cta_bg_color" value="<?php echo esc_attr(get_option('kenya_cta_bg_color', '#2a1f18')); ?>" /></td></tr>
                <tr><th>Background Image</th><td>
                    <div><input type="hidden" name="kenya_cta_bg_image" id="kenya_cta_bg_image" value="<?php echo esc_attr($cta_bg_image); ?>" />
                    <div id="cta-image-preview"><?php if ($cta_bg_image): ?><img src="<?php echo esc_url($cta_bg_image); ?>" style="max-width:200px"><?php endif; ?></div>
                    <button type="button" class="button" id="upload-cta-image">Upload Image</button>
                    <button type="button" class="button" id="remove-cta-image">Remove</button></div>
                 </th> </tr>
                <tr><th>Image Opacity</th><td><input type="range" name="kenya_cta_bg_opacity" min="0" max="100" value="<?php echo $cta_bg_opacity; ?>"> <span><?php echo $cta_bg_opacity; ?>%</span> </th> </tr>
             </table>
             
             <h2 style="margin-top: 30px; padding: 10px; background: #f0f0f0;">Footer Settings</h2>
             <table class="form-table">
                <tr><th>Site Name</th><td><input type="text" name="kenya_footer_name" value="<?php echo esc_attr(get_option('kenya_footer_name', 'Kenya Safari Solutions')); ?>" class="regular-text" /> </th> </tr>
                <tr><th>Footer Logo</th><td><input type="text" name="kenya_footer_logo" id="kenya_footer_logo" value="<?php echo esc_attr(get_option('kenya_footer_logo', '')); ?>" class="regular-text" /><button type="button" class="button" id="upload-logo-btn">Upload Logo</button> </th> </tr>
                <tr><th>Tagline</th><td><input type="text" name="kenya_footer_tagline" value="<?php echo esc_attr(get_option('kenya_footer_tagline', 'Explore . Discover . Experience')); ?>" class="regular-text" /> </th> </tr>
                <tr><th>Description</th><td><textarea name="kenya_footer_description" rows="3" class="large-text"><?php echo esc_textarea(get_option('kenya_footer_description', 'Private safaris, marine adventures, and unforgettable experiences across Kenya.')); ?></textarea> </th> </tr>
                <tr><th>Phone Number</th><td><input type="text" name="kenya_footer_phone" value="<?php echo esc_attr(get_option('kenya_footer_phone', '+254 700 000 000')); ?>" class="regular-text" /> </th> </tr>
                <tr><th>Email Address</th><td><input type="email" name="kenya_footer_email" value="<?php echo esc_attr(get_option('kenya_footer_email', 'info@kenyasafarisolutions.com')); ?>" class="regular-text" /> </th> </tr>
                <tr><th>Facebook URL</th><td><input type="text" name="kenya_footer_facebook" value="<?php echo esc_url(get_option('kenya_footer_facebook', '')); ?>" class="regular-text" /> </th> </tr>
                <tr><th>Instagram URL</th><td><input type="text" name="kenya_footer_instagram" value="<?php echo esc_url(get_option('kenya_footer_instagram', '')); ?>" class="regular-text" /> </th> </tr>
                <tr><th>Twitter URL</th><td><input type="text" name="kenya_footer_twitter" value="<?php echo esc_url(get_option('kenya_footer_twitter', '')); ?>" class="regular-text" /> </th> </tr>
                <tr><th>YouTube URL</th><td><input type="text" name="kenya_footer_youtube" value="<?php echo esc_url(get_option('kenya_footer_youtube', '')); ?>" class="regular-text" /> </th> </tr>
                <tr><th>Copyright Text</th><td><input type="text" name="kenya_footer_copyright" value="<?php echo esc_attr(get_option('kenya_footer_copyright', 'Kenya Safari Solutions. All rights reserved.')); ?>" class="regular-text" /> </th> </tr>
             </table>
             
            <?php submit_button('Save Settings'); ?>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var mediaUploader;
        $('#upload-logo-btn').click(function(e) {
            e.preventDefault();
            if (mediaUploader) { mediaUploader.open(); return; }
            mediaUploader = wp.media({ title: 'Select Logo', button: { text: 'Use this logo' }, multiple: false });
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#kenya_footer_logo').val(attachment.url);
            });
            mediaUploader.open();
        });
        
        var imageUploader;
        $('#upload-cta-image').click(function(e) {
            e.preventDefault();
            if (imageUploader) { imageUploader.open(); return; }
            imageUploader = wp.media({ title: 'Select Background Image', button: { text: 'Use this image' }, multiple: false });
            imageUploader.on('select', function() {
                var attachment = imageUploader.state().get('selection').first().toJSON();
                $('#kenya_cta_bg_image').val(attachment.url);
                $('#cta-image-preview').html('<img src="' + attachment.url + '" style="max-width:200px">');
            });
            imageUploader.open();
        });
        
        $('#remove-cta-image').click(function(e) {
            e.preventDefault();
            $('#kenya_cta_bg_image').val('');
            $('#cta-image-preview').html('');
        });
    });
    </script>
    <?php
}

// Add Section Headers Settings
function kenya_safari_section_headers_settings() {
    add_settings_section(
        'kenya_section_headers',
        'Section Headers',
        null,
        'kenya-safari-settings'
    );
    
    // Destinations Section Header
    register_setting('kenya_safari_settings', 'kenya_destinations_eyebrow');
    add_settings_field(
        'kenya_destinations_eyebrow',
        'Destinations Eyebrow',
        'kenya_destinations_eyebrow_callback',
        'kenya-safari-settings',
        'kenya_section_headers'
    );
    
    register_setting('kenya_safari_settings', 'kenya_destinations_title');
    add_settings_field(
        'kenya_destinations_title',
        'Destinations Title',
        'kenya_destinations_title_callback',
        'kenya-safari-settings',
        'kenya_section_headers'
    );
    
    register_setting('kenya_safari_settings', 'kenya_destinations_description');
    add_settings_field(
        'kenya_destinations_description',
        'Destinations Description',
        'kenya_destinations_description_callback',
        'kenya-safari-settings',
        'kenya_section_headers'
    );
    
    // Packages Section Header
    register_setting('kenya_safari_settings', 'kenya_packages_eyebrow');
    add_settings_field(
        'kenya_packages_eyebrow',
        'Packages Eyebrow',
        'kenya_packages_eyebrow_callback',
        'kenya-safari-settings',
        'kenya_section_headers'
    );
    
    register_setting('kenya_safari_settings', 'kenya_packages_title');
    add_settings_field(
        'kenya_packages_title',
        'Packages Title',
        'kenya_packages_title_callback',
        'kenya-safari-settings',
        'kenya_section_headers'
    );
    
    register_setting('kenya_safari_settings', 'kenya_packages_description');
    add_settings_field(
        'kenya_packages_description',
        'Packages Description',
        'kenya_packages_description_callback',
        'kenya-safari-settings',
        'kenya_section_headers'
    );
    
    // Marine Section Header
    register_setting('kenya_safari_settings', 'kenya_marine_eyebrow');
    add_settings_field(
        'kenya_marine_eyebrow',
        'Marine Eyebrow',
        'kenya_marine_eyebrow_callback',
        'kenya-safari-settings',
        'kenya_section_headers'
    );
    
    register_setting('kenya_safari_settings', 'kenya_marine_title');
    add_settings_field(
        'kenya_marine_title',
        'Marine Title',
        'kenya_marine_title_callback',
        'kenya-safari-settings',
        'kenya_section_headers'
    );
    
    register_setting('kenya_safari_settings', 'kenya_marine_description');
    add_settings_field(
        'kenya_marine_description',
        'Marine Description',
        'kenya_marine_description_callback',
        'kenya-safari-settings',
        'kenya_section_headers'
    );
    
    // Rentals Section Header
    register_setting('kenya_safari_settings', 'kenya_rentals_eyebrow');
    add_settings_field(
        'kenya_rentals_eyebrow',
        'Rentals Eyebrow',
        'kenya_rentals_eyebrow_callback',
        'kenya-safari-settings',
        'kenya_section_headers'
    );
    
    register_setting('kenya_safari_settings', 'kenya_rentals_title');
    add_settings_field(
        'kenya_rentals_title',
        'Rentals Title',
        'kenya_rentals_title_callback',
        'kenya-safari-settings',
        'kenya_section_headers'
    );
    
    register_setting('kenya_safari_settings', 'kenya_rentals_description');
    add_settings_field(
        'kenya_rentals_description',
        'Rentals Description',
        'kenya_rentals_description_callback',
        'kenya-safari-settings',
        'kenya_section_headers'
    );
    
    // Transfers Section Header
    register_setting('kenya_safari_settings', 'kenya_transfers_eyebrow');
    add_settings_field(
        'kenya_transfers_eyebrow',
        'Transfers Eyebrow',
        'kenya_transfers_eyebrow_callback',
        'kenya-safari-settings',
        'kenya_section_headers'
    );
    
    register_setting('kenya_safari_settings', 'kenya_transfers_title');
    add_settings_field(
        'kenya_transfers_title',
        'Transfers Title',
        'kenya_transfers_title_callback',
        'kenya-safari-settings',
        'kenya_section_headers'
    );
    
    register_setting('kenya_safari_settings', 'kenya_transfers_description');
    add_settings_field(
        'kenya_transfers_description',
        'Transfers Description',
        'kenya_transfers_description_callback',
        'kenya-safari-settings',
        'kenya_section_headers'
    );
}
add_action('admin_init', 'kenya_safari_section_headers_settings', 30);

// Callback functions
function kenya_destinations_eyebrow_callback() {
    $value = get_option('kenya_destinations_eyebrow', 'Featured destinations');
    echo '<input type="text" name="kenya_destinations_eyebrow" value="' . esc_attr($value) . '" class="regular-text" />';
}
function kenya_destinations_title_callback() {
    $value = get_option('kenya_destinations_title', 'Eight Kenyas, one journey.');
    echo '<input type="text" name="kenya_destinations_title" value="' . esc_attr($value) . '" class="regular-text" />';
}
function kenya_destinations_description_callback() {
    $value = get_option('kenya_destinations_description', 'From migration plains to coral coastlines — tap any tile for the inner brief, day-by-day cues, and what makes it unforgettable.');
    echo '<textarea name="kenya_destinations_description" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
}

function kenya_packages_eyebrow_callback() {
    $value = get_option('kenya_packages_eyebrow', 'Safari packages');
    echo '<input type="text" name="kenya_packages_eyebrow" value="' . esc_attr($value) . '" class="regular-text" />';
}
function kenya_packages_title_callback() {
    $value = get_option('kenya_packages_title', 'Day-by-day journeys, ready to book.');
    echo '<input type="text" name="kenya_packages_title" value="' . esc_attr($value) . '" class="regular-text" />';
}
function kenya_packages_description_callback() {
    $value = get_option('kenya_packages_description', 'Filter by style, open the itinerary, then book what\'s right for you.');
    echo '<textarea name="kenya_packages_description" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
}

function kenya_marine_eyebrow_callback() {
    $value = get_option('kenya_marine_eyebrow', 'Marine experiences');
    echo '<input type="text" name="kenya_marine_eyebrow" value="' . esc_attr($value) . '" class="regular-text" />';
}
function kenya_marine_title_callback() {
    $value = get_option('kenya_marine_title', 'The Indian Ocean, on your terms.');
    echo '<input type="text" name="kenya_marine_title" value="' . esc_attr($value) . '" class="regular-text" />';
}
function kenya_marine_description_callback() {
    $value = get_option('kenya_marine_description', 'Coral gardens, wild dolphins, and dhows under a melting sun. Explore Watamu\'s protected marine park with our expert guides.');
    echo '<textarea name="kenya_marine_description" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
}

function kenya_rentals_eyebrow_callback() {
    $value = get_option('kenya_rentals_eyebrow', 'Fleet & rentals');
    echo '<input type="text" name="kenya_rentals_eyebrow" value="' . esc_attr($value) . '" class="regular-text" />';
}
function kenya_rentals_title_callback() {
    $value = get_option('kenya_rentals_title', 'Pick your ride');
    echo '<input type="text" name="kenya_rentals_title" value="' . esc_attr($value) . '" class="regular-text" />';
}
function kenya_rentals_description_callback() {
    $value = get_option('kenya_rentals_description', 'Browse our fleet of safari vehicles. Click any vehicle for details and booking.');
    echo '<textarea name="kenya_rentals_description" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
}

function kenya_transfers_eyebrow_callback() {
    $value = get_option('kenya_transfers_eyebrow', 'Airport transfers');
    echo '<input type="text" name="kenya_transfers_eyebrow" value="' . esc_attr($value) . '" class="regular-text" />';
}
function kenya_transfers_title_callback() {
    $value = get_option('kenya_transfers_title', 'Land smoothly, leave gracefully.');
    echo '<input type="text" name="kenya_transfers_title" value="' . esc_attr($value) . '" class="regular-text" />';
}
function kenya_transfers_description_callback() {
    $value = get_option('kenya_transfers_description', 'Terminal-to-destination with premium vehicles and professional drivers.');
    echo '<textarea name="kenya_transfers_description" rows="3" class="large-text">' . esc_textarea($value) . '</textarea>';
}
