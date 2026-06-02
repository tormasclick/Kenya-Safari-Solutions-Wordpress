</main>

<footer class="bg-[#21160e] text-white/90">
    <div class="mx-auto max-w-7xl px-4 py-12 md:py-16">
        <div class="grid gap-8 md:grid-cols-4">
            <!-- Column 1: Brand Info -->
            <div>
                <?php 
                $footer_logo = get_option('kenya_footer_logo', '');
                if ($footer_logo): 
                ?>
                    <img src="<?php echo esc_url($footer_logo); ?>" alt="Kenya Safari Solutions" class="h-12 w-auto mb-4">
                <?php endif; ?>
                <div class="font-display text-xl font-bold">
                    <?php echo esc_html(get_option('kenya_footer_name', 'Kenya Safari Solutions')); ?>
                </div>
                <div class="mt-2 text-xs uppercase tracking-[0.18em] text-amber-400">
                    <?php echo esc_html(get_option('kenya_footer_tagline', 'Explore . Discover . Experience')); ?>
                </div>
                <p class="mt-4 text-sm text-white/70">
                    <?php echo esc_html(get_option('kenya_footer_description', 'Private safaris, marine adventures, and unforgettable experiences across Kenya.')); ?>
                </p>
            </div>

            <!-- Column 2: Quick Links (from WordPress menu) -->
            <div>
                <h3 class="font-display text-lg font-semibold">Quick Links</h3>
                <ul class="mt-3 space-y-2 text-sm">
                    <?php
                    // Check if footer menu is set
                    if (has_nav_menu('footer')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'container' => false,
                            'menu_class' => '',
                            'items_wrap' => '%3$s',
                            'fallback_cb' => false,
                        ));
                    } else {
                        // Default links if no menu set
                        $default_links = array(
                            'Home' => home_url('/'),
                            'Safaris' => home_url('/safaris'),
                            'Marine' => home_url('/marine'),
                            'Rentals' => home_url('/rentals'),
                            'Transfers' => home_url('/transfers'),
                            'Contact' => home_url('/contact'),
                        );
                        foreach ($default_links as $label => $url) {
                            echo '<li><a href="' . esc_url($url) . '" class="text-white/70 hover:text-white transition">' . esc_html($label) . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>

            <!-- Column 3: Contact Info -->
            <div>
                <h3 class="font-display text-lg font-semibold">Contact</h3>
                <ul class="mt-3 space-y-2 text-sm">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-phone-alt h-4 w-4 mt-0.5 text-amber-400"></i>
                        <span class="text-white/70"><?php echo esc_html(get_option('kenya_footer_phone', '+254 700 000 000')); ?></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-envelope h-4 w-4 mt-0.5 text-amber-400"></i>
                        <span class="text-white/70"><?php echo esc_html(get_option('kenya_footer_email', 'info@kenyasafarisolutions.com')); ?></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-map-marker-alt h-4 w-4 mt-0.5 text-amber-400"></i>
                        <span class="text-white/70">Nairobi &amp; Watamu, Kenya</span>
                    </li>
                </ul>
            </div>

            <!-- Column 4: Plan Your Trip & Social -->
            <div>
                <h3 class="font-display text-lg font-semibold">Plan Your Trip</h3>
                <p class="mt-3 text-sm text-white/70">Ready for an unforgettable Kenyan adventure?</p>
                <a href="#" id="footer-wa" target="_blank" rel="noreferrer" class="mt-4 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-amber-500 to-orange-500 px-5 py-2.5 text-sm font-bold text-white hover:scale-105 transition">
                    <i class="fab fa-whatsapp h-4 w-4"></i> Chat with us
                </a>
                
                <!-- Social Links -->
                <?php 
                $facebook = get_option('kenya_footer_facebook', '');
                $instagram = get_option('kenya_footer_instagram', '');
                $twitter = get_option('kenya_footer_twitter', '');
                $youtube = get_option('kenya_footer_youtube', '');
                
                if ($facebook || $instagram || $twitter || $youtube): 
                ?>
                    <div class="mt-6">
                        <h3 class="font-display text-sm font-semibold mb-3">Follow Us</h3>
                        <div class="flex space-x-3">
                            <?php if ($facebook): ?>
                                <a href="<?php echo esc_url($facebook); ?>" target="_blank" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-amber-500 transition">
                                    <i class="fab fa-facebook-f text-xs"></i>
                                </a>
                            <?php endif; ?>
                            <?php if ($instagram): ?>
                                <a href="<?php echo esc_url($instagram); ?>" target="_blank" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-amber-500 transition">
                                    <i class="fab fa-instagram text-xs"></i>
                                </a>
                            <?php endif; ?>
                            <?php if ($twitter): ?>
                                <a href="<?php echo esc_url($twitter); ?>" target="_blank" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-amber-500 transition">
                                    <i class="fab fa-twitter text-xs"></i>
                                </a>
                            <?php endif; ?>
                            <?php if ($youtube): ?>
                                <a href="<?php echo esc_url($youtube); ?>" target="_blank" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-amber-500 transition">
                                    <i class="fab fa-youtube text-xs"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="mt-8 border-t border-white/20 pt-6 text-center text-xs text-white/60">
            © <?php echo date('Y'); ?> <?php echo esc_html(get_option('kenya_footer_copyright', 'Kenya Safari Solutions. All rights reserved.')); ?>
        </div>
    </div>
</footer>

<script>
// WhatsApp link for footer button
const footerWaMessage = "Hi, I'd like to plan my Kenya safari.";
const footerWaUrl = "https://wa.me/254700000000?text=" + encodeURIComponent(footerWaMessage);
document.getElementById('footer-wa')?.setAttribute('href', footerWaUrl);
</script>

<?php wp_footer(); ?>
</body>
</html>
