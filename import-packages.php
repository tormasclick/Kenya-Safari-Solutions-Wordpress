<?php
require_once('wp-load.php');

$packages = array(
    array(
        'slug' => '3-days-maasai-mara',
        'title' => '3 Days Maasai Mara',
        'tag' => 'Safari',
        'duration' => '3 Days',
        'blurb' => 'Classic Mara immersion with optional balloon dawn.',
        'image' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=800',
        'itinerary' => json_encode(array(
            array('day' => 'Day 1', 'title' => 'Nairobi → Mara', 'detail' => 'Scenic drive from Nairobi to Mara, check-in, evening sunset game drive across the southern plains.'),
            array('day' => 'Day 2', 'title' => 'Big Five day', 'detail' => 'Full-day tracking the Big Five with a picnic lunch in-park. Optional hot air balloon at dawn.'),
            array('day' => 'Day 3', 'title' => 'Sunrise & return', 'detail' => 'Sunrise game drive, brunch, and return journey to Nairobi by afternoon.'),
        )),
        'order' => 0,
    ),
    array(
        'slug' => '2-days-amboseli',
        'title' => '2 Days Amboseli',
        'tag' => 'Safari',
        'duration' => '2 Days',
        'blurb' => 'Elephants framed by Kilimanjaro.',
        'image' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01b4e?w=800',
        'itinerary' => json_encode(array(
            array('day' => 'Day 1', 'title' => 'Nairobi → Amboseli', 'detail' => 'Drive with Mount Kilimanjaro as a scenic backdrop, afternoon game drive through swamp habitat.'),
            array('day' => 'Day 2', 'title' => 'Early exploration', 'detail' => 'Early park exploration with elephant herds, brunch, and transfer return to Nairobi.'),
        )),
        'order' => 1,
    ),
    array(
        'slug' => '1-day-nairobi-park',
        'title' => '1 Day Nairobi Park',
        'tag' => 'City',
        'duration' => 'Full Day',
        'blurb' => 'Urban safari tracking lions, rhinos and giraffes against the skyline.',
        'image' => 'https://images.unsplash.com/photo-1504208434309-cb69f4fe52b0?w=800',
        'itinerary' => json_encode(array(
            array('day' => 'Day 1', 'title' => 'Urban safari', 'detail' => 'Full-day exploration of Nairobi National Park tracking lions, rhinos and giraffes against the city skyline. Optional ivory burning monument stop.'),
        )),
        'order' => 2,
    ),
    array(
        'slug' => '5-days-kenya-explorer',
        'title' => '5 Days Kenya Explorer',
        'tag' => 'Combo',
        'duration' => '5 Days',
        'blurb' => 'Mara plains, Nakuru flamingos and Naivasha boat in one loop.',
        'image' => 'https://images.unsplash.com/photo-1534177616072-ef7dc120449d?w=800',
        'itinerary' => json_encode(array(
            array('day' => 'Day 1', 'title' => 'Nairobi → Mara', 'detail' => 'Travel to the Mara, afternoon game drive.'),
            array('day' => 'Day 2', 'title' => 'Mara full day', 'detail' => 'Big Five exploration across the open plains.'),
            array('day' => 'Day 3', 'title' => 'Mara → Nakuru', 'detail' => 'Travel via the Rift Valley to the pink-rimmed shores of Lake Nakuru.'),
            array('day' => 'Day 4', 'title' => 'Nakuru → Naivasha', 'detail' => 'Morning game drive at Nakuru, transfer to Lake Naivasha for a freshwater boat excursion.'),
            array('day' => 'Day 5', 'title' => 'Naivasha → Nairobi', 'detail' => 'Optional Hell\'s Gate cycle, return to Nairobi.'),
        )),
        'order' => 3,
    ),
    array(
        'slug' => '3-days-tsavo-safari',
        'title' => '3 Days Tsavo Safari',
        'tag' => 'Safari',
        'duration' => '3 Days',
        'blurb' => 'Coast-connected wilderness, volcanic scenery and crimson elephants.',
        'image' => 'https://images.unsplash.com/photo-1564767655650-2c6b8782f2c4?w=800',
        'itinerary' => json_encode(array(
            array('day' => 'Day 1', 'title' => 'Arrival → Tsavo', 'detail' => 'Arrival and entry into Tsavo, afternoon game drive along the Galana River.'),
            array('day' => 'Day 2', 'title' => 'Volcanic country', 'detail' => 'Full-day game tracking with Lugard Falls and Mzima Springs visits.'),
            array('day' => 'Day 3', 'title' => 'Final drive', 'detail' => 'Sunrise game drive and onward transfer to coast or Nairobi.'),
        )),
        'order' => 4,
    ),
);

foreach ($packages as $pkg) {
    $existing = get_page_by_path($pkg['slug'], OBJECT, 'package');
    
    if (!$existing) {
        $post_id = wp_insert_post(array(
            'post_title' => $pkg['title'],
            'post_name' => $pkg['slug'],
            'post_content' => $pkg['blurb'],
            'post_excerpt' => $pkg['blurb'],
            'post_status' => 'publish',
            'post_type' => 'package',
            'menu_order' => $pkg['order'],
            'meta_input' => array(
                '_package_tag' => $pkg['tag'],
                '_package_duration' => $pkg['duration'],
                '_package_blurb' => $pkg['blurb'],
                '_package_image' => $pkg['image'],
                '_package_itinerary' => $pkg['itinerary'],
            ),
        ));
        
        echo "Created package: " . $pkg['title'] . " (ID: $post_id)\n";
    } else {
        // Update existing
        wp_update_post(array(
            'ID' => $existing->ID,
            'menu_order' => $pkg['order'],
        ));
        update_post_meta($existing->ID, '_package_tag', $pkg['tag']);
        update_post_meta($existing->ID, '_package_duration', $pkg['duration']);
        update_post_meta($existing->ID, '_package_blurb', $pkg['blurb']);
        update_post_meta($existing->ID, '_package_image', $pkg['image']);
        update_post_meta($existing->ID, '_package_itinerary', $pkg['itinerary']);
        echo "Updated package: " . $pkg['title'] . "\n";
    }
}

echo "\nPackages import completed!\n";
