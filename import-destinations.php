<?php
/**
 * Import destinations from Next.js data
 * Run this file once from command line: php import-destinations.php
 */

require_once('wp-load.php');

$destinations = array(
    array(
        'slug' => 'maasai-mara',
        'name' => 'Maasai Mara',
        'tagline' => 'Home of the Great Migration',
        'duration' => '3 Days / 4 Days',
        'blurb' => 'Rolling savanna theatre where the Big Five roam and a million wildebeest thunder across the plains each year.',
        'highlights' => array("Sunrise & sunset game drives", "Maasai cultural village visit", "Optional hot air balloon at dawn", "Mara River migration crossings"),
        'span' => 'md:col-span-2 md:row-span-2',
        'content' => '<h2>Maasai Mara National Reserve</h2><p>The Maasai Mara is Kenya\'s most famous wildlife reserve, part of the larger Serengeti ecosystem. Known for the Great Migration, where over 1.5 million wildebeest and zebras cross the Mara River, it offers unparalleled game viewing year-round.</p><h3>Best Time to Visit</h3><p>July to October for the migration crossing, December to February for calving season.</p>'
    ),
    array(
        'slug' => 'amboseli',
        'name' => 'Amboseli',
        'tagline' => 'Elephants under Kilimanjaro',
        'duration' => '2 Days / 3 Days',
        'blurb' => 'Free-ranging elephant herds wander wetlands framed by Africa\'s tallest mountain.',
        'highlights' => array("Free-ranging elephant observation", "Swamp walks & birdlife", "Kilimanjaro photography points", "Maasai community visits"),
        'span' => '',
        'content' => '<h2>Amboseli National Park</h2><p>Famous for its large elephant herds and stunning views of Mount Kilimanjaro, Amboseli offers classic African scenery with swamps, savannah, and acacia woodlands.</p>'
    ),
    array(
        'slug' => 'tsavo',
        'name' => 'Tsavo',
        'tagline' => 'Land of the red elephants',
        'duration' => '2 Days / 3 Days',
        'blurb' => 'A vast crimson-dust wilderness of lava flows, springs and big-tusker elephants.',
        'highlights' => array("Galana River drives", "Lugard Falls geology", "Mzima Springs underwater hippo viewing", "Tsavo lion country"),
        'span' => '',
        'content' => '<h2>Tsavo National Park</h2><p>One of the largest national parks in the world, Tsavo is divided into Tsavo East and West. Known for its red elephants, volcanic landscapes, and the famous man-eating lions of Tsavo.</p>'
    ),
    array(
        'slug' => 'nairobi-national-park',
        'name' => 'Nairobi National Park',
        'tagline' => 'Wildlife meets skyline',
        'duration' => 'Half Day / Full Day',
        'blurb' => 'The only national park bordering a capital — lions and rhinos with skyscrapers behind.',
        'highlights' => array("Layover-friendly itineraries", "Ivory burning site monument", "Black & white rhino tracking", "Animal orphanage add-on"),
        'span' => '',
        'content' => '<h2>Nairobi National Park</h2><p>A unique wildlife sanctuary just minutes from Nairobi\'s city center, where you can see lions, giraffes, rhinos, and zebras against the backdrop of the city skyline.</p>'
    ),
    array(
        'slug' => 'lake-nakuru',
        'name' => 'Lake Nakuru',
        'tagline' => 'A sea of pink flamingos',
        'duration' => '1 Day / 2 Days',
        'blurb' => 'An alkaline lake fringed pink with flamingos and surrounded by rhino sanctuary forest.',
        'highlights' => array("Baboon Cliff viewpoint", "Black & white rhino sanctuary", "Out of Africa lookout", "Lakeside picnic stops"),
        'span' => 'md:col-span-2',
        'content' => '<h2>Lake Nakuru National Park</h2><p>Known for its millions of flamingos that turn the lake shores pink, Lake Nakuru is also a rhino sanctuary and offers excellent bird watching with over 450 species recorded.</p>'
    ),
    array(
        'slug' => 'lake-naivasha',
        'name' => 'Lake Naivasha',
        'tagline' => 'Freshwater escape & Hell\'s Gate',
        'duration' => '1 Day / 2 Days',
        'blurb' => 'Hippos, fish eagles and a cycle-through-the-park experience at Hell\'s Gate.',
        'highlights' => array("Boat rides among hippos", "Hell's Gate gorge hiking", "Cycle safari with zebras", "Crescent Island walking safari"),
        'span' => '',
        'content' => '<h2>Lake Naivasha & Hell\'s Gate</h2><p>A freshwater lake home to hippos and over 400 bird species. Nearby Hell\'s Gate National Park offers unique walking and cycling safaris through dramatic gorges.</p>'
    ),
    array(
        'slug' => 'watamu',
        'name' => 'Watamu',
        'tagline' => 'Turquoise marine paradise',
        'duration' => '3 Days / 5 Days',
        'blurb' => 'White-sand crescents, coral reefs and protected sea turtle waters.',
        'highlights' => array("Mangrove forest exploring", "White sand rest spots", "Marine park snorkeling", "Local sea turtle conservation"),
        'span' => '',
        'content' => '<h2>Watamu Marine National Park</h2><p>A stunning coastal paradise with pristine white sand beaches, vibrant coral reefs, and protected sea turtle nesting sites. Part of UNESCO\'s Biosphere Reserve.</p>'
    ),
    array(
        'slug' => 'malindi',
        'name' => 'Malindi',
        'tagline' => 'Coral coast culture',
        'duration' => '3 Days / 5 Days',
        'blurb' => 'A sun-bleached Swahili town of ruins, pillars and palm-fringed beaches.',
        'highlights' => array("Gede Ruins historical tour", "Vasco da Gama pillar", "Coral garden snorkeling", "Old town spice walks"),
        'span' => 'md:col-span-2',
        'content' => '<h2>Malindi</h2><p>A historic Swahili town with rich cultural heritage, beautiful beaches, and the famous Gede Ruins. Perfect for combining beach relaxation with cultural exploration.</p>'
    ),
    array(
        'slug' => 'marafa-hells-kitchen',
        'name' => 'Marafa Hell\'s Kitchen',
        'tagline' => 'The Grand Canyon of Kenya',
        'duration' => 'Half Day / Full Day',
        'blurb' => 'A stunning geological wonder of colorful sandstone gorges carved by water over millennia.',
        'highlights' => array("Sunrise & sunset photography", "Guided gorge walks", "Geological formations", "Local Giriama legends", "Bird watching"),
        'span' => '',
        'content' => '<h2>Marafa Hell\'s Kitchen</h2><p>A spectacular geological formation of deep gorges and towering sandstone pillars, carved by water erosion over thousands of years. Known locally as Nyari, meaning "the place broken by itself."</p>'
    ),
);

foreach ($destinations as $dest) {
    // Check if destination already exists
    $existing = get_page_by_path($dest['slug'], OBJECT, 'destination');
    
    if (!$existing) {
        // Create the destination post
        $post_id = wp_insert_post(array(
            'post_title' => $dest['name'],
            'post_name' => $dest['slug'],
            'post_content' => $dest['content'],
            'post_excerpt' => $dest['blurb'],
            'post_status' => 'publish',
            'post_type' => 'destination',
            'meta_input' => array(
                '_destination_tagline' => $dest['tagline'],
                '_destination_duration' => $dest['duration'],
                '_destination_blurb' => $dest['blurb'],
                '_destination_highlights' => implode("\n", $dest['highlights']),
                '_destination_span' => $dest['span'],
            ),
        ));
        
        echo "Created destination: " . $dest['name'] . " (ID: $post_id)\n";
    } else {
        echo "Destination already exists: " . $dest['name'] . "\n";
    }
}

echo "\nImport completed!\n";
