<?php
/**
 * Page-specific settings for landing pages
 */

// Add meta boxes to specific pages
function kenya_safari_add_page_metaboxes() {
    // Safaris page meta box
    add_meta_box(
        'safaris_page_settings',
        'Safaris Page Settings',
        'kenya_safari_safaris_page_callback',
        'page',
        'normal',
        'high'
    );
    
    // Marine page meta box
    add_meta_box(
        'marine_page_settings',
        'Marine Page Settings',
        'kenya_safari_marine_page_callback',
        'page',
        'normal',
        'high'
    );
    
    // Rentals page meta box
    add_meta_box(
        'rentals_page_settings',
        'Rentals Page Settings',
        'kenya_safari_rentals_page_callback',
        'page',
        'normal',
        'high'
    );
    
    // Transfers page meta box
    add_meta_box(
        'transfers_page_settings',
        'Transfers Page Settings',
        'kenya_safari_transfers_page_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kenya_safari_add_page_metaboxes');

// Safaris Page Meta Box
function kenya_safari_safaris_page_callback($post) {
    if ($post->post_name !== 'safaris') return;
    
    wp_nonce_field('safaris_page_settings', 'safaris_page_settings_nonce');
    
    $destinations_eyebrow = get_post_meta($post->ID, '_destinations_eyebrow', true);
    $destinations_title = get_post_meta($post->ID, '_destinations_title', true);
    $destinations_description = get_post_meta($post->ID, '_destinations_description', true);
    $packages_eyebrow = get_post_meta($post->ID, '_packages_eyebrow', true);
    $packages_title = get_post_meta($post->ID, '_packages_title', true);
    $packages_description = get_post_meta($post->ID, '_packages_description', true);
    ?>
    <style>
        .page-settings-field { margin-bottom: 20px; }
        .page-settings-field label { display: block; font-weight: bold; margin-bottom: 8px; }
        .page-settings-field input[type="text"] { width: 100%; padding: 8px; }
        .page-settings-field textarea { width: 100%; padding: 8px; min-height: 80px; }
        .settings-divider { border-top: 1px solid #ddd; margin: 20px 0; padding-top: 10px; }
    </style>
    
    <h3>Destinations Section</h3>
    <div class="page-settings-field">
        <label>Destinations Eyebrow:</label>
        <input type="text" name="destinations_eyebrow" value="<?php echo esc_attr($destinations_eyebrow ?: 'Featured destinations'); ?>" />
    </div>
    <div class="page-settings-field">
        <label>Destinations Title:</label>
        <input type="text" name="destinations_title" value="<?php echo esc_attr($destinations_title ?: 'Eight Kenyas, one journey.'); ?>" />
    </div>
    <div class="page-settings-field">
        <label>Destinations Description:</label>
        <textarea name="destinations_description"><?php echo esc_textarea($destinations_description ?: 'From migration plains to coral coastlines — tap any tile for the inner brief, day-by-day cues, and what makes it unforgettable.'); ?></textarea>
    </div>
    
    <div class="settings-divider"></div>
    
    <h3>Packages Section</h3>
    <div class="page-settings-field">
        <label>Packages Eyebrow:</label>
        <input type="text" name="packages_eyebrow" value="<?php echo esc_attr($packages_eyebrow ?: 'Safari packages'); ?>" />
    </div>
    <div class="page-settings-field">
        <label>Packages Title:</label>
        <input type="text" name="packages_title" value="<?php echo esc_attr($packages_title ?: 'Day-by-day journeys, ready to book.'); ?>" />
    </div>
    <div class="page-settings-field">
        <label>Packages Description:</label>
        <textarea name="packages_description"><?php echo esc_textarea($packages_description ?: 'Filter by style, open the itinerary, then book what\'s right for you.'); ?></textarea>
    </div>
    <?php
}

// Marine Page Meta Box
function kenya_safari_marine_page_callback($post) {
    if ($post->post_name !== 'marine') return;
    
    wp_nonce_field('marine_page_settings', 'marine_page_settings_nonce');
    
    $eyebrow = get_post_meta($post->ID, '_marine_eyebrow', true);
    $title = get_post_meta($post->ID, '_marine_title', true);
    $description = get_post_meta($post->ID, '_marine_description', true);
    ?>
    <div class="page-settings-field">
        <label>Marine Eyebrow:</label>
        <input type="text" name="marine_eyebrow" value="<?php echo esc_attr($eyebrow ?: 'Marine experiences'); ?>" />
    </div>
    <div class="page-settings-field">
        <label>Marine Title:</label>
        <input type="text" name="marine_title" value="<?php echo esc_attr($title ?: 'The Indian Ocean, on your terms.'); ?>" />
    </div>
    <div class="page-settings-field">
        <label>Marine Description:</label>
        <textarea name="marine_description"><?php echo esc_textarea($description ?: 'Coral gardens, wild dolphins, and dhows under a melting sun. Explore Watamu\'s protected marine park with our expert guides.'); ?></textarea>
    </div>
    <?php
}

// Rentals Page Meta Box
function kenya_safari_rentals_page_callback($post) {
    if ($post->post_name !== 'rentals') return;
    
    wp_nonce_field('rentals_page_settings', 'rentals_page_settings_nonce');
    
    $eyebrow = get_post_meta($post->ID, '_rentals_eyebrow', true);
    $title = get_post_meta($post->ID, '_rentals_title', true);
    $description = get_post_meta($post->ID, '_rentals_description', true);
    ?>
    <div class="page-settings-field">
        <label>Rentals Eyebrow:</label>
        <input type="text" name="rentals_eyebrow" value="<?php echo esc_attr($eyebrow ?: 'Fleet & rentals'); ?>" />
    </div>
    <div class="page-settings-field">
        <label>Rentals Title:</label>
        <input type="text" name="rentals_title" value="<?php echo esc_attr($title ?: 'Pick your ride'); ?>" />
    </div>
    <div class="page-settings-field">
        <label>Rentals Description:</label>
        <textarea name="rentals_description"><?php echo esc_textarea($description ?: 'Browse our fleet of safari vehicles. Click any vehicle for details and booking.'); ?></textarea>
    </div>
    <?php
}

// Transfers Page Meta Box
function kenya_safari_transfers_page_callback($post) {
    if ($post->post_name !== 'transfers') return;
    
    wp_nonce_field('transfers_page_settings', 'transfers_page_settings_nonce');
    
    $eyebrow = get_post_meta($post->ID, '_transfers_eyebrow', true);
    $title = get_post_meta($post->ID, '_transfers_title', true);
    $description = get_post_meta($post->ID, '_transfers_description', true);
    ?>
    <div class="page-settings-field">
        <label>Transfers Eyebrow:</label>
        <input type="text" name="transfers_eyebrow" value="<?php echo esc_attr($eyebrow ?: 'Airport transfers'); ?>" />
    </div>
    <div class="page-settings-field">
        <label>Transfers Title:</label>
        <input type="text" name="transfers_title" value="<?php echo esc_attr($title ?: 'Land smoothly, leave gracefully.'); ?>" />
    </div>
    <div class="page-settings-field">
        <label>Transfers Description:</label>
        <textarea name="transfers_description"><?php echo esc_textarea($description ?: 'Terminal-to-destination with premium vehicles and professional drivers.'); ?></textarea>
    </div>
    <?php
}

// Save page settings
function kenya_safari_save_page_settings($post_id) {
    // Safaris page
    if (isset($_POST['safaris_page_settings_nonce']) && wp_verify_nonce($_POST['safaris_page_settings_nonce'], 'safaris_page_settings')) {
        $fields = array('destinations_eyebrow', 'destinations_title', 'destinations_description', 'packages_eyebrow', 'packages_title', 'packages_description');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    
    // Marine page
    if (isset($_POST['marine_page_settings_nonce']) && wp_verify_nonce($_POST['marine_page_settings_nonce'], 'marine_page_settings')) {
        $fields = array('marine_eyebrow', 'marine_title', 'marine_description');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    
    // Rentals page
    if (isset($_POST['rentals_page_settings_nonce']) && wp_verify_nonce($_POST['rentals_page_settings_nonce'], 'rentals_page_settings')) {
        $fields = array('rentals_eyebrow', 'rentals_title', 'rentals_description');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    
    // Transfers page
    if (isset($_POST['transfers_page_settings_nonce']) && wp_verify_nonce($_POST['transfers_page_settings_nonce'], 'transfers_page_settings')) {
        $fields = array('transfers_eyebrow', 'transfers_title', 'transfers_description');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}
add_action('save_post', 'kenya_safari_save_page_settings');
