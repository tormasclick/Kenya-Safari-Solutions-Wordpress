<?php
/**
 * Custom Metaboxes for Kenya Safari Solutions
 */

// Enable media uploader
function kenya_admin_scripts() {
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'kenya_admin_scripts');

// Hero Section
function kenya_hero_metabox() {
    add_meta_box('kenya_hero', 'Hero Section', 'kenya_hero_callback', ['page', 'post'], 'normal', 'high');
}
add_action('add_meta_boxes', 'kenya_hero_metabox');

function kenya_hero_callback($post) {
    wp_nonce_field('kenya_hero_nonce', 'kenya_hero_nonce');
    $fields = [
        'hero_title' => get_post_meta($post->ID, '_kenya_hero_title', true),
        'hero_subtitle' => get_post_meta($post->ID, '_kenya_hero_subtitle', true),
        'hero_cta_text' => get_post_meta($post->ID, '_kenya_hero_cta_text', true),
        'hero_cta_url' => get_post_meta($post->ID, '_kenya_hero_cta_url', true),
        'hero_video' => get_post_meta($post->ID, '_kenya_hero_video', true),
    ];
    ?>
    <style>.kenya-field{margin-bottom:15px}.kenya-field label{display:block;font-weight:600;margin-bottom:5px}.kenya-field input,.kenya-field textarea{width:100%;padding:8px}</style>
    <div class="kenya-field"><label>Hero Title</label><input type="text" name="kenya_hero_title" value="<?php echo esc_attr($fields['hero_title']); ?>" /></div>
    <div class="kenya-field"><label>Hero Subtitle</label><textarea name="kenya_hero_subtitle" rows="3"><?php echo esc_textarea($fields['hero_subtitle']); ?></textarea></div>
    <div class="kenya-field"><label>CTA Button Text</label><input type="text" name="kenya_hero_cta_text" value="<?php echo esc_attr($fields['hero_cta_text']); ?>" /></div>
    <div class="kenya-field"><label>CTA Button URL</label><input type="url" name="kenya_hero_cta_url" value="<?php echo esc_url($fields['hero_cta_url']); ?>" /></div>
    <div class="kenya-field"><label>Background Video URL (MP4)</label><input type="url" name="kenya_hero_video" value="<?php echo esc_url($fields['hero_video']); ?>" /></div>
    <?php
}

// Destinations Section
function kenya_destinations_metabox() {
    add_meta_box('kenya_destinations', 'Destinations', 'kenya_destinations_callback', 'page', 'normal', 'high');
}
add_action('add_meta_boxes', 'kenya_destinations_metabox');

function kenya_destinations_callback($post) {
    wp_nonce_field('kenya_destinations_nonce', 'kenya_destinations_nonce');
    $destinations = get_post_meta($post->ID, '_kenya_destinations', true);
    if (!is_array($destinations)) $destinations = [];
    ?>
    <div id="destinations-wrapper">
        <div class="destinations-list">
            <?php foreach ($destinations as $i => $d): ?>
                <div class="dest-item" style="border:1px solid #ccc; padding:15px; margin-bottom:15px;">
                    <h4>Destination <?php echo $i+1; ?></h4>
                    <p><label>Name:</label><input type="text" name="kenya_destinations[<?php echo $i; ?>][name]" value="<?php echo esc_attr($d['name']); ?>" style="width:100%" /></p>
                    <p><label>Description:</label><textarea name="kenya_destinations[<?php echo $i; ?>][desc]" rows="2" style="width:100%"><?php echo esc_textarea($d['desc']); ?></textarea></p>
                    <p><label>Image URL:</label><input type="url" name="kenya_destinations[<?php echo $i; ?>][image]" value="<?php echo esc_url($d['image']); ?>" style="width:100%" class="dest-image" /></p>
                    <button type="button" class="button upload-image">Upload Image</button>
                    <button type="button" class="button remove-dest" style="background:#dc2626; color:white; margin-left:10px;">Remove</button>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" id="add-destination" class="button button-primary">Add Destination</button>
    </div>
    <script>
    jQuery(document).ready(function($) {
        var index = $('.dest-item').length;
        $('#add-destination').click(function() {
            var newDest = `<div class="dest-item" style="border:1px solid #ccc; padding:15px; margin-bottom:15px;">
                <h4>Destination ${index+1}</h4>
                <p><label>Name:</label><input type="text" name="kenya_destinations[${index}][name]" style="width:100%" /></p>
                <p><label>Description:</label><textarea name="kenya_destinations[${index}][desc]" rows="2" style="width:100%"></textarea></p>
                <p><label>Image URL:</label><input type="url" name="kenya_destinations[${index}][image]" style="width:100%" class="dest-image" /></p>
                <button type="button" class="button upload-image">Upload Image</button>
                <button type="button" class="button remove-dest" style="background:#dc2626; color:white; margin-left:10px;">Remove</button>
            </div>`;
            $('#destinations-wrapper .destinations-list').append(newDest);
            index++;
        });
        $(document).on('click', '.remove-dest', function() { $(this).closest('.dest-item').remove(); });
        $(document).on('click', '.upload-image', function(e) {
            e.preventDefault();
            var btn = $(this);
            var frame = wp.media({ title: 'Select Image', button: { text: 'Use this image' }, multiple: false });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                btn.siblings('.dest-image').val(attachment.url);
            });
            frame.open();
        });
    });
    </script>
    <?php
}

// Save all metaboxes
function kenya_save_metaboxes($post_id) {
    if (isset($_POST['kenya_hero_nonce']) && wp_verify_nonce($_POST['kenya_hero_nonce'], 'kenya_hero_nonce')) {
        $hero_fields = ['kenya_hero_title', 'kenya_hero_subtitle', 'kenya_hero_cta_text', 'kenya_hero_cta_url', 'kenya_hero_video'];
        foreach ($hero_fields as $field) {
            if (isset($_POST[$field])) update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
    
    if (isset($_POST['kenya_destinations_nonce']) && wp_verify_nonce($_POST['kenya_destinations_nonce'], 'kenya_destinations_nonce')) {
        if (isset($_POST['kenya_destinations'])) {
            $dests = [];
            foreach ($_POST['kenya_destinations'] as $dest) {
                if (!empty($dest['name'])) {
                    $dests[] = [
                        'name' => sanitize_text_field($dest['name']),
                        'desc' => sanitize_textarea_field($dest['desc']),
                        'image' => esc_url_raw($dest['image']),
                    ];
                }
            }
            update_post_meta($post_id, '_kenya_destinations', $dests);
        }
    }
}
add_action('save_post', 'kenya_save_metaboxes');
