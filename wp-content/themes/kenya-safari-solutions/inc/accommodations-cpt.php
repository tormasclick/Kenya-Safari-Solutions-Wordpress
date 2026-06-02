<?php
/**
 * Accommodations Custom Post Type - Complete with Meta Boxes
 */

// Register Accommodations Custom Post Type
function kenya_safari_register_accommodations() {
    $labels = array(
        'name' => 'Accommodations',
        'singular_name' => 'Accommodation',
        'menu_name' => 'Accommodations',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Accommodation',
        'edit_item' => 'Edit Accommodation',
        'new_item' => 'New Accommodation',
        'view_item' => 'View Accommodation',
        'search_items' => 'Search Accommodations',
        'not_found' => 'No accommodations found',
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'rewrite' => array('slug' => 'accommodation'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-building',
        'show_in_rest' => true,
        'menu_position' => 6,
    );
    
    register_post_type('accommodation', $args);
}
add_action('init', 'kenya_safari_register_accommodations', 0);

// Add meta boxes for accommodations
function kenya_safari_accommodation_metaboxes() {
    add_meta_box(
        'accommodation_details',
        'Accommodation Details',
        'kenya_safari_accommodation_details_callback',
        'accommodation',
        'normal',
        'high'
    );
    
    add_meta_box(
        'accommodation_gallery',
        'Accommodation Gallery',
        'kenya_safari_accommodation_gallery_callback',
        'accommodation',
        'normal',
        'high'
    );
    
    add_meta_box(
        'accommodation_faqs',
        'Frequently Asked Questions',
        'kenya_safari_accommodation_faqs_callback',
        'accommodation',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kenya_safari_accommodation_metaboxes');

// Details Meta Box
function kenya_safari_accommodation_details_callback($post) {
    wp_nonce_field('accommodation_details_box', 'accommodation_details_box_nonce');
    
    $tagline = get_post_meta($post->ID, '_accommodation_tagline', true);
    $location = get_post_meta($post->ID, '_accommodation_location', true);
    $price_range = get_post_meta($post->ID, '_accommodation_price_range', true);
    $type = get_post_meta($post->ID, '_accommodation_type', true);
    $rating = get_post_meta($post->ID, '_accommodation_rating', true);
    $amenities = get_post_meta($post->ID, '_accommodation_amenities', true);
    $best_for = get_post_meta($post->ID, '_accommodation_best_for', true);
    ?>
    <style>
        .acc-meta-field { margin-bottom: 15px; }
        .acc-meta-field label { display: block; font-weight: bold; margin-bottom: 5px; }
        .acc-meta-field input[type="text"],
        .acc-meta-field textarea,
        .acc-meta-field select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .acc-meta-field textarea { height: 100px; }
    </style>
    
    <div class="acc-meta-field">
        <label>Tagline:</label>
        <input type="text" name="accommodation_tagline" value="<?php echo esc_attr($tagline); ?>" />
    </div>
    
    <div class="acc-meta-field">
        <label>Location:</label>
        <input type="text" name="accommodation_location" value="<?php echo esc_attr($location); ?>" />
    </div>
    
    <div class="acc-meta-field">
        <label>Price Range:</label>
        <input type="text" name="accommodation_price_range" value="<?php echo esc_attr($price_range); ?>" placeholder="e.g., $800-1200 per night" />
    </div>
    
    <div class="acc-meta-field">
        <label>Type:</label>
        <select name="accommodation_type">
            <option value="LUXURY" <?php selected($type, 'LUXURY'); ?>>LUXURY</option>
            <option value="MIDRANGE" <?php selected($type, 'MIDRANGE'); ?>>MIDRANGE</option>
            <option value="BUDGET" <?php selected($type, 'BUDGET'); ?>>BUDGET</option>
        </select>
    </div>
    
    <div class="acc-meta-field">
        <label>Rating (1-5):</label>
        <select name="accommodation_rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>><?php echo $i; ?> Stars <?php echo str_repeat('★', $i) . str_repeat('☆', 5 - $i); ?></option>
            <?php endfor; ?>
        </select>
    </div>
    
    <div class="acc-meta-field">
        <label>Amenities (comma separated):</label>
        <textarea name="accommodation_amenities" placeholder="Private game drives, Hot air balloon safaris, Spa, Infinity pool"><?php echo esc_textarea($amenities); ?></textarea>
    </div>
    
    <div class="acc-meta-field">
        <label>Best For (comma separated):</label>
        <textarea name="accommodation_best_for" placeholder="Honeymooners, Families, Wildlife photographers"><?php echo esc_textarea($best_for); ?></textarea>
    </div>
    <?php
}

// Gallery Meta Box
function kenya_safari_accommodation_gallery_callback($post) {
    wp_nonce_field('accommodation_gallery_box', 'accommodation_gallery_box_nonce');
    
    $gallery_ids = get_post_meta($post->ID, '_accommodation_gallery_ids', true);
    $gallery_ids_array = $gallery_ids ? explode(',', $gallery_ids) : array();
    ?>
    <div class="acc-gallery">
        <button type="button" class="button" id="upload-acc-gallery-btn">Add Images to Gallery</button>
        <div id="acc-gallery-preview" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px;">
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
        <input type="hidden" name="accommodation_gallery_ids" id="accommodation_gallery_ids" value="<?php echo esc_attr($gallery_ids); ?>" />
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var frame;
        $('#upload-acc-gallery-btn').click(function(e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({ title: 'Select Gallery Images', button: { text: 'Add to Gallery' }, multiple: true });
            frame.on('select', function() {
                var selection = frame.state().get('selection');
                var ids = [];
                var currentIds = $('#accommodation_gallery_ids').val() ? $('#accommodation_gallery_ids').val().split(',') : [];
                selection.map(function(attachment) {
                    attachment = attachment.toJSON();
                    ids.push(attachment.id);
                    if (!currentIds.includes(attachment.id.toString())) {
                        $('#acc-gallery-preview').append('<div class="gallery-img" data-id="'+attachment.id+'" style="position:relative; width:100px; height:100px;"><img src="'+attachment.url+'" style="width:100%; height:100%; object-fit:cover; border-radius:4px;"><button type="button" class="remove-img" style="position:absolute; top:-5px; right:-5px; background:red; color:white; border:none; border-radius:50%; width:20px; height:20px; cursor:pointer;">×</button></div>');
                    }
                });
                var allIds = currentIds.concat(ids);
                $('#accommodation_gallery_ids').val(allIds.join(','));
            });
            frame.open();
        });
        
        $(document).on('click', '.remove-img', function() {
            var imgDiv = $(this).closest('.gallery-img');
            var imgId = imgDiv.data('id');
            var currentIds = $('#accommodation_gallery_ids').val().split(',');
            var newIds = currentIds.filter(function(id) { return id != imgId; });
            $('#accommodation_gallery_ids').val(newIds.join(','));
            imgDiv.remove();
        });
    });
    </script>
    <?php
}

// FAQs Meta Box
function kenya_safari_accommodation_faqs_callback($post) {
    wp_nonce_field('accommodation_faqs_box', 'accommodation_faqs_box_nonce');
    
    $faqs = get_post_meta($post->ID, '_accommodation_faqs', true);
    $faqs_array = $faqs ? json_decode($faqs, true) : array();
    ?>
    <div id="acc-faqs-repeater">
        <div class="faqs-list">
            <?php if (!empty($faqs_array)): ?>
                <?php foreach ($faqs_array as $index => $faq): ?>
                    <div class="faq-item" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #f59e0b;">
                        <h4>FAQ <?php echo $index + 1; ?></h4>
                        <p><label>Question:</label><br><input type="text" name="acc_faq_question[]" value="<?php echo esc_attr($faq['question']); ?>" style="width: 100%;" /></p>
                        <p><label>Answer:</label><br><textarea name="acc_faq_answer[]" rows="3" style="width: 100%;"><?php echo esc_textarea($faq['answer']); ?></textarea></p>
                        <button type="button" class="button remove-acc-faq" style="background: #dc2626; color: white;">Remove</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button type="button" class="button button-primary" id="add-acc-faq">+ Add FAQ</button>
    </div>
    
    <input type="hidden" name="accommodation_faqs_json" id="accommodation_faqs_json" value="<?php echo esc_attr($faqs); ?>" />
    
    <script>
    jQuery(document).ready(function($) {
        $('#add-acc-faq').click(function() {
            var index = $('.faq-item').length;
            var newFaq = `
                <div class="faq-item" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #f59e0b;">
                    <h4>FAQ ${index + 1}</h4>
                    <p><label>Question:</label><br><input type="text" name="acc_faq_question[]" style="width: 100%;" /></p>
                    <p><label>Answer:</label><br><textarea name="acc_faq_answer[]" rows="3" style="width: 100%;"></textarea></p>
                    <button type="button" class="button remove-acc-faq" style="background: #dc2626; color: white;">Remove</button>
                </div>
            `;
            $('#acc-faqs-repeater .faqs-list').append(newFaq);
            updateAccFaqsJson();
        });
        
        $(document).on('click', '.remove-acc-faq', function() {
            $(this).closest('.faq-item').remove();
            updateAccFaqsJson();
        });
        
        $(document).on('change keyup', 'input[name="acc_faq_question[]"], textarea[name="acc_faq_answer[]"]', function() {
            updateAccFaqsJson();
        });
        
        function updateAccFaqsJson() {
            var faqs = [];
            $('.faq-item').each(function() {
                var question = $(this).find('input[name="acc_faq_question[]"]').val();
                var answer = $(this).find('textarea[name="acc_faq_answer[]"]').val();
                if (question && answer) {
                    faqs.push({ question: question, answer: answer });
                }
            });
            $('#accommodation_faqs_json').val(JSON.stringify(faqs));
        }
    });
    </script>
    <?php
}

// Save all accommodation meta data
function kenya_safari_save_accommodation_meta($post_id) {
    // Save details
    if (isset($_POST['accommodation_details_box_nonce']) && wp_verify_nonce($_POST['accommodation_details_box_nonce'], 'accommodation_details_box')) {
        $fields = array('accommodation_tagline', 'accommodation_location', 'accommodation_price_range', 'accommodation_type', 'accommodation_rating', 'accommodation_amenities', 'accommodation_best_for');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    
    // Save gallery
    if (isset($_POST['accommodation_gallery_box_nonce']) && wp_verify_nonce($_POST['accommodation_gallery_box_nonce'], 'accommodation_gallery_box')) {
        if (isset($_POST['accommodation_gallery_ids'])) {
            update_post_meta($post_id, '_accommodation_gallery_ids', sanitize_text_field($_POST['accommodation_gallery_ids']));
        }
    }
    
    // Save FAQs
    if (isset($_POST['accommodation_faqs_box_nonce']) && wp_verify_nonce($_POST['accommodation_faqs_box_nonce'], 'accommodation_faqs_box')) {
        if (isset($_POST['accommodation_faqs_json'])) {
            update_post_meta($post_id, '_accommodation_faqs', sanitize_text_field($_POST['accommodation_faqs_json']));
        }
    }
}
add_action('save_post', 'kenya_safari_save_accommodation_meta');

// Include the FAQs fix
require_once get_template_directory() . '/inc/accommodation-faqs-fix.php';
