<?php
/**
 * Transfers Custom Post Type - Complete with Meta Boxes
 */

// Register Transfers Custom Post Type
function kenya_safari_register_transfers() {
    $labels = array(
        'name' => 'Transfers',
        'singular_name' => 'Transfer',
        'menu_name' => 'Transfers',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Transfer',
        'edit_item' => 'Edit Transfer',
        'new_item' => 'New Transfer',
        'view_item' => 'View Transfer',
        'search_items' => 'Search Transfers',
        'not_found' => 'No transfers found',
        'all_items' => 'All Transfers',
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'rewrite' => array('slug' => 'transfers'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-airplane',
        'show_in_rest' => true,
        'menu_position' => 10,
    );
    
    register_post_type('transfer', $args);
}
add_action('init', 'kenya_safari_register_transfers', 0);

// Add meta boxes for transfers
function kenya_safari_transfer_metaboxes() {
    add_meta_box(
        'transfer_details',
        'Transfer Details',
        'kenya_safari_transfer_details_callback',
        'transfer',
        'normal',
        'high'
    );
    
    add_meta_box(
        'transfer_gallery',
        'Transfer Gallery',
        'kenya_safari_transfer_gallery_callback',
        'transfer',
        'normal',
        'high'
    );
    
    add_meta_box(
        'transfer_faqs',
        'Frequently Asked Questions',
        'kenya_safari_transfer_faqs_callback',
        'transfer',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kenya_safari_transfer_metaboxes');

// Details Meta Box
function kenya_safari_transfer_details_callback($post) {
    wp_nonce_field('transfer_details_box', 'transfer_details_box_nonce');
    
    $tagline = get_post_meta($post->ID, '_transfer_tagline', true);
    $price = get_post_meta($post->ID, '_transfer_price', true);
    $duration = get_post_meta($post->ID, '_transfer_duration', true);
    $vehicle_type = get_post_meta($post->ID, '_transfer_vehicle_type', true);
    $capacity = get_post_meta($post->ID, '_transfer_capacity', true);
    $luggage = get_post_meta($post->ID, '_transfer_luggage', true);
    $features = get_post_meta($post->ID, '_transfer_features', true);
    $includes = get_post_meta($post->ID, '_transfer_includes', true);
    $best_for = get_post_meta($post->ID, '_transfer_best_for', true);
    ?>
    <style>
        .transfer-meta-field { margin-bottom: 15px; }
        .transfer-meta-field label { display: block; font-weight: bold; margin-bottom: 5px; }
        .transfer-meta-field input[type="text"],
        .transfer-meta-field textarea,
        .transfer-meta-field select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .transfer-meta-field textarea { height: 100px; }
    </style>
    
    <div class="transfer-meta-field">
        <label>Tagline:</label>
        <input type="text" name="transfer_tagline" value="<?php echo esc_attr($tagline); ?>" />
    </div>
    
    <div class="transfer-meta-field">
        <label>Price ($):</label>
        <input type="text" name="transfer_price" value="<?php echo esc_attr($price); ?>" />
    </div>
    
    <div class="transfer-meta-field">
        <label>Duration:</label>
        <input type="text" name="transfer_duration" value="<?php echo esc_attr($duration); ?>" />
    </div>
    
    <div class="transfer-meta-field">
        <label>Vehicle Type:</label>
        <input type="text" name="transfer_vehicle_type" value="<?php echo esc_attr($vehicle_type); ?>" />
    </div>
    
    <div class="transfer-meta-field">
        <label>Capacity (passengers):</label>
        <input type="text" name="transfer_capacity" value="<?php echo esc_attr($capacity); ?>" />
    </div>
    
    <div class="transfer-meta-field">
        <label>Luggage Capacity:</label>
        <input type="text" name="transfer_luggage" value="<?php echo esc_attr($luggage); ?>" />
    </div>
    
    <div class="transfer-meta-field">
        <label>Features (comma separated):</label>
        <textarea name="transfer_features" placeholder="Meet & greet, Flight monitoring, Wi-Fi"><?php echo esc_textarea($features); ?></textarea>
    </div>
    
    <div class="transfer-meta-field">
        <label>What's Included (comma separated):</label>
        <textarea name="transfer_includes" placeholder="Hotel pickup, Airport drop-off, Professional driver"><?php echo esc_textarea($includes); ?></textarea>
    </div>
    
    <div class="transfer-meta-field">
        <label>Best For (comma separated):</label>
        <textarea name="transfer_best_for" placeholder="Business travelers, Families, Couples"><?php echo esc_textarea($best_for); ?></textarea>
    </div>
    <?php
}

// Gallery Meta Box
function kenya_safari_transfer_gallery_callback($post) {
    wp_nonce_field('transfer_gallery_box', 'transfer_gallery_box_nonce');
    
    $gallery_ids = get_post_meta($post->ID, '_transfer_gallery_ids', true);
    $gallery_ids_array = $gallery_ids ? explode(',', $gallery_ids) : array();
    ?>
    <div class="transfer-gallery">
        <button type="button" class="button" id="upload-transfer-gallery-btn">Add Images to Gallery</button>
        <div id="transfer-gallery-preview" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px;">
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
        <input type="hidden" name="transfer_gallery_ids" id="transfer_gallery_ids" value="<?php echo esc_attr($gallery_ids); ?>" />
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var frame;
        $('#upload-transfer-gallery-btn').click(function(e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({ title: 'Select Gallery Images', button: { text: 'Add to Gallery' }, multiple: true });
            frame.on('select', function() {
                var selection = frame.state().get('selection');
                var ids = [];
                var currentIds = $('#transfer_gallery_ids').val() ? $('#transfer_gallery_ids').val().split(',') : [];
                selection.map(function(attachment) {
                    attachment = attachment.toJSON();
                    ids.push(attachment.id);
                    if (!currentIds.includes(attachment.id.toString())) {
                        $('#transfer-gallery-preview').append('<div class="gallery-img" data-id="'+attachment.id+'" style="position:relative; width:100px; height:100px;"><img src="'+attachment.url+'" style="width:100%; height:100%; object-fit:cover; border-radius:4px;"><button type="button" class="remove-img" style="position:absolute; top:-5px; right:-5px; background:red; color:white; border:none; border-radius:50%; width:20px; height:20px; cursor:pointer;">×</button></div>');
                    }
                });
                var allIds = currentIds.concat(ids);
                $('#transfer_gallery_ids').val(allIds.join(','));
            });
            frame.open();
        });
        
        $(document).on('click', '.remove-img', function() {
            var imgDiv = $(this).closest('.gallery-img');
            var imgId = imgDiv.data('id');
            var currentIds = $('#transfer_gallery_ids').val().split(',');
            var newIds = currentIds.filter(function(id) { return id != imgId; });
            $('#transfer_gallery_ids').val(newIds.join(','));
            imgDiv.remove();
        });
    });
    </script>
    <?php
}

// FAQs Meta Box
function kenya_safari_transfer_faqs_callback($post) {
    wp_nonce_field('transfer_faqs_box', 'transfer_faqs_box_nonce');
    
    $faqs = get_post_meta($post->ID, '_transfer_faqs', true);
    $faqs_array = !empty($faqs) ? json_decode($faqs, true) : array();
    ?>
    <div id="transfer-faqs-repeater">
        <div class="faqs-list">
            <?php if (!empty($faqs_array)): ?>
                <?php foreach ($faqs_array as $index => $faq): ?>
                    <div class="faq-item" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #f59e0b;">
                        <h4>FAQ <?php echo $index + 1; ?></h4>
                        <p><label>Question:</label><br><input type="text" name="transfer_faq_question[]" value="<?php echo esc_attr($faq['question']); ?>" style="width: 100%;" /></p>
                        <p><label>Answer:</label><br><textarea name="transfer_faq_answer[]" rows="3" style="width: 100%;"><?php echo esc_textarea($faq['answer']); ?></textarea></p>
                        <button type="button" class="button remove-transfer-faq" style="background: #dc2626; color: white;">Remove</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No FAQs added yet. Click the button below to add your first FAQ.</p>
            <?php endif; ?>
        </div>
        <button type="button" class="button button-primary" id="add-transfer-faq">+ Add FAQ</button>
    </div>
    
    <input type="hidden" name="transfer_faqs_json" id="transfer_faqs_json" value="<?php echo esc_attr(json_encode($faqs_array)); ?>" />
    
    <script>
    jQuery(document).ready(function($) {
        $('#add-transfer-faq').click(function() {
            var index = $('.faq-item').length;
            var newFaq = `
                <div class="faq-item" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #f59e0b;">
                    <h4>FAQ ${index + 1}</h4>
                    <p><label>Question:</label><br><input type="text" name="transfer_faq_question[]" style="width: 100%;" /></p>
                    <p><label>Answer:</label><br><textarea name="transfer_faq_answer[]" rows="3" style="width: 100%;"></textarea></p>
                    <button type="button" class="button remove-transfer-faq" style="background: #dc2626; color: white;">Remove</button>
                </div>
            `;
            $('#transfer-faqs-repeater .faqs-list').append(newFaq);
            updateTransferFaqsJson();
        });
        
        $(document).on('click', '.remove-transfer-faq', function() {
            $(this).closest('.faq-item').remove();
            updateTransferFaqsJson();
        });
        
        $(document).on('change keyup', 'input[name="transfer_faq_question[]"], textarea[name="transfer_faq_answer[]"]', function() {
            updateTransferFaqsJson();
        });
        
        function updateTransferFaqsJson() {
            var faqs = [];
            $('.faq-item').each(function() {
                var question = $(this).find('input[name="transfer_faq_question[]"]').val();
                var answer = $(this).find('textarea[name="transfer_faq_answer[]"]').val();
                if (question && answer) {
                    faqs.push({ question: question, answer: answer });
                }
            });
            $('#transfer_faqs_json').val(JSON.stringify(faqs));
        }
    });
    </script>
    <?php
}

// Save all transfer meta data
function kenya_safari_save_transfer_meta($post_id) {
    // Save details
    if (isset($_POST['transfer_details_box_nonce']) && wp_verify_nonce($_POST['transfer_details_box_nonce'], 'transfer_details_box')) {
        $fields = array('transfer_tagline', 'transfer_price', 'transfer_duration', 'transfer_vehicle_type', 'transfer_capacity', 'transfer_luggage', 'transfer_features', 'transfer_includes', 'transfer_best_for');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    
    // Save gallery
    if (isset($_POST['transfer_gallery_box_nonce']) && wp_verify_nonce($_POST['transfer_gallery_box_nonce'], 'transfer_gallery_box')) {
        if (isset($_POST['transfer_gallery_ids'])) {
            update_post_meta($post_id, '_transfer_gallery_ids', sanitize_text_field($_POST['transfer_gallery_ids']));
        }
    }
    
    // Save FAQs
    if (isset($_POST['transfer_faqs_box_nonce']) && wp_verify_nonce($_POST['transfer_faqs_box_nonce'], 'transfer_faqs_box')) {
        if (isset($_POST['transfer_faqs_json'])) {
            update_post_meta($post_id, '_transfer_faqs', sanitize_text_field($_POST['transfer_faqs_json']));
        }
    }
}
add_action('save_post', 'kenya_safari_save_transfer_meta');
