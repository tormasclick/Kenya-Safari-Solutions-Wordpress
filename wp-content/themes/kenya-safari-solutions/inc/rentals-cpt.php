<?php
/**
 * Rentals Custom Post Type - Complete with Meta Boxes
 */

// Register Rentals Custom Post Type
function kenya_safari_register_rentals() {
    $labels = array(
        'name' => 'Rentals',
        'singular_name' => 'Rental',
        'menu_name' => 'Rentals',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Vehicle',
        'edit_item' => 'Edit Vehicle',
        'new_item' => 'New Vehicle',
        'view_item' => 'View Vehicle',
        'search_items' => 'Search Rentals',
        'not_found' => 'No rentals found',
        'all_items' => 'All Rentals',
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'rewrite' => array('slug' => 'rentals'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-car',
        'show_in_rest' => true,
        'menu_position' => 11,
    );
    
    register_post_type('rental', $args);
}
add_action('init', 'kenya_safari_register_rentals', 0);

// Add meta boxes for rentals
function kenya_safari_rental_metaboxes() {
    add_meta_box(
        'rental_details',
        'Vehicle Details',
        'kenya_safari_rental_details_callback',
        'rental',
        'normal',
        'high'
    );
    
    add_meta_box(
        'rental_gallery',
        'Vehicle Gallery',
        'kenya_safari_rental_gallery_callback',
        'rental',
        'normal',
        'high'
    );
    
    add_meta_box(
        'rental_specifications',
        'Specifications',
        'kenya_safari_rental_specifications_callback',
        'rental',
        'normal',
        'high'
    );
    
    add_meta_box(
        'rental_faqs',
        'Frequently Asked Questions',
        'kenya_safari_rental_faqs_callback',
        'rental',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kenya_safari_rental_metaboxes');

// Details Meta Box
function kenya_safari_rental_details_callback($post) {
    wp_nonce_field('rental_details_box', 'rental_details_box_nonce');
    
    $tagline = get_post_meta($post->ID, '_rental_tagline', true);
    $price_per_day = get_post_meta($post->ID, '_rental_price_per_day', true);
    $price_per_week = get_post_meta($post->ID, '_rental_price_per_week', true);
    $type = get_post_meta($post->ID, '_rental_type', true);
    $capacity = get_post_meta($post->ID, '_rental_capacity', true);
    $transmission = get_post_meta($post->ID, '_rental_transmission', true);
    $features = get_post_meta($post->ID, '_rental_features', true);
    $includes = get_post_meta($post->ID, '_rental_includes', true);
    ?>
    <style>
        .rental-meta-field { margin-bottom: 15px; }
        .rental-meta-field label { display: block; font-weight: bold; margin-bottom: 5px; }
        .rental-meta-field input[type="text"],
        .rental-meta-field textarea,
        .rental-meta-field select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .rental-meta-field textarea { height: 100px; }
    </style>
    
    <div class="rental-meta-field">
        <label>Tagline:</label>
        <input type="text" name="rental_tagline" value="<?php echo esc_attr($tagline); ?>" />
    </div>
    
    <div class="rental-meta-field">
        <label>Price Per Day ($):</label>
        <input type="text" name="rental_price_per_day" value="<?php echo esc_attr($price_per_day); ?>" />
    </div>
    
    <div class="rental-meta-field">
        <label>Price Per Week ($):</label>
        <input type="text" name="rental_price_per_week" value="<?php echo esc_attr($price_per_week); ?>" />
    </div>
    
    <div class="rental-meta-field">
        <label>Type:</label>
        <select name="rental_type">
            <option value="SUV" <?php selected($type, 'SUV'); ?>>SUV</option>
            <option value="LUXURY" <?php selected($type, 'LUXURY'); ?>>LUXURY</option>
            <option value="VAN" <?php selected($type, 'VAN'); ?>>VAN</option>
            <option value="4x4" <?php selected($type, '4x4'); ?>>4x4</option>
        </select>
    </div>
    
    <div class="rental-meta-field">
        <label>Capacity (passengers):</label>
        <input type="text" name="rental_capacity" value="<?php echo esc_attr($capacity); ?>" />
    </div>
    
    <div class="rental-meta-field">
        <label>Transmission:</label>
        <select name="rental_transmission">
            <option value="Manual" <?php selected($transmission, 'Manual'); ?>>Manual</option>
            <option value="Automatic" <?php selected($transmission, 'Automatic'); ?>>Automatic</option>
        </select>
    </div>
    
    <div class="rental-meta-field">
        <label>Features (comma separated):</label>
        <textarea name="rental_features" placeholder="Pop-up roof, Air conditioning, GPS navigation"><?php echo esc_textarea($features); ?></textarea>
    </div>
    
    <div class="rental-meta-field">
        <label>What's Included (comma separated):</label>
        <textarea name="rental_includes" placeholder="Unlimited mileage, Insurance, GPS"><?php echo esc_textarea($includes); ?></textarea>
    </div>
    <?php
}

// Specifications Meta Box
function kenya_safari_rental_specifications_callback($post) {
    wp_nonce_field('rental_specifications_box', 'rental_specifications_box_nonce');
    
    $engine = get_post_meta($post->ID, '_rental_engine', true);
    $fuel_capacity = get_post_meta($post->ID, '_rental_fuel_capacity', true);
    $ground_clearance = get_post_meta($post->ID, '_rental_ground_clearance', true);
    $drivetrain = get_post_meta($post->ID, '_rental_drivetrain', true);
    ?>
    <div class="rental-meta-field">
        <label>Engine:</label>
        <input type="text" name="rental_engine" value="<?php echo esc_attr($engine); ?>" placeholder="e.g., 4.2L Diesel Turbo" />
    </div>
    
    <div class="rental-meta-field">
        <label>Fuel Capacity (L):</label>
        <input type="text" name="rental_fuel_capacity" value="<?php echo esc_attr($fuel_capacity); ?>" />
    </div>
    
    <div class="rental-meta-field">
        <label>Ground Clearance (mm):</label>
        <input type="text" name="rental_ground_clearance" value="<?php echo esc_attr($ground_clearance); ?>" />
    </div>
    
    <div class="rental-meta-field">
        <label>Drivetrain:</label>
        <input type="text" name="rental_drivetrain" value="<?php echo esc_attr($drivetrain); ?>" placeholder="e.g., Full-time 4x4" />
    </div>
    <?php
}

// Gallery Meta Box
function kenya_safari_rental_gallery_callback($post) {
    wp_nonce_field('rental_gallery_box', 'rental_gallery_box_nonce');
    
    $gallery_ids = get_post_meta($post->ID, '_rental_gallery_ids', true);
    $gallery_ids_array = $gallery_ids ? explode(',', $gallery_ids) : array();
    ?>
    <div class="rental-gallery">
        <button type="button" class="button" id="upload-rental-gallery-btn">Add Images to Gallery</button>
        <div id="rental-gallery-preview" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px;">
            <?php foreach ($gallery_ids_array as $image_id): 
                $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                if ($image_url):
            ?>
                <div class="gallery-img" data-id="<?php echo $image_id; ?>" style="position: relative; width: 100px; height: 100px;">
                    <img src="<?php echo esc_url($image_url); ?>" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                    <button type="button" class="remove-img" style="position:absolute; top:-5px; right:-5px; background:red; color:white; border:none; border-radius:50%; width:20px; height:20px; cursor:pointer;">×</button>
                </div>
            <?php endif; endforeach; ?>
        </div>
        <input type="hidden" name="rental_gallery_ids" id="rental_gallery_ids" value="<?php echo esc_attr($gallery_ids); ?>" />
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var frame;
        $('#upload-rental-gallery-btn').click(function(e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({ title: 'Select Gallery Images', button: { text: 'Add to Gallery' }, multiple: true });
            frame.on('select', function() {
                var selection = frame.state().get('selection');
                var ids = [];
                var currentIds = $('#rental_gallery_ids').val() ? $('#rental_gallery_ids').val().split(',') : [];
                selection.map(function(attachment) {
                    attachment = attachment.toJSON();
                    ids.push(attachment.id);
                    if (!currentIds.includes(attachment.id.toString())) {
                        $('#rental-gallery-preview').append('<div class="gallery-img" data-id="'+attachment.id+'" style="position:relative; width:100px; height:100px;"><img src="'+attachment.url+'" style="width:100%; height:100%; object-fit:cover; border-radius:4px;"><button type="button" class="remove-img" style="position:absolute; top:-5px; right:-5px; background:red; color:white; border:none; border-radius:50%; width:20px; height:20px; cursor:pointer;">×</button></div>');
                    }
                });
                var allIds = currentIds.concat(ids);
                $('#rental_gallery_ids').val(allIds.join(','));
            });
            frame.open();
        });
        
        $(document).on('click', '.remove-img', function() {
            var imgDiv = $(this).closest('.gallery-img');
            var imgId = imgDiv.data('id');
            var currentIds = $('#rental_gallery_ids').val().split(',');
            var newIds = currentIds.filter(function(id) { return id != imgId; });
            $('#rental_gallery_ids').val(newIds.join(','));
            imgDiv.remove();
        });
    });
    </script>
    <?php
}

// FAQs Meta Box
function kenya_safari_rental_faqs_callback($post) {
    wp_nonce_field('rental_faqs_box', 'rental_faqs_box_nonce');
    
    $faqs = get_post_meta($post->ID, '_rental_faqs', true);
    $faqs_array = !empty($faqs) ? json_decode($faqs, true) : array();
    
    if (!is_array($faqs_array)) {
        $faqs_array = array();
    }
    ?>
    <div id="rental-faqs-repeater">
        <div class="faqs-list">
            <?php if (!empty($faqs_array)): ?>
                <?php foreach ($faqs_array as $index => $faq): ?>
                    <div class="faq-item" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #f59e0b;">
                        <h4>FAQ <?php echo $index + 1; ?></h4>
                        <p><label>Question:</label><br><input type="text" name="rental_faq_question[]" value="<?php echo esc_attr($faq['question']); ?>" style="width: 100%;" /></p>
                        <p><label>Answer:</label><br><textarea name="rental_faq_answer[]" rows="3" style="width: 100%;"><?php echo esc_textarea($faq['answer']); ?></textarea></p>
                        <button type="button" class="button remove-rental-faq" style="background: #dc2626; color: white;">Remove</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No FAQs added yet. Click the button below to add your first FAQ.</p>
            <?php endif; ?>
        </div>
        <button type="button" class="button button-primary" id="add-rental-faq">+ Add FAQ</button>
    </div>
    
    <input type="hidden" name="rental_faqs_json" id="rental_faqs_json" value="<?php echo esc_attr(json_encode($faqs_array)); ?>" />
    
    <script>
    jQuery(document).ready(function($) {
        $('#add-rental-faq').click(function() {
            var index = $('.faq-item').length;
            var newFaq = `
                <div class="faq-item" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #f59e0b;">
                    <h4>FAQ ${index + 1}</h4>
                    <p><label>Question:</label><br><input type="text" name="rental_faq_question[]" style="width: 100%;" /></p>
                    <p><label>Answer:</label><br><textarea name="rental_faq_answer[]" rows="3" style="width: 100%;"></textarea></p>
                    <button type="button" class="button remove-rental-faq" style="background: #dc2626; color: white;">Remove</button>
                </div>
            `;
            $('#rental-faqs-repeater .faqs-list').append(newFaq);
            updateRentalFaqsJson();
        });
        
        $(document).on('click', '.remove-rental-faq', function() {
            $(this).closest('.faq-item').remove();
            updateRentalFaqsJson();
        });
        
        $(document).on('change keyup', 'input[name="rental_faq_question[]"], textarea[name="rental_faq_answer[]"]', function() {
            updateRentalFaqsJson();
        });
        
        function updateRentalFaqsJson() {
            var faqs = [];
            $('.faq-item').each(function() {
                var question = $(this).find('input[name="rental_faq_question[]"]').val();
                var answer = $(this).find('textarea[name="rental_faq_answer[]"]').val();
                if (question && answer) {
                    faqs.push({ question: question, answer: answer });
                }
            });
            $('#rental_faqs_json').val(JSON.stringify(faqs));
        }
    });
    </script>
    <?php
}

// Save all rental meta data
function kenya_safari_save_rental_meta($post_id) {
    // Save details
    if (isset($_POST['rental_details_box_nonce']) && wp_verify_nonce($_POST['rental_details_box_nonce'], 'rental_details_box')) {
        $fields = array('rental_tagline', 'rental_price_per_day', 'rental_price_per_week', 'rental_type', 'rental_capacity', 'rental_transmission', 'rental_features', 'rental_includes');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    
    // Save specifications
    if (isset($_POST['rental_specifications_box_nonce']) && wp_verify_nonce($_POST['rental_specifications_box_nonce'], 'rental_specifications_box')) {
        $specs = array('rental_engine', 'rental_fuel_capacity', 'rental_ground_clearance', 'rental_drivetrain');
        foreach ($specs as $spec) {
            if (isset($_POST[$spec])) {
                update_post_meta($post_id, '_' . $spec, sanitize_text_field($_POST[$spec]));
            }
        }
    }
    
    // Save gallery
    if (isset($_POST['rental_gallery_box_nonce']) && wp_verify_nonce($_POST['rental_gallery_box_nonce'], 'rental_gallery_box')) {
        if (isset($_POST['rental_gallery_ids'])) {
            update_post_meta($post_id, '_rental_gallery_ids', sanitize_text_field($_POST['rental_gallery_ids']));
        }
    }
    
    // Save FAQs
    if (isset($_POST['rental_faqs_box_nonce']) && wp_verify_nonce($_POST['rental_faqs_box_nonce'], 'rental_faqs_box')) {
        if (isset($_POST['rental_faqs_json'])) {
            update_post_meta($post_id, '_rental_faqs', sanitize_text_field($_POST['rental_faqs_json']));
        }
    }
}
add_action('save_post', 'kenya_safari_save_rental_meta');
