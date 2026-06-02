<?php
require_once('wp-load.php');

$testimonials = array(
    array(
        'client_name' => 'Sofia & Marco',
        'client_origin' => 'Italy',
        'rating' => 5,
        'text' => 'The Mara migration trip was once-in-a-lifetime. Our guide from Kenya Vivid Escape was extraordinary.',
        'order' => 0,
    ),
    array(
        'client_name' => 'James Carter',
        'client_origin' => 'UK',
        'rating' => 5,
        'text' => 'Smooth JKIA pickup, perfect Amboseli safari, and Watamu blew us away.',
        'order' => 1,
    ),
    array(
        'client_name' => 'Aisha Khan',
        'client_origin' => 'UAE',
        'rating' => 5,
        'text' => 'Family safari with kids — felt completely safe, organized, and magical.',
        'order' => 2,
    ),
    array(
        'client_name' => 'Chen & Wei',
        'client_origin' => 'Singapore',
        'rating' => 5,
        'text' => 'Honeymoon: 3 days Mara + 4 days Watamu. Already planning the next trip.',
        'order' => 3,
    ),
    array(
        'client_name' => 'Michael & Sarah',
        'client_origin' => 'USA',
        'rating' => 5,
        'text' => 'The attention to detail was incredible. Every lodge exceeded our expectations. Can\'t wait to return!',
        'order' => 4,
    ),
    array(
        'client_name' => 'Emma Watson',
        'client_origin' => 'Australia',
        'rating' => 5,
        'text' => 'From the first WhatsApp message to the final drop-off, everything was seamless. Best vacation ever!',
        'order' => 5,
    ),
);

foreach ($testimonials as $testimonial) {
    $existing = get_page_by_title($testimonial['client_name'], OBJECT, 'testimonial');
    
    if (!$existing) {
        $post_id = wp_insert_post(array(
            'post_title' => $testimonial['client_name'],
            'post_content' => $testimonial['text'],
            'post_status' => 'publish',
            'post_type' => 'testimonial',
            'menu_order' => $testimonial['order'],
            'meta_input' => array(
                '_testimonial_client_name' => $testimonial['client_name'],
                '_testimonial_client_origin' => $testimonial['client_origin'],
                '_testimonial_rating' => $testimonial['rating'],
                '_testimonial_text' => $testimonial['text'],
            ),
        ));
        
        echo "Created testimonial: " . $testimonial['client_name'] . " (ID: $post_id)\n";
    } else {
        echo "Testimonial already exists: " . $testimonial['client_name'] . "\n";
    }
}

echo "\nTestimonials import completed!\n";
