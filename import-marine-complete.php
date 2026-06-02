<?php
require_once('wp-load.php');

$marine_activities = array(
    array(
        'slug' => 'dolphin-tours',
        'name' => 'Dolphin Tours',
        'tagline' => 'Experience the magic of swimming with wild dolphins in their natural habitat off the coast of Watamu and Kisite Marine Park.',
        'price' => '$70',
        'duration' => 'Half Day (4-5 hours)',
        'best_time' => 'October to March (peak dolphin season)',
        'activities' => 'Dolphin watching, Snorkeling, Marine life viewing, Photography',
        'description' => '<h2>Swim with Wild Dolphins in Their Natural Habitat</h2><p>Watamu Marine National Park is one of the best places in Africa for wild dolphin encounters. Our dolphin tours offer you the rare opportunity to swim alongside these intelligent and playful marine mammals in their natural environment.</p>',
        'order' => 0,
    ),
    array(
        'slug' => 'safari-blue',
        'name' => 'Safari Blue',
        'tagline' => 'Experience the ultimate dhow sailing adventure with snorkeling at three reef sites, sandbank seafood lunch, and marine exploration.',
        'price' => '$95',
        'duration' => 'Full Day (8 hours)',
        'best_time' => 'October to April (calmest seas)',
        'activities' => 'Dhow sailing, Snorkeling (3 reef sites), Sandbank lunch, Marine exploration',
        'description' => '<h2>Experience the Magic of Traditional Dhow Sailing</h2><p>Safari Blue is our flagship marine experience—a full-day adventure aboard a traditional Swahili dhow.</p>',
        'order' => 1,
    ),
    array(
        'slug' => 'snorkeling',
        'name' => 'Snorkeling',
        'tagline' => 'Discover the underwater wonders of Watamu\'s coral reefs, home to green sea turtles, tropical fish, and vibrant coral gardens.',
        'price' => '$55',
        'duration' => 'Half Day (4 hours)',
        'best_time' => 'October to April (clearest waters)',
        'activities' => 'Snorkeling, Coral reef exploration, Marine life spotting',
        'description' => '<h2>Discover Kenya\'s Most Accessible Coral Reefs</h2><p>Watamu Marine National Park protects some of the Indian Ocean\'s healthiest and most accessible coral reefs.</p>',
        'order' => 2,
    ),
    array(
        'slug' => 'watamu-marine-park',
        'name' => 'Watamu Marine Park',
        'tagline' => 'Visit Kenya\'s premier marine protected area, home to green turtles, stingrays, and some of the coast\'s healthiest coral reefs.',
        'price' => '$50',
        'duration' => 'Half Day / Full Day (flexible)',
        'best_time' => 'Year-round (calmest October-March)',
        'activities' => 'Marine park tour, Snorkeling, Coral viewing, Sea turtle spotting',
        'description' => '<h2>Explore Kenya\'s Most Important Marine Protected Area</h2><p>Watamu Marine National Park was established in 1968 and is now a UNESCO Biosphere Reserve.</p>',
        'order' => 3,
    ),
);

foreach ($marine_activities as $activity) {
    $existing = get_page_by_path($activity['slug'], OBJECT, 'marine');
    
    if (!$existing) {
        $post_id = wp_insert_post(array(
            'post_title' => $activity['name'],
            'post_name' => $activity['slug'],
            'post_content' => $activity['description'],
            'post_excerpt' => $activity['tagline'],
            'post_status' => 'publish',
            'post_type' => 'marine',
            'menu_order' => $activity['order'],
            'meta_input' => array(
                '_marine_tagline' => $activity['tagline'],
                '_marine_price' => $activity['price'],
                '_marine_duration' => $activity['duration'],
                '_marine_best_time' => $activity['best_time'],
                '_marine_activities' => $activity['activities'],
            ),
        ));
        
        echo "Created marine activity: " . $activity['name'] . " (ID: $post_id)\n";
    } else {
        // Update existing
        wp_update_post(array(
            'ID' => $existing->ID,
            'menu_order' => $activity['order'],
        ));
        update_post_meta($existing->ID, '_marine_tagline', $activity['tagline']);
        update_post_meta($existing->ID, '_marine_price', $activity['price']);
        update_post_meta($existing->ID, '_marine_duration', $activity['duration']);
        update_post_meta($existing->ID, '_marine_best_time', $activity['best_time']);
        update_post_meta($existing->ID, '_marine_activities', $activity['activities']);
        echo "Updated marine activity: " . $activity['name'] . "\n";
    }
}

echo "\nMarine activities import completed!\n";
