<?php
/**
 * Testimonials Custom Post Type
 */

// Register Testimonials Custom Post Type
function kenya_safari_register_testimonials() {
    $labels = array(
        'name' => 'Testimonials',
        'singular_name' => 'Testimonial',
        'menu_name' => 'Testimonials',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Testimonial',
        'edit_item' => 'Edit Testimonial',
        'new_item' => 'New Testimonial',
        'view_item' => 'View Testimonial',
        'search_items' => 'Search Testimonials',
        'not_found' => 'No testimonials found',
        'all_items' => 'All Testimonials',
    );
    
    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => false,
        'rewrite' => false,
        'supports' => array('title', 'editor'),
        'menu_icon' => 'dashicons-format-quote',
        'show_in_rest' => true,
        'menu_position' => 12,
    );
    
    register_post_type('testimonial', $args);
}
add_action('init', 'kenya_safari_register_testimonials', 0);

// Add Testimonial Meta Boxes
function kenya_safari_testimonial_metaboxes() {
    add_meta_box(
        'testimonial_details',
        'Testimonial Details',
        'kenya_safari_testimonial_metabox_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kenya_safari_testimonial_metaboxes');

function kenya_safari_testimonial_metabox_callback($post) {
    wp_nonce_field('testimonial_meta_box', 'testimonial_meta_box_nonce');
    
    $client_name = get_post_meta($post->ID, '_testimonial_client_name', true);
    $client_origin = get_post_meta($post->ID, '_testimonial_client_origin', true);
    $rating = get_post_meta($post->ID, '_testimonial_rating', true);
    $testimonial_text = get_post_meta($post->ID, '_testimonial_text', true);
    ?>
    <style>
        .testimonial-meta-field { margin-bottom: 15px; }
        .testimonial-meta-field label { display: block; font-weight: bold; margin-bottom: 5px; }
        .testimonial-meta-field input[type="text"],
        .testimonial-meta-field textarea,
        .testimonial-meta-field select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .testimonial-meta-field textarea { height: 120px; }
    </style>
    
    <div class="testimonial-meta-field">
        <label>Client Name:</label>
        <input type="text" name="testimonial_client_name" value="<?php echo esc_attr($client_name); ?>" placeholder="e.g., Sofia & Marco" />
    </div>
    
    <div class="testimonial-meta-field">
        <label>Client Origin:</label>
        <input type="text" name="testimonial_client_origin" value="<?php echo esc_attr($client_origin); ?>" placeholder="e.g., Italy" />
    </div>
    
    <div class="testimonial-meta-field">
        <label>Rating (1-5):</label>
        <select name="testimonial_rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>><?php echo $i; ?> Stars <?php echo str_repeat('★', $i) . str_repeat('☆', 5 - $i); ?></option>
            <?php endfor; ?>
        </select>
    </div>
    
    <div class="testimonial-meta-field">
        <label>Testimonial Text:</label>
        <textarea name="testimonial_text" placeholder="The Mara migration trip was once-in-a-lifetime..."><?php echo esc_textarea($testimonial_text); ?></textarea>
    </div>
    <?php
}

function kenya_safari_save_testimonial_meta($post_id) {
    if (!isset($_POST['testimonial_meta_box_nonce']) || !wp_verify_nonce($_POST['testimonial_meta_box_nonce'], 'testimonial_meta_box')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array('testimonial_client_name', 'testimonial_client_origin', 'testimonial_rating', 'testimonial_text');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'kenya_safari_save_testimonial_meta');
