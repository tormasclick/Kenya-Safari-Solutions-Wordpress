<?php
/**
 * Working Accommodation FAQs Meta Box
 */

function kenya_safari_working_accommodation_faqs_callback($post) {
    wp_nonce_field('working_accommodation_faqs_box', 'working_accommodation_faqs_box_nonce');
    
    // Get the meta value directly
    $faqs_json = get_post_meta($post->ID, '_accommodation_faqs', true);
    $faqs_array = array();
    
    if (!empty($faqs_json)) {
        $faqs_array = json_decode($faqs_json, true);
        if (!is_array($faqs_array)) {
            $faqs_array = array();
        }
    }
    
    // Debug output
    echo '<div style="background: #e8f4fd; padding: 10px; margin-bottom: 15px; border-left: 4px solid #2196f3;">';
    echo '<strong>Debug:</strong> Found ' . count($faqs_array) . ' FAQs in database for this post.';
    echo '</div>';
    ?>
    <div id="working-acc-faqs">
        <div class="faqs-list">
            <?php if (!empty($faqs_array)): ?>
                <?php foreach ($faqs_array as $index => $faq): ?>
                    <div class="faq-item" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #f59e0b;">
                        <h4>FAQ <?php echo $index + 1; ?></h4>
                        <p>
                            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Question:</label>
                            <input type="text" name="working_faq_question[]" value="<?php echo htmlspecialchars($faq['question']); ?>" style="width: 100%;" />
                        </p>
                        <p>
                            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Answer:</label>
                            <textarea name="working_faq_answer[]" rows="3" style="width: 100%;"><?php echo htmlspecialchars($faq['answer']); ?></textarea>
                        </p>
                        <button type="button" class="button remove-working-faq">Remove FAQ</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No FAQs found. Click the button below to add your first FAQ.</p>
            <?php endif; ?>
        </div>
        <button type="button" class="button button-primary" id="add-working-faq">+ Add FAQ</button>
    </div>
    
    <input type="hidden" name="working_accommodation_faqs_json" id="working_accommodation_faqs_json" value="<?php echo esc_attr(json_encode($faqs_array)); ?>" />
    
    <script>
    jQuery(document).ready(function($) {
        $('#add-working-faq').click(function() {
            var index = $('.faq-item').length;
            var newFaq = '<div class="faq-item" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #f59e0b;">' +
                '<h4>FAQ ' + (index + 1) + '</h4>' +
                '<p><label style="display: block; font-weight: bold; margin-bottom: 5px;">Question:</label>' +
                '<input type="text" name="working_faq_question[]" style="width: 100%;" /></p>' +
                '<p><label style="display: block; font-weight: bold; margin-bottom: 5px;">Answer:</label>' +
                '<textarea name="working_faq_answer[]" rows="3" style="width: 100%;"></textarea></p>' +
                '<button type="button" class="button remove-working-faq">Remove FAQ</button></div>';
            $('#working-acc-faqs .faqs-list').append(newFaq);
            updateWorkingFaqsJson();
        });
        
        $(document).on('click', '.remove-working-faq', function() {
            $(this).closest('.faq-item').remove();
            updateWorkingFaqsJson();
        });
        
        $(document).on('change keyup', 'input[name="working_faq_question[]"], textarea[name="working_faq_answer[]"]', function() {
            updateWorkingFaqsJson();
        });
        
        function updateWorkingFaqsJson() {
            var faqs = [];
            $('.faq-item').each(function() {
                var question = $(this).find('input[name="working_faq_question[]"]').val();
                var answer = $(this).find('textarea[name="working_faq_answer[]"]').val();
                if (question && answer) {
                    faqs.push({ question: question, answer: answer });
                }
            });
            $('#working_accommodation_faqs_json').val(JSON.stringify(faqs));
        }
    });
    </script>
    <?php
}

// Add the working meta box
function kenya_safari_add_working_accommodation_faqs_metabox() {
    add_meta_box(
        'working_accommodation_faqs',
        'Frequently Asked Questions',
        'kenya_safari_working_accommodation_faqs_callback',
        'accommodation',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'kenya_safari_add_working_accommodation_faqs_metabox', 70);

// Save function
function kenya_safari_save_working_accommodation_faqs($post_id) {
    if (isset($_POST['working_accommodation_faqs_box_nonce']) && wp_verify_nonce($_POST['working_accommodation_faqs_box_nonce'], 'working_accommodation_faqs_box')) {
        if (isset($_POST['working_accommodation_faqs_json'])) {
            update_post_meta($post_id, '_accommodation_faqs', sanitize_text_field($_POST['working_accommodation_faqs_json']));
        }
    }
}
add_action('save_post', 'kenya_safari_save_working_accommodation_faqs');
