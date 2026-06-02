<?php
require_once('wp-load.php');

$transfers = array(
    array(
        'slug' => 'jkia-nairobi',
        'title' => 'JKIA → Nairobi CBD',
        'desc' => 'Premium airport transfer to city center.',
        'price' => '$65',
        'duration' => '30-45 minutes',
        'vehicle' => 'Luxury SUV',
        'capacity' => '4 passengers',
        'order' => 0,
    ),
    array(
        'slug' => 'mombasa-diani',
        'title' => 'Moi Airport → Diani Beach',
        'desc' => 'Scenic coastal transfer to paradise.',
        'price' => '$110',
        'duration' => '1.5 hours',
        'vehicle' => 'Land Cruiser',
        'capacity' => '6 passengers',
        'order' => 1,
    ),
    array(
        'slug' => 'watamu-malindi',
        'title' => 'Malindi Airport → Watamu',
        'desc' => 'Coastal paradise transfer.',
        'price' => '$90',
        'duration' => '45 minutes',
        'vehicle' => 'Minivan',
        'capacity' => '7 passengers',
        'order' => 2,
    ),
    array(
        'slug' => 'sgr-nairobi',
        'title' => 'SGR Terminus → Nairobi',
        'desc' => 'Train station transfer to city.',
        'price' => '$50',
        'duration' => '30 minutes',
        'vehicle' => 'Premium Sedan',
        'capacity' => '3 passengers',
        'order' => 3,
    ),
);

foreach ($transfers as $transfer) {
    $existing = get_page_by_path($transfer['slug'], OBJECT, 'transfer');
    
    if (!$existing) {
        $post_id = wp_insert_post(array(
            'post_title' => $transfer['title'],
            'post_name' => $transfer['slug'],
            'post_content' => $transfer['desc'],
            'post_excerpt' => $transfer['desc'],
            'post_status' => 'publish',
            'post_type' => 'transfer',
            'menu_order' => $transfer['order'],
            'meta_input' => array(
                '_transfer_price' => $transfer['price'],
                '_transfer_duration' => $transfer['duration'],
                '_transfer_vehicle' => $transfer['vehicle'],
                '_transfer_capacity' => $transfer['capacity'],
            ),
        ));
        
        echo "Created transfer: " . $transfer['title'] . " (ID: $post_id)\n";
    } else {
        echo "Transfer already exists: " . $transfer['title'] . "\n";
    }
}

echo "\nTransfers import completed!\n";
