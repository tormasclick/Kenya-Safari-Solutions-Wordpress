<?php
/**
 * Marine Activities Custom Post Type - Matching Destinations CPT Structure
 */

// Register Marine Activities Custom Post Type
function kenya_safari_register_marine() {
    $labels = array(
        'name' => 'Marine Activities',
        'singular_name' => 'Marine Activity',
        'menu_name' => 'Marine',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Marine Activity',
        'edit_item' => 'Edit Marine Activity',
        'new_item' => 'New Marine Activity',
        'view_item' => 'View Marine Activity',
        'search_items' => 'Search Marine Activities',
        'not_found' => 'No marine activities found',
        'all_items' => 'All Marine Activities',
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'rewrite' => array('slug' => 'marine'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_icon' => 'dashicons-ocean',
        'show_in_rest' => true,
        'menu_position' => 7,
    );
    
    register_post_type('marine', $args);
}
add_action('init', 'kenya_safari_register_marine');

// Add meta boxes for marine activities
function kenya_safari_marine_metaboxes() {
    add_meta_box(
        'marine_details',
        'Marine Activity Details',
        'kenya_safari_marine_details_callback',
        'marine',
        'normal',
        'high'
    );
    
    add_meta_box(
        'marine_gallery',
        'Marine Gallery',
        'kenya_safari_marine_gallery_callback',
        'marine',
        'normal',
        'high'
    );
    
    add_meta_box(
        'marine_faqs',
        'Frequently Asked Questions',
        'kenya_safari_marine_faqs_callback',
        'marine',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kenya_safari_marine_metaboxes');

// Details Meta Box
function kenya_safari_marine_details_callback($post) {
    wp_nonce_field('marine_details_box', 'marine_details_box_nonce');
    
    $tagline = get_post_meta($post->ID, '_marine_tagline', true);
    $duration = get_post_meta($post->ID, '_marine_duration', true);
    $best_time = get_post_meta($post->ID, '_marine_best_time', true);
    $price = get_post_meta($post->ID, '_marine_price', true);
    $highlights = get_post_meta($post->ID, '_marine_highlights', true);
    $activities = get_post_meta($post->ID, '_marine_activities', true);
    $included = get_post_meta($post->ID, '_marine_included', true);
    ?>
    <style>
        .marine-meta-field { margin-bottom: 15px; }
        .marine-meta-field label { display: block; font-weight: bold; margin-bottom: 5px; }
        .marine-meta-field input[type="text"],
        .marine-meta-field textarea,
        .marine-meta-field select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .marine-meta-field textarea { height: 100px; }
    </style>
    
    <div class="marine-meta-field">
        <label>Tagline:</label>
        <input type="text" name="marine_tagline" value="<?php echo esc_attr($tagline); ?>" />
    </div>
    
    <div class="marine-meta-field">
        <label>Duration:</label>
        <input type="text" name="marine_duration" value="<?php echo esc_attr($duration); ?>" />
    </div>
    
    <div class="marine-meta-field">
        <label>Best Time to Visit:</label>
        <input type="text" name="marine_best_time" value="<?php echo esc_attr($best_time); ?>" />
    </div>
    
    <div class="marine-meta-field">
        <label>Price (per person):</label>
        <input type="text" name="marine_price" value="<?php echo esc_attr($price); ?>" />
    </div>
    
    <div class="marine-meta-field">
        <label>Highlights (one per line):</label>
        <textarea name="marine_highlights" placeholder="Swim with wild dolphins&#10;Snorkeling at coral reefs&#10;Sandbank seafood lunch"><?php echo esc_textarea($highlights); ?></textarea>
    </div>
    
    <div class="marine-meta-field">
        <label>Activities (one per line):</label>
        <textarea name="marine_activities" placeholder="Dolphin watching&#10;Snorkeling&#10;Marine photography"><?php echo esc_textarea($activities); ?></textarea>
    </div>
    
    <div class="marine-meta-field">
        <label>What's Included (one per line):</label>
        <textarea name="marine_included" placeholder="Snorkeling equipment&#10;Professional guide&#10;Lunch on sandbank"><?php echo esc_textarea($included); ?></textarea>
    </div>
    <?php
}

// Gallery Meta Box
function kenya_safari_marine_gallery_callback($post) {
    wp_nonce_field('marine_gallery_box', 'marine_gallery_box_nonce');
    
    $gallery_ids = get_post_meta($post->ID, '_marine_gallery_ids', true);
    $gallery_ids_array = $gallery_ids ? explode(',', $gallery_ids) : array();
    ?>
    <div class="marine-gallery">
        <button type="button" class="button" id="upload-marine-gallery-btn">Add Images to Gallery</button>
        <div id="marine-gallery-preview" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px;">
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
        <input type="hidden" name="marine_gallery_ids" id="marine_gallery_ids" value="<?php echo esc_attr($gallery_ids); ?>" />
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var frame;
        $('#upload-marine-gallery-btn').click(function(e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({ title: 'Select Gallery Images', button: { text: 'Add to Gallery' }, multiple: true });
            frame.on('select', function() {
                var selection = frame.state().get('selection');
                var ids = [];
                var currentIds = $('#marine_gallery_ids').val() ? $('#marine_gallery_ids').val().split(',') : [];
                selection.map(function(attachment) {
                    attachment = attachment.toJSON();
                    ids.push(attachment.id);
                    if (!currentIds.includes(attachment.id.toString())) {
                        $('#marine-gallery-preview').append('<div class="gallery-img" data-id="'+attachment.id+'" style="position:relative; width:100px; height:100px;"><img src="'+attachment.url+'" style="width:100%; height:100%; object-fit:cover; border-radius:4px;"><button type="button" class="remove-img" style="position:absolute; top:-5px; right:-5px; background:red; color:white; border:none; border-radius:50%; width:20px; height:20px; cursor:pointer;">×</button></div>');
                    }
                });
                var allIds = currentIds.concat(ids);
                $('#marine_gallery_ids').val(allIds.join(','));
            });
            frame.open();
        });
        
        $(document).on('click', '.remove-img', function() {
            var imgDiv = $(this).closest('.gallery-img');
            var imgId = imgDiv.data('id');
            var currentIds = $('#marine_gallery_ids').val().split(',');
            var newIds = currentIds.filter(function(id) { return id != imgId; });
            $('#marine_gallery_ids').val(newIds.join(','));
            imgDiv.remove();
        });
    });
    </script>
    <?php
}

// FAQs Meta Box - Exactly like Destinations
function kenya_safari_marine_faqs_callback($post) {
    wp_nonce_field('marine_faqs_box', 'marine_faqs_box_nonce');
    
    $faqs = get_post_meta($post->ID, '_marine_faqs', true);
    $faqs_array = $faqs ? json_decode($faqs, true) : array();
    ?>
    <div id="marine-faqs-repeater">
        <div class="faqs-list">
            <?php if (!empty($faqs_array)): ?>
                <?php foreach ($faqs_array as $index => $faq): ?>
                    <div class="faq-item" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #f59e0b;">
                        <h4>FAQ <?php echo $index + 1; ?></h4>
                        <p><label>Question:</label><br><input type="text" name="marine_faq_question[]" value="<?php echo esc_attr($faq['question']); ?>" style="width: 100%;" /></p>
                        <p><label>Answer:</label><br><textarea name="marine_faq_answer[]" rows="3" style="width: 100%;"><?php echo esc_textarea($faq['answer']); ?></textarea></p>
                        <button type="button" class="button remove-marine-faq" style="background: #dc2626; color: white;">Remove</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button type="button" class="button button-primary" id="add-marine-faq">+ Add FAQ</button>
    </div>
    
    <input type="hidden" name="marine_faqs_json" id="marine_faqs_json" value="<?php echo esc_attr($faqs); ?>" />
    
    <script>
    jQuery(document).ready(function($) {
        $('#add-marine-faq').click(function() {
            var index = $('.faq-item').length;
            var newFaq = `
                <div class="faq-item" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #f59e0b;">
                    <h4>FAQ ${index + 1}</h4>
                    <p><label>Question:</label><br><input type="text" name="marine_faq_question[]" style="width: 100%;" /></p>
                    <p><label>Answer:</label><br><textarea name="marine_faq_answer[]" rows="3" style="width: 100%;"></textarea></p>
                    <button type="button" class="button remove-marine-faq" style="background: #dc2626; color: white;">Remove</button>
                </div>
            `;
            $('#marine-faqs-repeater .faqs-list').append(newFaq);
            updateMarineFaqsJson();
        });
        
        $(document).on('click', '.remove-marine-faq', function() {
            $(this).closest('.faq-item').remove();
            updateMarineFaqsJson();
        });
        
        $(document).on('change keyup', 'input[name="marine_faq_question[]"], textarea[name="marine_faq_answer[]"]', function() {
            updateMarineFaqsJson();
        });
        
        function updateMarineFaqsJson() {
            var faqs = [];
            $('.faq-item').each(function() {
                var question = $(this).find('input[name="marine_faq_question[]"]').val();
                var answer = $(this).find('textarea[name="marine_faq_answer[]"]').val();
                if (question && answer) {
                    faqs.push({ question: question, answer: answer });
                }
            });
            $('#marine_faqs_json').val(JSON.stringify(faqs));
        }
    });
    </script>
    <?php
}

// Save all marine meta data
function kenya_safari_save_marine_meta($post_id) {
    // Save details
    if (isset($_POST['marine_details_box_nonce']) && wp_verify_nonce($_POST['marine_details_box_nonce'], 'marine_details_box')) {
        $fields = array('marine_tagline', 'marine_duration', 'marine_best_time', 'marine_price', 'marine_highlights', 'marine_activities', 'marine_included');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    
    // Save gallery
    if (isset($_POST['marine_gallery_box_nonce']) && wp_verify_nonce($_POST['marine_gallery_box_nonce'], 'marine_gallery_box')) {
        if (isset($_POST['marine_gallery_ids'])) {
            update_post_meta($post_id, '_marine_gallery_ids', sanitize_text_field($_POST['marine_gallery_ids']));
        }
    }
    
    // Save FAQs
    if (isset($_POST['marine_faqs_box_nonce']) && wp_verify_nonce($_POST['marine_faqs_box_nonce'], 'marine_faqs_box')) {
        if (isset($_POST['marine_faqs_json'])) {
            update_post_meta($post_id, '_marine_faqs', sanitize_text_field($_POST['marine_faqs_json']));
        }
    }
}
add_action('save_post', 'kenya_safari_save_marine_meta');

// Add Accommodations Selection Meta Box for Marine
function kenya_safari_marine_accommodations_callback($post) {
    wp_nonce_field('marine_accommodations_box', 'marine_accommodations_box_nonce');
    
    $selected_accommodations = get_post_meta($post->ID, '_marine_accommodations', true);
    $selected_accommodations_array = $selected_accommodations ? explode(',', $selected_accommodations) : array();
    
    $accommodations = get_posts(array(
        'post_type' => 'accommodation',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    ?>
    <p>Select which accommodations to recommend for this marine activity (drag to reorder):</p>
    <ul id="marine-accommodations-sortable" style="list-style: none; padding: 0; margin: 0;">
        <?php foreach ($selected_accommodations_array as $acc_id): 
            $acc = get_post($acc_id);
            if ($acc):
        ?>
            <li style="padding: 8px; margin: 5px 0; background: #f0f0f0; border: 1px solid #ddd; border-radius: 4px; cursor: move;">
                <input type="checkbox" name="marine_accommodations[]" value="<?php echo $acc_id; ?>" checked="checked" />
                <?php echo esc_html($acc->post_title); ?>
            </li>
        <?php endif; endforeach; ?>
        
        <?php foreach ($accommodations as $acc): 
            if (!in_array($acc->ID, $selected_accommodations_array)):
        ?>
            <li style="padding: 8px; margin: 5px 0; background: #fff; border: 1px solid #ddd; border-radius: 4px; cursor: move;">
                <input type="checkbox" name="marine_accommodations[]" value="<?php echo $acc->ID; ?>" />
                <?php echo esc_html($acc->post_title); ?>
            </li>
        <?php endif; endforeach; ?>
    </ul>
    
    <script>
    jQuery(document).ready(function($) {
        $('#marine-accommodations-sortable').sortable({ update: function() { updateMarineOrder(); } });
        function updateMarineOrder() {
            $('#marine-accommodations-sortable li').each(function(idx) {
                $(this).find('input').attr('name', 'marine_accommodations[]');
            });
        }
    });
    </script>
    <?php
}

// Add the meta box to marine
function kenya_safari_add_marine_accommodations_metabox() {
    add_meta_box(
        'marine_accommodations',
        'Recommended Accommodations',
        'kenya_safari_marine_accommodations_callback',
        'marine',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kenya_safari_add_marine_accommodations_metabox');

// Save marine accommodations
function kenya_safari_save_marine_accommodations($post_id) {
    if (isset($_POST['marine_accommodations_box_nonce']) && wp_verify_nonce($_POST['marine_accommodations_box_nonce'], 'marine_accommodations_box')) {
        if (isset($_POST['marine_accommodations'])) {
            $accommodations = array_map('intval', $_POST['marine_accommodations']);
            update_post_meta($post_id, '_marine_accommodations', implode(',', $accommodations));
        } else {
            delete_post_meta($post_id, '_marine_accommodations');
        }
    }
}
add_action('save_post', 'kenya_safari_save_marine_accommodations');
