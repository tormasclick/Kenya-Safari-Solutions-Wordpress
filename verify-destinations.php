<?php
require_once('wp-load.php');

// Expected data from Next.js
$expected = array(
    'maasai-mara' => array('name' => 'Maasai Mara', 'tagline' => 'Home of the Great Migration', 'duration' => '3 Days / 4 Days', 'span' => 'md:col-span-2 md:row-span-2'),
    'amboseli' => array('name' => 'Amboseli', 'tagline' => 'Elephants under Kilimanjaro', 'duration' => '2 Days / 3 Days', 'span' => ''),
    'tsavo' => array('name' => 'Tsavo', 'tagline' => 'Land of the red elephants', 'duration' => '2 Days / 3 Days', 'span' => ''),
    'nairobi-national-park' => array('name' => 'Nairobi National Park', 'tagline' => 'Wildlife meets skyline', 'duration' => 'Half Day / Full Day', 'span' => ''),
    'lake-nakuru' => array('name' => 'Lake Nakuru', 'tagline' => 'A sea of pink flamingos', 'duration' => '1 Day / 2 Days', 'span' => 'md:col-span-2'),
    'lake-naivasha' => array('name' => 'Lake Naivasha', 'tagline' => 'Freshwater escape & Hell\'s Gate', 'duration' => '1 Day / 2 Days', 'span' => ''),
    'watamu' => array('name' => 'Watamu', 'tagline' => 'Turquoise marine paradise', 'duration' => '3 Days / 5 Days', 'span' => ''),
    'malindi' => array('name' => 'Malindi', 'tagline' => 'Coral coast culture', 'duration' => '3 Days / 5 Days', 'span' => 'md:col-span-2'),
    'marafa-hells-kitchen' => array('name' => 'Marafa Hell\'s Kitchen', 'tagline' => 'The Grand Canyon of Kenya', 'duration' => 'Half Day / Full Day', 'span' => ''),
);

echo "Verifying destinations...\n\n";

foreach ($expected as $slug => $data) {
    $post = get_page_by_path($slug, OBJECT, 'destination');
    if ($post) {
        // Update metadata
        update_post_meta($post->ID, '_destination_tagline', $data['tagline']);
        update_post_meta($post->ID, '_destination_duration', $data['duration']);
        update_post_meta($post->ID, '_destination_span', $data['span']);
        
        echo "✓ Updated: {$data['name']}\n";
    } else {
        echo "✗ Missing: {$data['name']}\n";
    }
}

echo "\nAll destinations verified!\n";
