<?php
/**
 * Simple Accommodation FAQs Meta Box
 */

function kenya_safari_simple_accommodation_faqs_callback($post) {
    wp_nonce_field('simple_accommodation_faqs_box', 'simple_accommodation_faqs_box_nonce');
    
    // Get saved FAQs
    $faqs_json = get_post_meta($post->ID, '_accommodation_faqs', true);
    $faqs_array = !empty($faqs_json) ? json_decode($faqs_json, true) : array();
    
    if (!is_array($faqs_array)) {
        $faqs_array = array();
    }
    ?>
    <div id="simple-acc-faqs">
        <div class="faqs-list">
            <?php if (!empty($faqs_array)): ?>
                <?php foreach ($faqs_array as $index => $faq): ?>
                    <div class="faq-item" style="background: #f0f8ff; padding: 15px; margin-bottom: 15px; border-left: 4px solid #f59e0b; border-radius: 8px;">
                        <h4>FAQ <?php echo $index + 1; ?></h4>
                        <p>
                            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Question:</label>
                            <input type="text" name="simple_acc_faq_question[]" value="<?php echo esc_attr($faq['question']); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" />
                        </p>
                        <p>
                            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Answer:</label>
                            <textarea name="simple_acc_faq_answer[]" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"><?php echo esc_textarea($faq['answer']); ?></textarea>
                        </p>
                        <button type="button" class="button remove-simple-faq" style="background: #dc2626; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Remove FAQ</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No FAQs added yet. Click the button below to add your first FAQ.</p>
            <?php endif; ?>
        </div>
        <button type="button" class="button button-primary" id="add-simple-faq" style="margin-top: 10px;">+ Add FAQ</button>
    </div>
    
    <input type="hidden" name="simple_accommodation_faqs_json" id="simple_accommodation_faqs_json" value="<?php echo esc_attr(json_encode($faqs_array)); ?>" />
    
    <script>
    jQuery(document).ready(function($) {
        $('#add-simple-faq').click(function() {
            var index = $('.faq-item').length;
            var newFaq = `
                <div class="faq-item" style="background: #f0f8ff; padding: 15px; margin-bottom: 15px; border-left: 4px solid #f59e0b; border-radius: 8px;">
                    <h4>FAQ ${index + 1}</h4>
                    <p>
                        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Question:</label>
                        <input type="text" name="simple_acc_faq_question[]" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" />
                    </p>
                    <p>
                        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Answer:</label>
                        <textarea name="simple_acc_faq_answer[]" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
                    </p>
                    <button type="button" class="button remove-simple-faq" style="background: #dc2626; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Remove FAQ</button>
                </div>
            `;
            $('#simple-acc-faqs .faqs-list').append(newFaq);
            updateSimpleFaqsJson();
        });
        
        $(document).on('click', '.remove-simple-faq', function() {
            $(this).closest('.faq-item').remove();
            updateSimpleFaqsJson();
        });
        
        $(document).on('change keyup', 'input[name="simple_acc_faq_question[]"], textarea[name="simple_acc_faq_answer[]"]', function() {
            updateSimpleFaqsJson();
        });
        
        function updateSimpleFaqsJson() {
            var faqs = [];
            $('.faq-item').each(function() {
                var question = $(this).find('input[name="simple_acc_faq_question[]"]').val();
                var answer = $(this).find('textarea[name="simple_acc_faq_answer[]"]').val();
                if (question && answer) {
                    faqs.push({ question: question, answer: answer });
                }
            });
            $('#simple_accommodation_faqs_json').val(JSON.stringify(faqs));
        }
    });
    </script>
    <?php
}

// Add the simple meta box
function kenya_safari_add_simple_accommodation_faqs_metabox() {
    add_meta_box(
        'simple_accommodation_faqs',
        'Frequently Asked Questions',
        'kenya_safari_simple_accommodation_faqs_callback',
        'accommodation',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kenya_safari_add_simple_accommodation_faqs_metabox', 50);

// Save the simple FAQ data
function kenya_safari_save_simple_accommodation_faqs($post_id) {
    if (isset($_POST['simple_accommodation_faqs_box_nonce']) && wp_verify_nonce($_POST['simple_accommodation_faqs_box_nonce'], 'simple_accommodation_faqs_box')) {
        if (isset($_POST['simple_accommodation_faqs_json'])) {
            update_post_meta($post_id, '_accommodation_faqs', sanitize_text_field($_POST['simple_accommodation_faqs_json']));
        }
    }
}
add_action('save_post', 'kenya_safari_save_simple_accommodation_faqs');
