<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <?php wp_head(); ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Fraunces:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<script>
// Theme toggle
(function() {
    const saved = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isDark = saved === 'dark' || (!saved && prefersDark);
    if (isDark) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
    window.setTheme = function(isDark) {
        if (isDark) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
        const icon = document.getElementById('theme-icon');
        if (icon) {
            icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
        }
    };
})();
</script>

<header class="fixed inset-x-0 top-0 z-50 transition-all duration-500 py-4">
    <div class="mx-auto max-w-7xl px-4">
        <nav class="flex items-center justify-between gap-4 rounded-full px-4 py-2 transition-all duration-500 bg-white/90 dark:bg-[#241710]/90 backdrop-blur-sm border border-gray-200 dark:border-[#3f2c21]">
            <a href="<?php echo home_url(); ?>" class="flex items-center gap-2 flex-shrink-0">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <div class="h-9 w-9 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 flex items-center justify-center text-white font-bold text-sm">KS</div>
                <?php endif; ?>
                <div class="hidden sm:block leading-tight">
                    <div class="font-display text-base font-bold text-gray-900 dark:text-white"><?php bloginfo('name'); ?></div>
                    <div class="text-[10px] uppercase tracking-[0.18em] text-amber-600 dark:text-amber-400 font-semibold"><?php echo get_bloginfo('description'); ?></div>
                </div>
            </a>

            <ul class="hidden lg:flex items-center gap-1">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'items_wrap' => '%3$s',
                    'fallback_cb' => false,
                    'walker' => new class extends Walker_Nav_Menu {
                        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                            $current_url = $_SERVER['REQUEST_URI'];
                            $is_active = ($item->url === home_url('/') && $current_url === '/') || 
                                         ($item->url !== home_url('/') && strpos($current_url, parse_url($item->url, PHP_URL_PATH)) === 0);
                            $active_class = $is_active ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#3f2c21] hover:text-amber-600 dark:hover:text-amber-400';
                            $output .= '<li><a href="' . $item->url . '" class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-200 ' . $active_class . '">' . $item->title . '</a></li>';
                        }
                    }
                ));
                ?>
            </ul>

            <div class="flex items-center gap-2 flex-shrink-0">
                <button id="theme-toggle" onclick="window.setTheme(!document.documentElement.classList.contains('dark'))" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 dark:bg-[#5a3d2e] text-gray-700 dark:text-amber-400 hover:bg-gray-200 dark:hover:bg-[#77482e] transition">
                    <i id="theme-icon" class="fas fa-moon"></i>
                </button>
                <a href="#" id="whatsapp-btn" class="hidden md:inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 px-5 py-2.5 text-sm font-bold text-white shadow-lg hover:scale-105 transition">
                    <i class="fab fa-whatsapp"></i> Chat with us
                </a>
                <button id="mobile-menu-btn" class="lg:hidden inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 dark:bg-[#3f2c21]">
                    <i class="fas fa-bars text-gray-700 dark:text-white"></i>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden mobile-menu-container">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'mobile-menu-items',
                'fallback_cb' => false,
            ));
            ?>
        </div>
    </div>
</header>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            mobileMenu.classList.toggle('hidden');
        });
        
        // Close when clicking a link
        const links = mobileMenu.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
            });
        });
    }
});

// WhatsApp link
const whatsappNumber = "<?php echo esc_js(get_option('kenya_whatsapp_number', '254700563754')); ?>";
document.getElementById('whatsapp-btn')?.setAttribute('href', 'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Hi Kenya Safari Solutions, I\'d like to inquire about a Kenya safari.'));
</script>

<main>
