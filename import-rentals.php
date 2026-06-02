<?php
require_once('wp-load.php');

$rentals = array(
    array(
        'slug' => 'landcruiser',
        'name' => 'Toyota Land Cruiser',
        'tagline' => 'The Ultimate Safari Machine',
        'price_per_day' => 220,
        'price_per_week' => 1400,
        'short_description' => 'The legendary Toyota Land Cruiser is Kenya\'s most trusted safari vehicle, built to conquer the toughest terrains.',
        'features' => '7 comfortable seats, Pop-up safari roof, Manual 4x4 transmission, Long-range fuel tank (180L), Air conditioning, USB charging ports',
        'specifications' => 'Engine: 4.2L Diesel Turbo, Fuel capacity: 180 Liters, Ground clearance: 235mm, Drivetrain: Full-time 4x4',
        'order' => 0,
    ),
    array(
        'slug' => 'prado',
        'name' => 'Toyota Prado TX',
        'tagline' => 'Luxury Meets Safari Capability',
        'price_per_day' => 180,
        'price_per_week' => 1150,
        'short_description' => 'The Toyota Prado TX combines luxury comfort with rugged 4x4 capability.',
        'features' => '5 leather seats, Automatic transmission, Selectable 4x4, Leather interior, Premium sound system, Rearview camera',
        'specifications' => 'Engine: 3.0L Diesel Turbo, Fuel capacity: 150 Liters, Ground clearance: 215mm, Transmission: 6-speed automatic',
        'order' => 1,
    ),
    array(
        'slug' => 'van',
        'name' => 'Tourist Safari Van',
        'tagline' => 'Best Value for Group Safaris',
        'price_per_day' => 160,
        'price_per_week' => 1000,
        'short_description' => 'Kenya\'s most popular safari vehicle for group tours with pop-up roof.',
        'features' => '9 seats, Pop-up safari roof, Raised suspension, Air conditioning, Roof rack',
        'specifications' => 'Engine: 3.0L Diesel, Fuel capacity: 70 Liters, Ground clearance: 200mm, Seating: 9 passengers',
        'order' => 2,
    ),
    array(
        'slug' => 'luxury',
        'name' => 'Mercedes V-Class',
        'tagline' => 'Executive Luxury Travel',
        'price_per_day' => 260,
        'price_per_week' => 1650,
        'short_description' => 'The Mercedes V-Class redefines executive travel with VIP luxury.',
        'features' => '6 executive captain\'s chairs, Premium leather upholstery, Heated & ventilated seats, Wi-Fi hotspot, Professional chauffeur',
        'specifications' => 'Engine: 2.1L Diesel Turbo, Transmission: 7-speed automatic, Seating: 6 passengers',
        'order' => 3,
    ),
);

foreach ($rentals as $rental) {
    $existing = get_page_by_path($rental['slug'], OBJECT, 'rental');
    
    if (!$existing) {
        $post_id = wp_insert_post(array(
            'post_title' => $rental['name'],
            'post_name' => $rental['slug'],
            'post_content' => $rental['short_description'],
            'post_excerpt' => $rental['short_description'],
            'post_status' => 'publish',
            'post_type' => 'rental',
            'menu_order' => $rental['order'],
            'meta_input' => array(
                '_rental_tagline' => $rental['tagline'],
                '_rental_price_per_day' => $rental['price_per_day'],
                '_rental_price_per_week' => $rental['price_per_week'],
                '_rental_features' => $rental['features'],
                '_rental_specifications' => $rental['specifications'],
            ),
        ));
        
        echo "Created rental: " . $rental['name'] . " (ID: $post_id)\n";
    } else {
        echo "Rental already exists: " . $rental['name'] . "\n";
    }
}

echo "\nRentals import completed!\n";
