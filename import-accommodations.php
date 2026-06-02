<?php
require_once('wp-load.php');

$accommodations = array(
    array(
        'slug' => 'angama-mara',
        'name' => 'Angama Mara',
        'tagline' => 'Luxury lodge perched on the Great Rift Valley escarpment',
        'location' => 'Maasai Mara',
        'price_range' => '$800-1200',
        'type' => 'LUXURY',
        'rating' => 5,
        'features' => 'Private game drives,Hot air balloon safaris,Spa,Infinity pool,Photography studio,Gym,Private veranda,Butler service',
        'description' => 'Angama Mara means "suspended in mid-air" in Swahili, perfectly describing this stunning lodge perched 300 meters above the floor of the Great Rift Valley. Located in the private Mara Conservancy, Angama offers unparalleled views of the Maasai Mara below.',
    ),
    array(
        'slug' => 'mahali-mzuri',
        'name' => 'Mahali Mzuri',
        'tagline' => "Sir Richard Branson's award-winning safari camp",
        'location' => 'Maasai Mara',
        'price_range' => '$1000-1500',
        'type' => 'LUXURY',
        'rating' => 5,
        'features' => 'Private conservancy access,Spa treatments,Swimming pool,All-inclusive dining,Night game drives,Walking safaris,Private vehicle option,Photography hides',
        'description' => 'Mahali Mzuri, meaning "beautiful place" in Swahili, is Sir Richard Branson\'s luxury safari camp in the private Olare Motorogi Conservancy. The camp features 12 glass-fronted safari tents, each with stunning views of the surrounding plains.',
    ),
    array(
        'slug' => 'tortilis-camp',
        'name' => 'Tortilis Camp',
        'tagline' => 'Eco-friendly luxury camp with stunning Mount Kilimanjaro views',
        'location' => 'Amboseli',
        'price_range' => '$700-1000',
        'type' => 'LUXURY',
        'rating' => 5,
        'features' => 'Kilimanjaro views,Swimming pool,Spa,Eco-friendly design,Walking safaris,Cultural visits,Private dining,Star bed experience',
        'description' => 'Tortilis Camp is an award-winning eco-luxury camp with breathtaking views of Mount Kilimanjaro. Named after the iconic tortilis trees that dot the landscape, the camp features 17 luxury tents and a family unit.',
    ),
    array(
        'slug' => 'salt-lick',
        'name' => 'Salt Lick Safari Lodge',
        'tagline' => 'Iconic lodge with unique architecture featuring underwater viewing tunnels',
        'location' => 'Tsavo',
        'price_range' => '$500-800',
        'type' => 'LUXURY',
        'rating' => 5,
        'features' => 'Underwater viewing hide,Swimming pool,Spa,Restaurant,Bar,Game drives,Walking safaris,Night game drives',
        'description' => 'Salt Lick Safari Lodge is one of Kenya\'s most iconic safari lodges, renowned for its unique architecture and spectacular wildlife viewing opportunities. The lodge is built on stilts with a series of interconnecting walkways.',
    ),
    array(
        'slug' => 'lake-nakuru-lodge',
        'name' => 'Lake Nakuru Lodge',
        'tagline' => 'Beautiful lodge with stunning lake views inside Lake Nakuru National Park',
        'location' => 'Lake Nakuru',
        'price_range' => '$300-500',
        'type' => 'LUXURY',
        'rating' => 4,
        'features' => 'Lake views,Swimming pool,Restaurant,Bar,Conference facilities,Gift shop,Game drives,Bird watching',
        'description' => 'Lake Nakuru Lodge is situated in the heart of Lake Nakuru National Park, offering spectacular views of the lake and its famous flamingo populations.',
    ),
    array(
        'slug' => 'kibo-camp',
        'name' => 'Kibo Safari Camp',
        'tagline' => 'Comfortable tented camp with spectacular Mount Kilimanjaro views',
        'location' => 'Amboseli',
        'price_range' => '$250-400',
        'type' => 'MIDRANGE',
        'rating' => 4,
        'features' => 'Kilimanjaro views,Swimming pool,Restaurant,Bar,Souvenir shop,Free parking,Hot water 24/7,Laundry service',
        'description' => 'Kibo Safari Camp offers comfortable tented accommodation with spectacular views of Mount Kilimanjaro. The camp features 71 luxury tents, each with en-suite bathrooms and private verandas looking toward the mountain.',
    ),
);

foreach ($accommodations as $acc) {
    $existing = get_page_by_path($acc['slug'], OBJECT, 'accommodation');
    
    if (!$existing) {
        $post_id = wp_insert_post(array(
            'post_title' => $acc['name'],
            'post_name' => $acc['slug'],
            'post_content' => $acc['description'],
            'post_excerpt' => $acc['tagline'],
            'post_status' => 'publish',
            'post_type' => 'accommodation',
            'meta_input' => array(
                '_accommodation_tagline' => $acc['tagline'],
                '_accommodation_location' => $acc['location'],
                '_accommodation_price_range' => $acc['price_range'],
                '_accommodation_type' => $acc['type'],
                '_accommodation_rating' => $acc['rating'],
                '_accommodation_features' => $acc['features'],
            ),
        ));
        
        echo "Created accommodation: " . $acc['name'] . " (ID: $post_id)\n";
    } else {
        echo "Accommodation already exists: " . $acc['name'] . "\n";
    }
}

echo "\nAccommodations import completed!\n";
