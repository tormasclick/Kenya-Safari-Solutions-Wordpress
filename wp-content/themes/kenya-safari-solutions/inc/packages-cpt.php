<?php
/**
 * Safari Packages Custom Post Type - Using Featured Images
 */

// Register Packages Custom Post Type
function kenya_safari_register_packages() {
    $labels = array(
        'name' => 'Safari Packages',
        'singular_name' => 'Package',
        'menu_name' => 'Packages',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Package',
        'edit_item' => 'Edit Package',
        'new_item' => 'New Package',
        'view_item' => 'View Package',
        'search_items' => 'Search Packages',
        'not_found' => 'No packages found',
        'all_items' => 'All Packages',
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'rewrite' => array('slug' => 'packages'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_icon' => 'dashicons-backup',
        'show_in_rest' => true,
        'menu_position' => 9,
    );
    
    register_post_type('package', $args);
}
add_action('init', 'kenya_safari_register_packages', 0);

// Remove the old image meta field and use featured image instead
function kenya_safari_package_remove_image_field() {
    // We'll keep the meta box but remove the image URL field
    // The featured image will be used instead
}
add_action('init', 'kenya_safari_package_remove_image_field');

// Add Package Meta Boxes (without image URL)
function kenya_safari_package_metaboxes() {
    add_meta_box(
        'package_details',
        'Package Details',
        'kenya_safari_package_metabox_callback',
        'package',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kenya_safari_package_metaboxes');

function kenya_safari_package_metabox_callback($post) {
    wp_nonce_field('package_meta_box', 'package_meta_box_nonce');
    
    $tag = get_post_meta($post->ID, '_package_tag', true);
    $duration = get_post_meta($post->ID, '_package_duration', true);
    $blurb = get_post_meta($post->ID, '_package_blurb', true);
    $itinerary = get_post_meta($post->ID, '_package_itinerary', true);
    
    // Note: Image is now handled by Featured Image
    ?>
    <style>
        .package-meta-field { margin-bottom: 15px; }
        .package-meta-field label { display: block; font-weight: bold; margin-bottom: 5px; }
        .package-meta-field input[type="text"],
        .package-meta-field textarea,
        .package-meta-field select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .package-meta-field textarea { height: 100px; }
        .package-notice { background: #f0f8ff; padding: 10px; margin-bottom: 15px; border-left: 4px solid #f59e0b; }
    </style>
    
    <div class="package-notice">
        <strong>📸 Package Image:</strong> Use the <strong>Featured Image</strong> section on the right to set your package image.
    </div>
    
    <div class="package-meta-field">
        <label>Package Tag (Safari/Combo/City):</label>
        <select name="package_tag">
            <option value="Safari" <?php selected($tag, 'Safari'); ?>>Safari</option>
            <option value="Combo" <?php selected($tag, 'Combo'); ?>>Combo</option>
            <option value="City" <?php selected($tag, 'City'); ?>>City</option>
        </select>
    </div>
    
    <div class="package-meta-field">
        <label>Duration:</label>
        <input type="text" name="package_duration" value="<?php echo esc_attr($duration); ?>" placeholder="e.g., 3 Days" />
    </div>
    
    <div class="package-meta-field">
        <label>Short Blurb:</label>
        <textarea name="package_blurb" placeholder="Brief description..."><?php echo esc_textarea($blurb); ?></textarea>
    </div>
    
    <div class="package-meta-field">
        <label>Itinerary (JSON format):</label>
        <textarea name="package_itinerary" placeholder='[{"day":"Day 1","title":"Title","detail":"Description"}]' style="height:150px"><?php echo esc_textarea($itinerary); ?></textarea>
        <small>Format: [{"day":"Day 1","title":"Your Title","detail":"Your description here"}]</small>
    </div>
    <?php
}

function kenya_safari_save_package_meta($post_id) {
    if (!isset($_POST['package_meta_box_nonce']) || !wp_verify_nonce($_POST['package_meta_box_nonce'], 'package_meta_box')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array('package_tag', 'package_duration', 'package_blurb', 'package_itinerary');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'kenya_safari_save_package_meta');
