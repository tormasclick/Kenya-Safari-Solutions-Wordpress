<?php get_header(); ?>

<!-- Hero Section -->
<section class="relative isolate overflow-hidden">
    <div class="absolute inset-0 -z-10">
        <?php 
        $video_path = get_template_directory_uri() . '/assets/videos/hero-safari-bg.mp4';
        if (file_exists(get_template_directory() . '/assets/videos/hero-safari-bg.mp4')): 
        ?>
            <video class="h-full w-full object-cover" autoplay loop muted playsinline>
                <source src="<?php echo $video_path; ?>" type="video/mp4">
            </video>
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/20 dark:from-black/80 dark:via-black/60 dark:to-black/40"></div>
    </div>

    <div class="relative mx-auto flex min-h-[60vh] max-w-7xl flex-col justify-center px-6 pt-24 pb-20 text-center">
        <div class="mx-auto max-w-4xl">
            <span class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 backdrop-blur-sm px-4 py-1.5 text-[11px] uppercase tracking-[0.22em] text-white">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                Tailored Kenyan Journeys
            </span>
            
            <h1 class="mt-6 font-display text-4xl text-white sm:text-5xl md:text-6xl lg:text-7xl"  sm:text-5xl md:text-6xl lg:text-7xl">
                Explore Kenya 
                <span class="text-gradient-gold">Beyond</span>
                <br class="hidden sm:inline">
                <span class="text-gradient-gold">Ordinary</span>
            </h1>
            
            <p class="mx-auto mt-4 max-w-2xl text-sm text-white/90 sm:text-base">
                Private safaris, marine adventures, airport transfers and unforgettable experiences across Kenya — crafted by locals.
            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                <a href="/safaris" class="group inline-flex items-center gap-2 rounded-full bg-white dark:bg-[#422b1b] px-6 py-3 text-sm font-semibold text-gray-900 dark:text-white shadow-lg transition-all hover:scale-105 hover:shadow-2xl">
                    Explore Safaris 
                    <i class="fas fa-arrow-right h-4 w-4 transition-transform group-hover:translate-x-1"></i>
                </a>
                <a href="#" id="hero-wa" target="_blank" rel="noreferrer" class="group inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 backdrop-blur-sm px-6 py-3 text-sm font-semibold text-white transition-all hover:scale-105 hover:bg-white/20">
                    <i class="fab fa-whatsapp h-4 w-4"></i> 
                    Chat on WhatsApp
                </a>
            </div>
        </div>
    </div>

    <!-- Search Wizard -->
    <div class="relative z-10 mx-auto -mt-12 max-w-6xl px-4 pb-12">
        <div class="relative rounded-2xl bg-white/95 dark:bg-[#2a1f18]/95 shadow-2xl backdrop-blur-sm p-4 border border-gray-200 dark:border-[#5a3d2e]">
            <div class="flex flex-col lg:flex-row items-stretch lg:items-center gap-3">
                <!-- Destination -->
                <div class="flex-1 relative">
                    <i class="fas fa-map-marker-alt absolute left-3 top-1/2 -translate-y-1/2 text-amber-500 dark:text-amber-400 h-4 w-4 z-10"></i>
                    <select id="search-destination" class="w-full rounded-xl border border-gray-200 dark:border-[#422b1b] bg-white dark:bg-[#422b1b] py-3 pl-9 pr-3 text-sm text-gray-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500 transition-all appearance-none cursor-pointer">
                        <option value="">Where to?</option>
                        <?php
                        $destinations = get_posts(array(
                            'post_type' => 'destination',
                            'posts_per_page' => -1,
                            'orderby' => 'title',
                            'order' => 'ASC'
                        ));
                        foreach ($destinations as $dest):
                        ?>
                            <option value="<?php echo esc_attr(get_the_title($dest->ID)); ?>"><?php echo esc_html(get_the_title($dest->ID)); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Start Date -->
                <div class="flex-1 relative">
                    <i class="fas fa-calendar-alt absolute left-3 top-1/2 -translate-y-1/2 text-amber-500 dark:text-amber-400 h-4 w-4 z-10"></i>
                    <input type="date" id="search-start" class="w-full rounded-xl border border-gray-200 dark:border-[#422b1b] bg-white dark:bg-[#422b1b] py-3 pl-9 pr-3 text-sm text-gray-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500 transition-all">
                </div>

                <!-- End Date -->
                <div class="flex-1 relative">
                    <i class="fas fa-calendar-alt absolute left-3 top-1/2 -translate-y-1/2 text-amber-500 dark:text-amber-400 h-4 w-4 z-10"></i>
                    <input type="date" id="search-end" class="w-full rounded-xl border border-gray-200 dark:border-[#422b1b] bg-white dark:bg-[#422b1b] py-3 pl-9 pr-3 text-sm text-gray-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500 transition-all">
                </div>

                <!-- Travelers -->
                <div class="flex-1 flex items-center gap-2 px-2">
                    <div class="flex items-center gap-2 bg-white dark:bg-[#422b1b] border border-gray-200 dark:border-[#422b1b] rounded-xl px-3 py-1.5">
                        <button id="adults-minus" class="h-7 w-7 rounded-full bg-gray-100 dark:bg-[#5a3d2e] text-gray-700 dark:text-white hover:bg-amber-500 hover:text-white transition font-bold">-</button>
                        <span id="adults-count" class="text-sm font-semibold min-w-[2rem] text-center text-gray-900 dark:text-white">2</span>
                        <button id="adults-plus" class="h-7 w-7 rounded-full bg-gray-100 dark:bg-[#5a3d2e] text-gray-700 dark:text-white hover:bg-amber-500 hover:text-white transition font-bold">+</button>
                        <span class="text-xs text-gray-600 dark:text-gray-400 ml-1">Adults</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white dark:bg-[#422b1b] border border-gray-200 dark:border-[#422b1b] rounded-xl px-3 py-1.5">
                        <button id="children-minus" class="h-7 w-7 rounded-full bg-gray-100 dark:bg-[#5a3d2e] text-gray-700 dark:text-white hover:bg-amber-500 hover:text-white transition font-bold">-</button>
                        <span id="children-count" class="text-sm font-semibold min-w-[2rem] text-center text-gray-900 dark:text-white">0</span>
                        <button id="children-plus" class="h-7 w-7 rounded-full bg-gray-100 dark:bg-[#5a3d2e] text-gray-700 dark:text-white hover:bg-amber-500 hover:text-white transition font-bold">+</button>
                        <span class="text-xs text-gray-600 dark:text-gray-400 ml-1">Kids</span>
                    </div>
                </div>

                <!-- Budget -->
                <div class="flex-1 relative">
                    <i class="fas fa-dollar-sign absolute left-3 top-1/2 -translate-y-1/2 text-amber-500 dark:text-amber-400 h-4 w-4 z-10"></i>
                    <select id="search-budget" class="w-full rounded-xl border border-gray-200 dark:border-[#422b1b] bg-white dark:bg-[#422b1b] py-3 pl-9 pr-3 text-sm text-gray-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500 transition-all appearance-none cursor-pointer">
                        <option value="">Budget?</option>
                        <option value="Luxury">Luxury</option>
                        <option value="Mid-range">Mid-range</option>
                        <option value="Budget">Budget</option>
                    </select>
                </div>

                <!-- Plan Trip Button -->
                <button id="search-plan-btn" class="px-6 py-3 rounded-xl text-sm font-bold whitespace-nowrap bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-lg hover:scale-105 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-search h-4 w-4 inline mr-2"></i> Plan Trip
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Rest of the sections -->
<?php get_template_part('template-parts/destinations-section'); ?>
<?php get_template_part('template-parts/featured-accommodations'); ?>
<?php get_template_part('template-parts/marine-section'); ?>
<?php get_template_part('template-parts/packages-section'); ?>
<?php get_template_part('template-parts/transfers-section'); ?>
<?php get_template_part('template-parts/rentals-section'); ?>
<?php get_template_part('template-parts/testimonials-section'); ?>
<?php get_template_part('template-parts/cta-section'); ?>

<script>
// Search Wizard functionality
document.addEventListener('DOMContentLoaded', function() {
    const destination = document.getElementById('search-destination');
    const startDate = document.getElementById('search-start');
    const endDate = document.getElementById('search-end');
    const budget = document.getElementById('search-budget');
    const planBtn = document.getElementById('search-plan-btn');
    
    let adults = 2;
    let children = 0;
    const adultsCount = document.getElementById('adults-count');
    const childrenCount = document.getElementById('children-count');
    
    function updateAdults(value) {
        adults = Math.max(1, adults + value);
        if (adultsCount) adultsCount.textContent = adults;
        checkCanSearch();
    }
    
    function updateChildren(value) {
        children = Math.max(0, children + value);
        if (childrenCount) childrenCount.textContent = children;
        checkCanSearch();
    }
    
    document.getElementById('adults-plus')?.addEventListener('click', () => updateAdults(1));
    document.getElementById('adults-minus')?.addEventListener('click', () => updateAdults(-1));
    document.getElementById('children-plus')?.addEventListener('click', () => updateChildren(1));
    document.getElementById('children-minus')?.addEventListener('click', () => updateChildren(-1));
    
    function checkCanSearch() {
        const canSearch = destination?.value && startDate?.value && endDate?.value && adults > 0 && budget?.value;
        if (planBtn) planBtn.disabled = !canSearch;
    }
    
    destination?.addEventListener('change', checkCanSearch);
    startDate?.addEventListener('change', checkCanSearch);
    endDate?.addEventListener('change', checkCanSearch);
    budget?.addEventListener('change', checkCanSearch);
    
    planBtn?.addEventListener('click', () => {
        if (!planBtn.disabled) {
            const whatsappNumber = "<?php echo esc_js(get_option('kenya_whatsapp_number', '254700563754')); ?>";
            const summary = `Hi, I'd like to plan: ${destination.value} | ${startDate.value} to ${endDate.value} | ${adults} adults${children ? `, ${children} children` : ''} | ${budget.value}.`;
            window.open(`https://wa.me/${whatsappNumber}?text=${encodeURIComponent(summary)}`, '_blank');
        }
    });
    
    checkCanSearch();
});

// WhatsApp links
const whatsappNumberGlobal = "<?php echo esc_js(get_option('kenya_whatsapp_number', '254700563754')); ?>";
const waUrl = "https://wa.me/" + whatsappNumberGlobal + "?text=" + encodeURIComponent("Hi, I'd like to plan my Kenya safari.");
document.getElementById('hero-wa')?.setAttribute('href', waUrl);
document.getElementById('cta-wa')?.setAttribute('href', waUrl);
</script>

<?php get_footer(); ?>
