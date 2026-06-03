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
    <div class="mx-auto max-w-7xl px-0">
        <nav class="flex items-center justify-between gap-4 rounded-full px-2 py-2 transition-all duration-500 bg-white/90 dark:bg-[#241710]/90 backdrop-blur-sm border border-gray-200 dark:border-[#3f2c21]">
            <!-- Logo -->
            <a href="<?php echo home_url(); ?>" class="site-logo flex items-center gap-2 flex-shrink-0">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php $dark_logo = get_theme_mod('kenya_dark_logo'); if ($dark_logo): ?><img src="<?php echo esc_url($dark_logo); ?>" alt="Dark Logo" class="dark-mode-logo" style="display:none"><?php endif; ?>
                <?php else: ?>
                    <div class="h-9 w-9 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 flex items-center justify-center text-white font-bold text-sm">KS</div>
                <?php endif; ?>
                <div class="hidden sm:block leading-tight">
                    <div class="font-display text-base font-bold text-gray-900 dark:text-white"><?php bloginfo('name'); ?></div>
                    <div class="text-[10px] uppercase tracking-[0.18em] text-amber-600 dark:text-amber-400 font-semibold"><?php echo get_bloginfo('description'); ?></div>
                </div>
            </a>

            <!-- Desktop Menu - Visible on desktop only -->
            <div class="desktop-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'flex items-center gap-1',
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
            </div>

            <!-- Right Icons -->
            <div class="site-logo flex items-center gap-2 flex-shrink-0">
                <button id="theme-toggle" onclick="window.setTheme(!document.documentElement.classList.contains('dark'))" class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 dark:bg-[#5a3d2e] text-gray-700 dark:text-amber-400 hover:bg-gray-200 dark:hover:bg-[#77482e] transition">
                    <i id="theme-icon" class="fas fa-moon"></i>
                </button>
                <a href="#" id="whatsapp-btn" class="hidden md:inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 px-5 py-2.5 text-sm font-bold text-white shadow-lg hover:scale-105 transition">
                    <i class="fab fa-whatsapp"></i> Chat with us
                </a>
                <!-- Mobile menu button - Visible only on mobile -->
                <button id="mobile-menu-btn" class="lg:hidden inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 dark:bg-[#3f2c21]">
                    <i class="fas fa-bars text-gray-700 dark:text-white"></i>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu - Hidden by default -->
        <div id="mobile-menu" class="hidden mt-2 rounded-2xl bg-white/95 dark:bg-[#241710]/95 backdrop-blur-md p-4 shadow-xl border border-gray-200 dark:border-[#3f2c21] lg:hidden">
            <div class="flex justify-end mb-3">
                <button id="mobile-menu-close" class="text-gray-500 dark:text-gray-400 hover:text-amber-600 dark:hover:text-amber-400 transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'grid gap-2',
                'fallback_cb' => false,
            ));
            ?>
        </div>
    </div>
</header>

<script>
// Scroll effect
let scrolled = false;
function onScroll() {
    const header = document.querySelector('header');
    const nav = document.querySelector('header nav');
    if (window.scrollY > 24) {
        if (!scrolled) {
            header?.classList.add('py-2');
            header?.classList.remove('py-4');
            nav?.classList.add('bg-white/95', 'dark:bg-[#241710]/95', 'shadow-lg');
            nav?.classList.remove('bg-white/90', 'dark:bg-[#241710]/90');
            scrolled = true;
        }
    } else {
        if (scrolled) {
            header?.classList.remove('py-2');
            header?.classList.add('py-4');
            nav?.classList.remove('bg-white/95', 'dark:bg-[#241710]/95', 'shadow-lg');
            nav?.classList.add('bg-white/90', 'dark:bg-[#241710]/90');
            scrolled = false;
        }
    }
}
window.addEventListener('scroll', onScroll, { passive: true });
onScroll();

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeBtn = document.getElementById('mobile-menu-close');
    
    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            mobileMenu.classList.toggle('hidden');
        });
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
            });
        }
    }
});

// WhatsApp link
const whatsappNumber = "<?php echo esc_js(get_option('kenya_whatsapp_number', '254700563754')); ?>";
document.getElementById('whatsapp-btn')?.setAttribute('href', 'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Hi Kenya Safari Solutions, I\'d like to inquire about a Kenya safari.'));
</script>

<main>

<script>
// Ensure logo is clickable in dark mode
document.addEventListener('DOMContentLoaded', function() {
    const logoLink = document.querySelector('.site-logo');
    const darkLogo = document.querySelector('.dark-mode-logo');
    
    if (logoLink && darkLogo) {
        // Make sure dark logo doesn't block clicks
        darkLogo.style.pointerEvents = 'auto';
        darkLogo.style.cursor = 'pointer';
        
        // If dark logo is clicked, navigate to home
        darkLogo.addEventListener('click', function(e) {
            window.location.href = logoLink.href;
        });
    }
});
</script>
