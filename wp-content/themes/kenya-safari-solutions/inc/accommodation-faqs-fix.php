<?php
// Fix for Accommodation FAQs Meta Box display

function kenya_safari_accommodation_faqs_callback_fixed($post) {
    wp_nonce_field('accommodation_faqs_box', 'accommodation_faqs_box_nonce');
    
    $faqs = get_post_meta($post->ID, '_accommodation_faqs', true);
    $faqs_array = !empty($faqs) ? json_decode($faqs, true) : array();
    
    if (!is_array($faqs_array)) {
        $faqs_array = array();
    }
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
            <?php else: ?>
                <p>No FAQs added yet. Click the button below to add your first FAQ.</p>
            <?php endif; ?>
        </div>
        <button type="button" class="button button-primary" id="add-acc-faq">+ Add FAQ</button>
    </div>
    
    <input type="hidden" name="accommodation_faqs_json" id="accommodation_faqs_json" value="<?php echo esc_attr(json_encode($faqs_array)); ?>" />
    
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

// Replace the existing meta box with the fixed version
remove_action('add_meta_boxes', 'kenya_safari_accommodation_metaboxes');
add_action('add_meta_boxes', 'kenya_safari_accommodation_metaboxes_fixed');

function kenya_safari_accommodation_metaboxes_fixed() {
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
        'kenya_safari_accommodation_faqs_callback_fixed',
        'accommodation',
        'normal',
        'high'
    );
}
