<?php
/**
 * Destinations Custom Post Type with Full Meta Boxes
 */

// Register Destinations Custom Post Type
function kenya_safari_register_destinations() {
    $labels = array(
        'name' => 'Destinations',
        'singular_name' => 'Destination',
        'menu_name' => 'Destinations',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Destination',
        'edit_item' => 'Edit Destination',
        'new_item' => 'New Destination',
        'view_item' => 'View Destination',
        'search_items' => 'Search Destinations',
        'not_found' => 'No destinations found',
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'rewrite' => array('slug' => 'destinations'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_icon' => 'dashicons-location-alt',
        'show_in_rest' => true,
    );
    
    register_post_type('destination', $args);
}
add_action('init', 'kenya_safari_register_destinations');

// Add meta boxes
function kenya_safari_destination_metaboxes() {
    add_meta_box(
        'destination_details',
        'Destination Details',
        'kenya_safari_destination_details_callback',
        'destination',
        'normal',
        'high'
    );
    
    add_meta_box(
        'destination_gallery',
        'Destination Gallery',
        'kenya_safari_destination_gallery_callback',
        'destination',
        'normal',
        'high'
    );
    
    add_meta_box(
        'destination_accommodations',
        'Select Accommodations for this Destination',
        'kenya_safari_destination_accommodations_callback',
        'destination',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kenya_safari_destination_metaboxes');

// Details Meta Box
function kenya_safari_destination_details_callback($post) {
    wp_nonce_field('destination_details_box', 'destination_details_box_nonce');
    
    $tagline = get_post_meta($post->ID, '_destination_tagline', true);
    $duration = get_post_meta($post->ID, '_destination_duration', true);
    $best_time = get_post_meta($post->ID, '_destination_best_time', true);
    $weather = get_post_meta($post->ID, '_destination_weather', true);
    $highlights = get_post_meta($post->ID, '_destination_highlights', true);
    $wildlife = get_post_meta($post->ID, '_destination_wildlife', true);
    $activities = get_post_meta($post->ID, '_destination_activities', true);
    ?>
    <style>
        .dest-meta-field { margin-bottom: 15px; }
        .dest-meta-field label { display: block; font-weight: bold; margin-bottom: 5px; }
        .dest-meta-field input, .dest-meta-field textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .dest-meta-field textarea { height: 100px; }
    </style>
    
    <div class="dest-meta-field">
        <label>Tagline:</label>
        <input type="text" name="destination_tagline" value="<?php echo esc_attr($tagline); ?>" />
    </div>
    
    <div class="dest-meta-field">
        <label>Recommended Duration:</label>
        <input type="text" name="destination_duration" value="<?php echo esc_attr($duration); ?>" />
    </div>
    
    <div class="dest-meta-field">
        <label>Best Time to Visit:</label>
        <input type="text" name="destination_best_time" value="<?php echo esc_attr($best_time); ?>" />
    </div>
    
    <div class="dest-meta-field">
        <label>Weather:</label>
        <input type="text" name="destination_weather" value="<?php echo esc_attr($weather); ?>" />
    </div>
    
    <div class="dest-meta-field">
        <label>Highlights (one per line):</label>
        <textarea name="destination_highlights"><?php echo esc_textarea($highlights); ?></textarea>
    </div>
    
    <div class="dest-meta-field">
        <label>Wildlife (comma separated):</label>
        <textarea name="destination_wildlife"><?php echo esc_textarea($wildlife); ?></textarea>
    </div>
    
    <div class="dest-meta-field">
        <label>Activities (comma separated):</label>
        <textarea name="destination_activities"><?php echo esc_textarea($activities); ?></textarea>
    </div>
    <?php
}

// Gallery Meta Box
function kenya_safari_destination_gallery_callback($post) {
    wp_nonce_field('destination_gallery_box', 'destination_gallery_box_nonce');
    
    $gallery_ids = get_post_meta($post->ID, '_destination_gallery_ids', true);
    $gallery_ids_array = $gallery_ids ? explode(',', $gallery_ids) : array();
    ?>
    <div class="dest-gallery">
        <button type="button" class="button" id="upload-gallery-btn">Add Images to Gallery</button>
        <div id="gallery-preview" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px;">
            <?php foreach ($gallery_ids_array as $image_id): 
                $image_url = wp_get_attachment_image_url($image_id, 'medium');
                if ($image_url):
            ?>
                <div class="gallery-img" data-id="<?php echo $image_id; ?>" style="position: relative; width: 100px; height: 100px;">
                    <img src="<?php echo esc_url($image_url); ?>" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
                    <button type="button" class="remove-img" style="position:absolute; top:-5px; right:-5px; background:red; color:white; border:none; border-radius:50%; width:20px; height:20px; cursor:pointer;">×</button>
                </div>
            <?php endif; endforeach; ?>
        </div>
        <input type="hidden" name="destination_gallery_ids" id="destination_gallery_ids" value="<?php echo esc_attr($gallery_ids); ?>" />
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var frame;
        $('#upload-gallery-btn').click(function(e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({ title: 'Select Gallery Images', button: { text: 'Add to Gallery' }, multiple: true });
            frame.on('select', function() {
                var selection = frame.state().get('selection');
                var ids = [];
                var currentIds = $('#destination_gallery_ids').val() ? $('#destination_gallery_ids').val().split(',') : [];
                selection.map(function(attachment) {
                    attachment = attachment.toJSON();
                    ids.push(attachment.id);
                    if (!currentIds.includes(attachment.id.toString())) {
                        $('#gallery-preview').append('<div class="gallery-img" data-id="'+attachment.id+'" style="position:relative; width:100px; height:100px;"><img src="'+attachment.url+'" style="width:100%; height:100%; object-fit:cover; border-radius:4px;"><button type="button" class="remove-img" style="position:absolute; top:-5px; right:-5px; background:red; color:white; border:none; border-radius:50%; width:20px; height:20px; cursor:pointer;">×</button></div>');
                    }
                });
                var allIds = currentIds.concat(ids);
                $('#destination_gallery_ids').val(allIds.join(','));
            });
            frame.open();
        });
        
        $(document).on('click', '.remove-img', function() {
            var imgDiv = $(this).closest('.gallery-img');
            var imgId = imgDiv.data('id');
            var currentIds = $('#destination_gallery_ids').val().split(',');
            var newIds = currentIds.filter(function(id) { return id != imgId; });
            $('#destination_gallery_ids').val(newIds.join(','));
            imgDiv.remove();
        });
    });
    </script>
    <?php
}

// Accommodations Selection Meta Box
function kenya_safari_destination_accommodations_callback($post) {
    wp_nonce_field('destination_accommodations_box', 'destination_accommodations_box_nonce');
    
    $selected_accommodations = get_post_meta($post->ID, '_destination_accommodations', true);
    $selected_accommodations_array = $selected_accommodations ? explode(',', $selected_accommodations) : array();
    
    $accommodations = get_posts(array(
        'post_type' => 'accommodation',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    ?>
    <p>Select which accommodations to feature for this destination (drag to reorder):</p>
    <ul id="accommodations-sortable" style="list-style: none; padding: 0; margin: 0;">
        <?php foreach ($selected_accommodations_array as $acc_id): 
            $acc = get_post($acc_id);
            if ($acc):
        ?>
            <li style="padding: 8px; margin: 5px 0; background: #f0f0f0; border: 1px solid #ddd; border-radius: 4px; cursor: move;">
                <input type="checkbox" name="destination_accommodations[]" value="<?php echo $acc_id; ?>" checked="checked" />
                <?php echo esc_html($acc->post_title); ?>
            </li>
        <?php endif; endforeach; ?>
        
        <?php foreach ($accommodations as $acc): 
            if (!in_array($acc->ID, $selected_accommodations_array)):
        ?>
            <li style="padding: 8px; margin: 5px 0; background: #fff; border: 1px solid #ddd; border-radius: 4px; cursor: move;">
                <input type="checkbox" name="destination_accommodations[]" value="<?php echo $acc->ID; ?>" />
                <?php echo esc_html($acc->post_title); ?>
            </li>
        <?php endif; endforeach; ?>
    </ul>
    
    <script>
    jQuery(document).ready(function($) {
        $('#accommodations-sortable').sortable({ update: function() { updateOrder(); } });
        function updateOrder() {
            $('#accommodations-sortable li').each(function(idx) {
                $(this).find('input').attr('name', 'destination_accommodations[]');
            });
        }
    });
    </script>
    <?php
}

// Save all meta data
function kenya_safari_save_destination_meta($post_id) {
    // Save details
    if (isset($_POST['destination_details_box_nonce']) && wp_verify_nonce($_POST['destination_details_box_nonce'], 'destination_details_box')) {
        $fields = array('destination_tagline', 'destination_duration', 'destination_best_time', 'destination_weather', 'destination_highlights', 'destination_wildlife', 'destination_activities');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    
    // Save gallery
    if (isset($_POST['destination_gallery_box_nonce']) && wp_verify_nonce($_POST['destination_gallery_box_nonce'], 'destination_gallery_box')) {
        if (isset($_POST['destination_gallery_ids'])) {
            update_post_meta($post_id, '_destination_gallery_ids', sanitize_text_field($_POST['destination_gallery_ids']));
        }
    }
    
    // Save accommodations
    if (isset($_POST['destination_accommodations_box_nonce']) && wp_verify_nonce($_POST['destination_accommodations_box_nonce'], 'destination_accommodations_box')) {
        if (isset($_POST['destination_accommodations'])) {
            $accommodations = array_map('intval', $_POST['destination_accommodations']);
            update_post_meta($post_id, '_destination_accommodations', implode(',', $accommodations));
        } else {
            delete_post_meta($post_id, '_destination_accommodations');
        }
    }
}
add_action('save_post', 'kenya_safari_save_destination_meta');

// Add FAQs Meta Box
function kenya_safari_destination_faqs_callback($post) {
    wp_nonce_field('destination_faqs_box', 'destination_faqs_box_nonce');
    
    $faqs = get_post_meta($post->ID, '_destination_faqs', true);
    $faqs_array = $faqs ? json_decode($faqs, true) : array();
    ?>
    <div id="faqs-repeater">
        <div class="faqs-list">
            <?php if (!empty($faqs_array)): ?>
                <?php foreach ($faqs_array as $index => $faq): ?>
                    <div class="faq-item" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #f59e0b;">
                        <h4>FAQ <?php echo $index + 1; ?></h4>
                        <p><label>Question:</label><br><input type="text" name="faq_question[]" value="<?php echo esc_attr($faq['question']); ?>" style="width: 100%;" /></p>
                        <p><label>Answer:</label><br><textarea name="faq_answer[]" rows="3" style="width: 100%;"><?php echo esc_textarea($faq['answer']); ?></textarea></p>
                        <button type="button" class="button remove-faq" style="background: #dc2626; color: white;">Remove</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button type="button" class="button button-primary" id="add-faq">+ Add FAQ</button>
    </div>
    
    <input type="hidden" name="destination_faqs_json" id="destination_faqs_json" value="<?php echo esc_attr($faqs); ?>" />
    
    <script>
    jQuery(document).ready(function($) {
        $('#add-faq').click(function() {
            var index = $('.faq-item').length;
            var newFaq = `
                <div class="faq-item" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #f59e0b;">
                    <h4>FAQ ${index + 1}</h4>
                    <p><label>Question:</label><br><input type="text" name="faq_question[]" style="width: 100%;" /></p>
                    <p><label>Answer:</label><br><textarea name="faq_answer[]" rows="3" style="width: 100%;"></textarea></p>
                    <button type="button" class="button remove-faq" style="background: #dc2626; color: white;">Remove</button>
                </div>
            `;
            $('#faqs-repeater .faqs-list').append(newFaq);
            updateFaqsJson();
        });
        
        $(document).on('click', '.remove-faq', function() {
            $(this).closest('.faq-item').remove();
            updateFaqsJson();
        });
        
        $(document).on('change keyup', 'input[name="faq_question[]"], textarea[name="faq_answer[]"]', function() {
            updateFaqsJson();
        });
        
        function updateFaqsJson() {
            var faqs = [];
            $('.faq-item').each(function() {
                var question = $(this).find('input[name="faq_question[]"]').val();
                var answer = $(this).find('textarea[name="faq_answer[]"]').val();
                if (question && answer) {
                    faqs.push({ question: question, answer: answer });
                }
            });
            $('#destination_faqs_json').val(JSON.stringify(faqs));
        }
    });
    </script>
    <?php
}

// Add FAQs meta box to the list
function kenya_safari_add_faqs_metabox() {
    add_meta_box(
        'destination_faqs',
        'Frequently Asked Questions',
        'kenya_safari_destination_faqs_callback',
        'destination',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kenya_safari_add_faqs_metabox');

// Save FAQs
function kenya_safari_save_faqs_meta($post_id) {
    if (isset($_POST['destination_faqs_box_nonce']) && wp_verify_nonce($_POST['destination_faqs_box_nonce'], 'destination_faqs_box')) {
        if (isset($_POST['destination_faqs_json'])) {
            update_post_meta($post_id, '_destination_faqs', sanitize_text_field($_POST['destination_faqs_json']));
        }
    }
}
add_action('save_post', 'kenya_safari_save_faqs_meta');
