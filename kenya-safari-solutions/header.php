<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="fixed top-0 left-0 right-0 bg-white shadow-md z-50 transition-all duration-300">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <div class="logo">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <a href="<?php echo home_url(); ?>" class="text-2xl font-display font-bold text-gray-800">
                        Kenya Safari Solutions
                    </a>
                <?php endif; ?>
            </div>
            
            <button id="mobile-menu-btn" class="md:hidden text-gray-800">
                <i class="fas fa-bars text-2xl"></i>
            </button>
            
            <nav id="primary-nav" class="hidden md:block">
                <?php wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_class' => 'flex space-x-8 font-medium',
                    'container' => false,
                    'fallback_cb' => false,
                ]); ?>
            </nav>
        </div>
        
        <div id="mobile-nav" class="hidden md:hidden pb-4">
            <?php wp_nav_menu([
                'theme_location' => 'primary',
                'menu_class' => 'flex flex-col space-y-3',
                'container' => false,
            ]); ?>
        </div>
    </div>
</header>

<main class="pt-20">
